<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Entry</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/login_signup.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <script src="assets/js/loading.js"></script>
</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="assets/images/logo.webp" alt="logo">
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <!-- Guest Register Button (Moved Above the Heading) -->
        <div class="text-end mb-3">
            <a href="{{ route('GuestRegister') }}" class="btn btn-secondary">Guest Register</a>
        </div>

        <h2 class="text-center">Guest Entry Form</h2>

        <!-- Success and Error Messages -->
        <div id="alertContainer">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Guest Entry Form -->
        <form action="{{ route('InsertGuest') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <div class="mb-3">
                <label for="phoneno" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phoneno" name="phoneno" required>
            </div>
            
            <div class="mb-3">
                <label for="checkin_gate" class="form-label">Check-in Gate</label>
                <select class="form-select" id="checkin_gate" name="checkin_gate" required>
                    <option value="">Select Gate</option>
                    <option value="main">Main</option>
                    <option value="poovam">Poovam</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="emailId" class="form-label">Email ID (Optional)</label>
                <input type="email" class="form-control" id="emailId" name="emailId">
            </div>
            
            <div class="mb-3">
                <label for="student_rollno" class="form-label">Related to? (Student's Roll No)</label>
                <input type="text" class="form-control" id="student_rollno" name="student_rollno">
            </div>
            
            <div class="mb-3">
                <label for="stay_at" class="form-label">Stay At (Optional)</label>
                <select class="form-select" id="stay_at" name="stay_at">
                    <option value="">Select Stay Location</option>
                    <option value="Bharani Hostel">Bharani Hostel</option>
                    <option value="Bhavani Hostel">Bhavani Hostel</option>
                    <option value="Moyar Hostel">Moyar Hostel</option>
                    <option value="Guest House">Guest House</option>
                    <option value="Faculty Quarters">Faculty Quarters</option>
                </select>
            </div>
            
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        // Automatically hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
