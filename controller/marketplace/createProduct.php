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
if (empty($_POST['title'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

// Check if status field is empty
if (empty($_POST['price'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

// Check if status field is empty
if (empty($_POST['category'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

// Check if status field is empty
if (empty($_POST['details'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

// Check if images field is empty
if (empty($_FILES['images'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Status or media field is required';
    exit;
}

$filesArray = convertArrayToObject($_FILES['images']);

// Set upload directory
$uploadDir = '../../public/images/products/';

// Loop through uploaded files
$uploadedFiles = array();

foreach ($_FILES['images']['name'] as $key => $name) {
    // Check if file was uploaded without errors
    if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Failed to upload file: ' . $name;
        exit;
    }

    // Check file type
    $allowedTypes = array('image/png', 'image/jpeg', 'image/gif', 'video/mp4');
    if (!in_array($_FILES['images']['type'][$key], $allowedTypes)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Invalid file type: ' . $name;
        exit;
    }

    // Check file size
    $maxImageSize = 2 * 1024 * 1024; // 2MB
    $maxVideoSize = 5 * 1024 * 1024; // 5MB
    if ($_FILES['images']['type'][$key] == 'video/mp4' && $_FILES['images']['size'][$key] > $maxVideoSize) {
        header('HTTP/1.1 400 Bad Request');
        echo 'File size exceeds limit: ' . $name;
        exit;
    } elseif (in_array($_FILES['images']['type'][$key], array_slice($allowedTypes, 0, 3)) && $_FILES['images']['size'][$key] > $maxImageSize) {
        header('HTTP/1.1 400 Bad Request');
        echo 'File size exceeds limit: ' . $name;
        exit;
    }

    // Generate unique file name
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $extension;
    $targetFile = $uploadDir . $fileName;

    // Save file to upload directory
    if (!move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFile)) {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Failed to upload file: ' . $name;
        exit;
    }

    // Add uploaded file name and type to array
    $fileType =  (strpos($_FILES['images']['type'][$key], 'image') !== false ? 'image' : 'video');

    // Add uploaded file to array
    $uploadedFiles[] = array('name' => $fileName, 'type' => $fileType);
}


// Use PDO to query the database for a user with the provided credentials
$db = new db();
$conn = $db->getConnection();

$title = $_POST['title'];
$category = $_POST['category'];
$price = $_POST['price'];
$details = $_POST['details'];
$userID = $_SESSION['user_id'];

$sql = "INSERT INTO `produits`(`Nom_produit`, `Description`, `Categorie`, `Prix`, `ID_utilisateur`) VALUES (?, ?, ?, ?, ?)";
$conn->prepare($sql)->execute([$title, $details, $category, $price, $userID]);

// Select the UUID value of the last inserted row
$sql = "SELECT `ID_produit` FROM `produits` 
WHERE `ID_utilisateur` = '$userID'  AND `Statut_produit` = 'modération'
ORDER BY `Date_publication` DESC LIMIT 1;";

$stmt = $conn->query($sql);
$postID = $stmt->fetchColumn();

if (!empty($uploadedFiles)) {
    foreach ($uploadedFiles as $file) {
        $fileName = $file['name'];
        $sql = "INSERT INTO `market_images`(`ID_produit`, `image_url`) VALUES (?, ?)";
        $conn->prepare($sql)->execute([$postID, $fileName]);
    }
}

createNotification($conn, "items were just added to your market.");

echo 'File uploaded successfully';
exit;

function convertArrayToObject($array)
{
    $objectArray = array();
    for ($i = 0; $i < count($array['name']); $i++) {
        $object = new stdClass();
        $object->name = $array['name'][$i];
        $object->full_path = $array['full_path'][$i];
        $object->type = $array['type'][$i];
        $object->tmp_name = $array['tmp_name'][$i];
        $object->error = $array['error'][$i];
        $object->size = $array['size'][$i];
        array_push($objectArray, $object);
    }
    return $objectArray;
}
