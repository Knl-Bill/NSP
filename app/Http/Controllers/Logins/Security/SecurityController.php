<?php

namespace App\Http\Controllers\Logins\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SecurityController extends Controller
{
    public function OutingText()
    {
        $user = Session::get('security');
        if($user)
            return view('Logins.SecurityPages.Outing.TextInput');
        else
            return redirect('/');
    }
    public function LeaveText()
    {
        $user = Session::get('security');
        if($user)
            return view('Logins/SecurityPages.Leave.TextInput');
        else
            return redirect('/');
    }
    public function OutingScanner()
    {
        $user = Session::get('security');
        if($user)
            return view('Logins.SecurityPages.Outing.OutingScanner');
        else
            return redirect('/');
    }
    public function LeaveScanner()
    {
        $user = Session::get('security');
        if($user)
            return view('Logins.SecurityPages.Leave.LeaveScanner');
        else
            return redirect('/');
    }
    public function GirlsRegisterText()
    {
        $user = Session::get('security');
        if($user)
            return view('Logins.SecurityPages.GirlsRegister.TextInput');
        else
            return redirect('/');
    }
    public function GirlsRegisterScanner()
    {
        $user = Session::get('security');
        if($user)
            return view('Logins.SecurityPages.GirlsRegister.GirlsRegisterScanner');
        else
            return redirect('/');
    }
}
