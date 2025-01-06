<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Public/css/main.css" />
    <link rel="stylesheet" type="text/css" href="../Public/css/header.css" />
    <title>CineReserve</title>
</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>
    <div class="banner">
        <img src="../Public/img/baners/film2-baner.jpeg" alt="" />
    </div>
    <section class="movies-section">
        <h2>Upcoming Movies</h2>
        <div class="movie-list">
            <div class="movie-card">
                <img src="../Public/img/cards/film-card1.jpeg" alt="Movie 1">
                <div class="movie-info">
                    <h3>Movie Title 1</h3>
                    <p>Release Date: 2023-10-15</p>
                </div>
            </div>
            <div class="movie-card">
                <img src="../Public/img/cards/film-card2.jpeg" alt="Movie 2">
                <div class="movie-info">
                    <h3>Movie Title 2</h3>
                    <p>Release Date: 2023-11-01</p>
                </div>
            </div>
            <div class="movie-card">
                <img src="../Public/img/cards/film-card3.jpeg" alt="Movie 3">
                <div class="movie-info">
                    <h3>Movie Title 3</h3>
                    <p>Release Date: 2023-11-20</p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>