<?php

session_start();  // Start the session to check login status

// If the user is logged in, show the page content
if (isset($_SESSION['user'])){
    echo "<h2>Welcome, " . $_SESSION['user'] . "!</h2>";
}

// Get the username from the session
$username = $_SESSION['user'] ?? null;  // Handle case if not logged in

if ($username) {
    // Path to the user's specific card file
    $user_card_file = "users/{$username}/{$username}_cards.txt";

    // Check if the user's card file exists and is readable
    if (file_exists($user_card_file) && is_readable($user_card_file)) {
        $card_data = file_get_contents($user_card_file);
        echo "<h1>Yu-Gi-Oh! Card List for {$username}</h1>";

        // Split the data into separate card entries
        $cards = explode("\n\n", $card_data);

        // Initialize a flag to track if any card data was found
        $card_found = false;

        // Loop through each card and display it
        foreach ($cards as $card) {
            $card = trim($card);  // Remove any unnecessary whitespace

            if (!empty($card)) {  // Ensure empty lines are not processed
                echo "<pre>" . htmlspecialchars($card) . "</pre>"; // Display card info
            }
        }

    } else {
        echo "<h2>No cards found or unable to read the file.</h2>";
    }
}

// Provide links for logged-in and non-logged-in users
if (isset($_SESSION['user'])){
    echo '<h2><a href="dashboard.php">Dashboard</a></h2>';
    echo '<h2><a href="logout.php">Logout</a></h2>';
} else {
    echo '<h2><a href="login.php">Login</a></h2>';
    echo '<h2><a href="register.php">Register</a></h2>';
    exit;
}

?>




