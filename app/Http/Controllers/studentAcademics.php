<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class studentAcademics extends Controller
{
    public function StudentAcademicsLink()
    {
        return view('Logins.StudentPages.StudentClassroom');
    }
    public function JoinedClassrooms($rollno)
    {
        if(strlen($rollno) != 9)
        {
            return redirect()->back()->with('error', 'Invalid Roll Number');
        }
        
        $classrooms = DB::table('classroom_students')->where('rollno', $rollno)->get();

        return view('Logins.StudentPages.StudentClassroom', ['classrooms' => $classrooms]);
    }

    public function JoinClassroom(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
            'class_code' => 'required',
            'joining_code' => 'required',
        ]);
        
        $classroom = DB::table('classrooms')
            ->where('class_code', $request->class_code)
            ->where('joining_code', $request->joining_code)
            ->first();
        
        if (!$classroom) {
            return redirect()->back()->with('error', 'Couldn\'t join classroom. Invalid entries.');
        }
        
        $existingEntry = DB::table('classroom_students')
            ->where('class_code', $request->class_code)
            ->where('rollno', $request->rollno)
            ->first();
        
        if ($existingEntry) {
            return redirect()->back()->with('error', 'You are already a member of this classroom.');
        }
        
        DB::table('classroom_students')->insert([
            'class_code' => $request->class_code,
            'rollno' => $request->rollno,
            'programme_name' => $classroom->programme_name,
            'faculty_name' => $classroom->faculty_name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $classroom_name = $classroom->class_code . "_students";
        $classroom_table = DB::table($classroom_name)->insert([
            'roll_number' => $request->rollno,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!$classroom_table) {

            DB::table('classroom_students')->where('rollno', $request->rollno)->where('class_code', $request->class_code)->delete();

            return redirect()->back()->with('error', 'Failed to join classroom.');
        }
        
        return redirect()->back()->with('success', 'Classroom ' . $request->class_code . ' joined successfully!');
    }

    public function ClassroomDetails(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
            'class_code' => 'required'
        ]);

        $classroom_name = $request->class_code . "_students";

        $classroom_data = DB::table($classroom_name)
            ->where('roll_number', $request->rollno)
            ->first();
        
        if(!$classroom_data)
        {
            return redirect()->back()->with('error', 'No data found for this classroom.');
        }

        return view('Logins.StudentPages.ClassroomDetails', ['classroom_data' => $classroom_data, 'class_code' => $request->class_code]);
    }

    public function StudentAttendance(Request $request)
    {
        $request->validate([
            'rollno' => 'required'
        ]);

        $classrooms = DB::table('classroom_students')->where('rollno', $request->rollno)->get();
        if ($classrooms->isEmpty()) {
            return redirect()->back()->with('error', 'No classrooms found for this roll number.');
        }

        $attendanceDetails = [];

        foreach ($classrooms as $classroom) {
            $classCode = $classroom->class_code;
            $tableName = $classCode . "_students";
            $data = DB::table($tableName)->where('roll_number', $request->rollno)->first();

            if ($data) {
                // Convert the object to an array for processing.
                $dataArr = (array)$data;
                // Columns to ignore for attendance calculation.
                $ignoreColumns = ['id', 'roll_number', 'CT1_marks', 'CT2_marks', 'assignment_marks', 'endsem_marks', 'created_at', 'updated_at'];
                $attendance = [];

                foreach ($dataArr as $key => $value) {
                    if (!in_array($key, $ignoreColumns)) {
                        $attendance[$key] = $value;
                    }
                }

                $totalClasses = count($attendance);
                $attendedClasses = 0;
                foreach ($attendance as $status) {
                    if ($status == 1) {
                        $attendedClasses++;
                    }
                }

                $attendancePercentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;

                $attendanceDetails[] = [
                    'classCode' => $classCode,
                    'AttendedClasses' => $attendedClasses,
                    'TotalClasses' => $totalClasses,
                    'AttendancePercentage' => $attendancePercentage,
                ];
            }
        }

        return view('Logins.StudentPages.AttendanceDetails', ['attendanceDetails' => $attendanceDetails]);
    }
}
