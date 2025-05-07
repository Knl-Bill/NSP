<?php

namespace App\Http\Controllers\Logins\Mess;
use App\Http\Requests;
use App\Models\password_reset_mess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use DB;
use Carbon\Carbon;
use Mail;
use Hash;

class ForgotPasswordMessController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('Logins.MessPages.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:mess_logins',
        ]);

        $token = Str::random(64);
        if(DB::table('password_reset_mess')->where('email',$request->email)->exists())
        {
            DB::table('password_reset_mess')
            ->where('email', $request->email)
            ->update([
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }
        else{
            DB::table('password_reset_mess')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
        }

        Mail::send('email.MessforgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token) 
    { 
        return view('Logins.MessPages.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:mess_logins',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'password_confirmation' => 'required|same:password',
        ]);

        $updatePassword = DB::table('password_reset_mess')
                            ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = DB::table('mess_logins')->where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_mess')->where(['email'=> $request->email])->delete();

        return redirect()->route('MessLogin')->with('success', "Password Changed Successfully");
    }
}