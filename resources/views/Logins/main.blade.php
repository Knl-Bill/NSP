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
            <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
            </div>
        </div>
    </nav>
    <div class="main-container">
        <div class="box-1">
            <button id="AdminId" class="big-btn loadspin">Faculty Login</button>
            <button id="StudentId" class="big-btn loadspin">Student Login</button>
            <button id="SecurityId" class="big-btn loadspin">Security Login</button>
            <button id="GuestId" class="big-btn loadspin">Guest Entry</button>
        </div>
        <div class="box-2">
            <div class="guide-container">
                <h3>Guide</h3>
                <div class="guide-section">
                    <h4>Faculty Login</h4>
                    <p>
                        Faculty members can log in to manage student records, approve leave requests, and update academic information. The system ensures a seamless experience for managing administrative tasks efficiently.
                    </p>
                </div>
                <div class="guide-section">
                    <h4>Student Login</h4>
                    <p>
                        Students can log in to access course materials, track attendance, view grades, and submit requests for leaves or outings. The platform provides an intuitive dashboard for a smooth user experience.
                    </p>
                </div>
                <div class="guide-section">
                    <h4>Security Login</h4>
                    <p>
                        Security personnel can log in to verify student exits, manage guest entries, and ensure campus security compliance. The system helps maintain a structured record of movements within the institution.
                    </p>
                </div>
                <div class="guide-section">
                    <h4>Guest Entry</h4>
                    <p>
                        Guests can register their entry details before accessing the premises. This feature allows for better visitor tracking, ensuring a secure and well-monitored environment.
                    </p>
                </div>
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
    <script src="assets/js/loading.js"></script>
</body>
</html>