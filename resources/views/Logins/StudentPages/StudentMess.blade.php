<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Menu</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/StudentDashboard.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <style>
        body {
            padding-top: 80px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #F7F8FA;
            overflow-x: hidden;
        }
        
        .custom-navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #002147, #005099 50%, #002147);
            color: white;
            padding: 5px 15px;
            margin: 0;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
            position: fixed;
            height: 80px;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        .navbar-title-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .custom-nav-items {
            margin-left: auto;
            font-size: 25px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .home-btn, .profile-btn, .logout-btn {
            color: white;
            cursor: pointer;
        }

        .home-btn:hover, .profile-btn:hover, .logout-btn:hover {
            color: white;
        }

        .logout-btn {
            background-color: rgb(210, 37, 37);
            padding: 5px;
            margin-top: 12px;
            border-radius: 10px;
            font-size: 16px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: rgb(231, 18, 18);
        }

        .next-meal-box {
            background: linear-gradient(to right, #002147, #005099 50%, #002147);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .meal-time {
            font-size: 0.9em;
            color: #f0f0f0;
            margin-top: 5px;
        }

        .menu-card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .menu-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .menu-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .menu-text {
            white-space: pre-line;
            color: #333;
        }

        .card-header {
            background: linear-gradient(to right, #002147, #005099 50%, #002147);
            color: white;
        }

        .card-header input[type="date"] {
            background-color: white;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .btn-light {
            background: white;
            color: #002147;
            border: none;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background: #f0f0f0;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .text-primary {
            color: #002147 !important;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .menu-card {
                margin: 15px 0;
            }

            .navbar-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
            <img class="logo" src="{{ asset('assets/images/logo.webp') }}" alt="logo">
            <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav custom-nav-items">
                    <li class="nav-item">
                        <a class="nav-link home-btn loadspin" href='{{route("StudentDashboard")}}'><i class="bi bi-house-door-fill"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-text">
        <h1 class="heading font">MESS MENU</h1>
    </div>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($nextMeal)
            <div class="next-meal-box">
                <h4>Next Meal: {{ ucfirst($nextMeal) }}</h4>
                <div class="meal-time">
                    @if($nextMeal == 'breakfast')
                        Timing: 7:30 AM - 9:30 AM
                    @elseif($nextMeal == 'lunch')
                        Timing: 12:30 PM - 2:00 PM
                    @elseif($nextMeal == 'snacks')
                        Timing: 5:00 PM - 6:00 PM
                    @else
                        Timing: 7:30 PM - 9:30 PM
                    @endif
                </div>
                @if($bookingOpen)
                    @if($canBook)
                        <form action="{{ route('bookMeal') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="meal" value="{{ $nextMeal }}">
                            <button type="submit" class="btn btn-light">Book {{ ucfirst($nextMeal) }}</button>
                        </form>
                    @else
                        <button class="btn btn-secondary mt-3" disabled>Already Booked</button>
                    @endif
                @else
                    <div class="mt-2 text-warning">Booking window is not open yet</div>
                @endif
            </div>
        @endif

        <div class="card menu-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Menu</h5>
                    <input type="date" class="form-control w-auto" id="menuDate" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="card-body" id="menuContent">
                @if($menu)
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
                @else
                    <p class="text-muted">No menu available for this date.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('menuDate').addEventListener('change', function() {
            fetch(`/student/mess/menu?date=${this.value}`)
                .then(response => response.json())
                .then(menu => {
                    const content = document.getElementById('menuContent');
                    if (menu) {
                        content.innerHTML = `
                            <div class="menu-item">
                                <h6 class="text-primary">Breakfast</h6>
                                <p class="menu-text">${menu.breakfast || 'Not set yet'}</p>
                            </div>
                            <div class="menu-item">
                                <h6 class="text-primary">Lunch</h6>
                                <p class="menu-text">${menu.lunch || 'Not set yet'}</p>
                            </div>
                            <div class="menu-item">
                                <h6 class="text-primary">Snacks</h6>
                                <p class="menu-text">${menu.snacks || 'Not set yet'}</p>
                            </div>
                            <div class="menu-item">
                                <h6 class="text-primary">Dinner</h6>
                                <p class="menu-text">${menu.dinner || 'Not set yet'}</p>
                            </div>
                        `;
                    } else {
                        content.innerHTML = '<p class="text-muted">No menu available for this date.</p>';
                    }
                });
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
    <script src="assets/js/StudentLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>