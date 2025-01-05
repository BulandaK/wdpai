<?php
session_start(); // Uruchomienie sesji na początku pliku

require_once __DIR__ . '/../../Database.php'; // Upewnij się, że include jest za `session_start`

$database = new Database();
$conn = $database->connect();

// ID seansu, które można przekazać jako parametr GET lub POST
$screeningId = $_GET['screeningId'] ?? 1; // Domyślnie seans o ID 1

// Pobierz ID zarezerwowanych miejsc dla danego seansu
$stmt = $conn->prepare('
          SELECT seat_id FROM reservations WHERE screening_id = :screeningId
      ');
$stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
$stmt->execute();
$reservedSeats = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Pobierz wszystkie miejsca w danej sali (np. sala 1)
$stmt = $conn->prepare('
          SELECT * FROM seats WHERE room_number = (
              SELECT room_number FROM screenings WHERE id = :screeningId
          )
      ');
$stmt->bindParam(':screeningId', $screeningId, PDO::PARAM_INT);
$stmt->execute();
$seats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CineReserve</title>
  <link rel="stylesheet" href="../Public/css/reserve.css" />
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const reserveBtn = document.querySelector(".reserve-btn");
      const selectedSeats = new Set();

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

        fetch("/reserveSeats", {
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
              alert("Failed to reserve seats.");
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
        <h2>Featured Movie</h2>
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
        <?php
        // Renderowanie siatki miejsc
        echo '<div class="seating">';
        foreach ($seats as $seat) {
          $class = in_array($seat['id'], $reservedSeats) ? 'seat reserved' : 'seat available';
          echo "<div class='$class' data-row='{$seat['seat_row']}' data-seat='{$seat['seat_number']}'></div>";
        }
        echo '</div>';
        ?>
      </div>

      <button class="reserve-btn">Reserve Seats</button>
    </section>
  </main>
</body>

</html>