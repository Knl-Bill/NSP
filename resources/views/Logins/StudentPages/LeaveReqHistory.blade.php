<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link rel="stylesheet" href="assets/css/stud_det.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">     
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="assets/css/main.css">  -->
    <link rel="stylesheet" href="assets/css/StudentNewLeaveReqHistory.css"> 
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
     /*Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    
    .form-group input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
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
    .status-text.approved {
        color: #fff;
        background-color: limegreen;
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
      <h1 class="heading font">LEAVE REQUESTS</h1>
       @if (Session::get('success'))
          <span class="text-safe" role="alert">
              {{ Session::get('success') }}
          </span>
      @endif
        @if($errors->has('rollno'))
                <span class="text-danger">{{ $errors->first('rollno') }}</span>
        @endif
      <div class="accordion" id="accordionExample">
          @foreach($students as $stud)
        <div class="accordion-item" >
          <h2 class="accordion-header">
            @if($stud->status=="Approved")
              <button class="accordion-button custom-button approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="outdate-text">OUTDATE -- {{ date('d/m/Y', strtotime($stud->outdate)) }}</span>
                <span class="status-text approved">{{$stud->status}}</span>
              </button>
            @elseif($stud->status=="Provisionally Approved")
              <button class="accordion-button custom-button provisionally-approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="outdate-text">OUTDATE -- {{ date('d/m/Y', strtotime($stud->outdate)) }}</span>
                <span class="status-text provisionally-approved">{{$stud->status}}</span>
              </button>
            @elseif($stud->faculty_adv==2 || $stud->warden==2)
              <button class="accordion-button custom-button rejected" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                <span class="outdate-text">OUTDATE -- {{ date('d/m/Y', strtotime($stud->outdate)) }}</span>
                <span class="status-text rejected">{{$stud->status}}</span>
              </button>
            @endif
          </h2>
          <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <table class="table table-striped-columns table-bordered">
              <tbody>
                <tr>
                        <td>Student</td>
                        <td style="text-align:center;"><img src="storage/profile/{{$stud->stud_photo}}" alt="Profile Picture" style="width:auto; height:150px; text-align:center;"></td>
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
                <tr>
                    @if($stud->faculty_adv==2 || $stud->warden==2 || $stud->status == "Provisionally Accepted" || $stud->created_at != $stud->updated_at)
                        <td>Remark </td>
                        <td>{{$stud->remark}}</td>
                    @endif
                </tr>
                <tr>
                    @if(isset($request) && $request->leaveid===$stud->id)
                        <td>Extension Status </td>
                          @if($request->warden==0 && $request->faculty_adv==0)
                            <td>Not Yet Approved</td>
                          @elseif($request->warden==0 && $request->faculty_adv==1)
                            <td>Approved by Faculty Advisor only</td>
                          @elseif($request->warden==1)
                            <td>Approved</td>
                          @elseif($request->faculty_adv==2 || $request->warden==2)
                            <td>Declined</td>
                          @endif
                    @elseif($stud->created_at != $stud->updated_at)
                        <td>Extension Status </td>
                        <td>Approved</td>
                    @endif
                </tr>
              </tbody>
            </table>
            <div class="buttons">
                @if ($stud->image!=NULL)
                  <div>
                        <button class="view-photo-btn" onclick="togglePhoto({{$loop->iteration}})">View Email</button>
                        <img src="storage/{{$stud->image}}" alt="email screenshot" class="photo" id="photo-{{$loop->iteration}}">
                  </div> 
                @endif
                @if ($stud->status!="Declined")
                    <div>
                        <button class="view-photo-btn" onclick="toggleLeaveExtension({{$loop->iteration}})">Extend Leave</button>
                    </div>
                @endif
            </div>
         <!--    Button to open the modal -->

        
         <!--Modal Structure -->
        <div id="leaveExtensionModal{{$loop->iteration}}" class="modal">
            <div class="modal-content">
                <span class="close" onclick="toggleLeaveExtension({{$loop->iteration}})">&times;</span>
                <h2>Extend Leave</h2>
                <form id="leaveExtensionForm{{$loop->iteration}}" method="POST" action="/InsertLeaveExtRequest" enctype="multipart/form-data">
                    @csrf
                    <!-- Hidden input for leaveid -->
                    <input type="hidden" name="leaveid" value="{{$stud->id}}">
                
                    <div class="form-group">
                        <label for="reason{{$loop->iteration}}">Reason</label>
                        <input type="text" id="reason{{$loop->iteration}}" name="reason" required>
                    </div>
                    <div class="form-group">
                        <label for="indate{{$loop->iteration}}">New In Date</label>
                        <input type="date" id="indate{{$loop->iteration}}" name="indate" min="{{$stud->indate}}" required>
                    </div>
                    <div class="form-group">
                        <label for="intime{{$loop->iteration}}">New In Time</label>
                        <input type="time" id="intime{{$loop->iteration}}" name="intime" required>
                    </div>
                    <div class="form-group">
                        <label for="email{{$loop->iteration}}">New Email</label>
                        <input type="file" id="email{{$loop->iteration}}" name="email" required>
                    </div>
                    <button class="view-photo-btn" type="submit">Submit</button>
                </form>

            </div>
        </div>

            @if ($stud->barcode!=NULL)
              <h5>BARCODE</h5>
              <div>
                  <img src="storage/{{$stud->barcode}}" alt="barcode" style="width:90%; max-width:350px;height: 100px;">
              </div> 
            @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <script>
        document.getElementById('logout').addEventListener('click',function() {
        // Make an AJAX Request to trigger the Logout function
            fetch('/StudentLogout').then(response => {
                if(response.ok)
                {
                    // If logout Successful, redirect to home page
                    window.location.reload();
                    window.location.href = '/';
                }
                else{
                    // If logout failed, handle error
                    console.error('Logout Failed');
                }
            })
            .catch(error => {
                console.error('Error during logout',error);
            });
        });
    </script>
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
    <script>
        function toggleLeaveExtension(id) {
            var modal = document.getElementById('leaveExtensionModal' + id);
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }
        
        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target === modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        };

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