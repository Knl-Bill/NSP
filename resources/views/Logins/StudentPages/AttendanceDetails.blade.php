<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Details</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/StudentAttendance.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
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
                        <a class="nav-link profile-btn" id="profile" href="{{ route('AdminProfile') }}">
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" id="logout" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container mt-5 right-container">
        <h2 class="heading mb-4 text-center">Attendance Details</h2>
        
        @if(isset($attendanceDetails) && count($attendanceDetails) > 0)
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Class Code</th>
                        <th>Attended Classes</th>
                        <th>Total Classes</th>
                        <th>Attendance Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendanceDetails as $attendance)
                        <tr class="{{ ($attendance['TotalClasses'] > 0 && $attendance['AttendancePercentage'] < 75) ? 'low-attendance' : '' }}"> 
                            <td>{{ $attendance['classCode'] }}</td>
                            <td>{{ $attendance['AttendedClasses'] }}</td>
                            <td>{{ $attendance['TotalClasses'] }}</td>
                            <td>
                                @if($attendance['TotalClasses'] > 0)
                                    {{ $attendance['AttendancePercentage'] }}%
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No attendance records available.
            </div>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">Back</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>