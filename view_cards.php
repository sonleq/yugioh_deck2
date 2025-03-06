<?php
session_start();  // Start the session for user tracking

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}

// Get the user's card file path from the session
$user_card_file = 'users/' . $_SESSION['user'] . '/' . $_SESSION['user'] . '_cards.txt';

// Check if the file exists and is readable
if (file_exists($user_card_file) && is_readable($user_card_file)) {
    $card_data = file_get_contents($user_card_file);  // Get the card data from the user's file

    echo "<h1>Yu-Gi-Oh! Card List for " . htmlspecialchars($_SESSION['user']) . "</h1>";

    // Split the data into separate card entries (assuming each card is separated by a double newline)
    $cards = explode("\n\n", $card_data);

    // Initialize a flag to track if any card data was found
    $card_found = false;

    // Loop through each card and display it
    foreach ($cards as $card) {
        $card = trim($card);  // Remove any unnecessary whitespace

        if (!empty($card)) {  // Ensure empty lines are not processed
            echo "<pre>" . htmlspecialchars($card) . "</pre>"; // Display card info
            $card_found = true;
        }
    }

    if (!$card_found) {
        echo "<p>No cards found for this user.</p>";
    }

} else {
    echo "<h2>No cards found or unable to read the file.</h2>";
}
?>

<h2><a href="add_card.php">Add Cards</a></h2>
<h2><a href="dashboard.php">Dashboard</a></h2>
<h2><a href="logout.php">Logout</a></h2>
