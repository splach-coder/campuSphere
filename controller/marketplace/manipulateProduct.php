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

if (!isset($_POST['id']) && empty($_POST['id'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

if (!isset($_POST['type']) && empty($_POST['type'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

if (!isset($_POST['msg']) && empty($_POST['msg'])) {
    header('HTTP/1.1 400 Bad Request ');
    echo 'Invalid request method';
    exit;
}

$produitID = $_POST['id'];
$type = $_POST['type'];

$sql = "";

if ($type == 'accept') {
    $sql = "UPDATE `produits` SET `Statut_produit`='actif' WHERE `ID_produit` = ?";
} else if ($type == 'reject') {
    $sql = "UPDATE `produits` SET `Statut_produit`='supprimé' WHERE `ID_produit` = ?";
}

$conn->prepare($sql)->execute([$produitID]);

$msg = "";

if ($type == 'accept') {
    $msg = "Product accepted! Your product is now live on our website market.";
} else if ($type == 'reject') {
    $msg = 'Post rejected! ' . $_POST['msg'];
}

createNotification($conn, $msg);

echo 'product modified';
