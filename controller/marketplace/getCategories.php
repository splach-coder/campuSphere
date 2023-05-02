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

$sql = "SELECT `ID_categorie`, `Nom_categorie`, `Icone` FROM `categories`";

$stmt = $conn->query($sql);
$categories = $stmt->fetchAll();

$cats = array();

foreach ($categories as $cat) {
    $c = array(
        'id' => $cat['ID_categorie'],
        'name' => $cat['Nom_categorie'],
        'icon' => $cat['Icone']
    );

    array_push($cats, $c);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_cats = json_encode($cats);

// Send the JSON response to JavaScript
echo $json_cats;
