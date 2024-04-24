<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Recommendations</title>
    <style>
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif; /* Ensures text is legible */
    }

    /* Basic styling for the form */
    form#movieForm {
        padding: 20px;
        text-align: center; /* Center align form elements */
    }

    input[type="text"] {
        width: 80%; /* Responsive width */
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        font-size: 16px; /* Larger font size for better readability */
    }

    .modal {
        display: none; 
        position: fixed;
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto; /* Lower top margin on mobile */
        padding: 20px;
        border: 1px solid #888;
        width: 90%; /* Full width but with some padding */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Soften the box shadow */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px; /* Make close button larger */
    }

    .close:hover,
    .close:focus {
        color: black;
        cursor: pointer;
    }

    #recommendations div {
        margin: 5px;
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    img {
        max-width: 100%; /* Ensure images are not larger than their container */
        height: auto; /* Maintain aspect ratio */
    }
</style>
</head>
<body>
    <form id="movieForm">
        <input type="text" id="movieName" placeholder="Enter Movie Name">
        <br></br>
        <button type="submit">Get Recommendations</button>
    </form>
    <div id="recommendations"></div>
    <button id="showMore" style="display:none;">Show More</button>

    <div id="movieModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalPoster" src="" alt="Movie Poster" style="width:100%; height:20%;">
            <h2 id="modalTitle"></h2>
            <p id="modalDescription"></p>
            <p id="modalScore"></p>
        </div>
    </div>

    <script>

document.getElementById('movieForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const movieName = document.getElementById('movieName').value;
    fetch(`search_movies.php?query=${encodeURIComponent(movieName)}`)
        .then(response => response.json())
        .then(data => {
            allRecommendations = data;
            currentIndex = 0;
            document.getElementById('recommendations').innerHTML = '';  // Clear previous results
            displayRecommendations();
        })
        .catch(error => console.error('Fetch Error:', error));
});

function displayRecommendations() {
    const container = document.getElementById('recommendations');
    const nextIndex = currentIndex + 5;
    for (let i = currentIndex; i < nextIndex && i < allRecommendations.length; i++) {
        const movie = allRecommendations[i];
        const div = document.createElement('div');
        div.className = 'movie-item';
        div.innerHTML = `<img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}" style="width:100px;"><h3>${movie.title} (${movie.vote_average})</h3>`;
        div.addEventListener('click', () => openModal(movie));
        container.appendChild(div);
    }
    currentIndex = nextIndex;

    // Update the visibility of the "Show More" button
    updateShowMoreVisibility();
}

function updateShowMoreVisibility() {
    document.getElementById('showMore').style.display = currentIndex < allRecommendations.length ? 'block' : 'none';
}

document.getElementById('showMore').addEventListener('click', displayRecommendations);

function openModal(movie) {
    const modal = document.getElementById('movieModal');
    document.getElementById('modalPoster').src = `https://image.tmdb.org/t/p/w500${movie.poster_path}`;
    document.getElementById('modalTitle').textContent = movie.title;
    document.getElementById('modalDescription').textContent = movie.overview;
    document.getElementById('modalScore').textContent = `Rating: ${movie.vote_average}`;
    modal.style.display = "block";
}

document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('movieModal').style.display = "none";
});

window.onclick = function(event) {
    const modal = document.getElementById('movieModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

    </script>
</body>
</html>