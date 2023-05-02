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
if (empty($_POST['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'friend_id field is required';
    exit;
}


// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// get the friend's user ID from the requests
$id = $_POST['id'];

// insert the message into the database
$query = "DELETE FROM `recent_searches` WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$result = $stmt->execute();

if ($result) {
    echo "query deleted successfully.";
} else {
    echo "Error sending message: " . $stmt->errorInfo()[2];
}
