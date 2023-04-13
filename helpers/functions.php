<?php

function sanitizeInput($input)
{
  $clean_input = filter_var($input, FILTER_SANITIZE_STRING);
  $clean_input = trim($clean_input);
  $clean_input = stripslashes($clean_input);
  $clean_input = htmlentities($clean_input, ENT_QUOTES, 'UTF-8');
  $clean_input = str_replace(array("\n", "\r", "\t"), '', $clean_input);

  return $clean_input;
}

function checkLogin()
{
  if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    // Redirect the user to the home page or another protected resource
    header('Location: ../views/dashboard.php');
    exit;
  }
}

function checkOneHourElapsed($datetime)
{
  // Convert MySQL datetime string to Unix timestamp
  $datetimeTimestamp = $datetime;

  // Calculate the Unix timestamp for one hour ago
  $oneHourAgoTimestamp = time() - 3600;

  // Compare the given datetime timestamp with one hour ago
  if ($datetimeTimestamp >= $oneHourAgoTimestamp) {
    // Return true if less than one hour has elapsed
    return true;
  } else {
    // Return false if more than one hour has elapsed
    return false;
  }
}

function compareStrings($string1, $string2)
{
  // Compare the two strings using the strcmp() function
  $result = strcmp($string1, $string2);

  // Return true if the result is 0 (i.e. the strings are equal)
  // Otherwise, return false
  return $result === 0;
}

function remember_me($conn)
{
  // Verify the token when the user visits the site
  if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $sql = "SELECT `id_user`, `user_name`, `role` FROM `users` WHERE `token` = ? AND `expiration` > NOW();";
    $user = $conn->prepare($sql)->execute([$token]);

    if ($user) {
      // Log the user in automatically
      // Store the user's session information
      $_SESSION['user_id'] = $user['id_user'];
      $_SESSION['username'] = $user['user_name'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['loggedIn'] = true;

      // Redirect the user to the home page or another protected resource
      header('Location: ../views/dashboard.php');
      exit;
    } else {
      //remove the cookie from the browser
      setcookie('remember_token', '', time() - 3600, '/');
    }
  }
}

function getRoute($type)
{
  $str = '../public/';
  if ($type == "photo")
    $str .= "images/stories/";
  else
    $str = "videos/";
  return $str;
}

function getMediaType($type)
{
  if ($type == 'image') {
    return 'photo';
  } elseif ($type == 'video') {
    return 'video';
  } else {
    return '';
  }
}

function instagram_time($date)
{
  $time = strtotime($date);
  $now = time();
  $diff = $now - $time;

  if ($diff < 60) {
    return $diff . ' seconds ago';
  } elseif ($diff < 3600) {
    $mins = floor($diff / 60);
    return $mins . ' minutes ago';
  } elseif ($diff < 86400) {
    $hours = floor($diff / 3600);
    return $hours . ' hours ago';
  } elseif ($diff < 604800) {
    $days = floor($diff / 86400);
    return $days . ' days ago';
  } else {
    return date('d M Y', $time);
  }
}

function slice_status($string, $pass)
{
  $words = explode(" ", $string);

  if (count($words) >= 8 && $pass == "non") {
    $sliced_words = array_slice($words, 0, 8);
    $sliced_string = implode(" ", $sliced_words) . "...   <button>read
    more</button>";
    return $sliced_string;
  } else {
    return $string;
  }
}


function sendPostInteraction($conn, $userID, $postID, $interaction)
{
  $sql = "INSERT INTO `posts_interactions`(`user_id`, `post_id`, `interaction_type`) VALUES (?, ?, ?)";
  $conn->prepare($sql)->execute([$userID, $postID,  $interaction]);
}

function fetchSingleValue($query, $conn)
{
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $num_views = $stmt->fetchColumn();
  return $num_views;
}
