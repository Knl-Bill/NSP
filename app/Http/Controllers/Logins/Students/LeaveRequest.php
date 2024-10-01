<?php

namespace App\Http\Controllers\Logins\Students;

use App\Http\Controllers\Controller;
use App\Models\leavereq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Hash;
use Carbon\Carbon;
use File;

class LeaveRequest extends Controller
{
    public function LeaveRequestPage()
    {
        $student = Session::get('student');
        if($student)
            return view('Logins.StudentPages.LeaveRequest');
        else
            return redirect('/');
    }
    public function InsertLeaveRequest(Request $request)
    {
        $rule = ([
            'purpose' => 'required',
            'placeofvisit' => 'required',
            'outdate' => 'required',
            'outime' => 'required',
            'indate' => 'required',
            'intime' => 'required',
            'noofdays' => 'required',
        ]);
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) 
        {
            return back()->withInput()->withErrors(['Invalid' => 'Fill all the required details']);
        }
        if($request->noofdays>3)
        {
            $rules=([
                'image' => 'required|max:1536',
            ]);
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                return back()->withInput()->withErrors($validator);
            }
        }
        
        $user = Session::get('student');
        $result=new leavereq();
        $result->rollno=$user->rollno;
        if (DB::table('leavereqs')->where('rollno',$user->rollno)->exists()) 
        {
            return back()->withInput()->withErrors(['rollno' => 'Already a request is pending!']);
        }
        $result->name=$user->name;
        $result->phoneno=$user->phoneno;
        $result->placeofvisit=$request->placeofvisit;
        $result->purpose=$request->purpose;
        $result->outdate=$request->outdate;
        $result->outime=$request->outime;
        $result->indate=$request->indate;
        $result->intime=$request->intime;
        $result->faculty_email=$user->faculty_advisor;
        $result->warden_email=$user->warden;
        $result->noofdays=$request->noofdays;  
        $result->gender = $user->gender;
        $result->year = $user->batch;
        $result->course = $user->course;
        $result->stud_photo = $user->profile_picture;
        if ($request->hasFile('image')) 
        {
            $image = $request->file('image');
            $filename = $result->rollno . '_' . $result->outdate;  
            $photoPath = $image->storeAs('leavereq_emails', $filename, 'public');
        } 
        else 
        {
            $photoPath = null;
        }
        $result->image = $photoPath;
        $result->save();

        // Redirect or return a response
        return back()->with('success',"Leave Request submitted successfully.");
    }
    public function DisabledDetails()
    {
        $user = Session::get('student');
        if($user)
            $student = DB::table('students')->where('rollno',$user->rollno)->first();
        else    
            return redirect('/');
        if($student)
        {
            return response()->json([
                'rollno' => $student->rollno,
                'name' => $student->name,
                'phoneno' => $student->phoneno,
            ]);
        }
        else{
            return redirect('/');
        }
    }

    public function show_leave_det()
    {
        $user = Session::get('student');
        if($user!=NULL)
        {
            $stmt="select * from leavereq_histories where rollno='". $user->rollno ."' order by outdate desc;"; 
            $students = DB::select($stmt);
            $request = DB::table('leaveext')
             ->where('rollno', $user->rollno)
             ->first();
            return view('Logins.StudentPages.LeaveReqHistory',['students'=>$students,'request'=>$request]);
        }
        else
            return redirect('/');
    }
    public function show_pending_leave_det()
    {
        $user = Session::get('student');
        if($user)
        {
            $stmt="select * from leavereqs where rollno='". $user->rollno ."' order by outdate desc;"; 
            $students = DB::select($stmt);
            return view('Logins.StudentPages.PendingLeaveRequest',['students'=>$students]);
        }
        else
            return redirect('/');
    }
    public function GetLeaves()
    {
        $student = Session::get('student');
        if($student)
        {
            $rollno = $student->rollno;
            $LeaveHistory = DB::table('leavehistory')->where('rollno',$rollno)->orderBy('outtime','desc')->get();
            return view('Logins.StudentPages.LeaveHistory',['LeaveHistory' => $LeaveHistory]);
        }
        else
            return redirect('/');
    }
    
    public function InsertLeaveExtRequest(Request $request)
    {
        $request->validate([
            'indate' => 'required',
            'intime' => 'required',
            'reason' => 'required',
            'email' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
         ]);
        $user = Session::get('student');

        if (DB::table('leaveext')->where('rollno', $user->rollno)->exists()) {
            return back()->withInput()->withErrors(['rollno' => 'Already a request is pending!']);
        }
        $leavereq = DB::table('leavereq_histories')
         ->where('id', $request->leaveid)
         ->first();


        // Prepare data for insertion
        $data = [
            'rollno' => $user->rollno,
            'name' => $user->name,
            'phoneno' => $user->phoneno,
            'placeofvisit' => $leavereq->placeofvisit,
            'outdate' => $leavereq->outdate,
            'outime' => $leavereq->outime,
            'indate' => $leavereq->indate,
            'intime' => $leavereq->intime,
            'faculty_email' => $user->faculty_advisor,
            'warden_email' => $user->warden,
            'stud_photo' => $user->profile_picture,
            'leaveid' => $request->leaveid,
            'ext_reason' => $request->reason,
            'new_indate' => $request->indate,
            'new_intime' => $request->intime,
        ];
        
        // Handle file upload
        if ($request->hasFile('email')) {
            $image = $request->file('email');
            $filename = $user->rollno . '_ext_' . $request->indate;
            $photoPath = $image->storeAs('leavereq_emails', $filename, 'public');
            $data['image'] = $photoPath;
        }
        
        DB::table('leaveext')->insert($data);


        // Redirect or return a response
        return back()->with('success',"Leave Extension requested successfully.");
    }

}