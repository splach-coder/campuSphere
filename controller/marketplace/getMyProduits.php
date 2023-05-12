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

$sql = "SELECT p.ID_produit, p.Nom_produit, p.location, p.Prix, mi.image_url FROM `produits` AS p
        INNER JOIN `market_images` AS mi ON p.ID_produit = mi.ID_produit
        WHERE `ID_utilisateur` = '$userID' 
        AND p.Statut_produit = 'actif' 
        GROUP BY p.ID_produit
        ORDER BY p.Date_publication DESC ";

$stmt = $conn->query($sql);
$products = $stmt->fetchAll();

$pros = array();

foreach ($products as $pro) {
    $p = array(
        'id' => $pro['ID_produit'],
        'name' => $pro['Nom_produit'],
        'price' => $pro['Prix'],
        'location' => $pro['location'],
        'image' => '../public/images/products/' . $pro['image_url'],
    );

    array_push($pros, $p);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_pros = json_encode($pros);

// Send the JSON response to JavaScript
echo $json_pros;
