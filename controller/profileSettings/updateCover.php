<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');
require_once('../../helpers/functions.php');

include('../../auth/ensureAuthentication.php');
require_once('../../validators/postValidator.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

// Check if status field is empty
if (empty($_FILES['file'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

// Set upload directory
$uploadDir = '../../public/images/';

$name = $_FILES['file']['name'];

// Check if file was uploaded without errors
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Failed to upload file: ' . $name;
    exit;
}

// Check file type
$allowedTypes = array('image/png', 'image/jpeg', 'image/gif');
if (!in_array($_FILES['file']['type'], $allowedTypes)) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid file type: ' . $name;
    exit;
}

// Check file size
$maxImageSize = 2 * 1024 * 1024; // 2MB

if (
    in_array($_FILES['file']['type'], array_slice($allowedTypes, 0, 3))
    && $_FILES['file']['size'] > $maxImageSize
) {
    header('HTTP/1.1 400 Bad Request');
    echo 'File size exceeds limit: ' . $name;
    exit;
}

// Generate unique file name
$extension = pathinfo($name, PATHINFO_EXTENSION);
$fileName = uniqid() . '.' . $extension;
$targetFile = $uploadDir . $fileName;

// Save file to upload directory
if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Failed to upload file: ' . $name;
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// get neccessary data
$userID = $_SESSION['user_id'];

$query = "UPDATE `profile` SET `cover`=? WHERE id_user = ?";
$conn->prepare($query)->execute([$fileName, $userID]);


echo $fileName;
exit();
