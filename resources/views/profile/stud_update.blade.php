<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">     
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="assets/css/profile.css"> -->
    <link rel="stylesheet" href="assets/css/NewProfile.css">
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
    <script>
        var hostelData = {
            "Bharani Hostel": { floors: 4, rooms: 43 },
            "Bhavani Hostel": { floors: 2, rooms: 43 },
            "Moyar Hostel": { blocks: 10, rooms: 8 }
        };

        window.onload = function() {
            var hostelSel = document.getElementById("hostelname");
            var floorSel = document.getElementById("floors");
            var roomSel = document.getElementById("roomno");
            
            hostelSel.onchange = function() {
                // Clear previous options
                floorSel.length = 1;
                roomSel.length = 1;
                var floorLabels = ['G', 'F', 'S', 'T', 'R'];
                var hostel = this.value;
                if (hostel === 'Moyar Hostel')
                {
                    for (var i = 65; i < 65 + hostelData[hostel].blocks; i++) {
                        var option = new Option(String.fromCharCode(i), String.fromCharCode(i));
                        floorSel.options[floorSel.options.length] = option;
                    }
                    for (var i = 1; i <= hostelData[hostel].rooms; i++) {
                        var option = new Option(i, i);
                        roomSel.options[roomSel.options.length] = option;
                    }
                } 
                else 
                {
                    for (var i = 0; i <= hostelData[hostel].floors; i++) {
                            var option = new Option(floorLabels[i],floorLabels[i]);
                            floorSel.options[floorSel.options.length] = option;
                    }
                    for (var i = 1; i <= hostelData[hostel].rooms; i++) {
                        var option = new Option(i, i);
                        roomSel.options[roomSel.options.length] = option;
                    }
                }
            };
        };
    </script>
</head>
<body>
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
                <a class="nav-link home-btn" href='{{route('StudentDashboard')}}'><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile-btn" href='{{route('StudentProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link logout-btn" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="profile-container">
        <div class="details">
            <!-- <h1 class="heading-update">Your Details</h1> -->
            <h1 class="heading font">YOUR DETAILS</h1>
            @foreach($students as $stud)
            <table class="table table-striped-columns table-bordered">
                <tbody>
                    <tr>
                        <td>Student</td>
                        <td style="text-align:center;"><img src="storage/profile/{{$stud->profile_picture}}" alt="Profile Picture" style="width:auto; height:150px; text-align:center;"></td>
                    </tr>
                    <tr>
                        <td>Roll Number</td>
                        <td>
                            {{$stud->rollno}} 
                            <br><br>
                            <img src="storage/{{$stud->barcode}}" alt="barcode" style="width:90%;height:100px; ">
                        </td>
                    </tr>
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
                    <tr>
                        <td>Course</td>
                        <td>{{$stud->course}}</td>
                    </tr>
                    <tr>
                        <td>Batch</td>
                        <td>{{$stud->batch}}</td>
                    </tr>
                    <tr>
                        <td>Department </td>
                        <td>{{$stud->dept}}</td>
                    </tr>
                    <tr>
                        <td>Hostel Name</td>
                        <td>{{$stud->hostelname}}</td>
                    </tr>
                    <tr>
                        <td>Room Number</td>
                        <td>{{$stud->roomno}}</td>
                    </tr>
                    <tr>
                        <td>Faculty Advisor</td>
                        <td>{{$faculty_advisor}}</td>
                    </tr>
                    <tr>
                        <td>Warden</td>
                        <td>{{$warden}}</td>
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
                @if (Session::has('error'))
                    <div class="text-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
            <div class="form-container">
                <h3 class="font font1">Password</h3>
            
                <form method="post" action="change-password" id="signup">
                    @csrf
                    <div class="form-group">
                        @if($errors->has('rollno'))
                            <span class="text-danger">{{ $errors->first('rollno') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="phoneno" class="font">Current Password</label>
                        <input class="inputs" type="password" name="curr_pass" id="currpass" placeholder="Enter Current Password" required>
                        @if($errors->has('curr_pass'))
                            <span class="text-danger">{{ $errors->first('curr_pass') }}</span>
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

                <!-- Update Hostel -->
                <h3 class="font font1">Hostel</h3>
                <form method="post" action="change-hostel" id="signup">
                    @csrf
                    <div class="form-group">
                        @if($errors->has('rollno'))
                            <span class="text-danger">{{ $errors->first('rollno') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="hostelname" class="font">New Hostel Name</label>
                        <select class="inputs" id="hostelname" name="new_hostelname" required>
                            <option value="" selected disabled hidden>Choose Hostel Name</option>
                            <option value="Bharani Hostel">Bharani Hostel</option>
                            <option value="Bhavani Hostel">Bhavani Hostel</option>
                            <option value="Moyar Hostel">Moyar Hostel</option>
                        </select>
                        @if($errors->has('new_hostelname'))
                            <span class="text-danger">{{ $errors->first('new_hostelname') }}</span>
                        @endif
                    </div>
                    <div class="form-group" id="floor-selection">
                        <label for="floors" class="labels font">Floor/Block</label>
                        <select class="inputs" id="floors" name="floors" >
                            <option value="" selected disabled hidden>Choose Floor/Block</option>
                        </select>
                        @if($errors->has('floors'))
                            <span class="text-danger">{{ $errors->first('floors') }}</span>
                        @endif
                    </div>
                    <div class="form-group" id="room-selection">
                        <label for="roomno" class="labels font">Hostel Room Number</label>
                        <select class="inputs" id="roomno" name="roomno" >
                            <option value="" selected disabled hidden>Choose Room Number</option>
                        </select>
                         @if($errors->has('roomno'))
                            <span class="text-danger">{{ $errors->first('roomno') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>
            <div class="form-container">

                <!-- Update Phone Number -->
                <h3 class="font font1">Phone Number</h3>
                <form method="post" action="change-phoneno" id="signup">
                    @csrf
                    <div class="form-group">
                        <!-- <label class="labels" for="phoneno" class="font">Roll Number</label>
                        <input class="inputs disabled" disabled type="text" name="rollno" id="rollno" placeholder="Enter Your Roll Number" required>
                        <input class="inputs disabled" hidden type="text" name="rollno" id="rollno" placeholder="rollno" required> -->
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
                <h3 class="font font1">E-Mail Address</h3>
                <form method="post" action="change-email" id="signup">
                    @csrf
                    <div class="form-group">
                        <!-- <label class="labels" for="phoneno" class="font">Roll Number</label>
                        <input class="inputs disabled" disabled type="text" name="rollno" id="rollno" placeholder="Enter Your Roll Number" required>
                        <input class="inputs disabled" hidden type="text" name="rollno" id="rollno" placeholder="rollno" required> -->
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
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>

            </div>
            <div class="form-container">
                
                <!-- Update Faculty Advisor-->
                <h3 class="font font1">Faculty Advisor</h3>
                <form method="post" action="/changefaculty" id="signup">
                    @csrf
                    <div class="form-group">
                        <label for="faculty_advisor" class="labels font">New Faculty Advisor</label>
                        <select class="inputs" id="faculty_advisor" name="new_faculty" required>
                            <option value="" selected disabled hidden>Select Your Faculty Advisor</option>
                            @foreach($admins as $admin)
                            <option value= "{{$admin->email}}" >{{$admin->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('new_faculty'))
                            <span class="text-danger">{{ $errors->first('new_faculty') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>
            <div class="form-container">
                
                <!-- Update Warden-->
                <h3 class="font font1">Warden</h3>
                <form method="post" action="/changeWarden" id="signup">
                    @csrf
                    <div class="form-group">
                        <label for="faculty_advisor" class="labels font">New Warden</label>
                        <select class="inputs" id="warden" name="new_warden" required>
                            <option value="" selected disabled hidden>Select Your Warden</option>
                            @foreach($admins as $admin)
                            <option value= "{{$admin->email}}" >{{$admin->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('new_warden'))
                            <span class="text-danger">{{ $errors->first('new_warden') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="confirmationPopup" class="popup">
        <p>Are you sure you want to update the changes?</p>
        <button class="yes-button" id="confirmYes">Yes</button>
        <button class="no-button" id="confirmNo">No</button>
    </div>

    <script src="assets/js/profile.js"></script>

    <script>
        document.getElementById('logout').addEventListener('click', function() {
        // Make an AJAX Request to trigger the Logout function
        fetch('/StudentLogout', { method: 'GET' })
        .then(response => {
                if (response.ok) {
                    // If logout Successful, redirect to home page
                    window.location.reload();
                    window.location.href = '/';
                } else {
                    // If logout failed, handle error
                    console.error('Logout Failed');
                }
            })
        .catch(error => {
                console.error('Error during logout', error);
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
</body>
</html>
