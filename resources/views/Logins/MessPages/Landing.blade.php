<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Dashboard</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
        let user = "{{Session::has('mess')}}";
        if(!user)
            window.location.href = '/';
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/StudentDashboard.css">
    <link rel="stylesheet" href="assets/css/loading.css">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link profile-btn loadspin" id="profile" href='{{route('MessProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-text">
        <div class="user" style="font-size: 24px;"></div>
        <h1 class="heading font">MESS DASHBOARD</h1>
    </div>

    <div class="dash-container">
        <button id="AttendanceId" class="loadspin dash-btn">Attendance Management</button>
        <button id="MenuId" class="loadspin dash-btn">Menu Management</button>
        <button id="FeeId" class="loadspin dash-btn">Mess Fee Records</button>
        <button id="ReportsId" class="loadspin dash-btn">Generate Reports</button>
    </div>

    <script>
        fetch('/MessSession').then(response => response.text()).then(data => {
            document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
        });

        document.getElementById('profile').addEventListener('click', function() {
            window.location.href = '{{route('MessProfile')}}';
        });

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
    <script src="assets/js/MessLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>