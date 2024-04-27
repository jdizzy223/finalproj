<?php
session_start();

if (!isset($_SESSION['userID'])) { // Check if the user is logged in
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

include 'db_connect.php'; // Include the database connection


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
