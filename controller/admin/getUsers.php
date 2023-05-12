<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');
require_once('../../helpers/functions.php');

require_once('../../auth/ensureAuthentication.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Use PDO to query the database for a user with the provided credentials
    $db = new db();
    $conn = $db->getConnection();

    $userID = $_SESSION['user_id'];

    $sql = "SELECT u.`id_user`,`user_name`, concat(`first_name`, ' ', `last_name`) AS fullname, `email`, `role`, `created_at`, `lastSeen`, profile_pic
    FROM `users` u
    INNER JOIN `profile` AS p ON u.id_user = p.id_user
    WHERE `role` = 'Student' 
    ORDER BY u.`created_at` DESC;";

    $stmt = $conn->query($sql);
    $users = $stmt->fetchAll();

    header('Content-Type: application/json');

    // Convert the $stories array to a JSON string using json_encode
    $json_users = json_encode($users);

    // Send the JSON response to JavaScript
    echo $json_users;
}
