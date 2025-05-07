<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="assets/css/main.css">  -->
    <link rel="stylesheet" href="assets/css/StudentDashboard.css">    
    <link rel="stylesheet" href="assets/css/loading.css">
    
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
                <a class="nav-link profile-btn loadspin" id="profile" href='{{route('StudentProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link logout-btn" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="dashboard-text">
        <div class="user" style="font-size: 24px;">
        </div>
        <h1 class="heading font">DASHBOARD</h1>
    </div>

    <div class="dash-container">
        <div class="status">
            <a class="leave-status loadspin dash-btn" href="{{ route('leavereqshist') }}">Leave Requests History</a>
        </div>
        <button id="Leave" class="loadspin dash-btn">Leave Requests</button>
        <button id="Mess" class="loadspin dash-btn">Mess Menu</button>
        <button id="Outing" class="loadspin dash-btn">Outing History</button>
        @if(session('student') && session('student')->gender === 'Female')
            <button id="GLH" class="loadspin dash-btn">GLH Register</button>
        @endif
        <button id="academics" class="loadspin dash-btn">Academics</button>
    </div>

    <script>
        fetch('/StudentSession').then(response => response.text()).then(data => {
            document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
        });

        document.getElementById('Leave').addEventListener('click', function() {
            window.location.href = '{{route('LeaveRequestPage')}}';
        });

        document.getElementById('profile').addEventListener('click', function() {
            window.location.href = '{{route('StudentProfile')}}';
        });
        
        document.getElementById('Outing').addEventListener('click', function() {
            window.location.href = '{{route('GetOutings')}}';
        });  

        document.getElementById('Mess').addEventListener('click', function() {
            window.location.href = '{{route("StudentMess")}}';
        });

        const glhOutingButton = document.getElementById('GLH');

        if(glhOutingButton) {
            document.getElementById('GLH').addEventListener('click', function() {
                window.location.href = '{{route('GetGLHOutings')}}';
            });
        }
        
        document.getElementById('academics').addEventListener('click', function() {
            window.location.href = '{{route('JoinedClassrooms', ['rollno' => session('student')->rollno])}}';
        });
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
    <script src="assets/js/StudentLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>
