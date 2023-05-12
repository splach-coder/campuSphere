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

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

if (!isset($_POST['name']) && empty($_POST['name'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'if field needed';
    exit;
}

if (!isset($_POST['description']) && empty($_POST['discription'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

if (!isset($_POST['date']) && empty($_POST['date'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

if (!isset($_POST['time']) && empty($_POST['time'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

if (!isset($_POST['location']) && empty($_POST['location'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

$name = $_POST['name'];
$desc = $_POST['description'];
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];


$sql = "INSERT INTO `events`(`name`, `date`, `time`, `location`, `description`) VALUES (?, ?, ?, ?, ?)";
$conn->prepare($sql)->execute([$name, $date, $time, $location, $desc]);

echo 'Event Added';
