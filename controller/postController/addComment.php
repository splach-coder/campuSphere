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

// Check if comment field is empty
if (empty($_POST['comment'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Comment field is required';
    exit;
}

// Check if post id field is empty
if (empty($_POST['postId'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}

// get neccessary data
$userID = $_SESSION['user_id'];
$comment = $_POST['comment'];
$postID = $_POST['postId'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// save comment in database
$sql = "INSERT INTO `post_comments` (`post_id`, `user_id`, `content`) VALUES (?,?,?);";
$conn->prepare($sql)->execute([$postID, $userID, $comment]);

// update post like in database
$sql = "UPDATE `posts` SET `comments_number`= `comments_number` + 1 WHERE `post_id`= ?";
$conn->prepare($sql)->execute([$postID]);

sendPostInteraction($conn, $userID, $postID, 'comment');

$numLikes = fetchSingleValue("SELECT comments_number FROM `posts` WHERE  `post_id`=  '$postID' LIMIT 1", $conn);

echo $numLikes;
exit;
