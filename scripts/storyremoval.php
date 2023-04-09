<?php

    //start the session
    session_start();
    
    // Import the DB class to handle database connections
    require_once('../config/db.php');
    
    // Use PDO to query the database for a user with the provided credentials
    $db = new db();
    $conn = $db->getConnection();

    $storysql = 'SELECT `story_id`, `created_at`, `delete_at` FROM `stories` where `active` = 1';
    $stm = $conn->query($storysql);
    $stories = $stm->fetchAll();

    foreach($stories as $story){
       
        if(has24HoursPassed($story['delete_at'])){
            $sql = "UPDATE `stories` SET `active` = 0 WHERE `story_id`=?";
            $stmt= $conn->prepare($sql);
            $stmt->execute([$story['story_id']]);
        }
    }
 
    function has24HoursPassed($dateString) {
        $currentDate = new DateTime();
        $dateToCheck = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
        
        if ($currentDate > $dateToCheck) {
            return true;
        } else {
            return false;
        }
    }
    
