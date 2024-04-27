<?php
// Establish database connection
$servername = "your_host";
$username = "your_username";
$password = "your_password";
$database = "your_database";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add a movie to a user's list
function addMovieToList($username, $posterPath, $title, $description, $rating, $releaseYear, $conn) {
    // Check if the movie already exists in the Movies table
    $checkQuery = $conn->prepare("SELECT MovieID FROM Movies WHERE Title = ?");
    $checkQuery->bind_param("s", $title);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        // Movie already exists, fetch its ID
        $movieID = $checkResult->fetch_assoc()['MovieID'];
    } else {
        // Movie doesn't exist, insert it into the Movies table
        $insertQuery = $conn->prepare("INSERT INTO Movies (PosterPath, Title, Description, Rating, ReleaseYear) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->bind_param("sssssi", $posterPath, $title, $description, $rating, $releaseYear);
        $insertQuery->execute();

        // Get the ID of the newly inserted movie
        $movieID = $insertQuery->insert_id;
    }

    // Insert the movie into the UserMovies table
    $userMovieQuery = $conn->prepare("INSERT INTO UserMovies (Username, MovieID) VALUES (?, ?)");
    $userMovieQuery->bind_param("si", $username, $movieID);
    $userMovieQuery->execute();
}

// Check if the button is clicked and handle the request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Get movie details from the form
    $posterPath = $_POST["poster_path"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $rating = $_POST["rating"];
    $releaseYear = $_POST["release_year"];
    $username = "example_user"; // Assuming a logged-in user

    // Add the movie to the user's list
    addMovieToList($username, $posterPath, $title, $description, $rating, $releaseYear, $conn);
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Movie to List</title>
</head>
<body>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="poster_path">Poster Path:</label><br>
    <input type="text" id="poster_path" name="poster_path" required><br><br>

    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="rating">Rating:</label><br>
    <input type="number" id="rating" name="rating" step="0.1" min="0" max="10" required><br><br>

    <label for="release_year">Release Year:</label><br>
    <input type="number" id="release_year" name="release_year" required><br><br>

    <input type="submit" name="submit" value="Add Movie">
</form>

</body>
</html>

