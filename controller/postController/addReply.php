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

// Check if commentid field is empty
if (empty($_POST['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Comment field is required';
    exit;
}

// Check if comment field is empty
if (empty($_POST['comment'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Comment field is required';
    exit;
}


// Get the comment ID and reply content from the POST request
$comment_id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$reply_content = $_POST['comment'];


// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();


// Insert the new reply into the replies table
$sql = "INSERT INTO comments_replies (comment_id, user_id, reply_content) 
        VALUES (:comment_id, :user_id, :reply_content)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':comment_id', $comment_id);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':reply_content', $reply_content);

if ($stmt->execute()) {
    // Update the number of replies for the comment in the comments table
    $sql = "UPDATE `post_comments` SET `replies`= `replies` + 1 WHERE id = :comment_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':comment_id', $comment_id);
    $stmt->execute();

    $numReplies = fetchSingleValue("SELECT count(*) FROM comments_replies WHERE comment_id = '$comment_id' LIMIT 1", $conn);
    echo $numReplies;
} else {
    // Display an error message if the reply couldn't be added
    echo "Error: " . $sql . "<br>" . $stmt->errorInfo()[2];
}
