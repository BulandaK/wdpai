<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <link rel="stylesheet" href="../Public/css/movies.css">
    <link rel="stylesheet" href="../Public/css/header.css">


</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>
    <div class="container">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <img src="../Public/uploads/<?= htmlspecialchars($movie->getFile()) ?>"
                    alt="<?= htmlspecialchars($movie->getTitle()) ?>">
                <div class="movie-info">
                    <h3><?= htmlspecialchars($movie->getTitle()) ?></h3>
                    <p><?= htmlspecialchars($movie->getDescription()) ?></p>
                    <p>Release Date: <?= htmlspecialchars($movie->getReleaseDate()) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>