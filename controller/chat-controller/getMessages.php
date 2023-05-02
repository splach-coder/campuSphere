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

// Check if status field is empty
if (empty($_POST['friend_id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'friend_id field is required';
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

$userID = $_SESSION['user_id'];
$friendID = $_POST['friend_id'];

$sql = "SELECT u.id_user, CONCAT(p.first_name, ' ', p.last_name) as 'fullname', p.profile_pic
FROM users AS u
INNER JOIN profile AS p ON u.id_user = p.id_user
WHERE u.id_user = '$friendID' LIMIT 1;";

$stmt = $conn->query($sql);
$user = $stmt->fetch();


$mesgs = array(
    'id' => $user['id_user'],
    'fullname' => $user['fullname'],
    'image' => '../public/images/' . $user['profile_pic'],
    'lastSeen' => userStatus($conn, $user['id_user']),
    'chat' => array(),
);

$sql = "SELECT id, message, created_at, sender_id
FROM messages
WHERE (sender_id = '$userID' AND receiver_id = '$friendID')
   OR (sender_id = '$friendID' AND receiver_id = '$userID')
ORDER BY created_at ASC;";

$stmt = $conn->query($sql);
$messages = $stmt->fetchAll();

foreach ($messages as $msg) {
    $sender = ($msg['sender_id'] == $userID) ? 'parker' : 'stark';
    $m = array(
        'id' => $msg['id'],
        'message' => $msg['message'],
        'date' => $msg['created_at'],
        'sender' => $sender
    );

    array_push($mesgs['chat'], $m);
}


header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_msgs = json_encode($mesgs);

// Send the JSON response to JavaScript
echo $json_msgs;
