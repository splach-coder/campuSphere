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
if (empty($_POST['bio'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}

// get neccessary data
$userID = $_SESSION['user_id'];
$bio = $_POST['bio'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// save like in database
$sql = "UPDATE `profile` SET `bio` = ? WHERE `id_user`= ?";
$conn->prepare($sql)->execute([$bio, $userID]);

echo 'updated';
exit;
