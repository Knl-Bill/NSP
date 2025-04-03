<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request For Leave</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/LeaveRequest.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    <script>
        window.addEventListener('pageshow', function(event) {
        if(event.persisted)
          {
            window.location.reload();
          }
        });
        let user = "{{Session::has('student')}}";
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
                <a class="nav-link home-btn loadspin" href='{{route('StudentDashboard')}}'><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile-btn loadspin" href='{{route('StudentProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="new-login-container">
        <div class="new-image-container">
            <!-- <img src="assets/images/leave.webp" alt="Leave Image" class="image" width="800px"> -->
            <img src="assets/images/humaaans.webp" alt="Leave Image" class="image" width="800px">
        </div>
        <div class="new-form-container">
            <div class="form-group form-button">
                <button class="form-group button submit-btn" id="status">See your Leave Status</button>
            </div>
            <div class="form-group form-button">
                <button class="form-group button submit-btn" id="leavehistory">Leave History</button>
            </div>
            <h1 class="heading font">LEAVE FORM</h1>
            @if($errors->has('Invalid'))
                    <span class="text-danger">{{ $errors->first('Invalid') }}</span>
            @endif
            @if (Session::get('success'))
                <span class="text-safe" role="alert">
                    {{ Session::get('success') }}
                </span>
            @endif
            
             @if($errors->has('rollno'))
                    <span class="text-danger">{{ $errors->first('rollno') }}</span>
            @endif
            <form method="post" action="/InsertLeaveRequest" id="leavereq" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="labels font" for="rollno">Roll No: - </label>
                    <input class="inputs disabled" disabled id="rollno" type="text" name="rollno" placeholder="Roll Number">
                </div>
                <div class="form-group">
                    <label class="labels font" for="name">Name: - </label>
                    <input class="inputs disabled" disabled id="name" type="text" name="name" placeholder="Full Name (as in ID card)">
                </div>
                <div class="form-group">
                    <label class="labels font" for="phoneno">Phone No: - </label>
                    <input class="inputs disabled" disabled id="phoneno" type="text" name="phoneno" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <label class="labels font" for="placeofvisit">Place of Visit: - </label>
                    <input class="inputs" type="text" name="placeofvisit" placeholder="Place Of Visit" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="purpose">Purpose of Visit: - </label>
                    <input class="inputs" type="text" name="purpose" placeholder="Purpose of Visit" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="outdate">Out Date: - </label>
                    <input class="inputs" type="text" id="outdate" name="outdate" placeholder="Out Date" onfocus="this.type='date'; updateMinOutDate()" onblur="this.type='text'; updateMinDate();" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="outime">Out Time: - </label>
                    <input class="inputs" id="outime" type="time" name="outime" placeholder="Out Time" onfocus="(this.type='time'); updateOutTimeMin();" onblur="(this.type='time')" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="indate">In Date: - </label>
                    <input class="inputs" type="text" id="indate" name="indate" placeholder="In Date" onfocus="this.type='date'; updateMinDate();" onblur="this.type='text';" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="intime">In Time: - </label>
                    <input class="inputs" id="intime" type="time" name="intime" placeholder="In Time" onfocus="(this.type='time'); updateInTimeMin();" onblur="(this.type='time')" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="noofdays">No of Days: - </label>
                    <input class="inputs" type="text" name="noofdays" placeholder="Number of Days" required>
                </div>
                <div class="form-group">
                    <label class="labels font" for="image">Screenshot of E-Mail from Parents <span style="color:red; font-size:12px;"><b>(max size 1.5 MB)</b></span>: - </label>
                    @if($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                    <input class="inputs" type="text" placeholder="E-Mail Screenshot" accept="image/png,image/jpeg"  oninput="this.className = ''" name="image" onfocus="(this.type='file')">
                </div>
                <div class="form-group button">
                    <input class="submit-btn loadspin" type="Submit" id="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
    <script>
    function updateOutTimeMin() {
        var outdate = document.getElementById('outdate').value;
        var outtime = document.getElementById('outime');
        outtime.type = 'time';
        var today = new Date();
        var todayDate = today.toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        var currentTime = today.toTimeString().split(' ')[0].slice(0, 5); // Get current time in HH:MM format
        console.log(todayDate);
        console.log(outdate);
        console.log(currentTime);
        console.log(outtime);
        // If outdate is today, block past times
        if (outdate === todayDate) {
            outtime.min = currentTime; // Set the min time to current time
            outtime.max = '23:59';
        } else {
            outtime.removeAttribute('min'); // Remove min attribute if date is not today
        }
    }

    // Block intime less than outtime if the indate and outdate are the same
    function updateInTimeMin() {
        var outdate = document.getElementById('outdate').value;
        var indate = document.getElementById('indate').value;
        var outtime = document.getElementById('outime').value;
        var intime = document.getElementById('intime');
        intime.type = 'time';
        // If the indate is the same as outdate and outtime is set, set intime to be greater than outtime
        if (indate === outdate && outtime) {
            intime.min = outtime; // Set the min time of intime to be the same as outtime
            intime.max = '23:59';
        } else {
            intime.removeAttribute('min'); // Remove min attribute if dates are different
        }
    }
</script>

    <script>
        fetch('DisabledDetails').then(response => response.json()).then(data => {
            document.getElementById('rollno').value = data.rollno;
            document.getElementById('rollno').placeholder = data.rollno;

            document.getElementById('name').value = data.name;
            document.getElementById('name').placeholder = data.name;

            document.getElementById('phoneno').value = data.phoneno;
            document.getElementById('phoneno').placeholder = data.phoneno;
        });

        document.getElementById('status').addEventListener('click', function() {
            window.location.href = '{{route('pendingleavereqshist')}}'
        });

        document.getElementById('leavehistory').addEventListener('click', function() {
            window.location.href = '{{route('GetLeaves')}}'
        });
    </script>
    <script src="assets/js/StudentLogout.js"></script>
    <script>
        function updateMinDate() {
            var outdate = document.getElementById('outdate').value;
            var indate = document.getElementById('indate');
            if (outdate) {
                indate.min = outdate; // Set the min attribute of the indate input
            } else {
                indate.removeAttribute('min'); // Remove the min attribute if outdate is not set
            }
        }
        function updateMinOutDate() {
            var outdate = document.getElementById('outdate');
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            var year = today.getFullYear();
            var minDate = year + '-' + month + '-' + day;
            outdate.min = minDate;
        }
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
    <script src="assets/js/loading.js"></script>
</body>
</html>

 