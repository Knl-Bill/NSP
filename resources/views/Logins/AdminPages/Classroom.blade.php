<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Academics - Faculty</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/logo.webp') }}">

    <link rel="icon" type="image/webp" href="{{ asset('assets/images/logo.webp') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/FacultyClassroom.css') }}">

</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <div id="attendanceSuccessAlert" class="alert alert-success alert-dismissible fade" role="alert" style="display:none;position:fixed;top:20px;right:20px;z-index:2000;">
        Attendance submitted successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="editSuccessAlert" class="alert alert-success alert-dismissible fade" role="alert" style="display:none;position:fixed;top:20px;right:20px;z-index:2000;">
        Classroom details updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="{{ asset('assets/images/logo.webp') }}" alt="logo">
            <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
            </div>
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
                    <a class="nav-link" href="#" onclick="openEditClassroomModal()">
                        <i class="bi bi-pencil-square me-2"></i>Edit Classroom Details
                    </a>
                </li>
            </ul>
        </div>

        <div class="right-container">
            <div class="create-btn-container">
                <button class="btn btn-create" onclick="openModal()">
                    <i class="bi bi-plus-circle me-1"></i> Create New
                </button>
            </div>
            
            <h4 class="mb-4">Classrooms</h4>

            <div class=" classroom-grid mt-4" id="classroomList">
                @if ($classrooms->isEmpty())
                    <div class="col-12 text-center p-5">
                        <p class="text-muted mt-3">No classrooms created yet.</p>
                    </div>
                @else
                    @foreach ($classrooms as $classroom)
                        <div class="classroom-card">
                            <div class="card-header">
                                <div class="card-header-content">
                                    <h5 class="mb-0">{{ $classroom->programme_name }}</h5>
                                    <small>{{ $classroom->class_code }}</small>
                                </div>
                                <button class="delete-btn" onclick="deleteClassroom('{{ $classroom->class_code }}')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <p><strong>Description:</strong> {{ $classroom->description ?: 'No description provided' }}</p>
                                <p><strong>Joining Code:</strong> <span class="badge bg-info">{{ $classroom->joining_code }}</span></p>
                            </div>
                            <div class="card-actions">
                                <button class="btn btn-sm btn-outline-primary">
                                    <a href="{{ route('viewStudents', ['class_code' => $classroom->class_code]) }}" class="text-decoration-none text-dark">
                                        <i class="bi bi-people-fill me-1"></i> View Students
                                    </a>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" onclick="openAttendanceModal('{{ $classroom->class_code }}')">
                                    <i class="bi bi-check-circle me-1"></i> Attendance
                                </button>
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
                        <button type="submit" class="btn btn-primary w-100">Create</button>
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
        fetch('/AdminSession').then(response => response.text()).then(data => {
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

    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Mark Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="attendanceForm" method="POST" onsubmit="submitAttendanceForm(event)">
                @csrf
                <div class="modal-body">
                    <div id="attendanceList">
                        <!-- Attendance checkboxes will be dynamically inserted here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Attendance</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        function openAttendanceModal(classCode) {
            console.log('openAttendanceModal called for class:', classCode); // Debug line
            // Attach the class code to the form for later use.
            document.getElementById("attendanceForm").dataset.classCode = classCode;
            // Display loading message
            document.getElementById("attendanceList").innerHTML = "Loading...";
            
            // Fetch the students for the given classroom.
            fetch(`/classroom/${classCode}/students`)
                .then(response => response.json())
                .then(students => {
                    let html = "";
                    if (students.length === 0) {
                        html = "<p>No students found for attendance.</p>";
                    } else {
                        // Hidden input to pass the class code
                        html += `<input type="hidden" name="class_code" value="${classCode}">`;
                        html += `<table class="table">
                                    <thead>
                                        <tr>
                                            <th>Roll Number</th>
                                            <th>Present</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                        students.forEach(student => {
                            html += `<tr>
                                    <td>${student.roll_number}</td>
                                    <td>
                                        <input type="checkbox" name="attendance[${student.roll_number}]" value="1" checked>
                                    </td>
                                    </tr>`;
                        });
                        html += `</tbody></table>`;
                    }
                    document.getElementById("attendanceList").innerHTML = html;
                    // Show the modal
                    var attendanceModal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    attendanceModal.show();
                })
                .catch(error => {
                    console.error("Error fetching students:", error);
                    document.getElementById("attendanceList").innerHTML = "<p>Error loading students.</p>";
                });
        }

        function submitAttendanceForm(event) {
            event.preventDefault();
            const form = event.target;
            const classCode = form.dataset.classCode;
            const formData = new FormData(form);

            fetch(`/classroom/${classCode}/attendance`, {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(result => {
                if(result.success) {
                    // Show the Bootstrap success alert
                    var alertBox = document.getElementById('attendanceSuccessAlert');
                    alertBox.style.display = 'block';
                    alertBox.classList.add('show');
                    setTimeout(function() {
                        alertBox.classList.remove('show');
                        alertBox.style.display = 'none';
                    }, 3000);
                    var attendanceModal = bootstrap.Modal.getInstance(document.getElementById('attendanceModal'));
                    attendanceModal.hide();
                } else {
                    alert("Error submitting attendance");
                }
            })
            .catch(error => {
                console.error("Error submitting attendance:", error);
                alert("Error submitting attendance");
            });
        }
    </script>

    <!-- Edit Classroom Modal -->
    <div class="modal fade" id="editClassroomModal" tabindex="-1" aria-labelledby="editClassroomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Classroom Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editClassroomForm">
                        <div class="mb-3">
                            <label class="form-label">Select Classroom</label>
                            <select class="form-select" id="editClassroomSelect" required>
                                <option value="" disabled selected>Select Classroom</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->class_code }}">{{ $classroom->programme_name }} ({{ $classroom->class_code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Student</label>
                            <select class="form-select" id="editStudentSelect" required disabled>
                                <option value="" disabled selected>Select Student</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CT1 Marks</label>
                            <input type="number" class="form-control" id="ct1Marks" name="CT1_marks">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CT2 Marks</label>
                            <input type="number" class="form-control" id="ct2Marks" name="CT2_marks">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assignment Marks</label>
                            <input type="number" class="form-control" id="assignmentMarks" name="assignment_marks">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End-Sem Marks</label>
                            <input type="number" class="form-control" id="endsemMarks" name="endsem_marks">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Attendance Column</label>
                            <select class="form-select" id="attendanceColumnSelect" name="attendance_column" disabled>
                                <option value="" disabled selected>Select Attendance Column</option>
                            </select>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="attendancePresent" name="attendance_present">
                                <label class="form-check-label" for="attendancePresent">Present</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    function openEditClassroomModal() {
        var modal = new bootstrap.Modal(document.getElementById('editClassroomModal'));
        modal.show();
    }

    document.getElementById('editClassroomSelect').addEventListener('change', function() {
        const classCode = this.value;
        const studentSelect = document.getElementById('editStudentSelect');
        studentSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        studentSelect.disabled = true;
        fetch(`/classroom/${classCode}/students`)
            .then(response => response.json())
            .then(students => {
                let html = '<option value="" disabled selected>Select Student</option>';
                students.forEach(student => {
                    html += `<option value="${student.roll_number}">${student.roll_number}</option>`;
                });
                studentSelect.innerHTML = html;
                studentSelect.disabled = false;
            });
        // Fetch attendance columns
        const attendanceSelect = document.getElementById('attendanceColumnSelect');
        attendanceSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        attendanceSelect.disabled = true;
        fetch(`/classroom/${classCode}/columns`)
            .then(response => response.json())
            .then(columns => {
                let html = '<option value="" disabled selected>Select Attendance Column</option>';
                columns.forEach(col => {
                    if(col.match(/^\d{8}_\d+$/)) html += `<option value="${col}">${col}</option>`;
                });
                attendanceSelect.innerHTML = html;
                attendanceSelect.disabled = false;
            });
    });

    document.getElementById('editStudentSelect').addEventListener('change', function() {
        const classCode = document.getElementById('editClassroomSelect').value;
        const rollNumber = this.value;
        fetch(`/classroom/${classCode}/student/${rollNumber}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('ct1Marks').value = data.CT1_marks || '';
                document.getElementById('ct2Marks').value = data.CT2_marks || '';
                document.getElementById('assignmentMarks').value = data.assignment_marks || '';
                document.getElementById('endsemMarks').value = data.endsem_marks || '';
            });
    });

    document.getElementById('attendanceColumnSelect').addEventListener('change', function() {
        const classCode = document.getElementById('editClassroomSelect').value;
        const rollNumber = document.getElementById('editStudentSelect').value;
        const column = this.value;
        fetch(`/classroom/${classCode}/student/${rollNumber}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('attendancePresent').checked = data[column] == 1;
            });
    });

    document.getElementById('editClassroomForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const classCode = document.getElementById('editClassroomSelect').value;
        const rollNumber = document.getElementById('editStudentSelect').value;
        const ct1 = document.getElementById('ct1Marks').value;
        const ct2 = document.getElementById('ct2Marks').value;
        const assignment = document.getElementById('assignmentMarks').value;
        const endsem = document.getElementById('endsemMarks').value;
        const attendanceCol = document.getElementById('attendanceColumnSelect').value;
        const attendancePresent = document.getElementById('attendancePresent').checked ? 1 : 0;
        fetch(`/classroom/${classCode}/student/${rollNumber}/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                CT1_marks: ct1,
                CT2_marks: ct2,
                assignment_marks: assignment,
                endsem_marks: endsem,
                attendance_column: attendanceCol,
                attendance_present: attendancePresent
            })
        })
        .then(response => response.json())
        .then(result => {
            if(result.success) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('editClassroomModal'));
                modal.hide();
                var alertBox = document.getElementById('editSuccessAlert');
                alertBox.style.display = 'block';
                alertBox.classList.add('show');
                setTimeout(function() {
                    alertBox.classList.remove('show');
                    alertBox.style.display = 'none';
                }, 3000);
            } else {
                alert('Failed to update classroom details.');
            }
        });
    });
    </script>

</body>
</html>
