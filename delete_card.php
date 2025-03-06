<?php
/*
// delete base on card name
// Get the card name to delete (from the query string or form)
if (isset($_GET['card_name'])) {
    $card_name_to_delete = $_GET['card_name'];

    // File path for the card data
    $file = "yugioh_cards.txt";

    // Check if the file exists and is readable
    if (file_exists($file) && is_readable($file)) {
        // Read the entire file contents
        $card_data = file_get_contents($file);
        // Split the data into separate card entries
        $cards = explode("\n\n", $card_data);

        // Initialize an array to store the cards that will remain after deletion
        $updated_cards = [];

        // Loop through the cards and skip the one that matches the card name to delete
        foreach ($cards as $card) {
            if (strpos($card, "Card Name: $card_name_to_delete") === false) {
                // If this card's name doesn't match, add it to the updated list
                $updated_cards[] = $card;
            }
        }

        // Join the updated cards array back into a string
        $updated_card_data = implode("\n\n", $updated_cards);

        // Write the updated data back to the file
        file_put_contents($file, $updated_card_data);

        echo "<h2>Card '$card_name_to_delete' deleted successfully!</h2>";
        echo "<a href='view_cards.php'>Back to View Cards</a>";
    } else {
        echo "Unable to read the card file.";
    }
} else {
    echo "No card name provided for deletion.";
}*/
?>


<?php

include 'protected_section.php';

// Get the username from the session
$username = $_SESSION['user'];  // Ensure this is set properly in your session

// Check if the card_id and card_name are passed via GET request
if (isset($_GET['card_id']) && isset($_GET['card_name'])) {
    $card_id = urldecode($_GET['card_id']);
    $card_name = urldecode($_GET['card_name']);
	

    // File path for the card data
   $user_card_file = "users/{$username}/{$username}_cards.txt";

    if (file_exists($user_card_file) && is_readable($user_card_file)) {
        // Read the entire file contents
        $card_data = file_get_contents($user_card_file);

        // Split the data into separate card entries using "\n\n" (card delimiter)
        $cards = explode("\n\n", $card_data);

        // Loop through each card and find the card to delete
        $new_card_data = ''; // Will hold the new card data without the deleted card
        foreach ($cards as $card) {
            // Check if the card contains the ID and card name to delete
            if (strpos($card, "ID: $card_id") !== false && strpos($card, "Card Name: $card_name") !== false) {
                // Skip this card (effectively deleting it)
                continue;
            }

            // Otherwise, add the card to the new data (keeping it)
            $new_card_data .= $card . "\n\n";
        }

        // Remove any trailing separator lines (e.g., "--------------------") at the end
        $new_card_data = rtrim($new_card_data);

        // Save the updated data back to the file
        file_put_contents($user_card_file, $new_card_data);

        echo "<h2>Card '$card_name' deleted successfully!</h2>";
        echo "<a href='view_cards.php'>Back to View Cards</a>";
    } else {
        echo "Unable to read the card file.";
    }
} else {
    echo "Invalid request.";
}
?>
