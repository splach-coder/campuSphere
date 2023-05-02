<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');

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

$sql = "SELECT *
FROM user_hobbies
JOIN hobbies ON user_hobbies.hobby_id = hobbies.id
WHERE user_hobbies.user_id = '$userID';";

$stmt = $conn->query($sql);
$hobbies = $stmt->fetchAll();

$hobbies_arr = array();

foreach ($hobbies as $hobbie) {
    $p = array(
        'id' => $hobbie['id'],
        'name' => $hobbie['name'],
        'icon' => $hobbie['icon']
    );

    array_push($hobbies_arr, $p);
};

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_hobbies = json_encode($hobbies_arr);

// Send the JSON response to JavaScript
echo $json_hobbies;
