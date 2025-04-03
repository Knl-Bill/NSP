<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="assets/css/main.css"> -->
    <link rel="stylesheet" href="assets/css/SecurityLanding.css">
    <link rel="stylesheet" href="assets/css/loading.css">
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
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav custom-nav-items">
              <li class="nav-item">
                <a class="nav-link profile-btn loadspin" id="profile" href='{{route('SecurityProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
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
        <h1 class="heading font">DASHBOARD</h1>
    </div>
    <!-- <div class="dashboard container">
        <div class="item Outing">
            <img src="assets/images/outing.png" alt="Leave" height="250px">
            <button class="submit-btn loadspin" id="OutingId">Outing</button>
        </div>
        <div class="item Outing">
            <img src="assets/images/girl.jpeg" alt="Leave" height="250px">
            <button class="submit-btn loadspin" id="GirlsId">Girls In-Campus Outing</button>
        </div>
        <div class="item">
            <img src="assets/images/leave_1.webp" alt="Leave" height="250px">
            <button class="submit-btn loadspin" id="LeaveId">Leave</button>
        </div>
    </div> -->

    <div class="main-container">
        <div class="box-1">
            <button id="LeaveId" class="big-btn loadspin">
                Leaves
            </button>
            <button id="OutingId" class="big-btn loadspin">
                Outings
            </button>
            <button id="GirlsId" class="big-btn loadspin">
                In-campus Outings
            </button>
            <button id="GuestEntry" class="big-btn">
                Guest Entry
            </button>
        </div>
        <div class="box-2">
            <div class="guide-container">
                <h3>Guide</h3>
                <div class="guide-section">
                    <h4>Leaves</h4>
                    <p>
                        <div class="tamil" style="color:red">
                            மாணவர் காட்டும் விடுப்புக் கோரிக்கை வார்டன் மற்றும் ஆசிரிய ஆலோசகரால் அங்கீகரிக்கப்பட்டதா அல்லது நியமிக்கப்பட்ட வார்டனால் தற்காலிகமாக அங்கீகரிக்கப்பட்டதா என்பதை உறுதிப்படுத்திக் கொள்ளுங்கள்.
                        </div>
                        <div class="enlish">
                            Make sure that the leave request that the student is showing is approved by both warden and faculty advisor or provisionally approved by the designated warden.
                        </div>
                        <hr>

                        <div class="tamil" style="color:red">
                            மாணவரின் விடுப்பு படிவத்தில் உருவாக்கப்பட்ட பார்கோடை ஸ்கேன் செய்து அல்லது கையேடு படிவத்தில் தேவையான விவரங்களை உள்ளிடுவதன் மூலம் பதிவு செய்யப்பட வேண்டிய இலைகள்
                        </div>
                        <div class="enlish">
                            Leaves to be registered by either scanning the barcode generated on the leave form of the student or by entering the required details in the manual form
                        </div>
                        <hr>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        fetch('/SecuritySession').then(response => response.text()).then(data => {
                // Update the user name in the HTML
                document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
            });
        

        document.getElementById('LeaveId').addEventListener('click', function() {
            window.location.href = '{{route('LeaveText')}}';
        });
        document.getElementById('OutingId').addEventListener('click', function() {
            window.location.href = '{{route('OutingText')}}';
        });
        document.getElementById('GirlsId').addEventListener('click', function() {
            window.location.href = '{{route('GirlsRegisterText')}}';
        });
        document.getElementById('profile').addEventListener('click', function() {
            window.location.href = '{{route('SecurityProfile')}}';
        });
        document.getElementById('GuestEntry').addEventListener('click', function() {
            window.location.href = '{{route('GuestEntry')}}';
        }) 
        
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
    <script src="assets/js/SecurityLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>