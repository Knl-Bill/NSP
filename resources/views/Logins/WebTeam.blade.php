<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Development Team</title>
    <link rel="icon" type="image/webp" href="assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/web_team.css"> 
    
</head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid custom-navbar">
          <img class="logo" src="assets/images/logo.webp" alt="logo">
          <!-- <a class="navbar-brand custom-brand" href="#">NIT Puducherry</a> -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav custom-nav-items">
              <li class="nav-item">
                <a class="nav-link home-btn" id="home"><i class="bi bi-house-door-fill custom-icon"></i></a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="team-container">
        <h1 class="heading font">WEB DEVELOPMENT TEAM</h1>
        <div class="team-members">
          <div class="team-member">
            <img src="assets/images/kunal.webp" alt="Kunal Billade" />
            <div class="member-info">
              <h2 class="name">Kunal Billade</h2>
              <p>Backend Developer<br/>CSE, 2021-25 Batch</p>
            </div>
          </div>
          <div class="team-member">
            <img src="assets/images/harsh.webp" alt="Harsh Prasad" />
            <div class="member-info">
              <h2 class="name">Harsh Prasad</h2>
              <p>Backend Developer<br/>CSE, 2021-25 Batch</p>
            </div>
          </div>
          <div class="team-member">
            <img src="assets/images/manvitha.webp" alt="Manvitha Pagadala" />
            <div class="member-info">
              <h2 class="name">Manvitha Pagadala</h2>
              <p>Frontend Developer<br/>CSE, 2021-25 Batch</p>
            </div>
          </div>
        </div>
    </div>

    <div class="acknowledgement">
        <h1 class="ack-heading heading font">ACKNOWLEDGEMENTS</h1>
        <p>
            The Web Team is proud to present our latest innovation aimed at streamlining the student experience at NIT Puducherry. Our team worked diligently to automate the leave approval system, transforming what was once a labor-intensive and time-consuming paper-based process. Previously, students had to obtain physical signatures from their faculty advisors and wardens, often leading to delays and inefficiencies. With the new system in place, leave requests can now be processed quickly and efficiently online, saving valuable time for both students and faculties. In addition, the outing system has also undergone a significant transformation. The old method relied on a book register to record outings, which made it difficult for students to start an outing from one gate and end it at another. Our automated system eliminates this hassle by using barcodes and digital tracking, ensuring a seamless experience for all students. This innovation not only enhances security and accountability but also provides greater flexibility for students. We extend our heartfelt thanks to everyone who contributed to this project and made this vision a reality. The support and collaboration of our faculty, staff, and students have been instrumental in driving this initiative forward. We remain committed to further enhancing the student experience through technology and innovation.
        </p>
    </div>
    <br><br>
    <footer class="footer-webpage">
      <div class="footer-content">
          <p>Copyright &copy; 2024 <a href='{{route('WebTeam')}}' style="font-weight: bold;color:white;">Webteam</a> @ NIT Puducherry</p>
      </div>
    </footer>
    <script>
        document.getElementById('home').addEventListener('click', function() {
            window.location.href = '/';
        });
    </script>
  </body>
</html>
