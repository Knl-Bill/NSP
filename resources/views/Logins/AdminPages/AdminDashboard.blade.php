<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <script>
        window.addEventListener('pageshow', function(event) {

            if (event.persisted) {
                window.location.reload();
            }
        });
        let user = "{{Session::has('admin')}}";
        if(!user)
            window.location.href = '/';
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/loading.css">
</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
          <img class="logo" src="assets/images/logo.webp" alt="logo">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav custom-nav-items">
              <li class="nav-item">
                <a class="nav-link profile-btn loadspin" id="profile" href='{{route('AdminProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="dashboard-text">
        <div class="user" style="font-size: 24px;">
    
        </div>
        @if(Session::has('message'))
            <span class="text-danger">{{ Session::get('message')  }}</span>
        @endif
        <h1 class="heading font">DASHBOARD</h1>
        <div class="status">
            <a class="leave-status loadspin" href="{{ route('leavereqshist_admin') }}">See Leave History</a>
        </div>
    </div>
    <div class="dashboard container">
        <div class="item">
            <img src="assets/images/leave_1.webp" alt="Leave" height="250px">
            <button id="LeaveId" class="loadspin">Leave Requests <span class="leave_count">{{$count}}</span> </button>
        </div>
        <div class="item">
            <img src="assets/images/faculty.webp" alt="Academics" height="250px">
            <button id="AcademicsId">Academic Details</button>
        </div>
    </div>
    <script>
        
        fetch('/AdminSession').then(response => response.text()).then(data => {
                // Update the user name in the HTML
                document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
        });

        

        document.getElementById('LeaveId').addEventListener('click', function() {
            window.location.href = '{{route('LeaveRequests')}}';
        });

        document.getElementById('profile').addEventListener('click', function() {
            window.location.href = '{{route('AdminProfile')}}';
        });
    </script>
    <script src="assets/js/AdminLogout.js"></script>
      <script src="assets/js/loading.js"></script>
</body>
</html>