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

if (!isset($_GET['id']) && empty($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

$produitID = $_GET['id'];

$sql = "SELECT `Nom_produit`, `Description`, `Prix`, `ID_utilisateur`, `Date_publication`, `location`, u.user_name, pf.profile_pic
FROM `produits` p
INNER JOIN `users` u ON p.ID_utilisateur = u.id_user 
INNER JOIN `profile` pf ON pf.id_user = u.id_user 
WHERE p.ID_produit = $produitID LIMIT 1";

$stmt = $conn->query($sql);
$produit = $stmt->fetch();

$ps = array(
    'id' => $produitID,
    'title' => $produit['Nom_produit'],
    'username' => $produit['user_name'],
    'description' => $produit['Description'],
    'image' => '../public/images/' . $produit['profile_pic'],
    'prix' => $produit['Prix'],
    'date' => instagram_time($produit['Date_publication']),
    'location' => $produit['location'],
    'images' => array()
);


$stmt = $conn->prepare("SELECT `ID_image`, `image_url` FROM `market_images` WHERE `ID_produit` = $produitID");
$stmt->execute();
$data = $stmt->fetchAll();

// and somewhere later:
foreach ($data as $row) {
    $new_item = array(
        'id' => $row['ID_image'],
        'url' => '../public/images/products/' . $row['image_url'],
    );

    array_push($ps['images'], $new_item);
}

header('Content-Type: application/json');

// Convert the $stories array to a JSON string using json_encode
$json_posts = json_encode($ps);

// Send the JSON response to JavaScript
echo $json_posts;
