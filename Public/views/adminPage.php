<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineReserve</title>
    <link rel="stylesheet" href="../Public/css/reserve.css" />


</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>

    <main>
        <section class="add-movie">
            <form action="addMovie" method="POST" enctype="multipart/form-data">
                <input name="title" type="text">
                <textarea name="description" placeholder="description"></textarea>
                <input type="file" name="file">
                <input type="date" name="realase_date">
                <button type="submit">send</button>
            </form>
        </section>

        <section class="reservation-section">

        </section>
    </main>
</body>

</html>