<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <title>Movie Recommendations</title>
    <meta name="viewport" content= "width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css"> 
<head>
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
</div>



<?php
 
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


<script>
const navButtons = document.getElementsByClassName('nav-button');
const popupMenus = document.getElementsByClassName('popup-menu');
const menu = document.querySelector('#mobile-menu');
const mobileMenu = document.querySelector('#popup-nav-mobile');
const mobileLinks = document.querySelector('.mobile-list');



function animateWave1(wave, duration) {

    function animate() {
    
        wave.animate({'background-position-x': '0px'}, duration * 1000, 'linear', function() {
            
            wave.css('background-position-x', '1000px');
            
            animate();
        });
    }

    animate();
}

function animateWave2(wave, duration) {

    function animate() {

        wave.animate({'background-position-x': '1000px'}, duration * 1000, 'linear', function() {
            
            wave.css('background-position-x', '0px');
            
            animate();
        });
    }

    animate();
}

var on = false;

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


