<?php
// Set a time threshold (in seconds)
$time_threshold = 60; // 5 minutes

// Get the current time
$current_time = time();

// Get the timestamp of the user's last activity
$last_activity = $_SESSION['last_activity'];

// Calculate the difference between the current time and the last activity
$time_difference = $current_time - $last_activity;

// Check if the user is online or not based on the time threshold
if ($time_difference < $time_threshold) {
    echo "User is currently online";
} else {
    echo "User is currently offline";
}
