// Check connection status on page load
if (navigator.onLine) {
    showOnlineStatus();
} else {
    showOfflineStatus();
}

// Listen for online/offline events
window.addEventListener('online', function () {
    showOnlineStatus();
});

window.addEventListener('offline', function () {
    showOfflineStatus();
});

// Function to show online status message
function showOnlineStatus() {
    alert("Connection restored.");
}

// Function to show offline status message
function showOfflineStatus() {
    alert("Connection failed.");
}