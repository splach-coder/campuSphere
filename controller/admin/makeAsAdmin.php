<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');
require_once('../../helpers/functions.php');

include('../../auth/ensureAuthentication.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

if (!isset($_POST['id']) && empty($_POST['id'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'if field needed';
    exit;
}

$userID = $_POST['id'];

$sql = "UPDATE `users` SET `role`= 'Admin' WHERE `id_user` = ?";
$conn->prepare($sql)->execute([$userID]);


echo 'user role changed';
