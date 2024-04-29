<?php
// Database credentials
$host = 'localhost'; // or other host if your database is on a remote server
$dbname = 'db3s875grjp4uu'; // your database name
$username = 'uhnaasmnqb94o'; // your database username
$password = 'Jad20032813'; // your database password

// Set up a PDO instance
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Uncomment the following line if you want to use emulated prepares (not recommended)
    // $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// echo "Database connected successfully.";
?>