document.getElementById('logout').addEventListener('click', function() {
        // Make an AJAX request to trigger the Logout function
            fetch('/AdminLogout').then(response => {
                    if(response.ok) 
                    {
                        // If logout successful, redirect to home page
                        window.location.href = '/';
                        // window.location.reload();
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