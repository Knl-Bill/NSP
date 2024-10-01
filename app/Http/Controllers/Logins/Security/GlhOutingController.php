<?php

namespace App\Http\Controllers\Logins\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class GlhOutingController extends Controller
{
    Protected $GirlsInTime;
    public function __construct()
    {
        $this->GirlsInTime = Carbon::createFromTime(21, 10, 0, 'Asia/Kolkata');
    }
    public function GLHOuting(Request $request)
    {
        $request->validate([
            'rollno' => 'required|string',
        ]);
        $security = Session::get('security');
        if($security)
        {
            $rollno = strtoupper($request->input('rollno'));

            $student = DB::table('students')->where('rollno',$rollno)->first();

            if(!$student)
            {
                return redirect()->back()->with('error',"$rollno is not a student of NITPY");
            }
            if($student->gender != "Female")
            return redirect()->back()->with('error',"$rollno does not belong to Girls Hostel");
            $existingOuting = DB::table('glh_outings')->where('rollno',$rollno)->whereNULL('intime')->first();
        
            $security_name = $security->name;
            if($existingOuting)
            {
                $intime = Carbon::now()->setTimezone('Asia/Kolkata');
                DB::table('glh_outings')->where('id',$existingOuting->id)->update(['intime' => $intime, 'security_in' => $security_name]);
                $outingDate = Carbon::parse($existingOuting->outtime);
                if($student->gender == "Female")
                {
                    $isLate = $intime->gt($this->GirlsInTime) || $intime->isAfter($outingDate->endOfDay());
                    DB::table('glh_outings')->where('id',$existingOuting->id)->update(['late' => $isLate? 1:0,]);
                }
                return redirect()->back()->with('success',"Outing Closed for $rollno at $intime");
            }
            else{
                $outtime = Carbon::now()->setTimezone('Asia/Kolkata');
                DB::table('glh_outings')->insert([
                    'rollno' => $student->rollno,
                    'name' => $student->name,
                    'phoneno' => $student->phoneno,
                    'email' => $student->email,
                    'year' => $student->batch,
                    'hostel' => $student->hostelname,
                    'roomno' => $student->roomno,
                    'outtime' => $outtime,
                    'intime' => null,
                    'security_out' => $security_name,
                    'security_in' => null,
                    'course' => $student->course,
                ]);
                return redirect()->back()->with('success',"Outing Started for $rollno at $outtime");
            }
        }
        else
            return redirect('/');
    }
    public function GLHOutingStatus(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $query = DB::table('glh_outings')->orderBy('outtime','desc');
            if($request->has('batch') && !empty($request->batch) && $request->input('batch')!=1)
            {
                if($request->has('batch') && !empty($request->batch)) {
                    $query->where('year', $request->input('batch'));
                }
                if($request->has('rollno') && !empty($request->rollno)) {
                    $query->where('rollno', $request->input('rollno'));
                }
                if($request->has('course') && !empty($request->course)) {
                    $query->where('course', $request->input('course'));
                }
                if($request->has('late') && !empty($request->late)) {
                    if($request->input('late')==1)
                        $query->where('late', $request->input('late'));
                }
            }
            if($request->has('rollno') && !empty($request->rollno)) {
                $query->where('rollno', $request->input('rollno'));
            }
            if($request->has('course') && !empty($request->course)) {
                $query->where('course', $request->input('course'));
            }
            if($request->has('late') && !empty($request->late)) {
                if($request->input('late')==1)
                    $query->where('late', $request->input('late'));
            }
            $OutingHistory = $query->get();
            $name = "Outing History";
            return view('Logins.SecurityPages.GirlsRegister.GirlsRegisterHistory',['OutingHistory' => $OutingHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
    public function GLHUnclosedOuting(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $query = DB::table('glh_outings')->whereNULL('intime')->orderBy('outtime','desc'); 
            if($request->has('batch') && !empty($request->batch) && $request->input('batch')!=1)
            {
                if($request->has('batch') && !empty($request->batch)) {
                    $query->where('year', $request->input('batch'));
                }
                if($request->has('rollno') && !empty($request->rollno)) {
                    $query->where('rollno', $request->input('rollno'));
                }
                if($request->has('course') && !empty($request->course)) {
                    $query->where('course', $request->input('course'));
                }
                if($request->has('late') && !empty($request->late)) {
                    if($request->input('late')==1)
                        $query->where('late', $request->input('late'));
                }
            }
            if($request->has('rollno') && !empty($request->rollno)) {
                $query->where('rollno', $request->input('rollno'));
            }
            if($request->has('course') && !empty($request->course)) {
                $query->where('course', $request->input('course'));
            }
            if($request->has('late') && !empty($request->late)) {
                if($request->input('late')==1)
                    $query->where('late', $request->input('late'));
            }       
            $OutingHistory = $query->get();
            $name = "Unclosed Outing";
            return view('Logins.SecurityPages.GirlsRegister.GirlsRegisterHistory',['OutingHistory' => $OutingHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
}
