<?php

include 'protected_section.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the original card name
    $old_card_name = $_POST['old_card_name'];  // Used to find the card to edit

    // Get new card details
    $card_name = $_POST['card_name'];
    $card_type = $_POST['card_type'];
    $attribute = $_POST['attribute'];
    $level = $_POST['level'];
    $atk = $_POST['atk'];
    $def = $_POST['def'];
    $effect = $_POST['effect'];
    $rarity = $_POST['rarity'];

    // File path for the card data
    $file = "yugioh_cards.txt";

    if (file_exists($file) && is_readable($file)) {
        // Read the entire file contents
        $card_data = file_get_contents($file);

        // Split the data into separate card entries using "\n\n" (card delimiter)
        $cards = explode("\n\n", $card_data);

        // Loop through each card and find the one to replace
        $found = false;
        foreach ($cards as $index => $card) {
            if (strpos($card, "Card Name: $old_card_name") !== false) {
                // Extract the ID from the original card
                preg_match("/ID: ([a-zA-Z0-9]+)/", $card, $id_matches);
                $card_id = $id_matches[1];  // Capture the ID

                // Prepare the updated card data, including the original ID
                $updated_card = "ID: $card_id\n";
                $updated_card .= "Card Name: $card_name\n";
                $updated_card .= "Type: $card_type\n";
                $updated_card .= "Attribute: $attribute\n";
                $updated_card .= "Level: $level\n";
                $updated_card .= "ATK: $atk\n";
                $updated_card .= "DEF: $def\n";
                $updated_card .= "Effect: $effect\n";
                $updated_card .= "Rarity: $rarity\n\n";

                // Replace the old card with the updated one
                $cards[$index] = $updated_card;
                $found = true;
                break; // Stop once the card is replaced
            }
        }

        // If the card was found and replaced, rebuild the updated card data
        if ($found) {
            $updated_card_data = implode("\n\n", $cards); // Rebuild the card data with the updated card

            // Save the updated card data back to the file
            file_put_contents($file, $updated_card_data);
            echo "<h2>Card '$card_name' updated successfully!</h2>";
        } else {
            echo "<h2>Error: Card not found.</h2>";
        }

        echo "<h2><a href='view_cards.php'>Back to View Cards</a><h2>";
		echo "<h2><a href='dashboard.php'>Dashboard</a></h2>";
	

    } else {
        echo "Unable to read the card file.";
    }
} else {
    echo "Invalid request.";
}
?>
