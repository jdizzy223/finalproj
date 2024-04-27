CREATE TABLE Users (
    Username VARCHAR(50) PRIMARY KEY,
    Password VARCHAR(50)
);

CREATE TABLE Movies (
    MovieID INT AUTO_INCREMENT PRIMARY KEY,
    PosterPath VARCHAR(255),
    Title VARCHAR(100),
    Description TEXT,
    Rating DECIMAL(3, 1),
    ReleaseYear YEAR
);

CREATE TABLE UserMovies (
    UserMovieID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50),
    MovieID INT,
    FOREIGN KEY (Username) REFERENCES Users(Username),
    FOREIGN KEY (MovieID) REFERENCES Movies(MovieID)
);



