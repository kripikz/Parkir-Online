<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION["user_id"];


if (isset($_GET['cancel'])) {
    $cancel_id = intval($_GET['cancel']);
    
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cancel_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking berhasil dibatalkan!'); window.location.href='riwayat.php';</script>";
        exit;
    } else {
        echo "Gagal membatalkan booking: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $plat = $_POST["plat"];
    $slot = $_POST["slot"];
    $durasi = $_POST["durasi"];
    $tanggal_masuk = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, nama, plat, slot, durasi, tanggal_masuk) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $user_id, $nama, $plat, $slot, $durasi, $tanggal_masuk);

    if ($stmt->execute()) {
        echo "<script>alert('Booking berhasil!'); window.location.href='riwayat.php';</script>";
        exit;
    } else {
        echo "Gagal menyimpan data booking: " . $conn->error;
    }
}

$query = "SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Booking - Parkinc</title>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f3f4f6;
      color: #374151;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    a { text-decoration: none; color: inherit; }
    a:focus, button:focus { outline: 3px solid #a3bffa; outline-offset: 2px; }
    header {
      position: sticky;
      top: 0;
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
      padding: 1rem 5vw;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
    }
    header h1 {
      font-family: 'Dancing Script', cursive;
      font-weight: 600;
      font-size: 48px;
      color: #111827;
      margin: 0;
      user-select: none;
    }
    nav { display: flex; gap: 2rem; }
    nav a {
      font-weight: 600;
      font-size: 1rem;
      color: #374151;
      padding: 0.25rem 0.5rem;
      border-radius: 0.5rem;
      transition: background-color 0.3s ease, color 0.3s ease;
      user-select: none;
    }
    nav a:hover, nav a:focus {
      background-color: #2563eb;
      color: #fff;
      outline: none;
    }
    .container {
      max-width: 800px;
      width: 90%;
      margin: 2rem auto;
      padding: 2.5rem;
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    h2 {
      font-size: 2rem;
      color: #111827;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background:rgb(197, 198, 201);
      color: black;
    }
    .btn-cancel {
      background: red;
      color: white;
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 14px;
    }
    .btn-cancel:hover {
      background: darkred;
    }
    footer {
      border-top: 1px solid #e5e7eb;
      text-align: center;
      font-size: 14px;
      color: #9ca3af;
      padding: 1.5rem 5vw;
      user-select: none;
    }
  </style>
</head>
<body>
  <header>
    <h1>Parkinc</h1>
    <nav role="navigation" aria-label="Primary">
      <a href="homepage.html">homepage</a>
      <a href="booking.php">booking</a>
      <a href="#" onclick="logout(event)">logout</a>
    </nav>
  </header>

  <main class="container" role="main">
    <h2>Riwayat Booking Anda</h2>
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Plat</th>
          <th>Tanggal Masuk</th>
          <th>Slot</th>
          <th>Durasi</th>
          <th>Waktu Booking</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row["nama"]) ?></td>
          <td><?= htmlspecialchars($row["plat"]) ?></td>
          <td><?= htmlspecialchars($row["tanggal_masuk"]) ?></td>
          <td><?= htmlspecialchars($row["slot"]) ?></td>
          <td><?= htmlspecialchars($row["durasi"]) ?> jam</td>
          <td><?= htmlspecialchars($row["created_at"]) ?></td>
          <td>
            <a class="btn-cancel" href="riwayat.php?cancel=<?= $row["id"] ?>" onclick="return confirm('Yakin ingin membatalkan booking ini?')">Batalkan</a>
          </td>
        </tr>
        <?php
          endwhile;
        else:
        ?>
        <tr><td colspan="8" style="text-align:center;">Belum ada data booking.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

  <footer>
    &copy; 2025 Parking. All rights reserved.
  </footer>

  <script>
    function logout(event) {
      event.preventDefault();
      localStorage.removeItem("loggedInUser");
      alert("Logout berhasil!");
      window.location.href = "homepage.html";
    }
  </script>
</body>
</html>
