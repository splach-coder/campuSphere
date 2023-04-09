<?php

    //the session already active
        
    // Import the DB class to handle database connections
    require_once('../config/db.php');
    require_once('../helpers/functions.php');

    include('../auth/ensureAuthentication.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
       $file = $_FILES['file'];
       $fileType = $_FILES['file']['type'];
       $fileName = $_POST['fileName'];
       $fileType2 = $_POST['fileType'];
       $userID = $_SESSION['user_id'];

       // Use PDO to query the database for a user with the provided credentials
       $db = new db();
       $conn = $db->getConnection();
       
       $maxFileSize = 1 * 1024 * 1024; // 1MB
       $uploadDir = '../public/images/stories/'; // directory to save the files
 
       // validate file size and type
       if (($fileSize = $file['size']) > $maxFileSize) {
            echo 'File size cannot exceed 1MB';
            exit;
       } else if (!in_array($fileType, array('image/png', 'image/jpeg', 'image/gif'))) {
            echo 'Only PNG, JPEG, and GIF images are allowed';
            exit;
       }
     
       // create file path and save file
       $filePath = $uploadDir . $fileName;
       if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            echo 'Error uploading file';
            exit;
       }else{
            // save file location in database
            $sql = "INSERT INTO `stories`(`user_id`, `type`, `content`) VALUES (?,?,?)";
            $conn->prepare($sql)->execute([$userID, getMediaType($fileType2), $fileName]);
        
            echo 'File uploaded successfully';
            exit;
       } 
    }
    
    
 
