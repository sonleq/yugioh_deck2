<?php

// Start the session to destroy it
session_start();  

// Clear all session variables
session_unset();  // Unset all session variables

// Destroy the session data
session_destroy();



// Redirect to the login page
header('Location: index.php');
exit;
?>
