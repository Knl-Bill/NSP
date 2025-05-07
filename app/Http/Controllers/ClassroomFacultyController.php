<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Session;
use DB;

class ClassroomFacultyController extends Controller
{
    public function index()
    {
        // Fetch faculty name from session
        $facultyName = Session::get('admin')->email;
        // Get classrooms where faculty name matches
        $classrooms = Classroom::where('faculty_name', $facultyName)->get();
        return view('Logins.AdminPages.Classroom', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_code' => 'required|string|max:10|unique:classrooms',
            'programme_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        // Fetch faculty name from Admin session
        $faculty = Session::get('admin');
        $facultyEmail = $faculty->email; // Adjust based on your session key

        // Generate a unique joining code
        $joiningCode = strtoupper($validated['class_code']) . substr(md5(uniqid()), 0, 5);

        // Save to the database
        $classroom = Classroom::create([
            'class_code' => $validated['class_code'],
            'programme_name' => $validated['programme_name'],
            'description' => $validated['description'],
            'faculty_name' => $facultyEmail,
            'joining_code' => $joiningCode
        ]);

        // Dynamically create the students table for this class
        $tableName = strtolower($validated['class_code'] . '_students'); // Example: CSE101_students
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('roll_number')->unique();
                $table->integer('CT1_marks')->nullable();
                $table->integer('CT2_marks')->nullable();
                $table->integer('assignment_marks')->nullable();
                $table->integer('endsem_marks')->nullable();
                $table->timestamps();
            });
        }
        $facultyName=$faculty->name;
        // Formal Success Message
        $successMessage = "📢 **Welcome to Your New Classroom!**\n\n" .
                        "*Faculty Name:* " . $facultyName . "\n" .
                        "*Class Name:* " . $validated['programme_name'] . "\n" .
                        "*Class Code:* " . $validated['class_code'] . "\n" .
                        "*Description:* " . ($validated['description'] ?: "No description provided.") . "\n\n" .
                        "*Joining Code:* " . $joiningCode . "\n\n" .
                        "📌 Use this code to join the classroom!\n\n" .
                        "🚀 Happy Learning!";

        return redirect()->back()->with('success', nl2br(e($successMessage)));
    }
    public function viewStudents($class_code)
    {
        // Fetch students from the corresponding class table
        $tableName = $class_code . '_students';
        $students = DB::table($tableName)->get(); // Dynamic table access

        return view('Logins.AdminPages.Classroom_students', compact('students', 'class_code'));
    }

    public function deleteStudent($class_code, $roll_number)
    {
        $tableName = $class_code . '_students';
        DB::table($tableName)->where('roll_number', $roll_number)->delete();

        return redirect()->back()->with('success', 'Student removed successfully.');
    }

    public function markAttendance(Request $request, $class_code)
    {
        // Build the dynamic table name (using lowercase for consistency)
        $tableName = strtolower($class_code) . '_students';

        // Use today's date in Ymd format as the base for the column
        $dateBase = date('Ymd');
        $lecture = 1;
        $columnName = $dateBase . '_' . $lecture;

        // If a column with today's date already exists, increment the lecture number
        while (Schema::hasColumn($tableName, $columnName)) {
            $lecture++;
            $columnName = $dateBase . '_' . $lecture;
        }

        // Create a new boolean column with default 1 (present)
        Schema::table($tableName, function (Blueprint $table) use ($columnName) {
            $table->boolean($columnName)->default(1);
        });

        // Retrieve the attendance array from the form
        $attendance = $request->input('attendance', []);

        // Build an array of roll numbers that are marked present
        $presentRollNumbers = array_keys($attendance);

        // Since the new column defaults to 1 (present), we only need to update students who are absent
        if (!empty($presentRollNumbers)) {
            DB::table($tableName)
                ->whereNotIn('roll_number', $presentRollNumbers)
                ->update([$columnName => 0]);
        } else {
            // If no attendance was marked, mark everyone absent
            DB::table($tableName)
                ->update([$columnName => 0]);
        }

        return response()->json(['success' => true]);
    }

    public function getAttendanceStudents($class_code)
    {
        // Build the students table name dynamically
        $tableName = strtolower($class_code) . '_students';
        
        // Retrieve students with only their roll numbers
        $students = DB::table($tableName)->select('roll_number')->get();
        
        return response()->json($students);
    }

    public function getAttendanceColumns($class_code)
    {
        $tableName = strtolower($class_code) . '_students';
        if (!\Schema::hasTable($tableName)) {
            return response()->json([]);
        }
        $columns = \Schema::getColumnListing($tableName);
        $ignore = ['id', 'roll_number', 'CT1_marks', 'CT2_marks', 'assignment_marks', 'endsem_marks', 'created_at', 'updated_at'];
        $attendanceColumns = array_values(array_filter($columns, function($col) use ($ignore) {
            return !in_array($col, $ignore);
        }));
        return response()->json($attendanceColumns);
    }

    public function updateStudentDetails(Request $request, $class_code, $roll_number)
    {
        $tableName = strtolower($class_code) . '_students';
        $data = [];
        // Only update if value is not null
        if ($request->has('CT1_marks')) $data['CT1_marks'] = $request->input('CT1_marks');
        if ($request->has('CT2_marks')) $data['CT2_marks'] = $request->input('CT2_marks');
        if ($request->has('assignment_marks')) $data['assignment_marks'] = $request->input('assignment_marks');
        if ($request->has('endsem_marks')) $data['endsem_marks'] = $request->input('endsem_marks');
        // Attendance column update
        if ($request->has('attendance_column')) {
            $attendanceCol = $request->input('attendance_column');
            $attendanceVal = $request->input('attendance_present', 0);
            $data[$attendanceCol] = $attendanceVal;
        }
        if (!empty($data)) {
            $updated = \DB::table($tableName)
                ->where('roll_number', $roll_number)
                ->update($data);
            return response()->json(['success' => true, 'updated' => $updated]);
        }
        return response()->json(['success' => false, 'error' => 'No data to update']);
    }
}

