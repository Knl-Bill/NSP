<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Profile</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">     
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="assets/css/profile.css"> -->
    <link rel="stylesheet" href="assets/css/NewProfile.css">
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
                <a class="nav-link home-btn loadspin" href='/SecurityDashboard'><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
              <!--<li class="nav-item">-->
              <!--  <a class="nav-link profile-btn" href='/SecurityProfile'><i class="bi bi-person-fill custom-icon"></i></a>-->
              <!--</li>-->
              <li class="nav-item">
                <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="profile-container">
        <div class="details">
            <h1 class="heading font">YOUR DETAILS</h1>
            @foreach($students as $stud)
            <table class="table table-striped-columns table-bordered">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{$stud->name}}</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>{{$stud->phoneno}}</td>
                    </tr>
                    <tr>
                        <td>E-Mail Address</td>
                        <td>{{$stud->email}}</td>
                    </tr>
                </tbody>
            </table>
            @endforeach
        </div>
        <div class="forms">
            <div class="form-text">
                <h1 class="heading font">UPDATE YOUR PROFILE</h1>
                @if(Session::get('success'))
                    <span class="text-safe">{{ Session::get('success') }}</span>
                @endif
            </div>
           
            <div class="form-container">
                <h3 class="font1">Password</h3>
            
                <form method="post" action="sec_change-password" id="signup">
                    @csrf
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <label class="labels" for="phoneno" class="font">Current Password</label>
                        <input class="inputs" type="text" name="curr_pass" id="currpass" placeholder="Enter Current Password" required>
                        @if($errors->has('phoneno'))
                            <span class="text-danger">{{ $errors->first('phoneno') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="phoneno" class="font">New Password</label>
                        <input class="inputs" type="password" name="new_pass" id="newpass" placeholder="Enter New Password" required>
                        @if($errors->has('new_pass'))
                            <span class="text-danger">{{ $errors->first('new_pass') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="password" class="font">Confirm Password</label>
                        <input class="inputs" type="password" id="password" name="confirmpass" placeholder="Enter Password Again" required>
                        @if($errors->has('confirmpass'))
                            <span class="text-danger">{{ $errors->first('confirmpass') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>

            <div class="form-container">
                <!-- Update Phone Number -->
                <h3 class="font1">Phone Number</h3>
                <form method="post" action="sec_change-phoneno" id="signup">
                    @csrf
                    <div class="form-group">
                        <!-- <label class="labels" for="phoneno" class="font">Roll Number</label>
                        <input class="disabled inputs" disabled type="text" name="rollno" id="rollno" placeholder="Enter Your Roll Number" required>
                        <input class="disabled inputs" hidden type="text" name="rollno" id="rollno" placeholder="rollno" required> -->
                        @if($errors->has('rollno'))
                            <span class="text-danger">{{ $errors->first('rollno') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="phoneno" class="font">New Phone Number</label>
                        <input class="inputs" type="text" name="new_phoneno" id="phoneno" placeholder="Enter New Phone Number" required>
                        @if($errors->has('new_phoneno'))
                            <span class="text-danger">{{ $errors->first('new_phoneno') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>

            <div class="form-container">

                <!-- Update Email -->
                <h3 class="font1">E-Mail Address</h3>
                <form method="post" action="sec_change-email" id="signup">
                    @csrf
                    <div class="form-group">
                        <!-- <label class="labels" for="phoneno" class="font">Roll Number</label>
                        <input class="disabled inputs" disabled type="text" name="rollno" id="rollno" placeholder="Enter Your Roll Number" required>
                        <input class="disabled inputs" hidden type="text" name="rollno" id="rollno" placeholder="rollno" required> -->
                        @if($errors->has('rollno'))
                            <span class="text-danger">{{ $errors->first('rollno') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="phoneno" class="font">New E-Mail Address</label>
                        <input class="inputs" type="text" name="new_email" id="email" placeholder="Enter New E-Mail Address" required>
                        @if($errors->has('new_email'))
                            <span class="text-danger">{{ $errors->first('new_email') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn"type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>    

        </div>
    </div>

    <div id="confirmationPopup" class="popup">
        <p>Are you sure you want to update the changes?</p>
        <button class="yes-button loadspin" id="confirmYes">Yes</button>
        <button class="no-button" id="confirmNo">No</button>
    </div>

    <!-- End of Divs, start of the JS Script Section-->
    <script src="assets/js/profile.js"></script>

    <script>
        fetch('DisabledDetails').then(response => response.json()).then(data => {
            document.querySelectorAll('.disabled').forEach(element => {
                element.value = data.rollno;
                element.placeholder = data.placeholder;
            });
        });
    </script>
    <script>
        fetch('/SecuritySession').then(response => response.text()).then(data => {
                // Update the user name in the HTML
                document.querySelector('.user').innerHTML = '<span class="welcome">Welcome</span>, ' + data;
        });

        document.getElementById('LeaveId').addEventListener('click', function() {
            window.location.href = '/LeaveText';
        });
        document.getElementById('OutingId').addEventListener('click', function() {
            window.location.href = '/OutingText';
        });
        document.getElementById('profile').addEventListener('click', function() {
            window.location.href = '/SecurityProfile';
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
    <script src="assets/js/SecurityLogout.js"></script>
        <script src="assets/js/loading.js"></script>
</body>
</html>
