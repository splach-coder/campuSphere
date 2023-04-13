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

$sql = "SELECT `id`, `requester_id`, concat(p.first_name, ' ', p.last_name) as 'fullname' , p.profile_pic FROM `friend_requests` AS fr
        INNER JOIN `users` AS u ON u.id_user = fr.requester_id
        INNER JOIN `profile` AS p ON p.id_user = u.id_user
        WHERE `status` = 'pending' 
        AND `recipient_id` = '$userID' 
        ORDER BY `requested_at` DESC;";

$stmt = $conn->query($sql);
$reqs = $stmt->fetchAll();

$requests = array();

foreach ($reqs as $req) {
    $p = array(
        'id' => $req['id'],
        'requester' => $req['requester_id'],
        'fullname' => $req['fullname'],
        'user_image' => '../public/images/' . $req['profile_pic'],
    );

    array_push($requests, $p);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_reqs = json_encode($requests);

// Send the JSON response to JavaScript
echo $json_reqs;
