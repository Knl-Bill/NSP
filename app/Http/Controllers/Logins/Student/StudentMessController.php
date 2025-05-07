<?php

namespace App\Http\Controllers\Logins\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class StudentMessController extends Controller
{
    private function getNextMealInfo() {
        $now = Carbon::now()->setTimezone('Asia/Kolkata');
        $currentTime = $now->format('H:i');
        
        // Define meal times
        $mealTimes = [
            'breakfast' => ['start' => '07:30', 'end' => '09:30', 'bookingStart' => '22:00', 'bookingEnd' => '07:30'],
            'lunch' => ['start' => '12:30', 'end' => '14:00', 'bookingStart' => '10:00', 'bookingEnd' => '12:30'],
            'snacks' => ['start' => '17:00', 'end' => '18:00', 'bookingStart' => '15:00', 'bookingEnd' => '16:30'],
            'dinner' => ['start' => '19:30', 'end' => '21:30', 'bookingStart' => '18:00', 'bookingEnd' => '19:45']
        ];

        // Check which is the next meal based on current time
        if ($currentTime < '07:30') {
            return ['meal' => 'breakfast', 'bookingOpen' => true];
        } elseif ($currentTime < '12:30') {
            return ['meal' => 'lunch', 'bookingOpen' => $currentTime >= '10:00'];
        } elseif ($currentTime < '17:00') {
            return ['meal' => 'snacks', 'bookingOpen' => $currentTime >= '15:00'];
        } elseif ($currentTime < '19:30') {
            return ['meal' => 'dinner', 'bookingOpen' => $currentTime >= '18:00'];
        } elseif ($currentTime >= '19:30') {
            // After dinner time, show next day's breakfast
            return ['meal' => 'breakfast', 'bookingOpen' => $currentTime >= '22:00', 'nextDay' => true];
        }
        
        // This should never be reached, but kept as a fallback
        return ['meal' => 'breakfast', 'bookingOpen' => false, 'nextDay' => true];
    }

    public function index()
    {
        $student = Session::get('student');
        if (!$student) {
            return redirect('/');
        }

        $nextMealInfo = $this->getNextMealInfo();
        $menu = DB::table('mess_menus')
                ->where('menu_date', $nextMealInfo['nextDay'] ?? false ? Carbon::tomorrow()->setTimezone('Asia/Kolkata')->format('Y-m-d') : Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d'))
                ->first();

        // Check if student has already booked the next meal
        $hasBooked = false;
        if ($nextMealInfo['meal']) {
            $booking = DB::table('mess_bookings')
                        ->where('student_rollno', $student->rollno)
                        ->where('meal_date', $nextMealInfo['nextDay'] ?? false ? Carbon::tomorrow()->setTimezone('Asia/Kolkata')->format('Y-m-d') : Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d'))
                        ->where('meal_type', $nextMealInfo['meal'])
                        ->first();
            $hasBooked = (bool) $booking;
        }

        return view('Logins.StudentPages.StudentMess', [
            'menu' => $menu,
            'nextMeal' => $nextMealInfo['meal'],
            'bookingOpen' => $nextMealInfo['bookingOpen'],
            'canBook' => !$hasBooked && $nextMealInfo['bookingOpen']
        ]);
    }

    public function getMenu(Request $request)
    {
        $date = $request->query('date', Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d'));
        $menu = DB::table('mess_menus')->where('menu_date', $date)->first();
        return response()->json($menu);
    }

    public function bookMeal(Request $request)
    {
        $student = Session::get('student');
        if (!$student) {
            return redirect('/')->with('error', 'Session expired');
        }

        $nextMealInfo = $this->getNextMealInfo();
        if (!$nextMealInfo['bookingOpen'] || $nextMealInfo['meal'] !== $request->meal) {
            return redirect()->back()->with('error', 'Booking window is closed or invalid meal type');
        }

        // Check if already booked
        $exists = DB::table('mess_bookings')
                    ->where('student_rollno', $student->rollno)
                    ->where('meal_date', $nextMealInfo['nextDay'] ?? false ? Carbon::tomorrow()->setTimezone('Asia/Kolkata')->format('Y-m-d') : Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d'))
                    ->where('meal_type', $request->meal)
                    ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already booked this meal');
        }

        // Insert booking
        DB::table('mess_bookings')->insert([
            'student_rollno' => $student->rollno,
            'meal_date' => $nextMealInfo['nextDay'] ?? false ? Carbon::tomorrow()->setTimezone('Asia/Kolkata')->format('Y-m-d') : Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d'),
            'meal_type' => $request->meal,
            'booked_at' => Carbon::now()->setTimezone('Asia/Kolkata'),
        ]);

        return redirect()->back()->with('success', 'Meal booked successfully');
    }
}