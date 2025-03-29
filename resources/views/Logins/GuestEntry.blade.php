<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Entry</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/GuestEntry.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <script src="assets/js/loading.js"></script>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
        let user = "{{Session::has('security')}}";
        if(!user)
            window.location.href = '/';
    </script>
</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="assets/images/logo.webp" alt="logo">
            <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
            </div>
        </div>
    </nav>

    <div class="page-container">
        <!-- Fixed Guest Register Button position -->
        <div class="guest-register-btn">
            <a href="{{ route('GuestRegister') }}" class="btn btn-secondary">Guest Register</a>
        </div>
        
        <div class="content-container">
            <div class="image-container">
                <img class="image" src="assets/images/humaaans.webp" alt="Sign Up Image">
            </div>
            
            <div class="form-container">
                <h1 class="heading font">GUEST ENTRY FORM</h1>

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

                <form action="{{ route('InsertGuest') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="font labels form-label">Name<span class="req">*</span></label>
                        <input type="text" class="inputs form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phoneno" class="font labels form-label">Phone Number<span class="req">*</span></label>
                        <input type="tel" class="inputs form-control" id="phoneno" name="phoneno" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="checkin_gate" class="font labels form-label">Check-in Gate<span class="req">*</span></label>
                        <select class="inputs form-select" id="checkin_gate" name="checkin_gate" required>
                            <option value="">Select Gate</option>
                            <option value="main">Main</option>
                            <option value="poovam">Poovam</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="emailId" class="font labels form-label">Email ID (Optional)</label>
                        <input type="email" class="inputs form-control" id="emailId" name="emailId">
                    </div>
                    
                    <div class="form-group">
                        <label for="student_rollno" class="font labels form-label">Related to? (Student's Roll No)</label>
                        <input type="text" class="inputs form-control" id="student_rollno" name="student_rollno">
                    </div>
                    
                    <div class="form-group">
                        <label for="stay_at" class="font labels form-label">Stay At (Optional)</label>
                        <select class="inputs form-select" id="stay_at" name="stay_at">
                            <option value="">Select Stay Location</option>
                            <option value="Bharani Hostel">Bharani Hostel</option>
                            <option value="Bhavani Hostel">Bhavani Hostel</option>
                            <option value="Moyar Hostel">Moyar Hostel</option>
                            <option value="Guest House">Guest House</option>
                            <option value="Faculty Quarters">Faculty Quarters</option>
                        </select>
                    </div>
                    
                    <div class="form-group button">
                        <button type="submit" class="submit-btn btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
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

        window.addEventListener("resize", function () {
            let title = document.querySelector(".navbar-title");
            if (window.innerWidth <= 768) {
                title.textContent = "NSP";
            } else {
                title.textContent = "NIT Puducherry Student Portal";
            }
        });
        // Run once on page load
        window.dispatchEvent(new Event("resize"));
    </script>
</body>
</html>