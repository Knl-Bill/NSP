<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Dashboard</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/StudentDashboard.css">
    <link rel="stylesheet" href="assets/css/loading.css">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link profile-btn" id="profile"><i class="bi bi-person-fill"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" id="logout">Logout</a>
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
        <div class="status">
            <button id="menuManagement" class="loadspin dash-btn">Menu Management</button>
        </div>
        <div class="status">
            <button id="messReports" class="loadspin dash-btn">View Reports</button>
        </div>
    </div>

    <script>
        document.getElementById('menuManagement').addEventListener('click', function() {
            window.location.href = '/MenuManagement';
        });

        document.getElementById('messReports').addEventListener('click', function() {
            window.location.href = '/MessReports';
        });

        document.getElementById('profile').addEventListener('click', function() {
            window.location.href = '/MessProfile';
        });

        document.getElementById('logout').addEventListener('click', function() {
            window.location.href = '/MessLogout';
        });

        fetch('/MessSession').then(response => response.text()).then(data => {
            document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
        });
    </script>
</body>
</html>