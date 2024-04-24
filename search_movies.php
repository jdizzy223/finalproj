<?php
// search_movies.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

if (empty($_GET['query'])) {
    echo json_encode(['error' => 'Query parameter is required']);
    exit;
}

$apiKey = 'd852165335c73fa831d5fb1008e6bd7e';
$query = urlencode($_GET['query']);

// Construct the search URL
$searchUrl = "https://api.themoviedb.org/3/search/movie?query=$query&api_key=$apiKey";

$searchResponse = file_get_contents($searchUrl);
if ($searchResponse === false) {
    echo json_encode(['error' => 'Failed to fetch data']);
    exit;
}

$searchData = json_decode($searchResponse, true);
if (empty($searchData['results'])) {
    echo json_encode(['error' => 'No results found']);
    exit;
}

$movieId = $searchData['results'][0]['id'] ?? null;
if ($movieId) {
    $recommendationsUrl = "https://api.themoviedb.org/3/movie/$movieId/recommendations?api_key=$apiKey";
    $recommendationsResponse = file_get_contents($recommendationsUrl);
    $recommendationsData = json_decode($recommendationsResponse, true);
    echo json_encode($recommendationsData['results'] ?? []);
} else {
    echo json_encode([]);
}


?>
