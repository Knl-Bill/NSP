<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Profile</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/NewProfile.css">
    <link rel="stylesheet" href="assets/css/loading.css">
    
    <script>
        window.addEventListener('pageshow', function(event) {
        if(event.persisted)
          {
            window.location.reload();
          }
        });
        let user = "{{Session::has('mess')}}";
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
                        <a class="nav-link home-btn loadspin" href='{{route("MessDashboard")}}'><i class="bi bi-house-door-fill"></i></a>
                    </li>
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
            @foreach($details as $detail)
            <table class="table table-striped-columns table-bordered">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{$detail->name}}</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>{{$detail->phoneno}}</td>
                    </tr>
                    <tr>
                        <td>E-Mail Address</td>
                        <td>{{$detail->email}}</td>
                    </tr>
                    <tr>
                        <td>Mess Hall</td>
                        <td>{{$detail->mess_hall}}</td>
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
                <form method="post" action="{{route('postMessChangePassword')}}" id="signup">
                    @csrf
                    <div class="form-group">
                        <label class="labels" for="current_password" class="font">Current Password</label>
                        <input class="inputs" type="password" name="current_password" id="current_password" placeholder="Enter Current Password" required>
                        @if($errors->has('current_password'))
                            <span class="text-danger">{{ $errors->first('current_password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="new_password" class="font">New Password</label>
                        <input class="inputs" type="password" name="new_password" id="new_password" placeholder="Enter New Password" required>
                        @if($errors->has('new_password'))
                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="new_password_confirmation" class="font">Confirm Password</label>
                        <input class="inputs" type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Enter Password Again" required>
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>

            <div class="form-container">
                <h3 class="font1">Phone Number</h3>
                <form method="post" action="{{route('postMessChangephoneno')}}" id="signup">
                    @csrf
                    <div class="form-group">
                        <label class="labels" for="phoneno" class="font">New Phone Number</label>
                        <input class="inputs" type="text" name="phoneno" id="phoneno" placeholder="Enter New Phone Number" pattern="[0-9]{10}" required>
                        @if($errors->has('phoneno'))
                            <span class="text-danger">{{ $errors->first('phoneno') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="password" class="font">Current Password</label>
                        <input class="inputs" type="password" name="password" id="password" placeholder="Enter Current Password" required>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group button">
                        <input class="submit-btn" type="submit" id="submit" value="Submit">
                    </div>
                </form>
            </div>

            <div class="form-container">
                <h3 class="font1">E-Mail Address</h3>
                <form method="post" action="{{route('postMessChangeemail')}}" id="signup">
                    @csrf
                    <div class="form-group">
                        <label class="labels" for="email" class="font">New E-Mail Address</label>
                        <input class="inputs" type="email" name="email" id="email" placeholder="Enter New Email" required>
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labels" for="password" class="font">Current Password</label>
                        <input class="inputs" type="password" name="password" id="password" placeholder="Enter Current Password" required>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
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
        <button class="yes-button loadspin" id="confirmYes">Yes</button>
        <button class="no-button" id="confirmNo">No</button>
    </div>

    <script src="assets/js/profile.js"></script>
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