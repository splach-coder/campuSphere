<?php
//start the session
session_start();

require_once "../config/db.php";
require_once "../helpers/functions.php";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["password"]) && isset($_POST["re-password"])) {

        $password = sanitizeInput($_POST["password"]);
        $repassword = sanitizeInput($_POST["re-password"]);

       
        if (compareStrings($password, $repassword)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_id = $_SESSION['user_id'];

            // Use PDO to query the database for a user with the provided credentials
            $db = new db();
            $conn = $db->getConnection();

            $sql = "UPDATE `users` SET `password`=? WHERE `id_user` = ?";
            $stmt= $conn->prepare($sql);
            $stmt->execute([$hashed_password, $user_id]);

            header('Location: ../views/login.php?message=Your password has been updated successfully.&type=success');
            exit();
            
            
        } else {
            header('Location: ../views/reset-password/reset-pass-form.php?message=The passwords you entered do not match. Please try again.&type=danger');
            exit();
        }
    }    
}
