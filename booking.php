<?php
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='index.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $nama = $_POST["nama"];
    $plat = $_POST["plat"];
    $tanggal_masuk = $_POST["tanggal_masuk"] . ' ' . $_POST["waktu_masuk"];
    $tanggal_keluar = $_POST["tanggal_keluar"] . ' ' . $_POST["waktu_keluar"];

    $datetime_masuk = new DateTime($tanggal_masuk);
    $datetime_keluar = new DateTime($tanggal_keluar);
    $interval = $datetime_masuk->diff($datetime_keluar);
    $durasi = ceil(($interval->days * 24) + ($interval->h) + ($interval->i / 60));

    $slot = $_POST["slot"];
    $kendaraan = $_POST["kendaraan"];
    $pembayaran = $_POST["pembayaran"];

    $harga_per_jam = ($kendaraan == "motor") ? 5000 : (($kendaraan == "mobil") ? 10000 : 13000);
    $total_harga = $harga_per_jam * $durasi;

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, nama, plat, tanggal_masuk, tanggal_keluar, durasi, slot, kendaraan, pembayaran, harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issssisssi", $user_id, $nama, $plat, $tanggal_masuk, $tanggal_keluar, $durasi, $slot, $kendaraan, $pembayaran, $total_harga);

    if ($stmt->execute()) {
        $last_id = $stmt->insert_id;
        echo "<script>window.location.href='struk.php?id=$last_id';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal booking!'); window.location.href='booking.php';</script>";
    }
}

$allSlots = [
    "C01", "C02", "C03", "C04",
    "C05", "C06", "C07", "C08",
    "C09", "C10", "C11", "C12",
    "C13", "C14", "C15", "C16"
];

function generateSlots($allSlots) {
    $html = '';
    foreach ($allSlots as $slot) {
        $html .= "<div class='slot' data-slot='$slot'>$slot</div>";
    }
    return $html;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Booking Lahan Parkir - Parkinc</title>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
  *, *::before, *::after { box-sizing: border-box; }
  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-image: url('img/booking.jpg');
    background-size: auto;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    color: #374151;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  a {
    text-decoration: none;
    color: inherit;
  }
  a:focus,
  button:focus {
    outline: 3px solid #a3bffa;
    outline-offset: 2px;
  }
  .container {
    max-width:550px;
    width: 80%;
    margin: 2rem auto;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  }
  header {
    background: rgba(255, 255, 255, 0);
    padding: 1rem 5vw;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  header h1 {
    font-family: 'Dancing Script', cursive;
    font-weight: 600;
    font-size: 48px;
    color: #111827;
    margin: 0;
    user-select: none;
  }
  nav {
    display: flex;
    gap: 2rem;
  }
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
  h2 {
    font-size: 2rem;
    color: #111827;
    margin-bottom: 1.5rem;
    text-align: center;
  }

  label {
    display: block;
    margin-top: 1rem;
    font-weight: 600;
    color: rgb(16, 16, 16);
  }

  input, select {
    width: 100%;
    padding: 0.75rem;
    margin-top: 0.5rem;
    border: 1px solid rgba(209, 213, 219, 2);
    border-radius: 0.5rem;
    font-size: 1rem;
    color: #111827;
    background-color: rgba(255, 255, 255, 2);
  }

  input:focus, select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
  }

  button {
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    margin-top: 2rem;
    transition: background-color 0.3s ease;
    width: 100%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  button:hover {
    background: #1e40af;
  }


  .slots {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 10px;
  }

  .slot {
    padding: 15px;
    border: 2px dashed #999;
    text-align: center;
    border-radius: 6px;
    cursor: pointer;
    background-color: #e8e8e8;
  }

  .slot.selected {
    background-color: #16a085;
    color: white;
    font-weight: bold;
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
    <nav>
      <a href="homepage.html">Home</a>
      <a href="riwayat.php">Riwayat</a>
      <a href="#" onclick="logout(event)">Logout</a>
    </nav>
  </header>

  <main class="container">
    <h2>Booking Lahan Parkir</h2>
    <form method="post">
      <label for="nama">Nama</label>
      <input type="text" id="nama" name="nama" required>

      <label for="plat">Plat Nomor</label>
      <input type="text" id="plat" name="plat" required>

      <label for="tanggal_masuk">Tanggal Masuk</label>
      <input type="date" id="tanggal_masuk" name="tanggal_masuk" required>

      <label for="waktu_masuk">Waktu Masuk</label>
      <input type="time" id="waktu_masuk" name="waktu_masuk" required>

      <label for="tanggal_keluar">Tanggal Keluar</label>
      <input type="date" id="tanggal_keluar" name="tanggal_keluar" required>

      <label for="waktu_keluar">Waktu Keluar</label>
      <input type="time" id="waktu_keluar" name="waktu_keluar" required>

      <label>Pilih Slot Parkir</label>
      <div class="slots" id="slotContainer">
        <?php echo generateSlots($allSlots); ?>
      </div>
      <input type="hidden" id="slot" name="slot" required>

      <label for="kendaraan">Jenis Kendaraan</label>
      <select id="kendaraan" name="kendaraan" required>
        <option value="motor">Motor (Rp 5.000)</option>
        <option value="mobil">Mobil (Rp 10.000)</option>
        <option value="truk">Truk (Rp 13.000)</option>
      </select>

      <label for="pembayaran">Metode Pembayaran</label>
      <select id="pembayaran" name="pembayaran" required>
        <option value="Cash">Cash</option>
        <option value="Dana">Dana</option>
        <option value="BCA">BCA</option>
        <option value="QRIS">QRIS</option>
      </select>

      <button type="submit">Pesan Sekarang</button>
    </form>
  </main>

  <footer>
    &copy; 2025 Parkinc. All rights reserved.
  </footer>

  <script>
    const slots = document.querySelectorAll('.slot');
    const slotInput = document.getElementById('slot');
    const metodePembayaran = document.getElementById('pembayaran');
    const qrisSection = document.getElementById('qrisSection');

    slots.forEach(slot => {
      slot.addEventListener('click', function () {
        slots.forEach(s => s.classList.remove('selected'));
        this.classList.add('selected');
        slotInput.value = this.dataset.slot;
      });
    });

    metodePembayaran.addEventListener('change', function () {
      qrisSection.style.display = this.value === 'QRIS' ? 'block' : 'none';
    });

    function logout(event) {
      event.preventDefault();
      localStorage.removeItem("loggedInUser");
      alert("Logout berhasil!");
      window.location.href = "homepage.html";
    }
  </script>
</body>
</html>
