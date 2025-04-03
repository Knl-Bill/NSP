<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Extension</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link rel="stylesheet" href="assets/css/stud_det.css">
    <link rel="stylesheet" href="assets/css/loading.css">   
    <!-- <link rel="stylesheet" href="assets/css/main.css"/> -->
    <link rel="stylesheet" href="assets/css/AdminLeave.css"/>  
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($students as $stud)
          const acceptCheckbox{{ $loop->iteration }} = document.getElementById('accept_checkbox_{{ $loop->iteration }}');
          const PacceptCheckbox{{ $loop->iteration }} = document.getElementById('paccept_checkbox_{{ $loop->iteration }}');
          const declineCheckbox{{ $loop->iteration }} = document.getElementById('decline_checkbox_{{ $loop->iteration }}');
          const declineReason{{ $loop->iteration }} = document.getElementById('decline_reason_{{ $loop->iteration }}');
          const submitBtn{{ $loop->iteration }} = document.getElementById('submit_{{ $loop->iteration }}');

          acceptCheckbox{{ $loop->iteration }}.addEventListener('change', function() {
              if (acceptCheckbox{{ $loop->iteration }}.checked) {
                  declineCheckbox{{ $loop->iteration }}.checked = false;
                  declineReason{{ $loop->iteration }}.disabled = true;
                  declineReason{{ $loop->iteration }}.value = '';
              }
          });
            
          declineCheckbox{{ $loop->iteration }}.addEventListener('change', function() {
              if (declineCheckbox{{ $loop->iteration }}.checked) {
                  acceptCheckbox{{ $loop->iteration }}.checked = false;
                  declineReason{{ $loop->iteration }}.disabled = false;
              } else {
                  declineReason{{ $loop->iteration }}.disabled = true;
                  declineReason{{ $loop->iteration }}.value = '';
              }
          });
          
          if(PacceptCheckbox{{$loop->iteration}} != null)
          {
              PacceptCheckbox{{ $loop->iteration }}.addEventListener('change', function() {
                  if (PacceptCheckbox{{ $loop->iteration }}.checked) {
                      console.log(PacceptCheckbox{{$loop->iteration}});
                      acceptCheckbox{{ $loop->iteration }}.checked = false;
                      declineReason{{ $loop->iteration }}.disabled = false;
                  } else {
                      declineReason{{ $loop->iteration }}.disabled = true;
                      declineReason{{ $loop->iteration }}.value = '';
                  }
              });           
          }

          submitBtn{{ $loop->iteration }}.addEventListener('click', function(event) {
              if (declineCheckbox{{ $loop->iteration }}.checked && declineReason{{ $loop->iteration }}.value.trim() === '') {
                  event.preventDefault();
                  alert('Please provide a reason for declining.');
              }
              if(PacceptCheckbox{{$loop->iteration}} != null)
              {
                  if(PacceptCheckbox{{$loop->iteration}}.checked &&
                  declineReason{{$loop->iteration}}.value.trim() === '') {
                     event.preventDefault();
                     alert('Please provide a reason for Accepting Provisionally');
                  }
              }
          });
        @endforeach

        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    });

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
    #decline_reason:disabled 
    {
        background-color: #f0f0f0; /* Light gray background */
        color: #999; /* Gray text */
        cursor: not-allowed; /* Show "not allowed" cursor */
    }
    
    .custom-button {
    border: 1px solid #ced4da;
    color: #333;
    padding: 10px 15px;
    font-size: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    transition: background-color 0.3s ease;
    }
    
    .button-content {
        display: flex;
        align-items: center;
    }
    
    .rollno-text {
        font-weight: bold;
        color: #007bff; /* Blue color for Roll No */
    }
    
    .received-time {
    font-weight: normal;
    color: #333; /* Darker gray for better readability */
    background-color: #f0f8ff; /* Light blue background */
    padding: 4px 8px; /* Add padding for better spacing */
    border-radius: 4px; /* Rounded corners for a smoother look */
    font-size: 14px; /* Slightly smaller font size for distinction */
    display: inline-block; /* Ensures padding and background are applied correctly */
    margin-left: 10px; /* Adds space between the roll number and the time */
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    
    /* Status-based button colors */
    .custom-button.faculty-approved {
        background-color: #9eff9e; /* Very light green for approved */
    }
    .custom-button.war-faculty-approved {
        background-color: #f8c797; /* Very light green for approved */
    }
    .custom-button.faculty-pending {
        background-color: #f2f2f2; /* Light gray for pending */
    }
    
    /* Hover effect */
    .custom-button:hover {
        filter: brightness(0.95);
    }
    </style>

</head>
<body>

    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>
    @php
    use Carbon\Carbon;
    @endphp
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
      <h1 class="heading font">LEAVE EXTENSION REQUESTS</h1>
      @if (Session::has('fac_req'))
        <div class="text-danger" role="alert">
            {{ Session::get('fac_req') }}
        </div>
    @endif
      @if (Session::get('success'))
          <span class="text-safe" role="alert">
              {{ Session::get('success') }}
          </span>
      @endif
      @if (Session::get('error'))
          <span class="text-danger" role="alert">
              {{ Session::get('error') }}
          </span>
      @endif
      <div class="accordion" id="accordionExample">
        @foreach ($students as $stud)
        <div class="accordion-item" >
          <h2 class="accordion-header">
          @if(session()->has('role'))
            @if(session('role')=="faculty")
              @if($stud->faculty_adv==1)
                  <button class="accordion-button custom-button faculty-approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                    <div class="button-content">
                      <span class="rollno-text">{{$stud->rollno}}</span>
                      <span class="received-time">&nbsp;&nbsp;Received On: {{ Carbon::parse($stud->created_at)->format('d-m-Y h:i a') }}</span>
                    </div>
                  </button>
              @else
                  <button class="accordion-button custom-button faculty-pending" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                    <div class="button-content">
                      <span class="rollno-text">{{$stud->rollno}}</span>
                      <span class="received-time">&nbsp;&nbsp;Received On: {{ Carbon::parse($stud->created_at)->format('d-m-Y h:i a') }}</span>
                    </div>
                  </button>
              @endif
            @else
              @if($stud->faculty_adv==1)
                <button class="accordion-button custom-button war-faculty-approved" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                    <div class="button-content">
                      <span class="rollno-text">{{$stud->rollno}}</span>
                      <span class="received-time">&nbsp;&nbsp;Received On: {{ Carbon::parse($stud->created_at)->format('d-m-Y h:i a') }}</span>
                    </div>
                </button>
              @else
                <button class="accordion-button custom-button faculty-pending" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                    <div class="button-content">
                      <span class="rollno-text">{{$stud->rollno}}</span>
                      <span class="received-time">&nbsp;&nbsp;Received On: {{ Carbon::parse($stud->created_at)->format('d-m-Y h:i a') }}</span>
                    </div>
                </button>
              @endif
            @endif
          @endif
          </h2>
          <div id="collapse{{$loop->iteration}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <table class="table table-striped-columns table-bordered">
                <tbody>
                  <tr>
                    <td>Student</td>
                    <td><img style="height:150px; width:auto;" src="storage/profile/{{$stud->stud_photo}}"></td>
                  </tr>
                  <tr>
                    <td>Name</td>
                    <td>{{$stud->name}}</td>
                  </tr>
                  <tr>
                    <td>Old In Date  </td>
                    <td>{{date('d/m/Y',strtotime($stud->indate))}}</td>
                  </tr>
                  <tr>
                    <td>Old In Time </td>
                    <td>{{date('h:i a',strtotime($stud->intime))}}</td>
                  </tr>
                  <tr>
                    <td>New In Date  </td>
                    <td>{{date('d/m/Y',strtotime($stud->new_indate))}}</td>
                  </tr>
                  <tr>
                    <td>New In Time </td>
                    <td>{{date('h:i a',strtotime($stud->new_intime))}}</td>
                  </tr>
                  <tr>
                    <td>Reason for Extension </td>
                    <td>{{$stud->ext_reason}}</td>
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
                    <td>Out Date</td>
                    <td>{{date('d/m/Y',strtotime($stud->outdate))}}</td>
                  </tr>
                  <tr>
                    <td>Out Time </td>
                    <td>{{date('h:i a',strtotime($stud->outime))}}</td>
                  </tr>
                  
                </tbody>
              </table>
              @if ($stud->image!=NULL)
              <div class="ss-and-approval">
                <div>
                    <button class="view-photo-btn" onclick="togglePhoto({{$loop->iteration}})">View Email</button>
                    <img src="storage/{{$stud->image}}" alt="email screenshot" class="photo" id="photo-{{$loop->iteration}}">
                </div> 
                @endif
                
                <div class="approval">
                  @if(session()->has('role'))
                    <!-- <p>{{session('role')}}</p> -->
                    @if(session('role')=="faculty")
                      <div class="buttons">
                        <div class="approval-text">
                          <h4 class="font1">FACULTY ADVISOR APPROVAL:</h4>
                        </div>
                        @if($stud->faculty_adv==0)
                          <form method="post" action="/LeaveExtensionFaculty/{{$stud->rollno}}" enctype="multipart/form-data">
                            @csrf
                            <div class="approval">
                              <div class="approval-btns">
                                <input type="radio" id="accept_checkbox_{{ $loop->iteration }}" name="fac_acc" value="Accept" required>
                                <label style="color: green; font-weight: bold;">Accept</label>
                              </div>
                              <div class="approval-btns">
                                <input type="radio" id="decline_checkbox_{{ $loop->iteration }}" name="fac_acc" value="Decline" required>
                                <label style="color: red; font-weight: bold;">Decline</label>
                              </div>
                              <br>
                              <div class="approval-btns">
                                <input type="text" id="decline_reason_{{$loop->iteration}}" name="decline_reason" placeholder="Enter reason" disabled required>
                              </div>
                              <br>
                              <div class="approval-btns">
                                <input class="submit-btn loadspin" type="Submit" id="submit_{{ $loop->iteration }}" value="Submit">
                              </div>
                            </div>
                          </form>
                          @elseif($stud->faculty_adv==1)
                            <h5 style="color: green; font-weight: bold;">Approved</h5>
                          @else
                            <h5 style="color: red; font-weight: bold;">Declined</h5>
                        @endif
                      </div>
                    @else
                      <div class="buttons">
                        @if($stud->faculty_adv==1)
                          <h5 style="font-style: italic; color: #228B22;">Approved by Faculty Advisor</h5>
                        @endif
                        <div class="approval-text">
                          <h4 class="font1">WARDEN APPROVAL:</h4>
                        </div>
                        @if($stud->faculty_adv==0)
                            <h5 style="font-style: italic; color: #FF0000;">Not Yet Approved by Faculty Advisor.</h5>
                            <form method="post" action="/LeaveExtensionWarden/{{$stud->rollno}}" enctype="multipart/form-data">
                            @csrf
                            <div class="approval">
                              <div class="approval-btns">
                                <input type="radio" id="accept_checkbox_{{ $loop->iteration }}" name="war_acc" value="Accept" disabled>
                                <label style="color: grey; font-weight: bold;">Accept</label>
                              </div>
                              <div class="approval-btns">
                                <input type="radio" id="paccept_checkbox_{{ $loop->iteration }}" name="war_acc" value="Paccept">
                                <label style="color: purple; font-weight: bold;">Provisional Acceptance</label>
                              </div>
                              <div class="approval-btns">
                                <input type="radio" id="decline_checkbox_{{ $loop->iteration }}" name="war_acc" value="Decline" disabled>
                                <label style="color: grey; font-weight: bold;">Decline</label>
                              </div>
                              <br>
                              <div class="approval-btns">
                                <input type="text" id="decline_reason_{{$loop->iteration}}" name="decline_reason" placeholder="Enter reason" disabled required>
                              </div>
                              <br>
                              <div class="approval-btns">
                                <input class="submit-btn loadspin" type="Submit" id="submit_{{ $loop->iteration }}" value="Submit">
                              </div>
                            </div>
                          </form>
                        @elseif($stud->warden==0)
                          <form method="post" action="/LeaveExtensionWarden/{{$stud->rollno}}" enctype="multipart/form-data">
                            @csrf
                            <div class="approval">
                              <div class="approval-btns">
                                <input type="radio" id="accept_checkbox_{{ $loop->iteration }}" name="war_acc" value="Accept" required>
                                <label style="color: green; font-weight: bold;">Accept</label>
                              </div>
                              <div class="approval-btns">
                                <input type="radio" id="decline_checkbox_{{ $loop->iteration }}" name="war_acc" value="Decline" required>
                                <label style="color: red; font-weight: bold;">Decline</label>
                              </div>
                              <br>
                              <div class="approval-btns">
                                <input type="text" id="decline_reason_{{$loop->iteration}}" name="decline_reason" placeholder="Enter reason" disabled required>
                              </div>
                              <br>
                              <div class="approval-btns">
                                <input class="submit-btn loadspin" type="Submit" id="submit_{{ $loop->iteration }}" value="Submit">
                              </div>
                            </div>
                          </form>
                          @elseif($stud->warden==1)
                            <h5 style="color: green; font-weight: bold;">Approved</h5>
                          @else
                            <h5 style="color: red; font-weight: bold;">Declined</h5>
                        @endif
                      </div>
                    @endif
                  @endif  
                </div> 
              </div>
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