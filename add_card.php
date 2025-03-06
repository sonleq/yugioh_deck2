<?php

	include 'protected_section.php';
	
	// Get the user's card file path from the session
	$user_card_file = 'users/' . $_SESSION['user'] . '/' . $_SESSION['user'] . '_cards.txt';

	// Check if the file exists and is writable
	if (!file_exists($user_card_file)) {
    // If the file doesn't exist, handle the error
    echo "No card file found for this user.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yu-Gi-Oh! Card Entry</title>
</head>
<body>
    <h1>Enter Yu-Gi-Oh! Card Information</h1>
    <form action="save_card.php" method="post">
        <label for="card_name">Card Name:</label>
        <input type="text" id="card_name" name="card_name" required><br><br>

        <label for="card_type">Type:</label>
        <input type="text" id="card_type" name="card_type" required><br><br>

        <label for="attribute">Attribute:</label>
        <input type="text" id="attribute" name="attribute" required><br><br>

        <label for="level">Level:</label>
        <input type="number" id="level" name="level" required><br><br>

        <label for="atk">ATK:</label>
        <input type="number" id="atk" name="atk" required><br><br>

        <label for="def">DEF:</label>
        <input type="number" id="def" name="def" required><br><br>

        <label for="effect">Effect:</label>
        <input type="text" id="effect" name="effect" required><br><br>

        <label for="rarity">Rarity:</label>
        <input type="text" id="rarity" name="rarity" required><br><br>

        <input type="submit" value="Submit Card">
    </form>

    <h2><a href="view_cards.php">View All Cards</a></h2>
	<h2><a href="dashboard.php">Dashboard</a></h2>
	<h2><a href="logout.php">Logout</a></h2>
</body>
</html>