<?php

// Import the DB class to handle database connections
require_once('../config/db.php');
require_once('../helpers/functions.php');

include('../auth/ensureAuthentication.php');

$db = new db();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM events ORDER BY id DESC;"); // Change the table name as per your database
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

echo json_encode($results);
