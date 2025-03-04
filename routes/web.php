<?php
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Logins\Admin\AdminController;
use App\Http\Controllers\Logins\Admin\ForgotPasswordAdminController;
use App\Http\Controllers\Logins\Admin\AdminProfile;
use App\Http\Controllers\Logins\Security\SecurityProfile;
use App\Http\Controllers\Logins\Security\ForgotPasswordSecurityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Logins\LoginController;
use App\Http\Controllers\Logins\Students\LeaveRequest;
use App\Http\Controllers\Logins\SecurityLogin;
use App\Http\Controllers\Logins\Security\SecurityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\stud_profile;
use App\Http\Controllers\Logins\StudentLogin;
use App\Http\Controllers\Logins\Students\OutingHistory;
use App\Http\Controllers\Logins\Security\OutingController;
use App\Http\Controllers\Logins\Security\GlhOutingController;
use App\Http\Controllers\Logins\AdminLogin;
use App\Http\Controllers\Logins\Security\LeaveController;
use App\Http\Controllers\GuestEntry;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Logins.main');

});

//Reset Password for Security
Route::get('reset_pass_sec', [ForgotPasswordSecurityController::class, 'showForgetPasswordForm'])->name('reset_pass_sec');
Route::post('sec-forget-password', [ForgotPasswordSecurityController::class, 'submitForgetPasswordForm'])->name('sec-forget.password.post'); 
Route::get('sec-reset.password/{token}/{phoneno}', [ForgotPasswordSecurityController::class, 'showResetPasswordForm'])->name('sec-reset.password.get');
Route::post('sec-reset.password', [ForgotPasswordSecurityController::class, 'submitResetPasswordForm'])->name('sec-reset.password.post');

//Reset Password for Admin
Route::get('reset_pass_admin', [ForgotPasswordAdminController::class, 'showForgetPasswordForm'])->name('reset_pass_admin');
Route::post('admin-forget-password', [ForgotPasswordAdminController::class, 'submitForgetPasswordForm'])->name('admin-forget.password.post'); 
Route::get('admin-reset.password/{token}', [ForgotPasswordAdminController::class, 'showResetPasswordForm'])->name('admin-reset.password.get');
Route::post('admin-reset.password', [ForgotPasswordAdminController::class, 'submitResetPasswordForm'])->name('admin-reset.password.post');

//Student SignUp
Route::get('student_signup_request', [StudentController::class, 'submit_signup_request_view'])->name('student_signup_request');
Route::post('student-signup-request', [StudentController::class, 'submit_signup_request'])->name('student-signup.request.post');
Route::get('student-signup.page/{token}/{rollno}/{name}/{email}', [StudentController::class, 'showSignupForm'])->name('student-signup.page.get');
Route::post('/signup/{rollno}/{email}/{name}', [StudentController::class, 'insert'])->name('signup');
Route::get('/WebTeam', [StudentController::class,'WebTeam'])->name('WebTeam');
Route::get('/StudentSignUp', [StudentController::class,'StudentSignUp'])->name('StudentSignUp');

// Guest Register
Route::get('/GuestEntry', [GuestEntry::class, 'GuestEntry'])->name('GuestEntry');
Route::get('/GuestRegister', [GuestEntry::class, 'GuestRegister'])->name('GuestRegister');
Route::post('/InsertGuest', [GuestEntry::class, 'InsertGuest'])->name('InsertGuest');
Route::post('/CloseGuestEntry/{id}', [GuestEntry::class, 'CloseGuestEntry'])->name('CloseGuestEntry');

//Forgot Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget-password');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset.password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset.password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Login Controller
Route::get('/AdminLogin',[LoginController::class,'AdminLogin'])->name('AdminLogin');
Route::get('/StudentLogin',[LoginController::class,'StudentLogin'])->name('StudentLogin');
Route::get('/SecurityLogin',[LoginController::class,'SecurityLogin'])->name('SecurityLogin');

// SecurityLogin Controller
Route::get('SecurityDashboard',[SecurityLogin::class,'SecurityDashboard'])->name('SecurityDashboard');
Route::post('/SecurityLoginVerify',[SecurityLogin::class,'SecurityLoginVerify'])->name('SecurityLoginVerify');
Route::get('/SecuritySession',[SecurityLogin::class,'SecuritySession'])->name('SecuritySession');
Route::get('/SecurityLogout',[SecurityLogin::class,'SecurityLogout'])->name('SecurityLogout');

//Admin Controller
Route::get('/leavereqshist_admin', [AdminController::class,'show_leave_det'])->name('leavereqshist_admin');
Route::get('/LeaveRequests',[AdminController::class,'LeaveRequests'])->name('LeaveRequests');
Route::post('/LeaveRequestWarden/{rollno}',[AdminController::class,'warden_approval']);
Route::post('/LeaveRequestFaculty/{rollno}',[AdminController::class,'faculty_approval']);
Route::get('/LeaveExtension', [AdminController::class, 'LeaveExtensionView'])->name('LeaveExtension');
Route::post('/LeaveExtensionFaculty/{rollno}',[AdminController::class,'faculty_approval_ext'])->name('LeaveExtensionFaculty');
Route::post('/LeaveExtensionWarden/{rollno}', [AdminController::class, 'warden_approval_ext'])->name('LeaveExtensionWarden');

// Security Controller
Route::get('/OutingText',[SecurityController::class,'OutingText'])->name('OutingText');
Route::get('/LeaveText',[SecurityController::class,'LeaveText'])->name('LeaveText');
Route::get('/OutingScanner',[SecurityController::class,'OutingScanner'])->name('OutingScanner');
Route::get('/LeaveScanner',[SecurityController::class,'LeaveScanner'])->name('LeaveScanner');
Route::get('/GirlsRegisterText',[SecurityController::class,'GirlsRegisterText'])->name('GirlsRegisterText');
Route::get('/GirlsRegisterScanner',[SecurityController::class,'GirlsRegisterScanner'])->name('GirlsRegisterScanner');

// StudentLogin Controller
Route::get('/StudentDashboard',[StudentLogin::class,'StudentDashboard'])->name('StudentDashboard');
Route::post('StudentLoginVerify',[StudentLogin::class,'StudentLoginVerify'])->name('StudentLoginVerify');
Route::get('StudentSession',[StudentLogin::class,'StudentSession'])->name('StudentSession');
Route::get('StudentLogout',[StudentLogin::class,'StudentLogout'])->name('StudentLogout');
Route::get('StudentProfile',[StudentLogin::class,'StudentProfile'])->name('StudentProfile');

// Student Page's Outing Controller
Route::get('/GetOutings',[OutingHistory::class,'GetOutings'])->name('GetOutings');
Route::get('/GetGLHOutings',[OutingHistory::class,'GetGLHOutings'])->name('GetGLHOutings');

// Security Page's Outing Controller
Route::post('/InsertOuting',[OutingController::class,'InsertOuting'])->name('InsertOuting');
Route::get('/OutingStatus',[OutingController::class,'OutingStatus'])->name('OutingStatus');
Route::get('/UnclosedOuting',[OutingController::class,'UnclosedOuting'])->name('UnclosedOuting');
Route::get('/BoysOuting',[OutingController::class,'BoysOuting'])->name('BoysOuting');
Route::get('/GirlsOuting',[OutingController::class,'GirlsOuting'])->name('GirlsOuting');

//GLH Outing Controller
Route::post('/GLHOuting',[GlhOutingController::class,'GLHOuting'])->name('GLHOuting');
Route::get('/GLHOutingStatus',[GlhOutingController::class,'GLHOutingStatus'])->name('GLHOutingStatus');
Route::get('/GLHUnclosedOuting',[GlhOutingController::class,'GLHUnclosedOuting'])->name('GLHUnclosedOuting');

// Security Pages's Leave Controller
Route::post('/InsertLeave',[LeaveController::class,'InsertLeave'])->name('InsertLeave');
Route::post('/InsertScannerLeave',[LeaveController::class,'InsertScannerLeave'])->name('InsertScannerLeave');
Route::get('/LeaveStatus',[LeaveController::class,'LeaveStatus'])->name('LeaveStatus');
Route::get('/UnclosedLeaves',[LeaveController::class,'UnclosedLeaves'])->name('UnclosedLeaves');
Route::get('/BoysLeave',[LeaveController::class,'BoysLeave'])->name('BoysLeave');
Route::get('/GirlsLeave',[LeaveController::class,'GirlsLeave'])->name('GirlsLeave');

// Student Controllers
Route::get('/LeaveRequestPage',[LeaveRequest::class,'LeaveRequestPage'])->name('LeaveRequestPage');
Route::post('/InsertLeaveRequest',[LeaveRequest::class,'InsertLeaveRequest'])->name('InsertLeaveRequest');
Route::get('/DisabledDetails',[LeaveRequest::class,'DisabledDetails'])->name('DisabledDetails');
Route::get('/leavereqshist', [LeaveRequest::class,'show_leave_det'])->name('leavereqshist');
Route::get('/pendingleavereqshist', [LeaveRequest::class,'show_pending_leave_det'])->name('pendingleavereqshist');
Route::get('/GetLeaves',[LeaveRequest::class,'GetLeaves'])->name('GetLeaves');
Route::post('/InsertLeaveExtRequest',[LeaveRequest::class,'InsertLeaveExtRequest'])->name('InsertLeaveExtRequest');


// Admin Login Controller
Route::get('/AdminDashboard',[AdminLogin::class,'AdminDashboard'])->name('AdminDashboard');
Route::post('/AdminLoginVerify',[AdminLogin::class,'AdminLoginVerify'])->name('AdminLoginVerify');
Route::get('/AdminSession',[AdminLogin::class,'AdminSession'])->name('AdminSession');
Route::get('/AdminLogout',[AdminLogin::class,'AdminLogout'])->name('AdminLogout');

// Route::post('/leavereqs', [LeavereqController::class, 'insert'])->name('leavereqs');
// Route::get('/login', [StudentController::class,'login'])->name('login');
//Route::post('/login', [StudentController::class, 'loginfinal'])->name('loginfinal'); 
// Route::get('/leavereqs', [LeavereqController::class,'show_leave_det'])->name('leavereqs');


//Student Profile Section
Route::get('/studupdate', [stud_profile::class,'changePassword'])->name('updatepassword');
Route::post('/change-password', [stud_profile::class, 'changePasswordSave'])->name('postChangePassword');
Route::post('/change-roomno', [stud_profile::class, 'changeroomno'])->name('postChangeroomno');
Route::post('/change-hostel', [stud_profile::class, 'changehostel'])->name('postChangehostel');
Route::post('/change-phoneno', [stud_profile::class, 'changephoneno'])->name('postChangephoneno');
Route::post('/change-email', [stud_profile::class, 'changeemail'])->name('postChangeemail');
Route::post('/changefaculty', [stud_profile::class, 'changefaculty'])->name('changefaculty');
Route::post('/changeWarden', [stud_profile::class, 'changeWarden'])->name('changeWarden');

//Admin Profile Section
Route::get('AdminProfile',[AdminLogin::class,'AdminProfile'])->name('AdminProfile');
Route::post('/adm_change-password', [AdminProfile::class, 'changePasswordSave'])->name('postadmChangePassword');
Route::post('/adm_change-phoneno', [AdminProfile::class, 'changephoneno'])->name('postadmChangephoneno');
Route::post('/adm_change-email', [AdminProfile::class, 'changeemail'])->name('postadmChangeemail');

//Security Profile Section
Route::get('SecurityProfile',[SecurityLogin::class,'SecurityProfile'])->name('SecurityProfile');
Route::post('/sec_change-password', [SecurityProfile::class, 'changePasswordSave'])->name('postsecChangePassword');
Route::post('/sec_change-phoneno', [SecurityProfile::class, 'changephoneno'])->name('postsecChangephoneno');
Route::post('/sec_change-email', [SecurityProfile::class, 'changeemail'])->name('postsecChangeemail');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Notifications
Route::post('/save-onesignal-user-id', 'StudentLogin@saveOneSignalUserId');


require __DIR__.'/auth.php';
