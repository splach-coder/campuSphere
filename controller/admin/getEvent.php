<?php

// Import the DB class to handle database connections
require_once('../../config/db.php');
require_once('../../helpers/functions.php');

require_once('../../auth/ensureAuthentication.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Use PDO to query the database for a user with the provided credentials
    $db = new db();
    $conn = $db->getConnection();

    $id = $_GET['id'];

    $sql = "SELECT * FROM `events` WHERE `id` = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    header('Content-Type: application/json');

    // Convert the $event array to a JSON string using json_encode and send it
    echo json_encode($event);
}
