<?php use Carbon\Carbon; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
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
        <h1 class="heading font">MENU MANAGEMENT</h1>
    </div>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="heading font">Create/Update Menu</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('saveMenu') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="menu_date" class="form-label">Select Date</label>
                        <input type="date" class="form-control" id="menu_date" name="menu_date" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="breakfast" class="form-label">Breakfast Menu</label>
                        <textarea class="form-control" id="breakfast" name="breakfast" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lunch" class="form-label">Lunch Menu</label>
                        <textarea class="form-control" id="lunch" name="lunch" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="snacks" class="form-label">Snacks Menu</label>
                        <textarea class="form-control" id="snacks" name="snacks" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="dinner" class="form-label">Dinner Menu</label>
                        <textarea class="form-control" id="dinner" name="dinner" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Save Menu</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="heading font">View Menu History</h3>
            </div>
            <div class="card-body">
                <form method="GET" class="row align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter Menus</button>
                        @if(request('start_date') || request('end_date'))
                            <a href="{{ route('menuManagement') }}" class="btn btn-secondary">Clear Filter</a>
                        @endif
                    </div>
                </form>

                @if(isset($menus) && count($menus) > 0)
                    <div class="row">
                        @foreach($menus as $menu)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">{{ date('d M Y', strtotime($menu->menu_date)) }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="menu-item">
                                        <h6 class="text-primary">Breakfast</h6>
                                        <p class="menu-text">{{ $menu->breakfast ?? 'Not set yet' }}</p>
                                    </div>
                                    <div class="menu-item">
                                        <h6 class="text-primary">Lunch</h6>
                                        <p class="menu-text">{{ $menu->lunch ?? 'Not set yet' }}</p>
                                    </div>
                                    <div class="menu-item">
                                        <h6 class="text-primary">Snacks</h6>
                                        <p class="menu-text">{{ $menu->snacks ?? 'Not set yet' }}</p>
                                    </div>
                                    <div class="menu-item">
                                        <h6 class="text-primary">Dinner</h6>
                                        <p class="menu-text">{{ $menu->dinner ?? 'Not set yet' }}</p>
                                    </div>
                                    <p class="text-muted mt-2 mb-0 small">Last updated: {{ Carbon::parse($menu->updated_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }} IST</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        No menu records found for the selected dates.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .menu-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .menu-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .menu-item h6 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .menu-text {
            margin-bottom: 0;
            white-space: pre-line;
        }
        .card-header.bg-primary {
            background-color: #0d6efd !important;
        }
    </style>

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