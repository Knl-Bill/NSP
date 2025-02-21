<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuestEntry extends Controller
{
    public function GuestEntry()
    {
        return view('Logins.GuestEntry');
    }
    
    public function GuestRegister()
    {
        // Fetch all guest entries from the database
        $guests = DB::table('guestentry')
            ->orderBy('checkin_date', 'desc')  // Order by check-in date (newest first)
            ->orderBy('checkin_time', 'desc')  // Order by check-in time (newest first)
            ->get();

return view('Logins.GuestRegister', compact('guests'));

    }

    public function InsertGuest(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'phoneno' => 'required|string|max:15',
            'checkin_gate' => 'required|string',
            'emailId' => 'nullable|email|max:255',
            'student_rollno' => 'nullable|string|max:50',
            'stay_at' => 'nullable|string|max:255',
        ]);

        // Set timezone to Asia/Kolkata and get current date & time
        $checkinDateTime = Carbon::now('Asia/Kolkata');

        // Insert data into the database
        DB::table('guestentry')->insert([
            'name' => $request->input('name'),
            'phoneno' => $request->input('phoneno'),
            'checkin_date' => $checkinDateTime->toDateString(),
            'checkin_time' => $checkinDateTime->toTimeString(),
            'checkin_gate' => $request->input('checkin_gate'),
            'checkout_date' => null,
            'checkout_time' => null,
            'checkout_gate' => null,
            'email_Id' => $request->input('emailId'),
            'student_rollno' => $request->input('student_rollno'),
            'stay_at' => $request->input('stay_at'),
        ]);

        return redirect()->back()->with('success', 'Guest Entry Recorded Successfully!');
    }

    public function CloseGuestEntry(Request $request, $id)
    {
        // Validate checkout gate selection
        $request->validate([
            'checkout_gate' => 'required|string',
        ]);

        // Set checkout date & time
        $checkoutDateTime = Carbon::now('Asia/Kolkata');

        // Update checkout details for the given guest ID
        DB::table('guestentry')->where('id', $id)->update([
            'checkout_date' => $checkoutDateTime->toDateString(),
            'checkout_time' => $checkoutDateTime->toTimeString(),
            'checkout_gate' => $request->input('checkout_gate'),
        ]);

        return redirect()->route('GuestRegister')->with('success', 'Guest entry closed successfully!');
    }
}
