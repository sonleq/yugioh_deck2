<?php
session_start();  // Start the session for user tracking

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Open the users.txt file to check credentials
    $file = 'users.txt';
    $users = file($file, FILE_IGNORE_NEW_LINES);  // Read all users

    foreach ($users as $user) {
        list($stored_username, $stored_hashed_password) = explode(':', $user);

        // Check if the entered username matches
        if ($stored_username === $username) {
            // Verify the password with the stored hash
            if (password_verify($password, $stored_hashed_password)) {
                // Password is correct, start the session and set user info
                $_SESSION['user'] = $username;  // Store the username in session
                header('Location: dashboard.php');  // Redirect to dashboard or a logged-in page
                exit;
            } else {
                echo "Incorrect password.";
                exit;
            }
        }
    }

    echo "User not found.";
}
?>

<h2>Login</h2>
<form action="login.php" method="POST">
    <label>Username: </label><input type="text" name="username" required><br>
    <label>Password: </label><input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
