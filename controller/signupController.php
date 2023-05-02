<?php

//start the session
session_start();

// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../helpers/functions.php');

// The main function that handles the login process
// Check if the user has submitted the login form

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('HTTP/1.1 405 Method Not Allowed');
  echo 'Invalid request method';
  exit;
}

// Store the form data in the session
$_SESSION["form_data"] = $_POST;

// Check if status field is empty
if (empty($_POST['username'])) {
  // If the user has not submitted the login form, display the login view
  $error_message = 'Invalid username or password.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// Check if status field is empty
if (empty($_POST['lastname'])) {
  // If the user has not submitted the login form, display the login view
  $error_message = 'Invalid lastname or password.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// Check if status field is empty
if (empty($_POST['lastname'])) {
  // If the user has not submitted the login form, display the login view
  $error_message = 'Invalid lastname or password.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// Check if status field is empty
if (empty($_POST['email'])) {
  // If the user has not submitted the login form, display the login view
  $error_message = 'Invalid email or password.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// Check if status field is empty
if (empty($_POST['password'])) {
  // If the user has not submitted the login form, display the login view
  $error_message = 'Invalid password or password.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// sanitize user inputs
function sanitize_input($input)
{
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

// retrieve user inputs
$username = sanitize_input($_POST['username']);
$firstname = sanitize_input($_POST['firstname']);
$lastname = sanitize_input($_POST['lastname']);
$email = sanitize_input($_POST['email']);
$password = sanitize_input($_POST['password']);
$repassword = sanitize_input($_POST['password']);


// validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || substr($email, -10) != '@upm.ac.ma') {
  $error_message = 'Invalid email format. Please enter a valid UPM email address.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// validate password format
if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
  $error_message = 'Invalid password format. Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// validate username format
if (!preg_match("/^[a-zA-Z0-9_.]+$/", $username)) {
  $error_message = 'Invalid username format.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

if (userExists($conn, 'user_name', $username)) {
  $error_message = 'User with username ' . $username . ' already exists.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

if (userExists($conn, 'email', $email)) {
  $error_message = 'User with email ' . $email . ' already exists.';
  header('Location: ../views/signup.php?message=' . $error_message . '&type=danger');
  exit();
}

if (compareStrings($password, $repassword)) {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $user_id = $_SESSION['user_id'];

  $sql = 'INSERT INTO `users`(`user_name`, `email`, `password`) VALUES (?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->execute([$username, $email, $hashed_password]);

  // Select the UUID value of the last inserted row
  $sql = "SELECT `id_user` FROM `users` WHERE user_name = '$username' ORDER by created_at desc limit 1";
  $stmt = $conn->query($sql);
  $userID = $stmt->fetchColumn();

  $sql = 'INSERT INTO `profile`(`first_name`, `last_name`, `id_user`) VALUES (?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->execute([$firstname, $lastname, $userID]);

  $success_message = 'Log in with please';
  header('Location: ../views/login.php?message=' . $success_message . '&type=success');
  exit();
} else {
  header('Location: ../views/reset-password/reset-pass-form.php?message=The passwords you entered do not match. Please try again.&type=danger');
  exit();
}
