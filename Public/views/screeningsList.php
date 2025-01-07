<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - Screenings</title>
    <link rel="stylesheet" href="../Public/css/screeningList.css">
    <link rel="stylesheet" href="../Public/css/header.css">
</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>

    <main>
        <h1>Available Screenings</h1>
        <section class="screenings-list">
            <?php if (!empty($screenings)): ?>
                <?php foreach ($screenings as $screening): ?>
                    <div class="screening-card">
                        <img src="../Public/uploads/<?= htmlspecialchars($screening['file']) ?>"
                            alt="<?= htmlspecialchars($screening['title']) ?>">
                        <div class="screening-info">
                            <h3><?= htmlspecialchars($screening['title']) ?></h3>
                            <p><?= htmlspecialchars($screening['description']) ?></p>
                            <p>Release Date: <?= htmlspecialchars($screening['release_date']) ?></p>
                            <p>Screening Time: <?= htmlspecialchars($screening['screening_time']) ?></p>
                            <p>Room: <?= htmlspecialchars($screening['room_number']) ?></p>
                            <a href="/reserve?screeningId=<?= $screening['screening_id'] ?>" class="reserve-button">Reserve
                                Seats</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No screenings available.</p>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>