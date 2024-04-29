<?php
session_start();

$errorMessage = ''; // Initialize error message variable

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
    width: 80%; /* Set the width of the container */
    max-width: 360px; /* Set the maximum width of the container */
    position: absolute; /* Position the container */
    top: 50%; /* Move the container 50% down from the top */
    left: 50%; /* Move the container 50% from the left */
    transform: translate(-50%, -50%); /* Center the container both horizontally and vertically */
    background-color: #595959; /* Set background color */
    padding: 24px; /* Add padding for better visual */
    border-radius: 12px; /* Add rounded edges */
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.1); /* Add box shadow */
}

form {
    color: white; /* Set text color to white */
    font-size: 1.44em; /* Increase text size by 20% */
}

form label {
    display: block; /* Display labels as block elements to make them appear on different lines */
    margin-bottom: 6px; /* Add some space between labels and input fields */
}

form input {
    width: 100%; /* Make input fields fill the width of their container */
    padding: 6px; /* Add padding for better visual */
    margin-bottom: 12px; /* Add some space between input fields */
}

form button {
    width: 100%; /* Make button fill the width of its container */
    padding: 12px; /* Add padding for better visual */
    margin-top: 12px; /* Add some space between button and input fields */
}

/* Media query for screens up to 600px */
@media (max-width: 600px) {
    .form-container {
        width: 90%; /* Adjust the width for smaller screens */
        max-width: 300px; /* Adjust maximum width for smaller screens */
    }

    form {
        font-size: 1.68em; /* Increase text size by 20% for smaller screens */
    }

    form input {
        padding: 7px; /* Adjust padding for smaller screens */
        margin-bottom: 14px; /* Adjust margin for smaller screens */
    }

    form button {
        padding: 14px; /* Adjust padding for smaller screens */
        margin-top: 14px; /* Adjust margin for smaller screens */
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