<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outing Registration</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/loading.css">
    <link rel="stylesheet" href="assets/css/SecurityOuting.css">
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
    <div class="outing-container">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="Scanner">
            <button class="submit-btn loadspin" id="Scanner">Scanner</button>
        </div>
        <br>
        <div class="form-container">
            <form action="/InsertOuting" method="POST">
                @csrf
                <div class="form-group">
                    <label class="labels" for="student">Enter a Roll No: - </label>
                    <input class="inputs" type="text" name="rollno" required>
                </div>
                <div class="form-group">
                    <label class="labels" for="student">Gate: - </label>
                    <select name="gate" id="gate" class="inputs">
                        <option value="Main">Main</option>
                        <option value="Poovam">Poovam</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="labels" for="student">Vehicle Number (if required):</label>
                    <input class="inputs" type="text" name="vehicle">
                </div>
                <div class="form-group button">
                    <button class="submit-btn loadspin" type="submit">Submit</button>
                </div>
            </form>
        </div>
        
        <div class="ButtonContainer">
            <div class="OutingStatus">
                <button class="submit-btn loadspin" id="OutingStatus">Outing Status</button>
            </div>
            <div class="Unclosed Outings">
                <button class="submit-btn loadspin" id="UnclosedOuting">Unclosed Outings</button>
            </div>
            <div class="BoysOuting">
                <button class="submit-btn loadspin" id="BoysOuting">Boys Outing</button>
            </div>
            <div class="GirlsOuting">
                <button class="submit-btn loadspin" id="GirlsOuting">Girls Outing</button>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('Scanner').addEventListener('click', function() {
            window.location.href = '{{route('OutingScanner')}}';
        });

        document.getElementById('OutingStatus').addEventListener('click', function() {
            window.location.href = '{{route('OutingStatus')}}';
        });

        document.getElementById('UnclosedOuting').addEventListener('click', function() {
            window.location.href = '{{route('UnclosedOuting')}}';
        });

        document.getElementById('BoysOuting').addEventListener('click', function() {
            window.location.href = '{{route('BoysOuting')}}';
        });

        document.getElementById('GirlsOuting').addEventListener('click', function() {
            window.location.href = '{{route('GirlsOuting')}}';
        });
    </script>
    <script src="assets/js/SecurityLogout.js"></script>
    <script src="assets/js/loading.js"></script>
</body>
</html>