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

// Check if post id field is empty
if (empty($_POST['postId']) && !isset($_POST['postId'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Post ID field is required';
    exit;
}

// get neccessary data
$userID = $_SESSION['user_id'];
$postID = $_POST['postId'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// save like in database
$sql = "DELETE FROM `post_likes` WHERE `post_id` = ? AND `user_id` = ? ;";
$conn->prepare($sql)->execute([$postID, $userID]);

// update post like in database
$sql = "UPDATE `posts` SET `likes_number`= `likes_number` - 1 WHERE `post_id`= ?";
$conn->prepare($sql)->execute([$postID]);

$numLikes = fetchSingleValue("SELECT likes_number FROM `posts` WHERE  `post_id`= '$postID' LIMIT 1", $conn);

echo $numLikes;
exit;
