<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/login_signup.css">
    <link rel="stylesheet" href="assets/css/loading.css">
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
        </div>
    </nav>

    <div class="new-login-container">
        <div class="new-image-container">
            <img src="assets/images/humaaans.webp" alt="Mess Staff Login" class="image" width="800px">
        </div>
        <div class="new-form-container">
            <h1 class="heading font">MESS STAFF LOGIN</h1>
            <form method="post" action="/MessLoginVerify">
                @csrf
                <div class="new-form-group">
                    @if (Session::get('success'))
                        <span class="text-safe">{{ Session::get('success') }}</span>
                    @endif
                    <label for="email" class="font labels">E-Mail</label>
                    <input class="inputs" type="email" name="email" id="email" placeholder="Enter your email" required>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="new-form-group">
                    <label for="password" class="font labels">Password</label>
                    <div class="password-container">
                        <input class="inputs" type="password" name="password" id="password" placeholder="Enter your password" required>
                        <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                    </div>
                    @if($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="new-form-group">
                    <a href="{{ route('reset_pass_mess') }}" class="font loadspin" style="font-size:14px; text-decoration:none;">Forgot Password?</a>
                </div>
                <div class="new-form-group">
                    <input type="submit" value="Login" class="submit-btn">
                </div>
            </form>
        </div>
    </div>

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

        // Password visibility toggle
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
</body>
</html>