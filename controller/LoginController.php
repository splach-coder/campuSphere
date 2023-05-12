<?php

//start the session
session_start();

// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../helpers/functions.php');

// The main function that handles the login process
// Check if the user has submitted the login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['username']) && isset($_POST['password'])) {

    // Get the user's credentials from the form submission
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use PDO to query the database for a user with the provided credentials
    $db = new db();
    $conn = $db->getConnection();

    // Sanitize the input using the function
    $sanitizedUsername = sanitizeInput($username);
    $sanitizedPassword = sanitizeInput($password);


    $stmt = $conn->prepare("SELECT u.id_user, `user_name`, `password`, `role`, p.first_name, p.last_name, concat(p.first_name, ' ', p.last_name) as 'fullname' , `profile_pic` FROM `users` u, `profile` p WHERE p.id_user = u.id_user AND `user_name` = ?");
    $stmt->execute([$sanitizedUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // If a user is found with the provided username, check their password
    if ($user && password_verify($sanitizedPassword, $user['password'])) {
      if (isset($_POST['remember_me'])) {
        // Generate a random token and store it in a cookie
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        setcookie('remember_token', $token, time() + (86400 * 30), '/'); // Cookie expires in 30 days

        // Store the token in the database
        $user_id = $user['id_user']; // Replace with the actual user ID
        $expiry_date = date('Y-m-d H:i:s', time() + (86400 * 30)); // Token expires in 30 days
        $sql = "UPDATE `users` SET `token`=?,`expiration`=? WHERE `id_user`=? ;";
        $conn->prepare($sql)->execute([$token, $expiry_date, $user_id]);
      }

      // Store the user's session information
      $_SESSION['user_id'] = $user['id_user'];
      $_SESSION['username'] = $user['user_name'];
      $_SESSION['fullname'] = $user['fullname'];
      $_SESSION['firstname'] = $user['first_name'];
      $_SESSION['lastname'] = $user['last_name'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['profile_pic'] = $user['profile_pic'];
      $_SESSION['last_activity'] = time();
      $_SESSION['loggedIn'] = true;

      if ($user['role'] == 'Student') {
        // Redirect the user to the home page or another protected resource
        header('Location: ../views/dashboard.php');
        exit;
      }

      if ($user['role'] == 'Admin') {
        // Redirect the user to the home page or another protected resource
        header('Location: ../views/admin/dashboard.php');
        exit;
      }
      
    } else {
      // If the user's credentials are invalid, display an error message
      $error_message = 'Invalid username or password.';
      header('Location: ../views/login.php?message=' . $error_message . '&type=danger');
      exit();
    }
  }
} else {
  // If the user has not submitted the login form, display the login view
  header('Location: ../views/login.php');
  exit();
}
