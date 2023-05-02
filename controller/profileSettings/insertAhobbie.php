<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');

include('../../auth/ensureAuthentication.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

// Check if hobbies array is present in the request data
if (empty($_POST['hobbies']) || !is_array($_POST['hobbies'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid or missing hobbies array';
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

$userID = $_SESSION['user_id'];
$hobbies = $_POST['hobbies'];

// Prepare a SQL statement to insert a new row into the user_hobbies table for each hobby ID
$stmt = $conn->prepare("INSERT INTO user_hobbies (user_id, hobby_id) VALUES (:user_id, :hobby_id)");

// Loop through the hobbies array and execute the statement for each hobby ID
foreach ($hobbies as $hobby_id) {
    // Bind the parameters to the statement
    $stmt->bindParam(':user_id', $userID);
    $stmt->bindParam(':hobby_id', $hobby_id);

    // Execute the statement to insert the new row
    $stmt->execute();
}

// Check if any rows were inserted successfully
if ($stmt->rowCount() > 0) {
    echo "New rows inserted into user_hobbies table.";
} else {
    echo "Failed to insert new rows into user_hobbies table.";
}

exit;
