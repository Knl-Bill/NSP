document.getElementById('logout').addEventListener('click', function() {
        // Make an AJAX request to trigger the Logout function
            fetch('/SecurityLogout').then(response => {
                    if(response.ok) 
                    {
                        // If logout successful, redirect to home page
                        window.location.reload();
                        window.location.href = '/';
                    } 
                    else 
                    {
                        // If logout failed, handle error
                        console.error('Logout failed');
                    }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
        });