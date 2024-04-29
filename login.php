<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login or Register</title>
</head>
<body>
    <?php
    session_start(); // Start a new session or resume the existing one

    if (isset($_SESSION['username'])) {
        // Redirect to another page to display user movies if already logged in
        header("Location: display_movies.php");
        exit;
    }
    ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="submit">Login / Register</button>
    </form>
</body>
</html>


//


<?php
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Consider hashing this with password_hash()

    $db = new PDO('mysql:host=localhost; dbname=db3s875grjp4uu', 'uhnaasmnqb94o', 'Jad20032813');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user exists
    $stmt = $db->prepare("SELECT * FROM Users WHERE Username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
     echo "<p>checking if ur real</p>";

    if ($user && password_verify($password, $user['Password'])) {
        // Login success
        $_SESSION['username'] = $username;
        header("Location: display_movies.php");
        exit;
        //   echo "<p>$_SESSION['username']</p>";
        //   echo "<p>$username</p>";
        //   echo "<p>login success!!!</p>";
        
    } else if (!$user) {
        // No user found, create new
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
         echo "<p>user created</p>";

        // Set session and redirect
        $_SESSION['Username'] = $username;
        header("Location: display_movies.php");
        echo "<p>logging in now</p>";
        exit;
    } else {
        // Password mismatch or other login failure
        echo "<p>Invalid username or password!</p>";
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
    <?php
    session_start(); // Start a new session or resume the existing one

    if (isset($_SESSION['username'])) {
        // Redirect to another page to display user movies if already logged in
        header("Location: display_movies.php");
        exit;
    }
    ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="submit">Login / Register</button>
    </form>
</body>
</html>







//This code works
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

