let allRecommendations = [];
let currentIndex = 0;

document.getElementById('movieForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const movieName = document.getElementById('movieName').value;
    fetch(`search_movies.php?query=${encodeURIComponent(movieName)}`)
        .then(response => response.json())
        .then(data => {
            allRecommendations = data;
            currentIndex = 0;
            displayRecommendations();
            document.getElementById('showMore').style.display = 'block';
        })
        .catch(error => console.error('Fetch Error:', error));
});

function displayRecommendations() {
    const container = document.getElementById('recommendations');
    if (currentIndex === 0) {
        container.innerHTML = '';
    }
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

    
}

if (currentIndex >= allRecommendations.length) {
        document.getElementById('showMore').style.display = 'none';
    } else {
        document.getElementById('showMore').style.display = 'block';
    }

    
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

// Close the modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('movieModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
