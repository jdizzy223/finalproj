<?php
session_start();

if (isset($_POST['submit'])) {
    // Connection settings
    $host = 'localhost'; // Adjust as necessary
    $dbname = 'db3s875grjp4uu'; // Your database name
    $username = 'uhnaasmnqb94o'; // Your database username
    $password = 'Jad20032813'; // Your database password

    try {
        // Establishing the database connection
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch user from the database
        $stmt = $db->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->execute([$_POST['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($_POST['password'], $user['Password'])) {
                // Correct password, login successful
                $_SESSION['username'] = $user['Username'];
                $_SESSION['userID'] = $user['UserID']; // Store user ID in session for later use
                header("Location: display_movies.php");
                exit;
            } else {
                // Wrong password
                echo "<p>Invalid username or password!</p>";
            }
        } else {
            // No user found, create new user
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO Users (Username, Password) VALUES (?, ?)");
            $stmt->execute([$_POST['username'], $hash]);

            // Login the new user
            $newUserID = $db->lastInsertId(); // Get the new user ID
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['userID'] = $newUserID;
            header("Location: display_movies.php");
            exit;
        }
    } catch (PDOException $e) {
        // Handle SQL errors or missing database connection
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login or Register</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="submit">Login / Register</button>
    </form>
</body>
</html>
