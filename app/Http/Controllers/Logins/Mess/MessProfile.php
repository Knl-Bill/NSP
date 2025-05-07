<?php

namespace App\Http\Controllers\Logins\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MessProfile extends Controller
{
    public function changePasswordSave(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Session::get('mess');
        if($user)
        {
            $current_user = DB::table('mess_logins')->where('email', $user->email)->first();
            if(Hash::check($request->current_password, $current_user->password))
            {
                DB::table('mess_logins')
                    ->where('email', $user->email)
                    ->update(['password' => Hash::make($request->new_password)]);
                return back()->with('success', 'Password Changed Successfully!');
            }
            else
            {
                return back()->withInput()->withErrors(['current_password' => 'Current Password is Incorrect!']);
            }
        }
        else
            return redirect('/');
    }

    public function changephoneno(Request $request)
    {
        $request->validate([
            'phoneno' => 'required|string|min:10|max:10',
            'password' => 'required',
        ]);

        $user = Session::get('mess');
        if($user)
        {
            $current_user = DB::table('mess_logins')->where('email', $user->email)->first();
            if(Hash::check($request->password, $current_user->password))
            {
                DB::table('mess_logins')
                    ->where('email', $user->email)
                    ->update(['phoneno' => $request->phoneno]);
                return back()->with('success', 'Phone Number Changed Successfully!');
            }
            else
            {
                return back()->withInput()->withErrors(['password' => 'Password is Incorrect!']);
            }
        }
        else
            return redirect('/');
    }

    public function changeemail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:mess_logins',
            'password' => 'required',
        ]);

        $user = Session::get('mess');
        if($user)
        {
            $current_user = DB::table('mess_logins')->where('email', $user->email)->first();
            if(Hash::check($request->password, $current_user->password))
            {
                DB::table('mess_logins')
                    ->where('email', $user->email)
                    ->update(['email' => $request->email]);
                return back()->with('success', 'Email Changed Successfully!');
            }
            else
            {
                return back()->withInput()->withErrors(['password' => 'Password is Incorrect!']);
            }
        }
        else
            return redirect('/');
    }
}