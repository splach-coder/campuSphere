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

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

if (!isset($_GET['id']) && empty($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

$commentID = $_GET['id'];

$sql = "SELECT
u1.id_user,
r.reply_id,
u1.user_name,
p1.profile_pic,
r.reply_content,
r.reply_date
FROM
users u1
JOIN comments_replies r ON u1.id_user = r.user_id
JOIN profile p1 ON u1.id_user = p1.id_user
WHERE r.comment_id = '$commentID' ORDER BY r.reply_date DESC";

$stmt = $conn->query($sql);
$comments = $stmt->fetchAll();

$comments_arr = array();

foreach ($comments as $post) {
    $p = array(
        'user_id' => $post['id_user'],
        'id' => $post['reply_id'],
        'user_name' => $post['user_name'],
        'user_image' => '../public/images/' . $post['profile_pic'],
        'content' => $post['reply_content'],
        'date' => instagram_time($post['reply_date'])
    );

    array_push($comments_arr, $p);
};

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_posts = json_encode($comments_arr);

// Send the JSON response to JavaScript
echo $json_posts;
