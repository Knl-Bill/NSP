<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/assets/css/login_signup.css?token={{ $token }}">
    <link rel="stylesheet" href="/assets/css/loading.css?token={{ $token }}">
    <script src="/assets/js/student_hostel_course.js?token={{ $token }}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <style>
        .modal-lg {
            max-width: 90%;
        }
        .img-container {
            max-width: 100%;
            max-height: 500px;
            overflow: hidden;
        }
        #image {
            width: 100%; /* Ensure the image fits within the container */
        }
        #croppedImagePreview {
          display: none;
          margin-top: 15px;
        }
    </style>


</head>
<body>
    <div class="loading-overlay">
        <div class="spinner"></div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
          <img class="logo" src="/assets/images/logo.webp" alt="logo">
        </div>
    </nav>
    <div class="login-container">
        <div class="image-container">
            <img src="/assets/images/signup.webp" alt="Sign Up Image" class="image" width="800px">
        </div>
        <div class="form-container">
            <h1 class="heading font">SIGN UP</h1>
            <form method="post" action="/signup/{{$rollno}}/{{$email}}/{{$name}}" id="signup" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="rollno" class="labels font">Roll Number <span class="req">*</span></label>
                    <input class="inputs" type="text" name="rollno"  placeholder="Roll Number" value="{{$rollno}}" hidden required>
                    <input class="inputs disabled" type="text" name="rollno" id="rollno" placeholder="{{$rollno}}" disabled >
                    @if($errors->has('rollno'))
                        <span class="text-danger">{{ $errors->first('rollno') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name" class="labels font">Full Name (as in ID card) <span class="req">*</span></label>
                    <input class="inputs" type="text" name="name"  placeholder="Full Name" value="{{$name}}" hidden required>
                    <input class="inputs disabled" type="text" name="name" id="name" placeholder="{{$name}}" disabled>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                
                <div class="form-group" >
                    <label for="email" class="labels font">E-Mail <span class="req">*</span></label>
                    <input class="inputs" type="text" name="email"  placeholder="E-Mail" value="{{$email}}" hidden required>
                    <input class="inputs disabled" type="text" name="email" id="email" placeholder="{{$email}}" disabled>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phoneno" class="labels font">Phone Number <span class="req">*</span></label>
                    <input class="inputs" type="text" name="phoneno" id="phoneno" placeholder="Phone Number" required>
                    @if($errors->has('phoneno'))
                        <span class="text-danger">{{ $errors->first('phoneno') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="course" class="labels font">Programme <span class="req">*</span></label>
                    <select class="inputs" id="course" name="course" required>
                        <option value="" selected="selected">Select Programme</option>
                    </select>
                    @if($errors->has('course'))
                        <span class="text-danger">{{ $errors->first('course') }}</span>
                    @endif
                </div> 
                <div class="form-group">
                    <label for="dept" class="labels font">Department <span class="req">*</span></label>
                    <select class="inputs" id="dept" name="dept" required>
                        <option value="" selected="selected">Select Department</option>
                    </select> 
                    @if($errors->has('dept'))
                        <span class="text-danger">{{ $errors->first('dept') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <?php $years = range(strftime("%Y", time())-5, strftime("%Y", time())); ?>
                    <label for="batch" class="labels font">Year of Admission <span class="req">*</span></label>
                    <select class="inputs" id="batch" name="batch" required>
                        <option value="" selected="selected">Select Year of Admission</option>
                        <?php foreach($years as $year) : ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                    </select>
                    @if($errors->has('batch'))
                        <span class="text-danger">{{ $errors->first('batch') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="gender" class="labels font">Gender <span class="req">*</span></label>
                    <select class="inputs" id="gender" name="gender" required>
                        <option value="" disabled selected hidden>Choose Gender</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                    @if($errors->has('gender'))
                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="hostelname" class="labels font">Hostel Name <span class="req">*</span></label>
                    <select class="inputs" id="hostelname" name="hostelname" required>
                        <option value="" selected disabled hidden>Choose Hostel Name</option>
                        <option value="Bharani Hostel">Bharani Hostel</option>
                        <option value="Bhavani Hostel">Bhavani Hostel</option>
                        <option value="Moyar Hostel">Moyar Hostel</option>
                    </select>
                    @if($errors->has('hostelname'))
                        <span class="text-danger">{{ $errors->first('hostelname') }}</span>
                    @endif
                </div>
                <div class="form-group" id="floor-selection">
                    <label for="floors" class="labels font">Floor/Block <span class="req">*</span></label>
                    <select class="inputs" id="floors" name="floors" required>
                        <option value="" selected disabled hidden>Choose Floor/Block</option>
                    </select>
                </div>
                <div class="form-group" id="room-selection">
                    <label for="roomno" class="labels font">Hostel Room Number <span class="req">*</span></label>
                    <select class="inputs" id="roomno" name="roomno" required>
                        <option value="" selected disabled hidden>Choose Room Number</option>
                    </select>
                     @if($errors->has('roomno'))
                        <span class="text-danger">{{ $errors->first('roomno') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="faculty_advisor" class="labels font">Faculty Advisor <span class="req">*</span></label>
                    <select class="inputs" id="faculty_advisor" name="faculty_advisor" required>
                        <option value="" selected disabled hidden>Select Your Faculty Advisor</option>
                        @foreach($students as $stud)
                        <option value= "{{$stud->email}}" >{{$stud->name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('faculty_advisor'))
                        <span class="text-danger">{{ $errors->first('faculty_advisor') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="warden" class="labels font">Warden <span class="req">*</span></label>
                    <select class="inputs" id="warden" name="warden" required>
                        <option value="" selected disabled hidden>Select Your Warden</option>
                        @foreach($students as $stud)
                        <option value= "{{$stud->email}}" >{{$stud->name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('warden'))
                        <span class="text-danger">{{ $errors->first('warden') }}</span>
                    @endif
                </div>
                <div class="form-group">
                  <label for="profile_photo" class="labels font">Profile Photo <span class="req">*</span></label>
                  <input class="inputs" type="file" name="profile_photo_show" id="profile_photo" accept="image/*" >
                  <input type="hidden" id="cropped_image_data" name="profile_photo" required>
                  <small class="text-muted">Upload an image with a max size of 1MB.</small>
                  <img id="croppedImagePreview" src="" alt="Cropped Image Preview">
                  <button type="button" id="deleteCroppedImage" class="btn btn-danger" style="display: none;">Delete</button>
                  @if($errors->has('profile_photo'))
                    <span class="text-danger">{{ $errors->first('profile_photo') }}</span>
                  @endif
                </div>
            
                <!-- Modal for cropping -->
                <div id="cropModal" class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Crop Image</h5>
                        <button type="button" class="close" aria-label="Close" id="closeModal">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="img-container">
                          <img id="image" src="" alt="Image for cropping">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelCrop">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="form-group password-container">
                    <label for="password" class="labels font">Password <span style="color:red; font-size:12px">(Should contain [a-z][A-Z][0-9][@$!%*?&]) </span><span class="req">*</span></label>
                    <input class="inputs" type="password" id="password" name="password" placeholder="Enter Password" required>
                    <span class="password-toggle-icon"><i class="fas fa-eye"style="padding-top: 30px"></i></span>
                    @if($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group password-container">
                    <label for="password" class="labels font">Confirm Password <span class="req">*</span></label>
                    <input class="inputs" type="password" id="password" name="confirmpass" placeholder="Enter Password Again" required>
                    <!-- <span class="password-toggle-icon"><i class="fas fa-eye"style="padding-top: 30px"></i></span> -->
                    @if($errors->has('confirmpass'))
                        <span class="text-danger">{{ $errors->first('confirmpass') }}</span>
                    @endif
                </div>
                <div class="form-group button">
                    <input class="submit-btn loadspin" type="submit" id="submit" value="Sign Up">
                </div>
                <div class="text-below-image">Have an account already? <a class="font loadspin" href="{{ route('StudentLogin') }}" style="text-decoration: none">Login</a></div>
            </form>
        </div>
    </div>
    <script>
        const passwordField = document.getElementById("password");
        const togglePassword = document.querySelector(".password-toggle-icon i");

        togglePassword.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            togglePassword.classList.remove("fa-eye");
            togglePassword.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            togglePassword.classList.remove("fa-eye-slash");
            togglePassword.classList.add("fa-eye");
        }
        });
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- Include Axios -->\
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('profile_photo');
        var image = document.getElementById('image');
        var croppedImageData = document.getElementById('cropped_image_data');
        var croppedImagePreview = document.getElementById('croppedImagePreview');
        var deleteCroppedImageBtn = document.getElementById('deleteCroppedImage');
        var cropper;
        var cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
    
        input.addEventListener('change', function (event) {
            var files = event.target.files;
            var done = function (url) {
                input.style.display = 'none'; // Hide file input after selection
                deleteCroppedImageBtn.style.display = 'none'; // Hide delete button
                croppedImagePreview.style.display = 'none'; // Hide the cropped image preview
                image.src = url;
                cropModal.show();
            };
            var reader;
            var file;
            var url;
    
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    
        document.getElementById('cropModal').addEventListener('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 3 / 4, // 3:4 aspect ratio
                viewMode: 1,
                autoCropArea: 1,
                cropBoxResizable: true,
                cropBoxMovable: true,
                responsive: true,
                scalable: true,
            });
        });
    
        document.getElementById('cropModal').addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            croppedImageData.style.display = 'none'; // Hide hidden input field again
            input.value = ''; // Clear the value of the file input field
        });
    
        document.getElementById('crop').addEventListener('click', function () {
            var canvas;
    
            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 225,
                    height: 300, // 3:4 aspect ratio
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        var base64data = reader.result;
    
                        if (croppedImageData) {
                            croppedImageData.value = base64data; // Update hidden input with base64 image data
                        }
                        croppedImagePreview.src = base64data; // Update the preview image with cropped data
                        croppedImagePreview.style.display = 'block'; // Show the preview image
                        deleteCroppedImageBtn.style.display = 'block'; // Show the delete button
    
                        cropModal.hide();
                    };
                });
            }
        });
    
        // Custom JavaScript to manually close the modal
        document.getElementById('closeModal').addEventListener('click', function () {
            cropModal.hide();
        });
    
        document.getElementById('cancelCrop').addEventListener('click', function () {
            cropModal.hide();
        });
    
        // Handle deletion of the cropped image
        deleteCroppedImageBtn.addEventListener('click', function () {
            croppedImagePreview.style.display = 'none'; // Hide the cropped image preview
            deleteCroppedImageBtn.style.display = 'none'; // Hide the delete button
            input.style.display = 'block'; // Show the file input again
            croppedImageData.value = ''; // Clear the hidden input value
        });
    });
  </script>
  <script src="{{asset('assets/js/loading.js')}}?token={{ $token }}"></script>
</body>
</html>