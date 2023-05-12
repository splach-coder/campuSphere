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

// Check if request method is POST
if (empty($_GET['str'])) {
    header('HTTP/1.1 400');
    echo 'required field';
    exit;
}

// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

$str = $_GET['str'];

$sql = "SELECT ID_produit, Nom_produit FROM produits
WHERE Nom_produit LIKE '%$str%' AND Statut_produit = 'actif' LIMIT 5;";

$stmt = $conn->query($sql);
$pros = $stmt->fetchAll();

$produits = array();

foreach ($pros as $cat) {
    $c = array(
        'id' => $cat['ID_produit'],
        'str' => $cat['Nom_produit']
    );

    array_push($produits, $c);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_cats = json_encode($produits);

// Send the JSON response to JavaScript
echo $json_cats;
