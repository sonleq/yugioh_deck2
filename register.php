
<?php
// bcrypt, Argon2, or PBKDF2
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

    // File where the users will be stored
    $file = 'users.txt';
    $new_user = $username . ':' . $hashed_password . PHP_EOL;

    // Open the file and append the new user
    if (file_put_contents($file, $new_user, FILE_APPEND | LOCK_EX) !== false) {
        // Create a new directory for this user to store their cards
        $user_dir = 'users/' . $username;  // Create a "users" directory to store individual user folders
        if (!is_dir($user_dir)) {
            // If the directory doesn't exist, create it
            mkdir($user_dir, 0755, true);  // 0755 permissions and recursive directory creation
        }

        // Create a new file for storing this user's cards
        $user_cards_file = $user_dir . '/' . $username . '_cards.txt';
        if (!file_exists($user_cards_file)) {
            // Create an empty file for storing the cards if it doesn't exist
            file_put_contents($user_cards_file, '');
        }

        echo "User registered successfully.";
        header('Location: index.php'); // Redirect to the homepage after successful registration
    } else {
        echo "Failed to register the user. Please try again.";
    }
}
?>

<h2>Registration</h2>
<form action="register.php" method="POST">
    <label>Username: </label><input type="text" name="username" required><br>
    <label>Password: </label><input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>