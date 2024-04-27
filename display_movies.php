<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

 
 echo "<h1>Welcome, " . $_SESSION['username'] . "</h1>";
 

include 'db_connect.php'; // Include the database connection

$userID = $_SESSION['userID']; // Get user ID from session

// Fetch the movies saved by the user
$query = "SELECT m.MovieTitle, m.MovieDescription, m.MoviePoster, m.MovieRating FROM Movies m
          INNER JOIN UserMovies um ON m.MovieID = um.MovieID
          WHERE um.UserID = ?";
$stmt = $db->prepare($query);
$stmt->execute([$userID]);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div>";
    echo "<h3>" . htmlspecialchars($row['MovieTitle']) . "</h3>";
    echo "<p>" . htmlspecialchars($row['MovieDescription']) . "</p>";
    echo "<img src='" . htmlspecialchars($row['MoviePoster']) . "' style='width: 200px;'>";
    echo "<p>Rating: " . htmlspecialchars($row['MovieRating']) . "</p>";
    echo "</div>";
}
?>

<a href="logout.php">Logout</a>


<?php
// session_start();


// // if (!isset($_SESSION['username'])) {
// //     header("Location: login.php");
// //     exit;
// // }

// echo "<h1>Welcome, " . $_SESSION['username'] . "</h1>";
// echo "<a href='logout.php'>Sign Out</a>";

// // Fetch and display movies from the database
// $db = new PDO('mysql:host=localhost; dbname=db3s875grjp4uu', 'uhnaasmnqb94o', 'Jad20032813');
// $stmt = $db->prepare("SELECT * FROM Movies WHERE Username = ?");
// $stmt->execute([$_SESSION['username']]);

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     echo "<p>" . htmlspecialchars($row['movie_title']) . "</p>"; // Display each movie title
// }
// ?>

<?php
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
?>

