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
if (empty($_POST['status']) && empty($_FILES['media'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

$media = isset($_FILES['media']) ? $_FILES['media'] : 'undefined';

$filesArray = ($media != 'undefined') ? convertArrayToObject($media) : $media;

// Validate post data
$postValidator = new PostValidator($_POST['status'], $filesArray, $_POST['audience']);

if ($postValidator->validate() !== true) {
    // Validation failed, return errors
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('errors' => $postValidator->validate()));
    exit;
}

// Set upload directory
$uploadDir = '../../public/images/posts/';

// Loop through uploaded files
$uploadedFiles = array();

if ($media != 'undefined') {
    foreach ($_FILES['media']['name'] as $key => $name) {
        // Check if file was uploaded without errors
        if ($_FILES['media']['error'][$key] !== UPLOAD_ERR_OK) {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Failed to upload file: ' . $name;
            exit;
        }

        // Check file type
        $allowedTypes = array('image/png', 'image/jpeg', 'image/gif', 'video/mp4');
        if (!in_array($_FILES['media']['type'][$key], $allowedTypes)) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Invalid file type: ' . $name;
            exit;
        }

        // Check file size
        $maxImageSize = 2 * 1024 * 1024; // 2MB
        $maxVideoSize = 5 * 1024 * 1024; // 5MB
        if ($_FILES['media']['type'][$key] == 'video/mp4' && $_FILES['media']['size'][$key] > $maxVideoSize) {
            header('HTTP/1.1 400 Bad Request');
            echo 'File size exceeds limit: ' . $name;
            exit;
        } elseif (in_array($_FILES['media']['type'][$key], array_slice($allowedTypes, 0, 3)) && $_FILES['media']['size'][$key] > $maxImageSize) {
            header('HTTP/1.1 400 Bad Request');
            echo 'File size exceeds limit: ' . $name;
            exit;
        }

        // Generate unique file name
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $extension;
        $targetFile = $uploadDir . $fileName;

        // Save file to upload directory
        if (!move_uploaded_file($_FILES['media']['tmp_name'][$key], $targetFile)) {
            header('HTTP/1.1 500 Internal Server Error');
            echo 'Failed to upload file: ' . $name;
            exit;
        }

        // Add uploaded file name and type to array
        $fileType =  (strpos($_FILES['media']['type'][$key], 'image') !== false ? 'image' : 'video');

        // Add uploaded file to array
        $uploadedFiles[] = array('name' => $fileName, 'type' => $fileType);

    }
}

// Save post data to database
$status = isset($_POST['status']) ? $_POST['status'] : '';
$audience = $_POST['audience'];

//$media = implode(',', $uploadedFiles);

$userID = $_SESSION['user_id'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// TODO: Save post data to database
// save file location in database
$sql = "INSERT INTO `posts`(`user_id`, `status`, `user_audience`) VALUES (?,?,?);";
$conn->prepare($sql)->execute([$userID,  $status, $audience]);

// Select the UUID value of the last inserted row
$sql = "SELECT `post_id` FROM `posts` WHERE `post_id` = LAST_INSERT_ID();";
$stmt = $conn->query($sql);
$postID = $stmt->fetchColumn();

if (!empty($uploadedFiles)) {
    foreach ($uploadedFiles as $file) {
      $fileName = $file['name'];
      $fileType = $file['type'];
      $sql = "INSERT INTO `post_media`(`post_id`, `media_url`, `type`) VALUES (?, ?, ?)";
      $conn->prepare($sql)->execute([$postID, $fileName, $fileType]);
    }
}

echo 'File uploaded successfully';
exit;

function convertArrayToObject($array)
{
    $objectArray = array();
    for ($i = 0; $i < count($array['name']); $i++) {
        $object = new stdClass();
        $object->name = $array['name'][$i];
        $object->full_path = $array['full_path'][$i];
        $object->type = $array['type'][$i];
        $object->tmp_name = $array['tmp_name'][$i];
        $object->error = $array['error'][$i];
        $object->size = $array['size'][$i];
        array_push($objectArray, $object);
    }
    return $objectArray;
}
