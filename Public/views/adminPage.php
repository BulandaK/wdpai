<?php
require_once __DIR__ . '/../../src/repository/MovieRepository.php';

$movieRepository = new MovieRepository();
$movies = $movieRepository->getAllMovies(); // Pobierz wszystkie filmy
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineReserve - Admin Page</title>
    <link rel="stylesheet" href="../Public/css/reserve.css" />


</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>

    <main>
        <section class="add-movie">
            <form action="/addMovie" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="description" placeholder="Description"></textarea>
                <input type="date" name="release_date" required> <!-- Upewnij się, że to pole istnieje -->
                <input type="file" name="file" accept="image/png, image/jpeg" required>
                <button type="submit">Add Movie</button>
            </form>

        </section>

        <section class="add-screening">
            <form action="/addScreening" method="POST">
                <label for="movie_id">Movie</label>
                <select name="movie_id" id="movie_id" required>
                    <option value="" disabled selected>Select a movie</option>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?= $movie->getId() ?>"><?= htmlspecialchars($movie->getTitle()) ?> (ID:
                            <?= $movie->getId() ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="screening_time">Screening Time</label>
                <input type="datetime-local" name="screening_time" id="screening_time" required>

                <label for="room_number">Room Number</label>
                <input type="number" name="room_number" id="room_number" placeholder="Room Number" required>

                <button type="submit">Add Screening</button>
            </form>
        </section>


    </main>
</body>

</html>