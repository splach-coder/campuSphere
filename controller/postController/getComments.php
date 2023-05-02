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

$postID = $_GET['id'];

$sql = "SELECT
u1.id_user,
pc.id,
u1.user_name,
p1.profile_pic,
pc.content,    
pc.created_at,
pc.replies,
pc.likes
FROM
users u1
JOIN post_comments pc ON u1.id_user = pc.user_id
JOIN profile p1 ON u1.id_user = p1.id_user
WHERE pc.post_id = '$postID' ORDER BY pc.created_at DESC";

$stmt = $conn->query($sql);
$comments = $stmt->fetchAll();

$comments_arr = array();

foreach ($comments as $post) {
    $p = array(
        'user_id' => $post['id_user'],
        'id' => $post['id'],
        'user_name' => $post['user_name'],
        'user_image' => '../public/images/' . $post['profile_pic'],
        'content' => $post['content'],
        'replies' => $post['replies'],
        'likes' => $post['likes'],
        'date' => instagram_time($post['created_at'])
    );
    
    array_push($comments_arr, $p);
};

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_posts = json_encode($comments_arr);

// Send the JSON response to JavaScript
echo $json_posts;
