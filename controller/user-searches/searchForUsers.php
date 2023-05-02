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
if (empty($_POST['query'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'friend_id field is required';
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

$userID = $_SESSION['user_id'];
$query = $_POST['query'];

$sql = "SELECT results.id_user,
CASE WHEN results.id_user = '$userID' THEN 'YOU' ELSE
     CASE WHEN results.is_friend = 1 THEN 'friend' ELSE 'user' END
END AS relation,
CONCAT(p.first_name, ' ', p.last_name) AS full_name,
p.profile_pic AS profile_picture
FROM (
SELECT u.* , CASE WHEN f.user_id IS NULL THEN 0 ELSE 1 END AS is_friend
FROM users u
LEFT JOIN friends f ON f.friend_id = u.id_user AND f.user_id ='$userID'
WHERE u.user_name LIKE '%$query%'
) results
INNER JOIN profile p ON p.id_user = results.id_user
ORDER BY CASE WHEN results.id_user = '$userID' THEN 0 ELSE
     CASE WHEN results.is_friend = 1 THEN 1 ELSE 2 END
END, results.user_name ASC LIMIT 5;";

$stmt = $conn->query($sql);
$searches = $stmt->fetchAll();

$results = array();

foreach ($searches as $search) {
    $m = array(
        'id' => $search['id_user'],
        'fullname' => $search['full_name'],
        'image' => '../public/images/' . $search['profile_picture'],
        'relation' => $search['relation']
    );

    array_push($results, $m);
}


header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_results = json_encode($results);

// Send the JSON response to JavaScript
echo $json_results;
