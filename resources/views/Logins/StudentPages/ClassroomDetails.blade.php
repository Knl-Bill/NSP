<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Details</title>
    <link rel="stylesheet" href="{{ asset('assets/css/Student_Classdetails.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
        let user = "{{Session::has('student')}}";
        if (!user) {
            window.location.href = '/';
        }
    </script>
</head>
<body>
    <!-- Navigation Bar (copied from StudentClassroom.blade.php) -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="{{ asset('assets/images/logo.webp') }}" alt="logo">
            <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" 
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link profile-btn" id="profile" href="{{ route('StudentProfile') }}">
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Classroom Details Content -->
    <div class="container mt-5">
        <h2 class="mb-4">Classroom Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Roll Number:</strong> {{ session('student')->rollno }}</p>
                <p><strong>Class Code:</strong> {{ $class_code }}</p>

                <h4 class="mt-4">Marks</h4>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>CT1 Marks</th>
                            <th>CT2 Marks</th>
                            <th>Assignment Marks</th>
                            <th>End-Sem Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $classroom_data->CT1_marks ?? 'N/A' }}</td>
                            <td>{{ $classroom_data->CT2_marks ?? 'N/A' }}</td>
                            <td>{{ $classroom_data->assignment_marks ?? 'N/A' }}</td>
                            <td>{{ $classroom_data->endsem_marks ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Calculate and display Attendance Details -->
                @php
                    // Convert the object to an array
                    $data = (array)$classroom_data;
                    // List of columns to ignore (marks and misc info)
                    $ignore = ['id','roll_number','created_at','updated_at','CT1_marks','CT2_marks','assignment_marks','endsem_marks'];
                    $attendance = [];
                    foreach($data as $key => $value) {
                        if(!in_array($key, $ignore)) {
                            $attendance[$key] = $value;
                        }
                    }
                    $totalClasses = count($attendance);
                    $presentCount = 0;
                    foreach($attendance as $col => $att) {
                        if($att == 1) {
                            $presentCount++;
                        }
                    }
                    $attendancePercentage = $totalClasses ? round(($presentCount/$totalClasses)*100, 2) : 0;
                @endphp

                <h4 class="mt-4">Attendance Details</h4>
                @if($totalClasses > 0)
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Present?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendance as $session => $status)
                                <tr>
                                    <td>{{ $session }}</td>
                                    <td>
                                        @if($status == 1)
                                            <span class="text-success">Present</span>
                                        @else
                                            <span class="text-danger">Absent</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><strong>Overall Attendance Percentage:</strong> {{ $attendancePercentage }}%</p>
                @else
                    <p>No attendance data available.</p>
                @endif

                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>