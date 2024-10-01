<?php

namespace App\Http\Controllers\Logins\Admin;
use App\Models\student;
use App\Http\Controllers\Controller;
use App\Notifications\LeaveRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\leavereq_history;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Events\LeaveRequestStatusChanged;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function LeaveRequests()
    {
        $admin = Session::get('admin');
        if($admin!=NULL)
        {
            $adminEmail = $admin->email;

            if ($adminEmail) 
            {
                $isFaculty=DB::table('leavereqs')->where('faculty_email', $adminEmail)->exists();
                $isWarden=DB::table('leavereqs')->where('warden_email', $adminEmail)->exists();

                if ($isFaculty) {
                    session(['role' => 'faculty']);
                } elseif ($isWarden) {
                    session(['role' => 'warden']);
                }
            }
            $fac_war="select * from leavereqs where faculty_email='". $adminEmail ."' or warden_email='".$adminEmail."';"; 
            $students=DB::select($fac_war);
            $leaveextCount = DB::table('leaveext')
            ->where('faculty_email', $adminEmail)
            ->orWhere('warden_email', $adminEmail)
            ->count();
            return view('Logins/AdminPages.LeaveRequest',['students'=>$students,'count'=>$leaveextCount]);
        }
        else
            return redirect('/');
    }

    public function warden_approval(Request $request,$rollno)
    {
        $request->validate([
            'war_acc'=>'required',
        ]);
        $student = DB::table('leavereqs')->where('rollno', $rollno)->first();
        if($request->war_acc=="Accept" or $request->war_acc == "Paccept")
        {
            $check = DB::table('leavereqs')->where('rollno',$rollno)->where('outdate',$student->outdate)->first();
            if($check->faculty_adv==0 && $request->war_acc != "Paccept")
            {
                return back()->with('fac_req','Faculty Advisors Approval Needed!');
            }
            $admin = Session::get('admin');
            if($admin!=NULL)
            {
                DB::table('leavereqs')->where('rollno',$rollno )->update(['warden' => 1]);
                
                $result=new leavereq_history();
                $result->rollno=$rollno;
                $result->name=$student->name;
                $result->phoneno=$student->phoneno;
                $result->placeofvisit=$student->placeofvisit;
                $result->purpose=$student->purpose;
                $result->outdate=$student->outdate;
                $result->outime=$student->outime;
                $result->indate=$student->indate;
                $result->intime=$student->intime;
                $result->noofdays=$student->noofdays;
                $result->faculty_email=$student->faculty_email;
                $result->warden_email=$student->warden_email;
                $result->warden=1;
                $result->faculty_adv=$student->faculty_adv;
                if($request->war_acc == "Paccept")
                {
                    $result->status="Provisionally Approved";
                    $result->remark=$request->decline_reason;
                }
                else
                    $result->status="Approved";
                $result->image=$student->image;
                $result->gender = $student->gender;
                $result->year = $student->year;
                $result->course = $student->course;
                $result->stud_photo = $student->stud_photo;
                
                $formattedOutdate = Carbon::parse($student->outdate)->format('Ymd');
                $BarcodeContent = $rollno . '_' . $formattedOutdate;

                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                $barcode = $generator->getBarcode($BarcodeContent, $generator::TYPE_CODE_128);
                $path = 'barcodes/' . $rollno . '_' . $student->outdate . '.png';
                Storage::disk('public')->put($path, $barcode);
                $result->barcode = $path;
                $result->save();
                DB::table('leavereqs')->where(['rollno'=> $rollno])->delete();
                return back();
            }
            else
                return redirect('/');
        }
        else
        {
            $check = DB::table('leavereqs')->where('rollno',$rollno)->where('outdate',$student->outdate)->first();
            if($check->faculty_adv==0)
            {
                return back()->with('fac_req','Faculty Advisors Approval Needed!');
            }
            $admin = Session::get('admin');
            if($admin!=NULL)
            {
                DB::table('leavereqs')->where('rollno',$rollno)->update(['warden' =>2]);
                $result=new leavereq_history();
                $result->rollno=$rollno;
                $result->name=$student->name;
                $result->phoneno=$student->phoneno;
                $result->placeofvisit=$student->placeofvisit;
                $result->purpose=$student->purpose;
                $result->outdate=$student->outdate;
                $result->outime=$student->outime;
                $result->indate=$student->indate;
                $result->intime=$student->intime;
                $result->noofdays=$student->noofdays;
                $result->faculty_adv=$student->faculty_adv;
                $result->faculty_email=$student->faculty_email;
                $result->warden_email=$student->warden_email;
                $result->warden=2;
                $result->status="Declined";
                $result->remark=$request->decline_reason;
                $result->image=$student->image;
                $result->gender = $student->gender;
                $result->year = $student->year;
                $result->course = $student->course;
                $result->stud_photo = $student->stud_photo;
                $result->save();
                DB::table('leavereqs')->where(['rollno'=> $rollno])->delete();
                $email=$admin->email;
                $fac_war="select * from leavereqs where faculty_email='". $email ."' or warden_email='".$email."';"; 
                $students=DB::select($fac_war);
                // if($students==NULL)
                //     return redirect('AdminDashboard')->with('message','There are no pending leave requests');
                return back();
            }
            else
                return redirect('/');
        }
    }
    
    public function faculty_approval(Request $request,$rollno)
    {
        $request->validate([
            'fac_acc'=>'required',
        ]);
        if($request->fac_acc=="Accept")
        {
            DB::table('leavereqs')->where('rollno',$rollno)->update(['faculty_adv' =>1]);
            event(new LeaveRequestStatusChanged($rollno, 'accepted'));
            return back();
        }   
        else
        {
            $admin = Session::get('admin');
            if($admin!=NULL)
            {
                DB::table('leavereqs')->where('rollno',$rollno)->update(['faculty_adv' =>2]);
                $student = DB::table('leavereqs')->where('rollno', $rollno)->first();
                $result=new leavereq_history();
                $result->rollno=$rollno;
                $result->name=$student->name;
                $result->phoneno=$student->phoneno;
                $result->placeofvisit=$student->placeofvisit;
                $result->purpose=$student->purpose;
                $result->outdate=$student->outdate;
                $result->outime=$student->outime;
                $result->indate=$student->indate;
                $result->intime=$student->intime;
                $result->noofdays=$student->noofdays;
                $result->warden=$student->warden;
                $result->faculty_email=$student->faculty_email;
                $result->warden_email=$student->warden_email;
                $result->faculty_adv=2;
                $result->status="Declined";
                $result->remark=$request->decline_reason;
                $result->image=$student->image;
                $result->gender = $student->gender;
                $result->year = $student->year;
                $result->course = $student->course;
                $result->stud_photo = $student->stud_photo;
                $result->save();
                DB::table('leavereqs')->where(['rollno'=> $rollno])->delete();
                $email=$admin->email;
                $fac_war="select * from leavereqs where faculty_email='". $email ."' or warden_email='".$email."';"; 
                $students=DB::select($fac_war);
                // if($students==NULL)
                //     return redirect('AdminDashboard')->with('message','There are no pending leave requests');
                return back();
            }
            else 
                return redirect('/');
        }
    }
    public function show_leave_det()
    {
        $admin = Session::get('admin');
        if($admin!=NULL)
        {
            $email=$admin->email;
            $students = DB::select("select * from leavereq_histories where faculty_email='". $email ."' or warden_email='".$email."' order by outdate desc;");
            return view('Logins.AdminPages.LeaveReqHistory',['students'=>$students]);
        }
        else
            return redirect('/');
    }
    public function LeaveExtensionView()
    {
        $admin = Session::get('admin');
        if($admin!=NULL)
        {
            $adminEmail = $admin->email;

            $students = DB::table('leaveext')->where('faculty_email', $adminEmail)
                            ->orWhere('warden_email', $adminEmail)
                            ->get();

            // $students=DB::select($fac_war);
            // if($students==NULL)
            //     return back()->with('message','There are no pending leave requests');
            return view('Logins/AdminPages.LeaveExtensionView',['students'=>$students]);
        }
        else
            return redirect('/');
    }
    public function faculty_approval_ext(Request $request,$rollno)
    {
        $request->validate([
            'fac_acc'=>'required',
        ]);
        $admin = Session::get('admin');
        if($admin)
        {
            if($request->fac_acc=="Accept")
            {
                DB::table('leaveext')->where('rollno',$rollno)->update(['faculty_adv' =>1]);
                event(new LeaveRequestStatusChanged($rollno, 'accepted'));
                return back();
            }
            else{
                $request->validate([
                'decline_reason' => 'required_if:fac_acc,Decline|string|max:255',
                ]);
                DB::table('leaveext')->where('rollno',$rollno)->update(['faculty_adv' => 2]);
                DB::table('leaveext')->where('rollno',$rollno)->delete();
                return back();
            }
        }
        else
            return redirect('/');
    }
    public function warden_approval_ext(Request $request,$rollno)
    {
        $request->validate([
            'war_acc'=>'required',
        ]);
        $admin = Session::get('admin');
        $student = DB::table('leaveext')->where('rollno', $rollno)->first();
        if($admin)
        {
            $check = DB::table('leaveext')->where('rollno',$rollno)->where('outdate',$student->outdate)->first();
            if($check->faculty_adv==0 && $request->war_acc != "Paccept")
            {
                return back()->with('fac_req','Faculty Advisors Approval Needed!');
            }
            else if(($check->faculty_adv==1 && ($request->war_acc == "Accept" || $request->war_acc == "Paccept")) || ($check->faculty_adv==0 && $request->war_acc == "Paccept"))
            {
                $ChangeTime = Carbon::now();
                DB::table('leaveext')->where('rollno',$rollno)->update(['warden' => 1]);
                DB::table('leavereq_histories')->where('id',$student->leaveid)->update(['indate' => $student->new_indate, 'intime' => $student->new_intime, 'updated_at' => $ChangeTime, 'purpose' => $student->ext_reason]);
                if($request->war_acc == "Paccept")
                {
                    DB::table('leavereq_histories')->where('id',$student->leaveid)->update(['remark' => $request->decline_reason]);
                }
                $leave = DB::table('leavereq_histories')->where('id',$student->leaveid)->first();
                if ($leave->image) {
                    Storage::disk('public')->delete($leave->image);
                }
            
                // Move and rename the new image
                if ($student->image) {
                    $newFilename = $rollno . '_' . $leave->outdate . '.' . pathinfo($student->image, PATHINFO_EXTENSION);
                    $newPath = 'leavereq_emails/' . $newFilename;
            
                    // Move and rename the image
                    Storage::disk('public')->move($student->image, $newPath);
            
                    // Optionally, update the path in the database
                    DB::table('leavereq_histories')
                        ->where('id', $student->leaveid)
                        ->update(['image' => $newPath]);
                    
                }
                DB::table('leaveext')->where('rollno',$rollno)->delete();
                return back();
            }
            else if($request->war_acc === "Decline")
            {
                $request->validate([
                'decline_reason' => 'required_if:war_acc,Decline|string|max:255',
                ]);
                DB::table('leaveext')->where('rollno',$rollno)->update(['warden' => 2]);
                DB::table('leaveext')->where('rollno',$rollno)->delete();
                return back();
            }
        }
        else
            return redirect('/');
    }
}
