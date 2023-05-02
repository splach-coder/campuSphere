<?php
session_start(); // start the session

// unset all session variables
$_SESSION = array();

// destroy the session
session_destroy();

// redirect the user to the login page or homepage
header("Location: ../views/login.php"); // replace with the appropriate URL

exit(); // terminate the script
