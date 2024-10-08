<?php

namespace App\Http\Controllers\Logins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminLogin extends Controller
{
    //
    public function AdminDashboard()
    {
       $admin = Session::get('admin');
       if(!$admin)
        return redirect('/');
        $email = $admin->email;
        
        // Count entries in the 'leavereqs' table
        $leavereqsCount = DB::table('leavereqs')
            ->where('faculty_email', $email)
            ->orWhere('warden_email', $email)
            ->count();
        
        // Count entries in the 'leaveext' table
        $leaveextCount = DB::table('leaveext')
            ->where('faculty_email', $email)
            ->orWhere('warden_email', $email)
            ->count();
        
        // Sum both counts
        $totalCount = $leavereqsCount + $leaveextCount;
        
        // Pass the total count to the view
        return view('Logins.AdminPages.AdminDashboard', ['count' => $totalCount]);
    }
    public function AdminLoginVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|min:8|max:100',
            'password' => 'required',
        ]);
        //$validator = Validator::make($request->all(), $rules);
       
        $email = $request->input('email');
        $password = $request->input('password');

        // Retrieve the user by their phone number
        $user = DB::table('admin_logins')->where('email', $email)->first();
        if($user) 
        {
            // If the user exists, check if the password matches
            if(HASH::check($password,$user->password)) 
            {
                // Password matches, redirect to dashboard
                Session::put('admin',$user);
                return redirect()->route('AdminDashboard');
            } 
            else 
            {
                // Password does not match, show error message
                return back()->withInput()->withErrors(['password' => 'Wrong Password!']);
            }
        } 
        else 
        {
            // User not found, show error message
            return back()->withInput()->withErrors(['email' => 'User does not Exist!']);
        }
    }
    public function AdminSession()
    {
        $user = Session::get('admin');
        if($user)
            return $user->name;
        else   
            return "Guest";
    }
    public function AdminLogout()
    {
        Session::forget('admin');
        return back();
    }
    public function AdminProfile()
    {
        $user = Session::get('admin');
        if($user != NULL)
        {
            $user = Session::get('admin');
            $stmt="select * from admin_logins where email='". $user->email ."';"; 
            $students = DB::select($stmt);
            return view('Logins.AdminPages.Admin_Profile',['students'=>$students]);
        }
        else
            return redirect('/');
    }
}
