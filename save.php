<?php
session_start();

if (!isset($_SESSION['username'])) {
    // User is not logged in
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

// Include database connection
include 'db_connect.php'; // Adjust this path as needed

$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$description = $data['description'];
$poster = $data['poster'];
$rating = $data['rating'];

try {
    $stmt = $db->prepare("INSERT INTO Movies (MovieTitle, MovieDescription, MoviePoster, MovieRating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $poster, $rating]);
    echo json_encode(['status' => 'success', 'message' => 'Movie saved successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>



// <?php
// session_start();


// // if (!isset($_SESSION['username'])) {
// //     header("Location: login.php");
// //     exit;
// // }

 echo "<h1>Welcome, " . $_SESSION['username'] . "</h1>";
 echo "<a href='logout.php'>Sign Out</a>";

// // Fetch and display movies from the database
// $db = new PDO('mysql:host=localhost; dbname=db3s875grjp4uu', 'uhnaasmnqb94o', 'Jad20032813');
// $stmt = $db->prepare("SELECT * FROM Movies WHERE Username = ?");
// $stmt->execute([$_SESSION['username']]);

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     echo "<p>" . htmlspecialchars($row['movie_title']) . "</p>"; // Display each movie title
// }
// ?>

// <?php
// session_start();
// include 'db_connection.php'; // Adjust this path as needed

// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }



// $result = $db->query("SELECT * FROM Movies");

// while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//     echo "<div>";
//     echo "<h3>" . htmlspecialchars($row['MovieTitle']) . "</h3>";
//     echo "<p>" . htmlspecialchars($row['MovieDescription']) . "</p>";
//     echo "<img src='" . htmlspecialchars($row['MoviePoster']) . "' style='width: 200px;'>";
//     echo "<p>Rating: " . htmlspecialchars($row['MovieRating']) . "</p>";
//     echo "</div>";
// }
// ?>



<?php
session_start();

if (!isset($_SESSION['userID'])) { // Check if the user is logged in
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

include 'db_connection.php'; // Include the database connection

$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$description = $data['description'];
$poster = $data['poster'];
$rating = $data['rating'];
$userID = $_SESSION['userID']; // User ID from session

try {
    // Insert the movie into the Movies table
    $stmt = $db->prepare("INSERT INTO Movies (MovieTitle, MovieDescription, MoviePoster, MovieRating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $description, $poster, $rating]);
    $movieID = $db->lastInsertId(); // Get the ID of the newly inserted movie

    // Associate the movie with the user in UserMovies table
    $stmt = $db->prepare("INSERT INTO UserMovies (UserID, MovieID) VALUES (?, ?)");
    $stmt->execute([$userID, $movieID]);

    echo json_encode(['status' => 'success', 'message' => 'Movie saved successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
