document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.querySelector('.loading-overlay');
    let hideLoadingTimeout;

    // Function to show the loading animation
    function showLoading() {
        loadingOverlay.style.display = 'flex';

        // Ensure the loading spinner hides after 5 seconds
        hideLoadingTimeout = setTimeout(hideLoading, 5000);
    }

    // Function to hide the loading animation
    function hideLoading() {
        loadingOverlay.style.display = 'none';
        clearTimeout(hideLoadingTimeout); // Clear the timeout
    }

    // Add event listeners to all buttons and anchor tags
    document.querySelectorAll('.loadspin').forEach(element => {
        element.addEventListener('click', function() {
            showLoading();
        });
    });

    // Handle page load from cache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Page was loaded from cache; don't show loading screen
            hideLoading();
        } 
    });

    // Hide loading animation on initial load if already visible
    window.addEventListener('load', function() {
        clearTimeout(hideLoadingTimeout);
        hideLoading();
    });

    // Ensure loading animation is hidden on page unload
    window.addEventListener('beforeunload', function() {
        hideLoading();
    });
});
