<?php
  //start the session
  session_start();

  if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != true){
    // Redirect the user to the home page or another protected resource
    header('Location: ../views/login.php?message=To access this view, please log in to your account.&type=warning');
    exit;
  }
?>
