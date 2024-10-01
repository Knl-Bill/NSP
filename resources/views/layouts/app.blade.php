<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>

<script>
    Pusher.logToConsole = true;

    const echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    echo.private(`student.${rollno}`)
        .listen('LeaveRequestStatusChanged', (e) => {
            alert(`Your leave request was ${e.status}`);
        });
</script>
