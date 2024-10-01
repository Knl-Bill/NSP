<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">
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
    <style>
    .button-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    .received-time {
        margin-left: auto;
    }
    .photo {
        display: none;
        margin-top: 10px;
        max-width: 100%;
        max-height: 300px;
    }
    .view-photo-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
    }
    .view-photo-btn:hover {
        background-color: #0056b3;
    }
    
    
    .custom-button {
        background-color: #f8f9fa; /* Light gray background for the button */
        border: 1px solid #ced4da; /* Border to make it more defined */
        color: #333; /* Dark text color */
        padding: 10px 15px;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%; /* Ensure the button takes the full width */
    }
    .custom-button.fac-approved {
    background-color: #ffffcc; /* Very light green for Approved */
    }

    .outdate-text {
        font-weight: bold;
        color: #1625AD; /* Blue color for the outdate text */
        background-color: #e7f1ff; /* Light blue background */
        padding: 2px 6px;
        border-radius: 4px;
        margin-right: 10px;
    }
    
    .status-text {
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
    }
    
    /* Specific status colors */
    .status-text.fac-approved {
        color: #ffffff;
        background-color: #ffc107;
    }
    .status-text.no-action {
        color: #ffffff;
        background-color: #a1a1a1;
    }
    .custom-button:hover {
    filter: brightness(0.95);
    }
    </style>
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
                <a class="nav-link home-btn loadspin" id="home" href='{{route('StudentDashboard')}}'><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile-btn loadspin" id="profile" href='{{route('StudentProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="table-container">
      <h1 class="heading font">PENDING LEAVE REQUESTS</h1>
      <div class="accordion" id="accordionExample">
          @foreach($students as $stud)
        <div class="accordion-item" >
          <h2 class="accordion-header">
            @if(($stud->warden==0 && $stud->faculty_adv==1))
              <button class="accordion-button custom-button fac-approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="outdate-text">OUTDATE -- {{ date('d/m/Y', strtotime($stud->outdate)) }}</span>
                <span class="status-text fac-approved">Faculty Adv. Approved</span>
              </button>
            @elseif(($stud->warden==0 && $stud->faculty_adv==0) )
              <button class="accordion-button custom-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="outdate-text">OUTDATE -- {{ date('d/m/Y', strtotime($stud->outdate)) }}</span>
                <span class="status-text no-action">No action</span>
              </button>
            @endif
          </h2>
          <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <table class="table table-striped-columns table-bordered">
              <tbody>
              <tr>
                  <td>Roll Number</td>
                  <td>{{$stud->rollno}}</td>
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
                  <td>Place of Visit</td>
                  <td>{{$stud->placeofvisit}}</td>
                </tr>
                <tr>
                  <td>Purpose of Visit</td>
                  <td>{{$stud->purpose}}</td>
                </tr>
                <tr>
                  <td>Out Date</td>
                  <td>{{date('d/m/Y',strtotime($stud->outdate))}}</td>
                </tr>
                <tr>
                  <td>Out Time </td>
                  <td>{{date('h:i a',strtotime($stud->outime))}}</td>
                </tr>
                <tr>
                  <td>In Date  </td>
                  <td>{{date('d/m/Y',strtotime($stud->indate))}}</td>
                </tr>
                <tr>
                  <td>In Time </td>
                  <td>{{date('h:i a',strtotime($stud->intime))}}</td>
                </tr>
                <tr>
                  <td>No. Of Days </td>
                  <td>{{$stud->noofdays}}</td>
                </tr>
                <tr>
                  <td>Status </td>
                  @if($stud->warden==0 && $stud->faculty_adv==0)
                    <td>Not Yet Approved</td>
                  @elseif($stud->warden==0 && $stud->faculty_adv==1)
                    <td>Approved by Faculty Advisor only</td>
                  @elseif($stud->warden==1)
                    <td>Approved</td>
                  @elseif($stud->faculty_adv==2 || $stud->warden==2)
                    <td>Declined</td>
                  @endif
                </tr>
              </tbody>
            </table>
            @if ($stud->image!=NULL)
              <div>
                    <button class="view-photo-btn" onclick="togglePhoto({{$loop->iteration}})">View Email</button>
                    <img src="public/storage/{{$stud->image}}" alt="email screenshot" class="photo" id="photo-{{$loop->iteration}}">
              </div> 
            @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <script>
        function togglePhoto(index) 
        {
            var photo = document.getElementById('photo-' + index);
            if (photo.style.display === 'none' || photo.style.display === '') 
            {
                photo.style.display = 'block';
            } else 
            {
                photo.style.display = 'none';
            }
        }
    </script>
    <script src="assets/js/StudentLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>