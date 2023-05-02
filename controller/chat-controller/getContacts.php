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

$sql = "SELECT m.id, m.message, m.created_at, m.sender_id,
concat(CASE WHEN m.sender_id = '$userID' 
    THEN CONCAT(p.first_name, ' ', p.last_name) 
    ELSE CONCAT(p2.first_name, ' ', p2.last_name) END) as 'fullname', p.profile_pic,
concat(CASE WHEN m.sender_id = '$userID' 
    THEN u.id_user
    ELSE u2.id_user END) as 'contactID'
FROM messages AS m 
INNER JOIN users AS u ON u.id_user = m.receiver_id
INNER JOIN users AS u2 ON u2.id_user = m.sender_id
INNER JOIN profile AS p ON p.id_user = u.id_user
INNER JOIN profile AS p2 ON p2.id_user = u2.id_user
WHERE m.id IN 
(
SELECT MAX(CAST(id AS int)) 
FROM messages 
WHERE receiver_id = '$userID' OR sender_id = '$userID' 
GROUP BY CASE WHEN sender_id = '$userID' THEN
receiver_id ELSE sender_id END ) 
ORDER BY id DESC;
";

$stmt = $conn->query($sql);
$contacts = $stmt->fetchAll();

$ctcs = array();

foreach ($contacts as $ctc) {

    $beforeMessage = ($ctc['sender_id'] == $userID) ? "YOU : " : "";
    $online = (userStatus($conn, $ctc['contactID']) == 'online') ? true : false;

    $c = array(
        'id' => $ctc['id'],
        'message' => slice_status($beforeMessage . $ctc['message'], "non", 4, ""),
        'date' => $ctc['created_at'],
        'contact' => $ctc['contactID'],
        'image' => '../public/images/' . $ctc['profile_pic'],
        'fullname' => $ctc['fullname'],
        'online' => $online
    );

    array_push($ctcs, $c);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_ctcs = json_encode($ctcs);

// Send the JSON response to JavaScript
echo $json_ctcs;
