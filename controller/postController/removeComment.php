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
if (empty($_POST['commentID']) && !isset($_POST['commentID'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Comment field is required';
    exit;
}

// Check if post id field is empty
if (empty($_POST['postId']) && !isset($_POST['postId'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}

// get neccessary data
$userID = $_SESSION['user_id'];
$commentID = $_POST['commentId'];
$postID = $_POST['postId'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// save comment in database
$sql = "DELETE FROM `post_comments` WHERE id = ? AND post_id = ? AND `user_id` = ?";
$conn->prepare($sql)->execute([$commentID, $postID, $userID]);

// update post like in database
$sql = "UPDATE `posts` SET `comments_number`= `comments_number` - 1 WHERE `post_id`= ?";
$conn->prepare($sql)->execute([$postID]);

$numLikes = fetchSingleValue("SELECT likes_number FROM `posts` WHERE  `post_id`= '$postID' LIMIT 1", $conn);

echo $numLikes;
exit;
