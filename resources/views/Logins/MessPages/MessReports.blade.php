<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Reports</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link home-btn loadspin" href='{{route("MessDashboard")}}'><i class="bi bi-house-door-fill"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-text">
        <h1 class="heading font">MESS REPORTS</h1>
    </div>

    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row align-items-end">
                    <div class="col-md-4">
                        <label for="date" class="form-label">Select Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $date->format('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary mb-3">View Reports</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Daily Registration Statistics for {{ $date->format('d M Y') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Breakfast</h5>
                                <p class="card-text display-4">{{ $stats['breakfast'] }}</p>
                                <p class="card-text text-muted">Students Registered</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Lunch</h5>
                                <p class="card-text display-4">{{ $stats['lunch'] }}</p>
                                <p class="card-text text-muted">Students Registered</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Snacks</h5>
                                <p class="card-text display-4">{{ $stats['snacks'] }}</p>
                                <p class="card-text text-muted">Students Registered</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Dinner</h5>
                                <p class="card-text display-4">{{ $stats['dinner'] }}</p>
                                <p class="card-text text-muted">Students Registered</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script src="assets/js/MessLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>