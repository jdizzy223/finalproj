<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trending Movies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        h1 {
            text-align: center;
        }
        .movie-list {
            list-style: none;
            padding: 0;
        }
        .movie-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .movie-item img {
            max-width: 100px;
            float: left;
            margin-right: 20px;
        }
        .movie-item h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Trending Movies</h1>
        <ul class="movie-list">
            <?php
            // Function to fetch trending movies from the API
            function fetchTrendingMovies() {
                $api_key = 'YOUR_API_KEY'; // Replace with your API key
                $url = 'https://api.themoviedb.org/3/trending/movie/week?api_key=' . $api_key;

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);

                return json_decode($response, true);
            }

            // Fetch trending movies
            $trending_movies = fetchTrendingMovies();

            // Check if API call was successful and display movies
            if(isset($trending_movies['results'])) {
                foreach($trending_movies['results'] as $movie) {
                    echo '<li class="movie-item">';
                    echo '<img src="https://image.tmdb.org/t/p/w200/' . $movie['poster_path'] . '" alt="' . $movie['title'] . '">';
                    echo '<div>';
                    echo '<h2>' . $movie['title'] . '</h2>';
                    echo '<p>Release Date: ' . $movie['release_date'] . '</p>';
                    echo '<p>Rating: ' . $movie['vote_average'] . '</p>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                // Handle API call failure
                echo "<p>Failed to fetch trending movies.</p>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
