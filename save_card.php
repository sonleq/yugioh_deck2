<?php
session_start();  // Start the session to check login status

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}

// Get the username from the session
$username = $_SESSION['user'];

// Limit cards to 3 per user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $card_name = $_POST['card_name'];
    $card_type = $_POST['card_type'];
    $attribute = $_POST['attribute'];
    $level = $_POST['level'];
    $atk = $_POST['atk'];
    $def = $_POST['def'];
    $effect = $_POST['effect'];
    $rarity = $_POST['rarity'];

    // Path to the user's card file (e.g., username_cards.txt)
    $user_card_file = "users/{$username}/{$username}_cards.txt";

    // Check if the user's card file exists and is readable
    if (file_exists($user_card_file) && is_readable($user_card_file)) {
        // Read the entire file contents
        $card_data = file_get_contents($user_card_file);

        // Count how many times the card name appears in the file
        $card_count = substr_count($card_data, "Card Name: $card_name");

        // If the card already appears 3 times, don't allow the 4th
        if ($card_count >= 3) {
            // If the card already exists 3 times, display an error
            echo "<h2>Error: You cannot add more than 3 cards with the name '$card_name'!</h2>";
            echo "<h2><a href='add_card.php'>Add Cards</a></h2>";
            echo "<h2><a href='dashboard.php'>Dashboard</a></h2>";
            exit; // Stop further execution
        }
    }

    // Generate a unique ID for the card
    $card_id = uniqid();

    // Prepare the data to be saved in the user's card file
    $card_data_to_save = "----- New Card -----\n";  // Add a delimiter between each card
    $card_data_to_save .= "ID: $card_id\n";  // Add the unique ID
    $card_data_to_save .= "Card Name: $card_name\n";
    $card_data_to_save .= "Type: $card_type\n";
    $card_data_to_save .= "Attribute: $attribute\n";
    $card_data_to_save .= "Level: $level\n";
    $card_data_to_save .= "ATK: $atk\n";
    $card_data_to_save .= "DEF: $def\n";
    $card_data_to_save .= "Effect: $effect\n";
    $card_data_to_save .= "Rarity: $rarity\n\n";
    $card_data_to_save .= "--------------------\n\n";  // End of card

    // Create the directory for the user if it doesn't exist
    if (!file_exists("users/{$username}")) {
        mkdir("users/{$username}", 0777, true);  // Create user directory with read/write permissions
    }

    // Write the card data to the user's card file
    file_put_contents($user_card_file, $card_data_to_save, FILE_APPEND);

    // Redirect back to the form with a success message
    echo "<h2>Card added successfully!</h2>";
    echo "<a href='dashboard.php'>Dashboard</a><br><br>";
    echo "<a href='view_cards.php'>View all cards</a><br><br>";
} else {
    echo "Invalid request.";
}
?>