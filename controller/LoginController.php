<?php

//start the session
session_start();

// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../helpers/functions.php');

// The main function that handles the login process
// Check if the user has submitted the login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['username']) && isset($_POST['password'])){  
            
        // Get the user's credentials from the form submission
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Use PDO to query the database for a user with the provided credentials
        $db = new db();
        $conn = $db->getConnection();
        
        // Sanitize the input using the function
        $sanitizedUsername = sanitizeInput($username);
        $sanitizedPassword = sanitizeInput($password);
        
        $stmt = $conn->prepare('SELECT `id_user`, `user_name`, `password`, `role` FROM `users` WHERE `user_name` = ?');
        $stmt->execute([$sanitizedUsername]);  
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If a user is found with the provided username, check their password
        if ($user /*&& password_verify($sanitizedPassword , $user['password'])*/) {
        
          // Store the user's session information
          $_SESSION['user_id'] = $user['id_user'];
          $_SESSION['username'] = $user['user_name'];
          $_SESSION['role'] = $user['role'];
          $_SESSION['loggedIn'] = true;
        
          // Redirect the user to the home page or another protected resource
          header('Location: ../views/dashboard.php');
          exit;
        
        } else {
          // If the user's credentials are invalid, display an error message
          $error_message = 'Invalid username or password.';
          header('Location: ../views/login.php?error='.$error_message);
          exit();
        }
    }
  
}else {
    // If the user has not submitted the login form, display the login view
    header('Location: ../views/login.php');
    exit();
}
  
?>
