<?php

namespace App\Http\Controllers\Logins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentLogin extends Controller
{
    //
    public function StudentDashboard()
    {
        return view('Logins.StudentPages.StudentDashboard');
    }
    public function StudentProfile()
    {
        $user = Session::get('student');
        
        if($user)
        {
            $stmt1="select * from admin_logins;"; 
            $admins = DB::select($stmt1);
            $stmt2="select * from students where rollno='". $user->rollno ."';"; 
            $students = DB::select($stmt2);
            $person = "select * from students where rollno='". $user->rollno ."';";
            $persondata = DB::select($person);
            $fac = "select name from admin_logins where email='". $persondata[0]->faculty_advisor ."';";
            $fac_adv = DB::select($fac);
            $war = "select name from admin_logins where email='". $persondata[0]->warden ."';";
            $warden = DB::select($war);
            return view('profile.stud_update',['students'=>$students,'admins'=>$admins, 'faculty_advisor'=>$fac_adv[0]->name, 'warden'=>$warden[0]->name]);
        }
        else
            return redirect('/');
    }
    public function StudentLoginVerify(Request $request)
    {
        $rules = [
            'rollno'=>'required|string|min:9|max:9|exists:students',
            'password' => 'required|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return redirect('StudentLogin')->withInput()->withErrors($validator);
        }
        else
        {
            $rollno = $request->input('rollno');
            $user1 = DB::table('students')->where('rollno', $rollno)->first();
            if(DB::table('students')->where('rollno',$rollno)->exists())
            {
                $password= $request->input('password');
                $user = DB::table('students')->where('rollno', $rollno)->value('password');
                if(HASH::check($password,$user))
                {
                    Session::put('student',$user1);
                    $onesignalUserId = $request->input('onesignal_user_id');
                    if ($onesignalUserId) {
                        DB::table('students')
                            ->where('rollno', $rollno)
                            ->update(['onesignal_user_id' => $onesignalUserId]);
                    }
                    return redirect()->route('StudentDashboard');
                }
                    
                else
                    return back()->withInput()->withErrors(['password' => 'Wrong Password!']);
            }
        }
    }
    public function StudentSession() 
    {
        $user = Session::get('student');
        if($user)
            return $user->name;
        else   
            return "Guest";
    }

    public function StudentLogout()
    {
        Session::forget('student');
        return back();
    }
}
