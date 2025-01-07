<?php
session_start(); // Uruchomienie sesji na początku pliku

require_once __DIR__ . '/../../src/repository/SeatRepository.php';

$seatsRepository = new SeatRepository();

// ID seansu, które można przekazać jako parametr GET lub POST
$screeningId = $_GET['screeningId'] ?? 1; // Domyślnie seans o ID 1

$userId = $_SESSION['user_id'] ?? null;

// Pobierz zarezerwowane miejsca i wszystkie miejsca w sali
$reservedSeats = $seatsRepository->getReservedSeats($screeningId);
$seats = $seatsRepository->getSeatsByScreening($screeningId);

$userReservedSeats = $userId ? $seatsRepository->getUserReservedSeats($userId, $screeningId) : [];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CineReserve</title>
  <link rel="stylesheet" href="../Public/css/reserve.css" />
  <link rel="stylesheet" href="../Public/css/header.css" />
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const reserveBtn = document.querySelector(".reserve-btn");
      const selectedSeats = new Set();
      const screeningId = <?= json_encode($screeningId) ?>; // Pobierz screeningId z PHP

      document.querySelectorAll(".seat.available").forEach((seat) => {
        seat.addEventListener("click", () => {
          if (seat.classList.contains("reserved")) return;
          seat.classList.toggle("selected");

          const seatInfo = `${seat.dataset.row}-${seat.dataset.seat}`;
          if (seat.classList.contains("selected")) {
            selectedSeats.add(seatInfo);
          } else {
            selectedSeats.delete(seatInfo);
          }
        });
      });



      reserveBtn.addEventListener("click", () => {
        fetch(`/reserveSeats?screeningId=${screeningId}`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ seats: Array.from(selectedSeats) }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert("Seats reserved successfully!");
              location.reload();
            } else {
              alert(data.message);
            }
          });
      });
    });

  </script>

</head>

<body>
  <?php include __DIR__ . '/header.php'; ?>

  <main>

    <section class="featured-movie">
      <img src="../Public/img/baners/film1-baner.jpeg" alt="Featured Movie" class="movie-image" />
      <div class="movie-info">
        <h2>Movie movie movie</h2>
        <p>
          Experience the thrill and excitement in our featured cinematic
          presentation. Reserve your seats now!
        </p>
      </div>
    </section>

    <section class="reservation-section">
      <h2>Select Your Movie</h2>
      <input type="text" placeholder="Select Your Movie" />
      <h3>Select Your Seats</h3>
      <div class="seating">
        <?php foreach ($seats as $seat): ?>
          <?php
          $class = 'seat available';
          if (in_array($seat['id'], $userReservedSeats)) {
            $class = 'seat reserved-by-user'; // Zarezerwowane przez zalogowanego użytkownika
          } elseif (in_array($seat['id'], $reservedSeats)) {
            $class = 'seat reserved'; // Zarezerwowane przez innych użytkowników
          }
          ?>
          <div class="<?= $class ?>" data-row="<?= htmlspecialchars($seat['seat_row']) ?>"
            data-seat="<?= htmlspecialchars($seat['seat_number']) ?>">
            <?= htmlspecialchars($seat['seat_row']) ?>-<?= htmlspecialchars($seat['seat_number']) ?>
          </div>
        <?php endforeach; ?>

      </div>

      <button class="reserve-btn">Reserve Seats</button>
    </section>
  </main>
  <div class="seating">

  </div>
</body>

</html>