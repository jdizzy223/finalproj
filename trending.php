<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$apiKey = 'd852165335c73fa831d5fb1008e6bd7e';
$url = "https://api.themoviedb.org/3/trending/movie/week?api_key=$apiKey";

$response = file_get_contents($url);
if ($response === false) {
    echo json_encode(['error' => 'Failed to fetch data']);
    exit;
}

echo $response;  // Send the raw JSON to the client
?>