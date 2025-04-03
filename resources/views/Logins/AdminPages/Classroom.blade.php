<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics - Faculty</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/logo.webp') }}">
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/faculty_classroom.css') }}">
</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="{{ asset('assets/images/logo.webp') }}" alt="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link profile-btn" id="profile" href="{{ route('AdminProfile') }}"><i class="bi bi-person-fill"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <div class="bg-dark text-white p-3 sidebar">
            <h4>Academics</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="#">Create Classroom</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Attendance</a>
                </li>
            </ul>
        </div>

        <div class="p-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Classrooms</h2>
                <button class="btn btn-primary" onclick="openModal()">Create New</button>
            </div>

            <div class="mt-4" id="classroomList">
                @if ($classrooms->isEmpty())
                    <p class="text-muted">No classrooms created yet.</p>
                @else
                    @foreach ($classrooms as $classroom)
                        <div class="card p-3 mb-2">
                            <h5>{{ $classroom->programme_name }}</h5>
                            <p><strong>Class Code:</strong> {{ $classroom->class_code }}</p>
                            <p><strong>Description:</strong> {{ $classroom->description ?: 'No description provided' }}</p>
                            <p><strong>Joining Code:</strong> {{ $classroom->joining_code }}</p>
                            <button class="btn btn-primary btn-sm" onclick="fetchStudents('{{ $classroom->class_code }}')">
                                View Students
                            </button>
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
                    <h5 class="modal-title">Create Classroom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createClassroom') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Class Code</label>
                            <input type="text" name="class_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Programme Name</label>
                            <input type="text" name="programme_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Brief Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
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
        function openModal() {
            var modal = new bootstrap.Modal(document.getElementById('createClassroomModal'));
            modal.show();
        }
    </script>

    <script src="{{ asset('assets/js/FacultyLogout.js') }}"></script>
    <script src="{{ asset('assets/js/loading.js') }}"></script>

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


</body>
</html>
