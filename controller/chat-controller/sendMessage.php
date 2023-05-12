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

// Check if status field is empty
if (empty($_POST['friend_id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'friend_id field is required';
    exit;
}

// Check if status field is empty
if (empty($_POST['message'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'message field is required';
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// get the friend's user ID from the requests
$friend_id = $_POST['friend_id'];
$message = $_POST['message'];

// insert the message into the database
$query = "INSERT INTO `messages`(`sender_id`, `receiver_id`, `message`) VALUES (:sender_id, :receiver_id, :message)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':sender_id', $_SESSION['user_id']);
$stmt->bindParam(':receiver_id', $friend_id);
$stmt->bindParam(':message', $message);
$result = $stmt->execute();

if ($result) {
    echo 'message sent';
} else {
    echo "Error sending message: " . $stmt->errorInfo()[2];
}
