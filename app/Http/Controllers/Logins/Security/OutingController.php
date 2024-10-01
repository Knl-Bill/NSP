<?php

namespace App\Http\Controllers\Logins\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class OutingController extends Controller
{
    // Class Variables
    Protected $BoysInTime;
    Protected $GirlsInTime;
    public function __construct()
    {
        $this->BoysInTime = Carbon::createFromTime(22, 30, 0, 'Asia/Kolkata');
        $this->GirlsInTime = Carbon::createFromTime(18, 30, 0, 'Asia/Kolkata');
    }
    
    // Functions start from here
    public function InsertOuting(Request $request)
    {
        $request->validate([
            'rollno' => 'required|string',
            'gate' => 'required|string',
        ]);
        $security = Session::get('security');
        if($security)
        {
            $rollno = strtoupper($request->input('rollno'));
            $gate = $request->input('gate');
            

            $student = DB::table('students')->where('rollno',$rollno)->first();

            if(!$student)
            {
                return redirect()->back()->with('error',"$rollno is not a student of NITPY");
            }

            $existingOuting = DB::table('outing__table')->where('rollno',$rollno)->whereNULL('intime')->first();
        
            $security_name = $security->name;
            if($existingOuting)
            {
                $intime = Carbon::now()->setTimezone('Asia/Kolkata');
                DB::table('outing__table')->where('id',$existingOuting->id)->update(['intime' => $intime, 'security_in' => $security_name, 'in_gate' => $gate]);
                $outingDate = Carbon::parse($existingOuting->outtime);
                if($student->gender == "Male")
                {
                    $isLate = $intime->gt($this->BoysInTime) || $intime->isAfter($outingDate->endOfDay());
                    DB::table('outing__table')->where('id',$existingOuting->id)->update(['late' => $isLate? 1:0,]);
                }
                else if($student->gender == "Female")
                {
                    $isLate = $intime->gt($this->GirlsInTime) || $intime->isAfter($outingDate->endOfDay());
                    DB::table('outing__table')->where('id',$existingOuting->id)->update(['late' => $isLate? 1:0,]);
                }
                return redirect()->back()->with('success',"Outing Closed for $rollno at $intime");
            }
            else{
                $outtime = Carbon::now()->setTimezone('Asia/Kolkata');
                DB::table('outing__table')->insert([
                    'rollno' => $student->rollno,
                    'name' => $student->name,
                    'phoneno' => $student->phoneno,
                    'email' => $student->email,
                    'year' => $student->batch,
                    'gender' => $student->gender,
                    'hostel' => $student->hostelname,
                    'roomno' => $student->roomno,
                    'outtime' => $outtime,
                    'intime' => null,
                    'out_gate' => $gate,
                    'security_out' => $security_name,
                    'security_in' => null,
                    'course' => $student->course,
                    'vehicle' => $request->input('vehicle'),
                    'late' => 0,
                ]);
                return redirect()->back()->with('success',"Outing Started for $rollno at $outtime");
            }
        }
        else
            return redirect('/');
    }
    public function OutingStatus(Request $request)
    {
        $security = Session::get('security');
        $admin = Session::get('admin');
        if($security || $admin)
        {
            $query = DB::table('outing__table')->orderBy('outtime','desc');
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
            return view('Logins.SecurityPages.Outing.OutingHistory',['OutingHistory' => $OutingHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
    public function UnclosedOuting(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $query = DB::table('outing__table')->whereNULL('intime')->orderBy('outtime','desc'); 
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
            return view('Logins.SecurityPages.Outing.OutingHistory',['OutingHistory' => $OutingHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
    public function BoysOuting(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $gender = "MALE";
            $query = DB::table('outing__table')->where('gender',$gender)->orderBy('outtime','desc'); 
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
            $name = "Boys Outing";
            return view('Logins.SecurityPages.Outing.OutingHistory',['OutingHistory' => $OutingHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
    public function GirlsOuting(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $gender = "FEMALE";
            $query = DB::table('outing__table')->where('gender',$gender)->orderBy('outtime','desc'); 
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
            $name = "Girls Outing";
            return view('Logins.SecurityPages.Outing.OutingHistory',['OutingHistory' => $OutingHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
}
