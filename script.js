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






// let allRecommendations = [];
// let currentIndex = 0;

// document.getElementById('movieForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     const movieName = document.getElementById('movieName').value;
//     fetch(`search_movies.php?query=${encodeURIComponent(movieName)}`)
//         .then(response => response.json())
//         .then(data => {
//             allRecommendations = data;  // Store all recommendations
//             currentIndex = 0;           // Reset index
//             displayRecommendations();   // Display the first set of recommendations
//             document.getElementById('showMore').style.display = 'block'; // Ensure the button is visible if data is available
//         })
//         .catch(error => console.error('Fetch Error:', error));
// });

// function displayRecommendations() {
//     const container = document.getElementById('recommendations');
//     if (currentIndex === 0) {
//         container.innerHTML = ''; // Clear previous results only if first call
//     }
//     const nextIndex = currentIndex + 5; // Show 5 more items
//     for (let i = currentIndex; i < nextIndex && i < allRecommendations.length; i++) {
//         const movie = allRecommendations[i];
//         const div = document.createElement('div');
//         div.innerHTML = `<h3>${movie.title} (${movie.vote_average})</h3><p>${movie.overview}</p>`;
//         container.appendChild(div);
//     }
//     currentIndex = nextIndex;  // Update the index to the next set of items

//     // Manage "Show More" button visibility
//     if (currentIndex >= allRecommendations.length) {
//         document.getElementById('showMore').style.display = 'none';  // Hide button if no more items to show
//     } else {
//         document.getElementById('showMore').style.display = 'block'; // Show button if more items to show
//     }
// }

// document.getElementById('showMore').addEventListener('click', displayRecommendations);






// let allRecommendations = [];
// let currentIndex = 0;

// document.getElementById('movieForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     const movieName = document.getElementById('movieName').value;
//     fetch(`search_movies.php?query=${encodeURIComponent(movieName)}`)
//         .then(response => response.json())
//         .then(data => {
//             allRecommendations = data;  // Store all recommendations
//             currentIndex = 0;           // Reset index
//             displayRecommendations();   // Display the first set of recommendations
//         })
//         .catch(error => console.error('Fetch Error:', error));
// });

// function displayRecommendations() {
//     const container = document.getElementById('recommendations');
//     const nextIndex = currentIndex + 10;
//     for (let i = currentIndex; i < nextIndex && i < allRecommendations.length; i++) {
//         const movie = allRecommendations[i];
//         const div = document.createElement('div');
//         div.innerHTML = `<h3>${movie.title} (${movie.vote_average})</h3><p>${movie.overview}</p>`;
//         container.appendChild(div);
//     }
//     currentIndex += 10;  // Update the index to the next set of items

//     // Manage "Show More" button visibility
//     const showMoreBtn = document.getElementById('showMore');
//     if (currentIndex >= allRecommendations.length) {
//         showMoreBtn.style.display = 'none';  // Hide button if no more items to show
//     } else {
//         showMoreBtn.style.display = 'block'; // Show button if more items to show
//     }
// }

// document.getElementById('showMore').addEventListener('click', displayRecommendations);



// document.getElementById('movieForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     const movieName = document.getElementById('movieName').value;
//     fetch(`search_movies.php?query=${encodeURIComponent(movieName)}`)
//         .then(response => response.json())
//         then(data => {
//         console.log(data);  // Log data to see its structure
//         if (data.error) {
//         console.error('Error:', data.error);
//     }   else {
//         displayRecommendations(data);
//     }
// })
//         .then(data => {
//         console.log("Received data:", data);  // This will show you what data actually looks like
//         displayRecommendations(data);
// })
//         .catch(error => console.error('Fetch Error:', error));
        
// });

// function displayRecommendations(data) {
//     const container = document.getElementById('recommendations');
//     container.innerHTML = '';  // Clear previous results

//     // Check if data is an array and has length
//     if (Array.isArray(data) && data.length > 0) {
//         data.forEach(movie => {
//             const div = document.createElement('div');
//             div.innerHTML = `<h3>${movie.title} (${movie.vote_average})</h3><p>${movie.overview}</p>`;
//             container.appendChild(div);
//         });
//     } else {
//         console.error('No valid movie data received:', data);
//         container.innerHTML = '<p>No movies found.</p>';  // Display no movies found message
//     }
// }



// function displayRecommendations(data) {
//     const container = document.getElementById('recommendations');
//     container.innerHTML = ''; // clear previous results
//     // Assuming data now contains more than just the movieId, adjust accordingly.
//     // This is a placeholder for actual implementation based on returned data structure.
//     data.forEach(movie => {
//         const div = document.createElement('div');
//         div.innerHTML = `<h3>${movie.title} (${movie.vote_average})</h3><p>${movie.overview}</p>`;
//         container.appendChild(div);
//     });
// }




// document.getElementById('movieForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     const movieName = document.getElementById('movieName').value;
//     fetch(`search_movies.php?query=${encodeURIComponent(movieName)}`)
//         .then(response => response.json())
//         .then(data => displayRecommendations(data))
//         .catch(error => console.error('Error:', error));
// });

// function displayRecommendations(data) {
//     const container = document.getElementById('recommendations');
//     container.innerHTML = '';
//     data.forEach(movie => {
//         const div = document.createElement('div');
//         div.innerHTML = `<h3>${movie.title} (${movie.vote_average})</h3><p>${movie.overview}</p>`;
//         container.appendChild(div);
//     });
// }


// document.getElementById('movieForm').addEventListener('submit', function(event) {
//     event.preventDefault();

//     const aspect1 = document.getElementById('aspect1').value;
//     const aspect2 = document.getElementById('aspect2').value;
//     const aspect3 = document.getElementById('aspect3').value;

//     fetch(`search_movies.php?aspect1=${aspect1}&aspect2=${aspect2}&aspect3=${aspect3}`)
//         .then(response => response.json())
//         .then(data => displayMovies(data))
//         .catch(error => console.error('Error:', error));
// });

// function displayMovies(movies) {
//     const resultsDiv = document.getElementById('movieResults');
//     resultsDiv.innerHTML = '';
//     movies.forEach(movie => {
//         const div = document.createElement('div');
//         div.innerHTML = `<h2>${movie.title} (${movie.vote_average})</h2><p>${movie.overview}</p>`;
//         resultsDiv.appendChild(div);
//     });
// }