<?php

namespace App\Http\Controllers\Logins\Mess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class MessController extends Controller
{
    public function dashboard()
    {
        $mess = Session::get('mess');
        if(!$mess || !$mess->mess_hall) {
            return redirect('/')->with('error', 'Please login as mess admin');
        }
        return view('Logins.MessPages.MessDashboard');
    }

    public function menuManagement()
    {
        $mess = Session::get('mess');
        if(!$mess || !$mess->mess_hall) {
            return redirect('/');
        }

        $query = DB::table('mess_menus')->where('mess_hall', $mess->mess_hall);
        
        // Add date filtering if provided
        if (request('start_date')) {
            $query->where('menu_date', '>=', request('start_date'));
        }
        if (request('end_date')) {
            $query->where('menu_date', '<=', request('end_date'));
        }
        
        // Get menus ordered by date
        $menus = $query->orderBy('menu_date', 'desc')->get();

        return view('Logins.MessPages.MenuManagement', ['menus' => $menus]);
    }

    public function saveMenu(Request $request)
    {
        $request->validate([
            'menu_date' => 'required|date',
            'breakfast' => 'required|string',
            'lunch' => 'required|string',
            'snacks' => 'required|string',
            'dinner' => 'required|string'
        ]);

        $mess = Session::get('mess');
        if(!$mess || !$mess->mess_hall) {
            return redirect('/');
        }

        // Update or create menu for the date
        DB::table('mess_menus')->updateOrInsert(
            ['mess_hall' => $mess->mess_hall, 'menu_date' => $request->menu_date],
            [
                'breakfast' => $request->breakfast,
                'lunch' => $request->lunch,
                'snacks' => $request->snacks,
                'dinner' => $request->dinner,
                'updated_at' => now()
            ]
        );

        return back()->with('success', 'Menu updated successfully');
    }

    public function messReports()
    {
        $mess = Session::get('mess');
        if(!$mess || !$mess->mess_hall) {
            return redirect('/');
        }

        $date = request('date') ? Carbon::parse(request('date')) : Carbon::today();
        
        $registrations = DB::table('mess_registrations')
                          ->where('mess_hall', $mess->mess_hall)
                          ->where('registration_date', $date)
                          ->get();

        $stats = [
            'breakfast' => $registrations->where('breakfast', true)->count(),
            'lunch' => $registrations->where('lunch', true)->count(),
            'snacks' => $registrations->where('snacks', true)->count(),
            'dinner' => $registrations->where('dinner', true)->count()
        ];

        return view('Logins.MessPages.MessReports', ['stats' => $stats, 'date' => $date]);
    }
}