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

$sql = "SELECT `ID_notification`, `Texte_notification`, `Date_notification`
        FROM `notifications` 
        WHERE `Statut_notification` = 'unseen'
        ORDER BY `Date_notification` DESC";

$stmt = $conn->query($sql);
$notifications = $stmt->fetchAll();

$notes = array();

foreach ($notifications as $not) {
    $n = array(
        'id' => $not['ID_notification'],
        'text' => $not['Texte_notification'],
        'date' => instagram_time($not['Date_notification'])
    );

    array_push($notes, $n);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_nots = json_encode($notes);

// Send the JSON response to JavaScript
echo $json_nots;
