<?php

// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../helpers/functions.php');

include('../auth/ensureAuthentication.php');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Invalid request method';
    exit;
}

$user_id = (empty($_GET['id'])) ? $_SESSION['user_id'] : $_GET['id'];

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

// insert the message into the database
$query = "SELECT u.id_user, concat(p.first_name, ' ', p.last_name) as 'fullname', p.profile_pic, p.bio, cover
          FROM users as u
          inner join profile as p on u.id_user = p.id_user
          WHERE u.id_user = '$user_id' LIMIT 1;";

$stmt = $conn->query($query);
$user = $stmt->fetch();

$users = array(
    'id' => $user['id_user'],
    'fullname' => $user['fullname'],
    'image' => '../public/images/' . $user['profile_pic'],
    'cover' => '../public/images/' . $user['cover'],
    'bio' => $user['bio'],
    'friendsNumber' => '0',
    'friends' => array(),
    'images' => array(),
);

$query = "SELECT count(*) FROM users u
        INNER JOIN friends f ON u.id_user = f.friend_id OR u.id_user = f.user_id
        WHERE (f.user_id = '$user_id' OR f.friend_id = '$user_id')
        AND u.id_user != '$user_id';";

$users['friendsNumber'] = fetchSingleValue($query, $conn);

// insert the message into the database
$query = "SELECT  u.id_user, p.profile_pic, concat(p.first_name, ' ', p.last_name) as 'fullname'
          FROM users u
          INNER JOIN friends f ON u.id_user = f.friend_id OR u.id_user = f.user_id
          INNER JOIN profile p ON p.id_user = u.id_user
          WHERE (f.user_id = '$user_id' OR f.friend_id = '$user_id')
          AND u.id_user != '$user_id' LIMIT 9;";

$stmt = $conn->query($query);
$friends = $stmt->fetchAll();

foreach ($friends as $friend) {
    $p = array(
        'id' => $friend['id_user'],
        'fullname' => $friend['fullname'],
        'image' => '../public/images/' . $friend['profile_pic']
    );

    array_push($users['friends'], $p);
}

$query = "SELECT pm.id, pm.media_url FROM `posts` p
        INNER JOIN post_media pm ON p.post_id = pm.post_id
        INNER JOIN users u ON p.user_id = u.id_user
        WHERE u.id_user = '$user_id' AND pm.type = 'image' LIMIT 9;";

$stmt = $conn->query($query);
$images = $stmt->fetchAll();

foreach ($images as $img) {
    $p = array(
        'id' => $img['id'],
        'url' => '../public/images/posts/' . $img['media_url']
    );

    array_push($users['images'], $p);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_user = json_encode($users);

// Send the JSON response to JavaScript
echo $json_user;
