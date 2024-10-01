<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outing History</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="assets/css/SecurityOutingHistory.css">
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
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav custom-nav-items">
                <li class="nav-item">
                <a class="nav-link home-btn loadspin" href='{{route('SecurityDashboard')}}'><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
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
    <div class="container filter">
        @if($Name === "Outing History")
        <form method="GET" action="{{ route('OutingStatus') }}">
        @elseif($Name === "Unclosed Outing")
        <form method="GET" action="{{ route('UnclosedOuting') }}">
        @elseif($Name === "Boys Outing")
        <form method="GET" action="{{ route('BoysOuting') }}">
        @elseif($Name === "Girls Outing")
        <form method="GET" action="{{ route('GirlsOuting') }}">
        @endif
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" name="rollno" placeholder="Enter Roll No">
                </div>
                <select class="inputs col" id="course" name="course">
                    <option value="" selected="selected" disabled hidden>Course</option>
                    <option value="B.Tech.">B.Tech</option>
                    <option value="M.Tech.">M.Tech</option>
                    <option value="B.Sc.">B.Sc</option>
                    <option value="M.Sc.">M.Sc</option>
                    <option value="PhD">PhD</option>
                </select>
                <?php $years = range(strftime("%Y", time())-5, strftime("%Y", time())); ?>
                    <select class="inputs col" id="batch" name="batch" required>
                        <option value=1>ALL</option>
                        <option value="" selected="selected"  disabled hidden>Select Batch</option>
                        <?php foreach($years as $year) : ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                    </select>
                <select class="inputs col" id="late" name="late">
                    <option value="" selected="selected" disabled hidden>Is Late?</option>
                    <option value="0">ALL</option>
                    <option value="1">Late</option>
                </select>
                <div class="col">
                    <button type="submit" class="btn btn-primary loadspin">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="outing-container">
        <div class="header">
            <h1 class="heading font">
                {{$Name}}
            </h1>
        </div>
        <br>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Out Date and Time</th>
                        <th>Security</th>
                        <th>Gate</th>
                        <th>In Date and Time</th>
                        <th>Security</th>
                        <th>Gate</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Vehicle</th>
                        <th>E-Mail</th>
                        <th>Year</th>
                        <th>Gender</th>
                        <th>Hostel</th>
                        <th>Room No</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($OutingHistory as $outing)
                    <tr class="{{$outing->gender == 'Male'? 'MaleRow' : 'FemaleRow'}}" @if($outing->late == 1) style="background-color: #ff4c4c; box-shadow: inset -3px -5px 10px #993333;" @endif>
                        <td>{{$outing->rollno}}</td>
                        <td>{{date('d/m/Y h:i a',strtotime($outing->outtime))}}</td>
                        <td>{{$outing->security_out}}</td>
                        <td>{{$outing->out_gate}}</td>
                        <td>{{$outing->intime== NULL?NULL: date('d/m/Y h:i a',strtotime($outing->intime))}}</td>
                        <td>{{$outing->security_in==NULL?NULL : $outing->security_in}}</td>
                        <td>{{$outing->in_gate==NULL?NULL : $outing->in_gate}}</td>
                        <td>{{$outing->name}}</td>
                        <td>{{$outing->phoneno}}</td>
                        <td>{{$outing->vehicle}}</td>
                        <td>{{$outing->email}}</td>
                        <td>{{$outing->year}}</td>
                        <td>{{$outing->gender}}</td>
                        <td>{{$outing->hostel}}</td>
                        <td>{{$outing->roomno}}</td>
                        <td>{{$outing->course}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="assets/js/SecurityLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>