<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave History</title>
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
        @if($Name === "Leave History")
        <form method="GET" action="{{ route('LeaveStatus') }}">
        @elseif($Name === "Unclosed Leaves")
        <form method="GET" action="{{ route('UnclosedLeaves') }}">
        @elseif($Name === "Boys Leaves")
        <form method="GET" action="{{ route('BoysLeave') }}">
        @elseif($Name === "Girls Leaves")
        <form method="GET" action="{{ route('GirlsLeave') }}">
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
                    <button type="submit loadspin" class="btn btn-primary">Search</button>
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
                        <th>Out-Gate</th>
                        <th>In Date and Time</th>
                        <th>Security</th>
                        <th>In-Gate</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Place of Visit</th>
                        <th>Purpose</th>
                        <th>Gender</th>
                        <th>Batch</th>
                        <th>Programme</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($LeaveHistory as $leave)
                    <tr class="{{$leave->gender == 'Male'? 'MaleRow' : 'FemaleRow'}}" @if($leave->late == 1) style="background-color: #ff4c4c; box-shadow: inset -3px -5px 10px #993333;" @endif>
                        <td>{{$leave->rollno}}</td>
                        <td>{{date('d/m/Y h:i a',strtotime($leave->outtime))}}</td>
                        <td>{{$leave->outregistration}}</td>
                        <td>{{$leave->outgate}}</td>
                        <td>{{$leave->intime== NULL?NULL: date('d/m/Y h:i a',strtotime($leave->intime))}}</td>
                        <td>{{$leave->inregistration==NULL?NULL:$leave->inregistration}}</td>
                        <td>{{$leave->ingate==NULL?NULL:$leave->ingate}}</td>
                        <td>{{$leave->name}}</td>
                        <td>{{$leave->phoneno}}</td>
                        <td>{{$leave->placeofvisit}}</td>
                        <td>{{$leave->purpose}}</td>
                        <td>{{$leave->gender}}</td>
                        <td>{{$leave->year}}</td>
                        <td>{{$leave->course}}</td>
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