<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');
require_once('../../helpers/functions.php');

include('../../auth/ensureAuthentication.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

// Check if status field is empty
if (empty($_GET['request_id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'friend_id field is required';
    exit;
}

// Check if status field is empty
if (empty($_GET['action'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'action field is required';
    exit;
}

// get the friend request ID and action from the POST data
$request_id = $_GET['request_id'];
$action = $_GET['action'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

if ($action == 'accept') {
    try {
        // add the friend to the user's friend list
        $query = "INSERT INTO friends (user_id, friend_id) SELECT recipient_id, requester_id FROM friend_requests WHERE id = :request_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':request_id', $request_id);
        $stmt->execute();

        // delete the friend request from the database
        $query = "DELETE FROM friend_requests WHERE id = :request_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':request_id', $request_id);
        $stmt->execute();

        echo "Friend request accepted.";
    } catch (PDOException $e) {
        echo "Error accepting friend request: " . $e->getMessage();
    }
} elseif ($action == 'decline') {
    try {
        // delete the friend request from the database
        $query = "DELETE FROM friend_requests WHERE id = :request_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':request_id', $request_id);
        $stmt->execute();

        echo "Friend request declined.";
    } catch (PDOException $e) {
        echo "Error declining friend request: " . $e->getMessage();
    }
} else {
    echo "Invalid action specified.";
}
