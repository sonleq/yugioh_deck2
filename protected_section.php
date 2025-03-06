<?php

session_start();  // Start the session to check login status

// Check if the user is logged in
if (!isset($_SESSION['user'])){
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// If the user is logged in, show the page content
 echo "<h2>Welcome, " . $_SESSION['user'] . "!</h2>";


?>