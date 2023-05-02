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
if (empty($_POST['id']) && !isset($_POST['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'comment ID field is required';
    exit;
}

// get neccessary data
$userID = $_SESSION['user_id'];
$commentID = $_POST['id'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// save like in database
$sql = "DELETE FROM `comments_likes` WHERE `comment_id` = ? AND `user_id` = ? ;";
$conn->prepare($sql)->execute([$commentID, $userID]);

// update post like in database
$sql = "UPDATE `post_comments` SET `likes`= `likes` - 1 WHERE `id`= ?";
$conn->prepare($sql)->execute([$commentID]);

$numLikes = fetchSingleValue("SELECT likes FROM `post_comments` WHERE `id`= '$commentID' LIMIT 1", $conn);

echo $numLikes;
exit;
