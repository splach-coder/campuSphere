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

$userID = $_GET['id'];
$currentuserID = $_SESSION['user_id'];

$sql = "SELECT p.post_id, p.user_id, u.user_name, pr.profile_pic, p.status, p.user_audience, p.has_media, p.comments_number, p.likes_number, p.views_number, p.shares_number, p.saves_number, p.created_at FROM `posts` AS p
INNER JOIN `users` AS u ON u.id_user = p.user_id
INNER JOIN `profile` AS pr ON pr.id_user = u.id_user
WHERE u.id_user = '$userID' ORDER BY p.created_at DESC;";

$stmt = $conn->query($sql);
$posts = $stmt->fetchAll();

$posts_arr = array();

foreach ($posts as $post) {
    $pass = 'pass';

    if ($post['has_media'] == "true") {
        $pass = "non";
    }

    $postID = $post['post_id'];

    $query = "SELECT count(*) FROM `post_likes` AS pl
    WHERE pl.user_id = '$currentuserID' 
    AND pl.post_id = '$postID' LIMIT 1";

    $liked = fetchSingleValue($query, $conn);

    $likedByUser = ($liked == 1) ? true : false;

    $p = array(
        'post_id' => $postID,
        'user_id' => $post['user_id'],
        'user_name' => $post['user_name'],
        'user_image' => '../public/images/' . $post['profile_pic'],
        'status' => slice_status($post['status'], $pass, 8),
        'user_audience' => $post['user_audience'],
        'date' => instagram_time($post['created_at']),
        'likes_number' => $post['likes_number'],
        'comments_number' => $post['comments_number'],
        'views_number' => $post['views_number'],
        'shares_number' => $post['shares_number'],
        'saves_number' => $post['saves_number'],
        'has_media' => $post['has_media'],
        'likedByUser' => $likedByUser,
        'post_media' => array()
    );

    array_push($posts_arr, $p);
};

foreach ($posts_arr as &$post) {
    $stmt = $conn->prepare("SELECT `id`, `post_id`, `media_url`, `type`, `created_at` FROM `post_media` WHERE `post_id` = :id");
    $stmt->execute(['id' => $post['post_id']]);
    $data = $stmt->fetchAll();

    // and somewhere later:
    foreach ($data as $row) {
        $new_item = array(
            'id' => $row['id'],
            'media_url' => '../public/images/posts/' . $row['media_url'],
            'type' => $row['type'],
        );

        array_push($post['post_media'], $new_item);
    }
};


header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_posts = json_encode($posts_arr);

// Send the JSON response to JavaScript
echo $json_posts;
