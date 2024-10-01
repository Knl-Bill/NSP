<?php

namespace App\Http\Controllers\Logins\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    //
    public function InsertLeave(Request $request)
    {
        $request->validate([
            'rollno' => 'required|string',
            'outdate' => 'required|date',
            'gate' => 'required|string'
        ]);
        $security = Session::get('security');
        if($security)
        {
            $rollno = strtoupper($request->input('rollno'));
            $outdate = $request->input('outdate');
            $gate = $request->input('gate');
            $student = DB::table('leavereq_histories')->where('rollno',$rollno)->where('outdate',$outdate)->where('status','Approved')->first();

            if(!$student)
            {
                return redirect()->back()->with('error',"$rollno has no approved leave requests");
            }

            $existingLeave = DB::table('leavehistory')->where('rollno',$rollno)->whereNULL('intime')->first();
            
            $security_name = $security->name;
        
            if($existingLeave)
            {
                $intime = Carbon::now()->setTimezone('Asia/Kolkata');
                $ProposedInTime = Carbon::parse("$student->indate $student->intime",'Asia/Kolkata');
                $ProposedInTime->addHours(3);
                $isLate = $intime->gt($ProposedInTime);
                DB::table('leavehistory')->where('id',$existingLeave->id)->update(['intime' => $intime, 'inregistration' => $security_name, 'ingate' => $gate, 'late' => $isLate? 1:0]);
                if($student && $student->barcode)
                {
                    // Delete the Barcode Image
                    Storage::disk('public')->delete($student->barcode);
                    if($student->image)
                        Storage::disk('public')->delete($student->image);
                    // Delete the row from leavereq_histories table
                    DB::table('leavereq_histories')->where('id',$student->id)->delete();
                }
                return redirect()->back()->with('success',"Leave Closed for $rollno at $intime");
            }
            else{
                $outtime = Carbon::now()->setTimezone('Asia/Kolkata');
                DB::table('leavehistory')->insert([
                    'rollno' => $student->rollno,
                    'name' => $student->name,
                    'phoneno' => $student->phoneno,
                    'placeofvisit' => $student->placeofvisit,
                    'purpose' => $student->purpose,
                    'outtime' => $outtime,
                    'outregistration' => $security_name,
                    'outgate' => $gate,
                    'intime' => null,
                    'inregistration' => null,
                    'ingate' => null,
                    'gender' => $student->gender,
                    'course' => $student->course,
                    'year' => $student->year,
                ]);
                return redirect()->back()->with('success',"Leave Started for $rollno at $outtime");
            }
        }
        else
            return redirect('/');
    }
    public function InsertScannerLeave(Request $request)
    {
        $request->validate([
            'rollno' => 'required|string',
            'gate' => 'required|string'
        ]);
        $BarcodeContent = $request->input('rollno');
        list($rollno, $outdate) = explode('_', $BarcodeContent);
        $outdate = Carbon::createFromFormat('Ymd',$outdate)->toDateString();

        $security = Session::get('security');
        if($security)
        {
            $gate = $request->input('gate');
            $student = DB::table('leavereq_histories')->where('rollno',$rollno)->where('outdate',$outdate)->where('status','Approved')->first();

            if(!$student)
            {
                return redirect()->back()->with('error',"$rollno has no approved leave requests");
            }

            $existingLeave = DB::table('leavehistory')->where('rollno',$rollno)->whereNULL('intime')->first();
            
            $security_name = $security->name;
        
            if($existingLeave)
            {
                $intime = Carbon::now()->setTimezone('Asia/Kolkata');
                $ProposedInTime = Carbon::parse("$student->indate $student->intime",'Asia/Kolkata');
                $ProposedInTime->addHours(3);
                $isLate = $intime->gt($ProposedInTime);
                DB::table('leavehistory')->where('id',$existingLeave->id)->update(['intime' => $intime, 'inregistration' => $security_name, 'ingate' => $gate, 'late' => $isLate? 1:0]);
                if($student && $student->barcode)
                {
                    // Delete the Barcode Image
                    Storage::disk('public')->delete($student->barcode);
                    // Delete the row from leavereq_histories table
                    DB::table('leavereq_histories')->where('id',$student->id)->delete();
                }
                return redirect()->back()->with('success',"Leave Closed for $rollno at $intime");
            }
            else{
                $outtime = Carbon::now()->setTimezone('Asia/Kolkata');
                DB::table('leavehistory')->insert([
                    'rollno' => $student->rollno,
                    'name' => $student->name,
                    'phoneno' => $student->phoneno,
                    'placeofvisit' => $student->placeofvisit,
                    'purpose' => $student->purpose,
                    'outtime' => $outtime,
                    'outregistration' => $security_name,
                    'outgate' => $gate,
                    'intime' => null,
                    'inregistration' => null,
                    'ingate' => null,
                    'gender' => $student->gender,
                    'course' => $student->course,
                    'year' => $student->year,
                ]);
                return redirect()->back()->with('success',"Leave Started for $rollno at $outtime");
            }
        }
        else
            return redirect('/');
    }
    public function LeaveStatus(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $query = DB::table('leavehistory')->orderBy('outtime','desc'); 
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
            $LeaveHistory = $query->get();
            $name = "Leave History";
            return view('Logins.SecurityPages.Leave.LeaveHistory',['LeaveHistory' => $LeaveHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
    public function UnclosedLeaves(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $query = DB::table('leavehistory')->whereNULL('intime')->orderBy('outtime','desc'); 
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
            $LeaveHistory = $query->get();
            $name = "Unclosed Leaves";
            return view('Logins.SecurityPages.Leave.LeaveHistory',['LeaveHistory' => $LeaveHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
    public function BoysLeave(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $gender = "MALE";
            $query = DB::table('leavehistory')->where('gender',$gender)->orderBy('outtime','desc'); 
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
            $LeaveHistory = $query->get();
            $name = "Boys Leaves";
            return view('Logins.SecurityPages.Leave.LeaveHistory',['LeaveHistory' => $LeaveHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');;
        }
    }
    public function GirlsLeave(Request $request)
    {
        $security = Session::get('security');
        if($security)
        {
            $gender = "FEMALE";
            $query = DB::table('leavehistory')->where('gender',$gender)->orderBy('outtime','desc'); 
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
            $LeaveHistory = $query->get(); 
            $name = "Girls Leaves";
            return view('Logins.SecurityPages.Leave.LeaveHistory',['LeaveHistory' => $LeaveHistory, 'Name' => $name]);
        }
        else{
            return redirect('/');
        }
    }
}
