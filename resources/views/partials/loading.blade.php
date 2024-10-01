<!-- resources/views/partials/loading.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/loading.css">

</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader"></div>
    </div>
    <!-- Your content goes here -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#AdminId, #StudentId, #SecurityId').on('click', function() {
                $('#loadingOverlay').fadeIn(); // Show loading overlay on button click
            });
        });
    </script>
</body>
</html>
