<?php 
include 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

if (!isset($_GET["id"])) {
    echo "<script>alert('ID Booking tidak ditemukan!'); window.location.href='booking.php';</script>";
    exit;
}

$booking_id = intval($_GET["id"]);
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "<script>alert('Data booking tidak ditemukan!'); window.location.href='booking.php';</script>";
    exit;
}

// Hitung durasi secara otomatis dari tanggal_masuk dan tanggal_keluar
$masuk = new DateTime($booking['tanggal_masuk']);
$keluar = new DateTime($booking['tanggal_keluar']);
$interval = $masuk->diff($keluar);
$durasi_jam = ceil(($interval->days * 24) + $interval->h + ($interval->i / 60));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Booking Parkir</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f1f1f1;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .receipt {
      background: #fff;
      padding: 30px;
      max-width: 420px;
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      position: relative;
      overflow: hidden;
    }

    .receipt::before,
    .receipt::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 30px;
      background: repeating-linear-gradient(-45deg, #fff, #fff 8px, #f1f1f1 8px, #f1f1f1 16px);
      left: 0;
    }

    .receipt::before { top: -15px; }
    .receipt::after { bottom: -15px; }

    h2 {
      text-align: center;
      color: #16a085;
      margin-bottom: 20px;
    }

    .receipt-info {
      font-size: 16px;
      line-height: 1.8;
      color: #333;
    }

    .receipt-info strong {
      display: inline-block;
      width: 130px;
    }

    canvas, #qrcode {
      display: block;
      margin: 20px auto;
      border: 1px dashed #ccc;
      padding: 10px;
      background: #fafafa;
    }

    .btn {
      display: inline-block;
      margin-top: 20px;
      background: #16a085;
      color: #fff;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .btn:hover { background: #13876f; }

    .line {
      border-top: 2px dashed #ccc;
      margin: 20px 0;
    }

    #qrcode { display: none; }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
  <script>
    window.onload = function () {
      const metode = "<?php echo $booking['pembayaran']; ?>";
      if (metode === "QRIS") {
        const qr = document.getElementById("qrcode");
        qr.style.display = "block";
        new QRCode(qr, {
          text: "ID: <?php echo $booking['id']; ?> | Nama: <?php echo $booking['nama']; ?> | Plat: <?php echo $booking['plat']; ?> | Slot: <?php echo $booking['slot']; ?> | Harga: Rp <?php echo number_format($booking['harga'], 0, ',', '.'); ?>",
          width: 128,
          height: 128
        });
      }

      window.print(); // otomatis print
    };
  </script>
</head>
<body>
  <div class="receipt">
    <h2>Struk Booking Parkir</h2>
    <div class="receipt-info">
      <strong>Nama:</strong> <?php echo htmlspecialchars($booking['nama']); ?><br>
      <strong>Plat Nomor:</strong> <?php echo htmlspecialchars($booking['plat']); ?><br>
      <strong>Masuk:</strong> <?php echo htmlspecialchars($booking['tanggal_masuk']); ?><br>
      <strong>Keluar:</strong> <?php echo htmlspecialchars($booking['tanggal_keluar']); ?><br>
      <strong>Durasi:</strong> <?php echo $durasi_jam; ?> jam<br>
      <strong>Slot:</strong> <?php echo htmlspecialchars($booking['slot']); ?><br>
      <strong>Pembayaran:</strong> <?php echo htmlspecialchars($booking['pembayaran']); ?><br>
      <strong>Total Harga:</strong> Rp <?php echo number_format($booking['harga'], 0, ',', '.'); ?><br>
    </div>
    <div class="line"></div>
    <div id="qrcode"></div>
    <div style="text-align: center;">
      <a href="homepage.html" class="btn">Kembali ke Home</a>
    </div>
  </div>
</body>
</html>
