<?php

// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../helpers/functions.php');

include('../auth/ensureAuthentication.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

// Check if post id field is empty
if (empty($_POST['firstname'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}

// Check if post id field is empty
if (empty($_POST['lastname'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}

// Check if post id field is empty
if (empty($_POST['username'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}


// get neccessary data
$userID = $_SESSION['user_id'];

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

// validate username format
if (!preg_match("/^[a-zA-Z0-9_.]+$/", $username)) {
    $error_message = 'Invalid username format.';
    echo $error_message;
    exit();
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

if (userExists($conn, 'user_name', $username)) {
    $error_message = 'User with username ' . $username . ' already exists.';
    echo $error_message;
    exit();
}

// save like in database
$sql = "UPDATE `profile` SET `first_name` = ?, `last_name` = ? WHERE `id_user`= ?";
$conn->prepare($sql)->execute([$firstname, $lastname, $userID]);

// save like in database
$sql = "UPDATE `users` SET `user_name` = ? WHERE `id_user`= ?";
$conn->prepare($sql)->execute([$username, $userID]);

echo 'updated';
exit;
