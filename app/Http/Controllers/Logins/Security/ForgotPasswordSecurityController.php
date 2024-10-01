<?php

namespace App\Http\Controllers\Logins\Security;
use App\Http\Requests;
use App\Models\password_reset_security;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use DB;
use Carbon\Carbon;
use Mail;
use Hash;
class ForgotPasswordSecurityController extends Controller
{
    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('Logins.SecurityPages.forgetPassword');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'phoneno' => 'required|exists:security_logins|min:10|max:10',
          ]);
  
          $token = Str::random(64);
          $phoneno=$request->phoneno;
          $email = DB::table('security_logins')
            ->where('phoneno', $phoneno)
            ->value('email');
          if(DB::table('password_reset_securities')->where('email',$email)->exists())
          {
            DB::table('password_reset_securities')
            ->where('email', $email)
            ->update([
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
          }
          else{
            DB::table('password_reset_securities')->insert([
              'email' => $email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
          }
  
          Mail::send('email.SecurityforgetPassword', ['token' => $token, 'phoneno' => $phoneno], function($message) use($email){
              $message->to($email);
              $message->subject('Reset Password');
          });
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token, $phoneno)
      { 
         return view('Logins.SecurityPages.forgetPasswordLink', ['token' => $token, 'phoneno' => $phoneno]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'phoneno' => 'required|exists:security_logins|min:10|max:10',
              'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
              'password_confirmation' => 'required|same:password',
          ]);
          if($request->req_phoneno != $request->phoneno)
            {
                return back()->withInput()->with('error', 'Invalid Request, Please request again!');
            }
            $email = DB::table('security_logins')
            ->where('phoneno', $request->phoneno)
            ->value('email');
          $updatePassword = DB::table('password_reset_securities')
                              ->where([
                                'email' => $email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = DB::table('security_logins')->where('phoneno', $request->phoneno)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_reset_securities')->where(['email'=> $email])->delete();
  
          return redirect()->route('SecurityLogin')->with('success',"Password Changed Successfully");
      }
}
