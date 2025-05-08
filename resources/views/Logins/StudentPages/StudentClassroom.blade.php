<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics - Student</title>
    <link rel="icon" type="image/webp" href="/assets/images/logo.webp">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="/assets/css/loading.css">
    <link rel="stylesheet" href="/assets/css/Student_Classroom.css">
    <style>
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        .nav-link {
            cursor: pointer;
        }
        .nav-link.active {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
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
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="/assets/images/logo.webp" alt="logo">
            <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link profile-btn" id="profile" href="/StudentProfile"><i class="bi bi-person-fill"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- <div class="left-container bg-dark text-white p-3 sidebar"> -->
        <div class="left-container">
            <!-- <h4>Academics</h4> -->
            <div class="dashboard-text">
                <div class="user" style="font-size: 16px; padding: 20px">
            
                </div>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-grid-fill me-2"></i>Classrooms
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="redirectToAttendance()">
                        <i class="bi bi-calendar-check me-2"></i>Attendance
                    </a>
                </li>
            </ul>
        </div>

        <div class="right-container">
            <div class="create-btn-container">
                <button class="btn btn-create" onclick="openModal()">
                    <i class="bi bi-plus-circle me-1"></i> Join New
                </button>
            </div>
            
            <h4 class="mb-4">Classrooms</h4>

            <div class=" classroom-grid mt-4" id="classroomList">
                @if ($classrooms->isEmpty())
                    <div class="col-12 text-center p-5">
                        <p class="text-muted mt-3">No classrooms joined yet.</p>
                    </div>
                @else
                    @foreach ($classrooms as $classroom)
                        <div class="classroom-card">
                            <div class="card-header clickable" onclick="redirectToClassroom('{{ $classroom->class_code }}')">
                                <div class="card-header-content">
                                    <h5 class="mb-0">{{ $classroom->programme_name }}</h5>
                                    <small>{{ $classroom->class_code }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="createClassroomModal" tabindex="-1" aria-labelledby="createClassroomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Join Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/JoinClassroom" method="POST">
                        @csrf
                        <input type="hidden" name="rollno" value="{{ session('student')->rollno }}">
                        <div class="mb-3">
                            <label class="form-label">Class Code</label>
                            <input type="text" name="class_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Joining Code</label>
                            <input type="text" name="joining_code" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Join</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Classroom Created Successfully!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Share this message with students:</strong></p>
                    <div class="alert alert-info">
                        <p id="successMessage"></p>
                    </div>
                    <button class="btn btn-success btn-sm" onclick="copyMessage()">Copy Message</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Student List Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Students in Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentList">
                            <!-- Students will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        fetch('/StudentSession').then(response => response.text()).then(data => {
                // Update the user name in the HTML
                document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
        });
    </script>
    <script>
        function copyMessage() {
            let message = document.getElementById("successMessage").innerText;
            navigator.clipboard.writeText(message).then(() => {
                alert("Message copied successfully!");
            });
        }

        @if(session('success'))
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("successMessage").innerHTML = `{!! session('success') !!}`;
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        @endif
    </script>

    <script>
        function redirectToClassroom(classCode) {
            const rollno = "{{ session('student')->rollno }}";
            window.location.href = "/ClassroomDetails" + "?rollno=" + rollno + "&class_code=" + classCode;
        }  
        
        function redirectToAttendance() {
            const rollno = "{{ session('student')->rollno }}";
            window.location.href = "/StudentAttendance" + "?rollno=" + rollno;
        }
    </script>

    <script>
        function openModal() {
            var modal = new bootstrap.Modal(document.getElementById('createClassroomModal'));
            modal.show();
        }
    </script>

    <script src="/assets/js/FacultyLogout.js"></script>
    <script src="/assets/js/loading.js"></script>

    <script>
        function fetchStudents(classCode) {
            fetch(`/classroom/${classCode}`)
                .then(response => response.json())
                .then(students => {
                    let studentList = document.getElementById("studentList");
                    studentList.innerHTML = "";

                    if (students.length === 0) {
                        studentList.innerHTML = `<tr><td colspan="2" class="text-center">No students found.</td></tr>`;
                    } else {
                        students.forEach(student => {
                            studentList.innerHTML += `
                                <tr>
                                    <td>${student.roll_number}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="deleteStudent('${classCode}', '${student.roll_number}')">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </td>
                                </tr>`;
                        });
                    }

                    // Show the modal
                    let studentModal = new bootstrap.Modal(document.getElementById("studentModal"));
                    studentModal.show();
                });
        }

        function deleteStudent(classCode, rollNumber) {
            if (!confirm("Are you sure you want to remove this student?")) return;

            fetch(`/classroom/${classCode}/students/${rollNumber}/delete`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert("Student removed successfully.");
                    fetchStudents(classCode); // Refresh student list
                } else {
                    alert("Failed to remove student.");
                }
            });
        }
    </script>
    <script>
        window.addEventListener("resize", function () {
            let title = document.querySelector(".navbar-title");
            if (window.innerWidth <= 768) {
                title.textContent = "NSP";
            } else {
                title.textContent = "NIT Puducherry Student Portal";
            }
        });
        window.dispatchEvent(new Event("resize"));
    </script>

</body>
</html>
