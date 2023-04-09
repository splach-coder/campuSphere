<?php

    //start the session
    session_start();
    
    // Import the DB class to handle database connections
    require_once('../config/db.php');
    require_once('../helpers/functions.php');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        // Use PDO to query the database for a user with the provided credentials
        $db = new db();
        $conn = $db->getConnection();

        $userID = $_SESSION['user_id'];

        $stories = array();

        $sql = "SELECT u.id_user, u.user_name, p.profile_pic, s.created_at FROM `users` u, `profile` p, `stories` s WHERE u.id_user = p.id_user AND u.id_user = s.user_id AND s.created_at = (SELECT MAX(created_at) FROM stories where user_id = u.id_user) AND s.active = 1 GROUP BY u.id_user ORDER BY CASE WHEN u.id_user = '$userID' THEN 0 ELSE 1 END, s.created_at DESC";
        $stm = $conn->query($sql);
        $users = $stm->fetchAll();

        foreach($users as $user){
            $s = array(
                'id' => $user['id_user'],
                'name' => $user['user_name'],
                'photo' => '../public/images/' . $user['profile_pic'],
                'link' => '',
                'lastUpdated' => strtotime($user['created_at']),
                'items' => array()
            );

            array_push($stories, $s);
        };

        foreach($stories as &$story){
            
            $stmt = $conn->prepare("SELECT s.story_id, s.type, s.content, s.created_at FROM `stories` s WHERE `user_id` = :id AND s.active = 1  ORDER BY s.created_at ");
            $stmt->execute(['id' => $story['id']]);
            $data = $stmt->fetchAll();
    
            // and somewhere later:
            foreach ($data as $row) {
                $new_item = array(
                    'id' => $row['story_id'],
                    'type' => $row['type'],
                    'src' => getRoute($row['type']) . $row['content'],
                    'time' => strtotime($row['created_at']),
                );
            
                array_push($story['items'], $new_item);
            }
        };

    
        header('Content-Type: application/json');
        
        // Convert the $stories array to a JSON string using json_encode
        $json_stories = json_encode($stories);

        // Send the JSON response to JavaScript
        echo $json_stories;
    }

 
