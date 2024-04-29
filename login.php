<?php
session_start();

$errorMessage = '';

if (isset($_POST['submit'])) {
    // Connection settings
    $host = 'localhost'; 
    $dbname = 'db3s875grjp4uu'; 
    $username = 'uhnaasmnqb94o'; 
    $password = 'Jad20032813'; 

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
                $_SESSION['userID'] = $user['UserID']; // Store user ID
                header("Location: profile.php");
                exit;
            } else {
                // Wrong password
                $errorMessage = 'Invalid username or password!';
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
            header("Location: profile.php");
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
    <link rel="stylesheet" href="styles.css"> 
    <style> 
        .form-container {
            width: 80%; 
            max-width: 360px; 
            position: absolute; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            background-color: #595959; 
            padding: 24px; 
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

form {
    color: white; 
    font-size: 1.44em;
}

form label {
    display: block; 
    margin-bottom: 6px; 
}

form input {
    width: 100%; 
    padding: 6px; 
    margin-bottom: 12px; 
}

form button {
    width: 100%; 
    padding: 12px; 
    margin-top: 12px;
}

/* Media query for screens up to 600px */
@media (max-width: 600px) {
    .form-container {
        width: 90%; 
        max-width: 300px; 
    }

    form {
        font-size: 1.68em; 
    }

    form input {
        padding: 7px; 
        margin-bottom: 14px; 
    }

    form button {
        padding: 14px; 
        margin-top: 14px; 
    }
}

    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" id="navbar-logo"> 
                <img src="https://justind.sgedu.site/final/images/logo.webp"/> </a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span> <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar-menu">
                <li class="navbar-item">
                    <button class="nav-button" id="nb1" > Sign Up/Log In </button>
                    <ul id="menu1" class="popup-menu">
                        <div class="popup-menu-container">
                            <li class="navbar-link"> <a href="/final/profile.php"> Profile </a> </li> 
                        </div>
                    </ul>
                </li>
                <li class="navbar-item">

                    <button class="nav-button" id="nb2">Trending </button> 
                    <ul id="menu2" class="popup-menu">
                        <div class="popup-menu-container">
                            <li class="navbar-link"> <a href="/final/display_trending.php"> Movies </a> </li>
                            <li class="navbar-link"> <a href="/final/display_trendingtv.php">TV</a> </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="form-container">
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="submit">Login / Register</button>
        </form>
        <?php if ($errorMessage): ?>
            <p id="error-message" style="color: red;"><?= $errorMessage ?></p>
        <?php endif; ?>
    </div>

    
</body>
</html>