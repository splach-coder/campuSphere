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

$userID = $_SESSION['user_id'];

$sql = "SELECT DISTINCT p.post_id, p.user_id, u.user_name, pr.profile_pic, p.status, p.user_audience, p.comments_number, p.views_number, p.shares_number, p.saves_number, p.    created_at
        FROM posts_interactions AS pi1
        INNER JOIN posts_interactions AS pi2 ON pi1.post_id = pi2.post_id
        INNER JOIN posts AS p ON pi2.post_id = p.post_id
        INNER JOIN users AS u ON u.id_user = p.user_id
        INNER JOIN profile AS pr ON u.id_user = pr.id_user 
        WHERE pi1.user_id = '$userID'
        AND pi1.interaction_type IN ('like', 'view', 'comment', 'share', 'save') 
        AND pi2.interaction_type IN ('like', 'view', 'comment', 'share', 'save') 
        AND pi1.user_id != pi2.user_id
        GROUP BY p.post_id
        HAVING COUNT(DISTINCT pi2.interaction_type) >= 2
        ORDER BY RAND();";

$stmt = $conn->query($sql);
$posts = $stmt->fetchAll();

$posts_arr = array();

foreach ($posts as $post) {
    $p = array(
        'post_id' => $post['post_id'],
        'user_id' => $post['user_id'],
        'user_name' => $post['user_name'],
        'user_image' => '../public/images/' . $post['profile_pic'],
        'status' => $post['status'],
        'user_audience' => $post['user_audience'],
        'created_at' => $post['created_at'],
        'comments_number' => $post['comments_number'],
        'views_number' => $post['views_number'],
        'shares_number' => $post['shares_number'],
        'saves_number' => $post['saves_number'],
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
            'media_url' => $row['media_url'],
            'type' => $row['type'],
        );

        array_push($posts_arr['post_media'], $new_item);
    }
};


header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_posts = json_encode($posts_arr);

// Send the JSON response to JavaScript
echo $json_posts;
