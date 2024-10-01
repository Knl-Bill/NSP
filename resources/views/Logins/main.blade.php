<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    @laravelPWA
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">  
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="assets/css/web_team.css">
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
    <div class="main-container">
        <div class="container">
        <div class="item">
            <img src="assets/images/admin.webp" alt="Admin" height="300px">
            <button id="AdminId" class="big-btn loadspin">Admin Login</button>
        </div>
        <div class="item">
            <img src="assets/images/student.webp" alt="Student" height="300px">
            <button id="StudentId" class="big-btn loadspin">Student Login</button>
        </div>
        <div class="item">
            <img src="assets/images/security.webp" alt="Security" height="300px">
            <button id="SecurityId" class="big-btn loadspin">Security Login</button>
        </div>        
        </div>
    </div>
    <footer class="footer-main">
      <div class="footer-content">
          <p>Copyright &copy; 2024 <a href='{{route('WebTeam')}}' style="font-weight: bold;color:white;">Webteam</a> @ NIT Puducherry</p>
      </div>
    </footer>
    <script>
        document.getElementById('AdminId').addEventListener('click', function() {
                let user = "{{Session::has('user')}}";
                if(user)
                    window.location.href = "{{route('AdminDashboard')}}";
                else
                    window.location.href = "{{route('AdminLogin')}}";
        });
        document.getElementById('StudentId').addEventListener('click', function() {
            let user = "{{Session::has('user')}}";
            if(user)
                window.location.href = "{{route('StudentDashboard')}}";
            else
                window.location.href = "{{route('StudentLogin')}}";
        });
        document.getElementById('SecurityId').addEventListener('click', function() {
            let user = "{{Session::has('user')}}";
            if(user)
                window.location.href = "{{route('SecurityDashboard')}}";
            else
                window.location.href = "{{route('SecurityLogin')}}";
        });

    </script>
    <script src="assets/js/loading.js"></script>
</body>
</html>