<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trending Movies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css"> 
    <style>
        body, html {
        margin: 0;
        padding: 0; 
        }

        form#movieForm {
            padding: 20px;
            text-align: center;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            font-size: 16px; 
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
            margin: 10% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 50%; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            position: relative;
            display: flex;
            align-items: center; 
            justify-content: center; 
            flex-direction: column;
        }
        
        .modal-content img {
            width: 100%; 
            max-width: auto; 
            height: 100px; 
            display: flex;
            align-items: center; 
            justify-content: center; 
        }


        .close {
            position: absolute; 
            top: 10px; 
            right: 10px; /
            color: #aaa;
            cursor: pointer;
            font-size: 28px; 
        }
  

        #saveMovie {
            background-color: #ef4e4e; 
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #saveMovie:hover {
            background-color: #ef6868; 
        }

        .close:hover,
        .close:focus {
            color: black;
            cursor: pointer;
            text-decoration: none;
        }

        img {
            max-width: 100%; 
            height: auto; 
        }
    
        @media (max-width: 768px) {
            #recommendations {
                grid-template-columns: repeat(2, 1fr); /* Two columns on smaller screens */
            }
        }

        @media (max-width: 480px) {
            #recommendations {
                grid-template-columns: 1fr; 
            }
        }

        #recommendations {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            padding: 20px;
        }
        .movie-item {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
        }
        .movie-item:hover {
            transform: scale(1.05);
            cursor: pointer;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
        }
        .movie-item img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ccc;
        }
        .movie-item h3 {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" id="navbar-logo"> 
                <img src="/images/hh.png"/> </a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span> <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar-menu">
                <li class="navbar-item">
                    <button class="nav-button" id="nb1" > Sign Up/Log In </button>
                    <ul id="menu1" class="popup-menu">
                        <div class="popup-menu-container">
                            <li class="navbar-link"> <a href="/final/display_movies.php"> Profile </a> </li>    
                        </div>
                    </ul>
                </li>
                <li class="navbar-item">
                    <button class="nav-button" id="nb2">Trending </button> 
                    <ul id="menu2" class="popup-menu">
                        <div class="popup-menu-container">
                            <li class="navbar-link"> <a href="/final/trending.php"> Movies </a> </li>
                            <li class="navbar-link"> <a href="/final/trending.php">TV</a> </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>     
    <div id="popup-nav-mobile">
        <ul class="mobile-list">
            <li class="mobile-link"> <a href="/index.php"> Recommendations </a> </li>
            <li class="mobile-link"> <a href="/trending.php"> Trending Movies  </a> </li>
            <li class="mobile-link"> <a href="/trending.php"> Trending TV </a> </li>
            <li class="mobile-link"> <a href="/display_movies.php"> Profile </a> </li>
        </ul>
    </div>
    <div id="recommendations"></div>  
    <div id="movieModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalPoster" src="" alt="Movie Poster" style="width:100%; height:20%;">
            <h2 id="modalTitle"></h2>
            <p id="modalDescription"></p>
            <p id="modalScore"></p>
            <button id="saveMovie"  onclick="saveMovieToDatabase()">Save Movie</button>
        </div>
    </div>

<script>

    var on = false;
    //code for saving to the database 
    function saveMovieToDatabase() {
        const movieTitle = document.getElementById('modalTitle').textContent;
        const movieDescription = document.getElementById('modalDescription').textContent;
        const moviePoster = document.getElementById('modalPoster').src;
        const movieRating = document.getElementById('modalScore').textContent.split(" ")[1]; // Assuming the textContent is "Rating: X.Y"

        console.log("Title: ", movieTitle);
        console.log("Description: ", movieDescription);
        console.log("Poster: ", moviePoster);
        console.log("Rating: ", movieRating);
    
        fetch('save_movie.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                title: movieTitle,
                description: movieDescription,
                poster: moviePoster,
                rating: movieRating
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Movie saved!');
            } else if (data.status === 'error') {
                alert(data.message); // Display the error message from PHP
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }





    function openModal(movie) {
        const modal = document.getElementById('movieModal');
        if (!modal) {
            console.error('Modal element not found');
            return;
        }
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

    window.onload = function() {
                fetch('trending.php')
                .then(response => response.json())
                .then(data => displayMovies(data.results))
                .catch(error => console.error('Error loading trending movies:', error));
    };

    function displayMovies(movies) {
        const container = document.getElementById('recommendations');
        movies.forEach(movie => {
            const div = document.createElement('div');
            div.className = 'movie-item';
            div.innerHTML = `
                <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}">
                <h3>${movie.title} (${movie.vote_average})</h3>
            `;
            div.addEventListener('click', () => openModal(movie));  // Make sure this line is working
            container.appendChild(div);
        });
    }

    const navButtons = document.getElementsByClassName('nav-button');
    const popupMenus = document.getElementsByClassName('popup-menu');
    const menu = document.querySelector('#mobile-menu');
    const mobileMenu = document.querySelector('#popup-nav-mobile');
    const mobileLinks = document.querySelector('.mobile-list');

    mobileMenu.style.height = "0px";
    mobileMenu.style.padding = "0px";

    for (let i = 0; i < popupMenus.length; i++) {
        popupMenus[i].style.display = "none";
    }



    menu.addEventListener("click", function() {
        menu.classList.toggle("is-active");
    });

    menu.addEventListener("click", toggleMobileMenu);

    for (let i = 0; i < navButtons.length; i++) {
        navButtons[i].addEventListener("mouseenter", revealMenu);
        popupMenus[i].addEventListener("mouseleave", hideMenu);
    }

    for (let i = 0; i < popupMenus.length; i++) {
        popupMenus[i].addEventListener("mouseenter", changeBackground);
        popupMenus[i].addEventListener("mouseleave", resetBackgroundPm);
        navButtons[i].addEventListener("mouseleave", resetBackground);
    }

    function toggleMobileMenu()  {
        on = !on;
        mobileMenu.style.height = on ? "350px" : "0px";
        mobileMenu.style.padding = on ? "80px, 0px" : "0px";
    }

    function revealMenu(event) {
        const buttonId = event.target.id.slice(event.target.id.indexOf("b")+1);
        const popupMenu = document.getElementById("menu" + buttonId);
        popupMenu.style.display = "block";
    }

    function hideMenu(event) {
        const popupMenuid = event.target.id;
        const popupMenu = document.getElementById(popupMenuid);
        popupMenu.style.display = "none";
    }


    function changeBackground(event) {
        const btnidnum = event.target.id.slice(event.target.id.indexOf("u")+1);
        const navButton = document.getElementById("nb" + btnidnum);
        navButton.style.backgroundColor = "#969E7D";
        navButton.style.borderColor = "#969E7D";
    }

    function resetBackgroundPm(event) {
        const btnidnum = event.target.id.slice(event.target.id.indexOf("u")+1);
        const navButton = document.getElementById("nb" + btnidnum);
        navButton.style.backgroundColor = "";
        navButton.style.borderColor = "";
    }

    function resetBackground(event) {
        const btnid = event.target.id;
        const navButton = document.getElementById(btnid);
        navButton.style.backgroundColor = "";
        navButton.style.borderColor = "";
    }
    

</script>
</body>
</html>
