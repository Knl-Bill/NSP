<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Hash;
use Str;
use Carbon\Carbon;
use Mail;

class StudentController extends Controller
{
    public function StudentSignUp()
    {
        $stmt="select * from admin_logins;"; 
        $students = DB::select($stmt);
        return view('Logins.StudentSignUp',['students'=>$students]);
    }
    public function submit_signup_request_view()
    {
        return view('SignupRequest');
    }
    
    public function submit_signup_request(Request $request)
    {
          $request->validate([
              'email' => 'required|email|exists:nitpy',
          ]);
          $roll="select rollno from nitpy where email='".$request->email."';";
          $rollno=DB::select($roll);
          $name="select name from nitpy where email='".$request->email."';";
          $stud_name=DB::select($name);
          $token = Str::random(64);
          if(DB::table('nitpy_signup')->where('email',$request->email)->exists())
          {
            DB::table('nitpy_signup')
            ->where('email', $request->email)
            ->update([
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
          }
          else{
              DB::table('nitpy_signup')->insert([
                  'email' => $request->email, 
                  'token' => $token, 
                  'created_at' => Carbon::now()
                ]);
          }
        
          Mail::send('email.studentsignup', ['token' => $token,'rollno'=>$rollno[0]->rollno, 'name' => $stud_name[0]->name, 'email' => $request->email], function($message) use($request){
              $message->to($request->email);
              $message->subject('Student SignUp');
          });
        
          return back()->with('message', 'We have e-mailed your Signup Link!');
    }
    public function showSignupForm($token,$rollno, $name, $email)
    { 
        $query = "select * from nitpy_signup where email='". $email. "';";
        $check = DB::select($query);
        if(!empty($check))
        {
            if($check[0]->token !== $token)
                return redirect('student_signup_request')->with('error', 'Invalid Token');
            $stmt="select * from admin_logins;"; 
            $students = DB::select($stmt);
            return view('Logins.StudentSignUp', ['token' => $token,'students'=>$students,'rollno'=>$rollno, 'name' => $name, 'email' => $email]);
        }
        else
            return redirect('student_signup_request')->with('error','Signup Request Invalid');
    }
    
    public function insert(Request $request, $rollno, $email, $name)
    {
        $request->validate([
            'email' => 'required|email|unique:students',
            'name' => 'required|string|max:255|regex:/^[a-zA-Z ]+$/',
            'phoneno' => 'required| min:10 |max:10| unique:students',
            'rollno'=>'required|string|min:9|max:9|unique:students',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'confirmpass' => 'required|same:password',
            'course' => 'required',
            'gender' => 'required',
            'batch' => 'required',
            'dept' => 'required',
            'hostelname' => 'required',
            'roomno' => 'required',
            'profile_photo' => 'required',
        ]);
        $base64Image = $request->input('profile_photo');
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
            $imageType = $matches[1]; // Get the image type (jpeg, png, etc.)
            $imageData = base64_decode(str_replace($matches[0], '', $base64Image)); // Decode the base64 string
        
            $profile_name = $request->input('rollno') . '.' . $imageType; // Use rollno as part of the filename
            $profilePhotoPath = 'profile/' . $profile_name;
            // Save the image data
            Storage::disk('public')->put($profilePhotoPath, $imageData);
        }
        $phoneno= $request->input('phoneno');
        $course= $request->input('course');
        $batch= $request->input('batch');
        $dept= $request->input('dept');
        $gender= $request->input('gender');
        $hostelname= $request->input('hostelname');
        $floor=$request->input('floors');
        $roomno= $request->input('roomno');
        $faculty_advisor=$request->input('faculty_advisor');
        $warden=$request->input('warden');
        $password= $request->input('password');
        $hashedpassword=Hash::make($password);
        $BarcodeContent = $rollno;
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($BarcodeContent, $generator::TYPE_CODE_128);
        
        // $profile_photo = $request->file('profile_photo');
       
        $path = 'student_roll_barcodes/' . $rollno. '.png';
        Storage::disk('public')->put($path, $barcode);
        
        $room=$floor.'-'.$roomno;
        
        DB::insert('insert into students (rollno,name,phoneno,email,course,batch,dept,gender,hostelname,roomno,faculty_advisor,warden,password,barcode,profile_picture) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$rollno,$name,$phoneno,$email,$course,$batch,$dept,$gender,$hostelname,$room,$faculty_advisor,$warden,$hashedpassword,$path,$profile_name] );
        DB::table('nitpy_signup')->where(['email'=> $email])->delete();
        return redirect()->route('StudentLogin')->with('success',"SignUp successful ! Please Login to continue...");   
    }
    public function login() { 
        return view('Logins.Student'); 
    }
    public function loginfinal(Request $request) 
    { 
        $rules = [
            'rollno'=>'required|string|min:9|max:9|exists:students',
            'password' => 'required|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return redirect('login')->withInput()->withErrors($validator);
        }
        else
        {
            $rollno = $request->input('rollno');
            if(DB::table('students')->where('rollno',$rollno)->exists())
            {
                $password= $request->input('password');
                $user = DB::table('students')->where('rollno', $rollno)->value('password');
                if(HASH::check($password,$user))
                    return redirect()->route('StudentDashboard');
                else
                    return back()->withInput()->withErrors(['password' => 'Wrong Password!']);
            }
        }
            
    }
    public function WebTeam()
    {
        return view('Logins.WebTeam');
    }
}
