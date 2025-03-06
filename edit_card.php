<?php

// Include the protected session check
include 'protected_section.php';  // This will ensure the user is logged in

// Now, the $username is available after including 'protected_section.php'
$username = $_SESSION['user'];  // Get the logged-in user's username

// Get the card name to edit (from the query string or form)
if (isset($_GET['card_name'])) {
    $card_name_to_edit = urldecode($_GET['card_name']);

    // File path for the user's card data
    $user_card_file = "users/{$username}/{$username}_cards.txt";

    // Check if the user's card file exists and is readable
    if (file_exists($user_card_file) && is_readable($user_card_file)) {
        // Read the entire file contents
        $card_data = file_get_contents($user_card_file);

        // Split the data into separate card entries
        $cards = explode("\n\n", $card_data);

        // Find the card to edit
        $card_details = null;  // Initialize variable
        foreach ($cards as $index => $card) {
            if (strpos($card, "Card Name: $card_name_to_edit") !== false) {
                // Card found, let's display its data in a form for editing
                $card_details = $card;
                break;
            }
        }

        // If card details are found, proceed with extracting data
        if ($card_details) {
            // Extract details for each field using regex
            preg_match("/Card Name: (.*)/", $card_details, $matches);
            $card_name = isset($matches[1]) ? $matches[1] : ''; // Check if match exists
            preg_match("/Type: (.*)/", $card_details, $matches);
            $card_type = isset($matches[1]) ? $matches[1] : '';
            preg_match("/Attribute: (.*)/", $card_details, $matches);
            $attribute = isset($matches[1]) ? $matches[1] : '';
            preg_match("/Level: (.*)/", $card_details, $matches);
            $level = isset($matches[1]) ? $matches[1] : '';
            preg_match("/ATK: (.*)/", $card_details, $matches);
            $atk = isset($matches[1]) ? $matches[1] : '';
            preg_match("/DEF: (.*)/", $card_details, $matches);
            $def = isset($matches[1]) ? $matches[1] : '';
            preg_match("/Effect: (.*)/", $card_details, $matches);
            $effect = isset($matches[1]) ? $matches[1] : '';
            preg_match("/Rarity: (.*)/", $card_details, $matches);
            $rarity = isset($matches[1]) ? $matches[1] : '';
        }

        // If data is not found, show an error message
        if (!isset($card_name)) {
            echo "Card details not found.";
            exit;
        }
        ?>

        <!-- Form to edit the card details -->
        <h2>Edit Card: <?php echo htmlspecialchars($card_name); ?></h2>
        <form action="save_edited_card.php" method="post">
            <input type="hidden" name="old_card_name" value="<?php echo htmlspecialchars($card_name); ?>">
            
            <label for="card_name">Card Name:</label>
            <input type="text" id="card_name" name="card_name" value="<?php echo htmlspecialchars($card_name); ?>" required><br><br>

            <label for="card_type">Type:</label>
            <input type="text" id="card_type" name="card_type" value="<?php echo htmlspecialchars($card_type); ?>" required><br><br>

            <label for="attribute">Attribute:</label>
            <input type="text" id="attribute" name="attribute" value="<?php echo htmlspecialchars($attribute); ?>" required><br><br>

            <label for="level">Level:</label>
            <input type="number" id="level" name="level" value="<?php echo htmlspecialchars($level); ?>" required><br><br> 
            
            <label for="atk">ATK:</label>
            <input type="number" id="atk" name="atk" value="<?php echo htmlspecialchars($atk); ?>" required><br><br>

            <label for="def">DEF:</label>
            <input type="number" id="def" name="def" value="<?php echo htmlspecialchars($def); ?>" required><br><br>

            <label for="effect">Effect:</label>
            <input type="text" id="effect" name="effect" value="<?php echo htmlspecialchars($effect); ?>" required><br><br>

            <label for="rarity">Rarity:</label>
            <input type="text" id="rarity" name="rarity" value="<?php echo htmlspecialchars($rarity); ?>" required><br><br>

            <input type="submit" value="Save Changes">
        </form>

        <?php
    } else {
        echo "<h2>No cards found or unable to read the file.</h2>";
    }
} else {
    echo "No card name provided for editing.";
}
?>

