<?php
include '../config.php';
// Assuming you have already established a database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you've performed any necessary form validation
    
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password']; // Remember to hash this password for security

    // Example validation
    if (!empty($username) && !empty($password)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute SQL statement to insert user into the database
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $hashedPassword]);

        // Check if the user was successfully added
        if ($stmt->rowCount() > 0) {
            echo "User added successfully!";
        } else {
            echo "Error adding user.";
        }
    } else {
        echo "Username and password are required.";
    }
}
?>

<!-- HTML Form -->
<form method="POST" action="add_user.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="Add User">
</form>
