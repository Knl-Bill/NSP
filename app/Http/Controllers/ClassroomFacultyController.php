<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Session;

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


    public function showStudents($id)
    {
        $classroom = Classroom::with('students')->findOrFail($id);
        return view('faculty.students', compact('classroom'));
    }

    public function getStudents($class_code)
    {
        $table_name = strtolower($class_code) . '_students'; // Convert to lowercase
        if (!Schema::hasTable($table_name)) {
            return response()->json(['error' => 'Table does not exist'], 404);
        }
    
        $students = DB::table($table_name)->select('roll_number')->get();
        return response()->json($students);
    }

    // Delete a student from the classroom
    public function deleteStudent(Request $request, $class_code, $roll_number)
    {
        DB::table($class_code . '_students')->where('roll_number', $roll_number)->delete();
        return response()->json(['success' => true]);
    }

}

