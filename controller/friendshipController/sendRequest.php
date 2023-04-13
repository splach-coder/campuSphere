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

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// get the friend's user ID from the requests
$friend_id = $_POST['friend_id'];

// check if the friend request has already been sent
$query = "SELECT count(*) FROM friend_requests WHERE requester_id = :requester_id AND recipient_id = :recipient_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':requester_id', $_SESSION['user_id']);
$stmt->bindParam(':recipient_id', $friend_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "You have already sent a friend request to this user.";
} else {
    // insert the friend request into the database
    $query = "INSERT INTO friend_requests (requester_id, recipient_id) VALUES (:requester_id, :recipient_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':requester_id', $_SESSION['user_id']);
    $stmt->bindParam(':recipient_id', $friend_id);
    $result = $stmt->execute();

    if ($result) {
        echo "Friend request sent successfully.";
    } else {
        echo "Error sending friend request: " . $stmt->errorInfo()[2];
    }
}
