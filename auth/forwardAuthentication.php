<?php
  //start the session
  session_start();
  
  $currentUrl = $_SERVER['REQUEST_URI'];
  $url = '';
  
  if (strpos($currentUrl, 'reset-password') !== false) {
    // the string 'reset-password' was found in the URL
    $url.='../';
  }
  
  
  require_once($url.'../config/db.php');
  require_once($url.'../helpers/functions.php');

  // Use PDO to query the database for a user with the provided credentials
  $db = new db();
  $conn = $db->getConnection();

  remember_me($conn);
  checkLogin();
?>
