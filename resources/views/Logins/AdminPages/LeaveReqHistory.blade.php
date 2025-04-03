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
    <!-- <link rel="stylesheet" href="assets/css/main.css"> -->
    <link rel="stylesheet" href="assets/css/AdminLeave.css"/>
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="assets/css/stud_det.css">
    <script>
        window.addEventListener('pageshow', function(event) {
        if(event.persisted)
          {
            window.location.reload();
          }
        });
        let user = "{{Session::has('admin')}}";
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
    .custom-button.approved {
    background-color: #ccffcc; /* Very light green for Approved */
    }
    
    .custom-button.provisionally-approved {
        background-color: #e6ccff; /* Very light purple for Provisionally Approved */
    }
    
    .custom-button.rejected {
        background-color: #ffcccc; /* Very light red for Rejected */
    }

    .rollno-text {
        font-weight: bold;
        color: #007bff; /* Blue color for Roll No */
    }
    
    .status-text {
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
    }
    
    /* Specific status colors */
    .status-text.approved {
        color: #fff;
        background-color: limegreen;
    }
    .status-text.extended {
        color: #fff;
        background-color: #cd8432;
    }
    .status-text.provisionally-approved {
        color: #fff;
        background-color: purple;
    }
    
    .status-text.rejected {
        color: #fff;
        background-color: red;
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
          <div class="navbar-title-container">
                <span class="navbar-title">NIT Puducherry Student Portal</span>
          </div>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav custom-nav-items">
              <li class="nav-item">
                <a class="nav-link home-btn loadspin" id="home" href='{{route('AdminDashboard')}}'><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile-btn loadspin" id="profile" href='{{route('AdminProfile')}}'><i class="bi bi-person-fill custom-icon"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link logout-btn loadspin" id="logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="table-container">
        <!--<div class="OutingStatus">-->
        <!--    <button class="submit-btn loadspin" id="OutingStatus">Outing Status</button>-->
        <!--</div>-->
      <h1 class="heading font">LEAVE REQUESTS</h1>
      <div class="accordion" id="accordionExample">
          @foreach($students as $stud)
        <div class="accordion-item" >
          <h2 class="accordion-header">
            @if($stud->status=="Approved")
                <button class="accordion-button custom-button approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="rollno-text">{{$stud->rollno}}</span>
                &nbsp;&nbsp;
                <span class="status-text approved">{{$stud->status}}</span>
                @if($stud->created_at != $stud->updated_at)
                    &nbsp;<span class="status-text extended">Extended</span>
                @endif
              </button>
            @elseif($stud->status=="Declined")
              <button class="accordion-button custom-button rejected" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="rollno-text">{{$stud->rollno}}</span>
                &nbsp;&nbsp;
                <span class="status-text rejected">{{$stud->status}}</span>
              </button>
            @elseif($stud->status=="Provisionally Approved")
              <button class="accordion-button custom-button provisionally-approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="rollno-text">{{$stud->rollno}}</span>
                &nbsp;&nbsp;
                <span class="status-text provisionally-approved">{{$stud->status}}</span>
                @if($stud->created_at != $stud->updated_at)
                    &nbsp;<span class="status-text extended">Extended</span>
                @endif
              </button>
            @endif
          </h2>
          <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <table class="table table-striped-columns table-bordered">
              <tbody>
                  <tr>
                    <td>Student</td>
                    <td><img style="height:150px; width:auto;" src="storage/profile/{{$stud->stud_photo}}"></td>
                  </tr>
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
                  <td>{{$stud->status}}</td>
                </tr>  
                @if(isset($stud->remark))
                    <tr>
                      <td>Remark </td>
                      <td>{{$stud->remark}}</td>
                    </tr> 
                @endif
              </tbody>
            </table>
            @if ($stud->image!=NULL)
              <div>
                    <button class="view-photo-btn" onclick="togglePhoto({{$loop->iteration}})">View Email</button>
                    <img src="storage/{{$stud->image}}" alt="email screenshot" class="photo" id="photo-{{$loop->iteration}}">
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
        document.getElementById('OutingStatus').addEventListener('click', function() {
            window.location.href = '{{route('OutingStatus')}}';
        });
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
    <script src="assets/js/AdminLogout.js"></script>
      <script src="assets/js/loading.js"></script>
</body>
</html>