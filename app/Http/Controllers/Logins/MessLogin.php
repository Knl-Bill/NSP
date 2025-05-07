<?php

namespace App\Http\Controllers\Logins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MessLogin extends Controller
{
    public function MessDashboard()
    {
        $mess = Session::get('mess');
        if(!$mess || !$mess->mess_hall) {
            return redirect('/')->with('error', 'Please login as mess admin');
        }
        return view('Logins.MessPages.MessDashboard');
    }

    public function MessLoginVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
       
        $email = $request->input('email');
        $password = $request->input('password');

        // Retrieve the mess admin from mess_logins table
        $user = DB::table('mess_logins')
                  ->where('email', $email)
                  ->first();
                  
        if($user) 
        {
            // If the user exists, check if the password matches
            if(Hash::check($password, $user->password)) 
            {
                // Password matches, redirect to dashboard
                Session::put('mess', $user);
                return redirect()->route('MessDashboard');
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
            return back()->withInput()->withErrors(['email' => 'Invalid mess staff credentials']);
        }
    }

    public function MessSession() 
    {
        $user = Session::get('mess');
        if($user)
            return $user->name;
        else   
            return "Guest";
    }

    public function MessLogout()
    {
        Session::forget('mess');
        return redirect('/');
    }

    public function MessProfile()
    {
        $user = Session::get('mess');
        if($user)
        {
            $stmt = "select * from mess_logins where email='". $user->email ."';"; 
            $details = DB::select($stmt);
            return view('Logins.MessPages.Mess_Profile', ['details' => $details]);
        }
        else
            return redirect('/');
    }
}