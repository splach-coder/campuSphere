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


$sql = "SELECT `id`, `search_input` FROM `recent_searches` 
WHERE `user_id` = '$userID'
ORDER BY  `created_at` DESC LIMIT 5;";

$stmt = $conn->query($sql);
$searches = $stmt->fetchAll();

$results = array();

foreach ($searches as $search) {
    $m = array(
        'id' => $search['id'],
        'text' => $search['search_input'],
    );

    array_push($results, $m);
}


header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_results = json_encode($results);

// Send the JSON response to JavaScript
echo $json_results;
