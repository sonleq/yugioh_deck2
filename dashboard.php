<?php

// Check if the user is logged in or has the right permissions
include 'protected_section.php';  // Make sure the user is logged in

// Get the username from the session
$username = $_SESSION['user'];

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

    // Loop through each card and display it with a delete button
    foreach ($cards as $card) {
        $card = trim($card);  // Remove any unnecessary whitespace

        if (!empty($card)) {  // Ensure empty lines are not processed
            echo "<pre>" . htmlspecialchars($card) . "</pre>"; // Display card info

            // Extract the card name and ID for the delete link
            if (preg_match('/ID: (.+)/', $card, $id_matches) && preg_match('/Card Name: (.+)/', $card, $name_matches)) {
                $card_id = urlencode($id_matches[1]); // Encode the unique card ID for the URL
                $card_name = urlencode($name_matches[1]); // Encode the card name

                // Create a delete link that passes the card ID in the URL
                echo "<a href='delete_card.php?card_id=$card_id&card_name=$card_name' onclick='return confirm(\"Are you sure you want to delete this card?\")'>Delete</a><br><br>";
                
                // Create an edit link that passes the card name in the URL
                echo "<a href='edit_card.php?card_name=$card_name'>Edit</a><br><br>";

                // Set the flag to indicate that we found a card
                $card_found = true;
            }
        }
    }

    // If no cards were found, display a message
    if (!$card_found) {
        echo "<h2>No cards available to display.</h2>";
    }

} else {
    echo "<h2>No cards found or unable to read the file.</h2>";
}
?>

<h2><a href="view_cards.php">View Deck</a></h2>
<h2><a href="add_card.php">Add Cards</a></h2>
<h2><a href="logout.php">Logout</a></h2>



<?php
// Check if the user is logged in or has the right permissions

/*session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view the card data.";
    exit;
}


// Read and display the file contents
$file = "yugioh_cards.txt";
if (file_exists($file) && is_readable($file)) {
    $card_data = file_get_contents($file);
    echo "<h1>Yu-Gi-Oh! Card List</h1>";

    // Split the data into separate card entries
    $cards = explode("\n\n", $card_data);

    // Loop through each card and display it with a delete button
    foreach ($cards as $card) {
        if (!empty($card)) {  // Ensure empty lines are not processed
            echo "<pre>" . htmlspecialchars($card) . "</pre>"; // Display card info

            // Extract the card name for the delete link
            if (preg_match('/Card Name: (.+)/', $card, $matches)) {
                $card_name = urlencode($matches[1]); // Encode the card name for the URL
                echo "<a href='delete_card.php?card_name=$card_name' onclick='return confirm(\"Are you sure you want to delete this card?\")'>Delete</a><br><br>";
            }
        }
    }
} else {
    echo "<h2>No cards found or unable to read the file.</h2>";
}*/
?>

