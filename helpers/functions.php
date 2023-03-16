<?php

function sanitizeInput($input) {
    $clean_input = filter_var($input, FILTER_SANITIZE_STRING);
    $clean_input = trim($clean_input);
    $clean_input = stripslashes($clean_input);
    $clean_input = htmlentities($clean_input, ENT_QUOTES, 'UTF-8');
    $clean_input = str_replace(array("\n", "\r", "\t"), '', $clean_input);
 
    return $clean_input;
}


function checkLogin(){
  
}


function remember_me($conn){
  // Verify the token when the user visits the site
  if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $sql = "SELECT `id_user`, `user_name`, `role` FROM `users` WHERE `token` = ? AND `expiration` > NOW();";
    $user = $conn->prepare($sql)->execute([$token]);
    
    if ($user) {
        // Log the user in automatically
        // Store the user's session information
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['user_name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['loggedIn'] = true;

        // Redirect the user to the home page or another protected resource
        header('Location: ../views/dashboard.php');
        exit;
    }else{

      //remove the cookie from the browser
      setcookie('remember_token', '', time() - 3600, '/');
    }
  }
}
  
