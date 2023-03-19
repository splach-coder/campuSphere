<?php
  //start the session
  session_start();

  require_once('../config/db.php');
  require_once('../helpers/functions.php');

  // Use PDO to query the database for a user with the provided credentials
  $db = new db();
  $conn = $db->getConnection();

  remember_me($conn);
  checkLogin();
?>
