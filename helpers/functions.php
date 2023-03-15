<?php

function sanitizeInput($input) {
    $clean_input = filter_var($input, FILTER_SANITIZE_STRING);
    $clean_input = trim($clean_input);
    $clean_input = stripslashes($clean_input);
    $clean_input = htmlentities($clean_input, ENT_QUOTES, 'UTF-8');
    $clean_input = str_replace(array("\n", "\r", "\t"), '', $clean_input);
 
    return $clean_input;
  }
  
