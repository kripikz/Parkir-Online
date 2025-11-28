<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                $ip_address = $_SERVER['REMOTE_ADDR'];
                $stmt_log = $conn->prepare("INSERT INTO login_logs (user_id, ip_address) VALUES (?, ?)");
                $stmt_log->bind_param("is", $user['id'], $ip_address);
                $stmt_log->execute();

                header("Location: homepage.html");
                exit();
            } else {
                echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Username tidak ditemukan!'); window.location.href='index.php';</script>";
        }
    } elseif (isset($_POST["signup"])) {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $username = $_POST["signup_username"];
        $password = $_POST["signup_password"]; 

        $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $email, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Email atau username sudah digunakan!'); window.location.href='index.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login & Sign Up - Parking</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { width: 100%; height: 100%; }
    body { font-family: 'Poppins', sans-serif; display: flex; justify-content: center; align-items: center; background: #f8f9fa; }
    .container { display: flex; width: 100vw; height: 100vh; }
    .form-section { width: 350px; padding: 2rem; display: flex; flex-direction: column; justify-content: center; background: #f3f3f3; }
    h2 { font-size: 1.8rem; margin-bottom: 1.5rem; color: #333; text-align: center; }
    .form input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
    .form button { width: 100%; padding: 12px; border-radius: 6px; border: none; font-size: 1rem; background: #333; color: white; cursor: pointer; font-weight: 600; transition: background 0.3s; }
    .form button:hover { background: #555; }
    .extra-text { text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #555; }
    .image-section { flex: 1; display: flex; justify-content: center; align-items: center; background:white; }
    .image-section img { max-width: 100%; height:100%; }
    #signup-form { display: none; }
  </style>
</head>
<body>

  <div class="container">
    <div class="form-section">
      <div id="login-form">
        <h2>Masuk ke Parking</h2>
        <form class="form" method="post">
          <input type="text" name="username" placeholder="Nama Pengguna" required>
          <input type="password" name="password" placeholder="Kata Sandi" required>
          <button type="submit" name="login">Masuk</button>
        </form>
        <div class="extra-text">
          <p>Belum punya akun? <a href="#" onclick="showSignup()">Daftar di sini</a></p>
        </div>
      </div>

      <div id="signup-form">
        <h2>Daftar Akun Parking</h2>
        <form class="form" method="post">
          <input type="text" name="fullname" placeholder="Nama Lengkap" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="text" name="signup_username" placeholder="Nama Pengguna" required>
          <input type="password" name="signup_password" placeholder="Kata Sandi" required>
          <button type="submit" name="signup">Daftar</button>
        </form>
        <div class="extra-text">
          <p>Sudah punya akun? <a href="#" onclick="showLogin()">Masuk di sini</a></p>
        </div>
      </div>
    </div>

    <div class="image-section">
      <img src="img/auth.gif" alt="Gambar">
    </div>
  </div>

  <script>
    function showSignup() {
      document.getElementById("login-form").style.display = "none";
      document.getElementById("signup-form").style.display = "block";
    }

    function showLogin() {
      document.getElementById("signup-form").style.display = "none";
      document.getElementById("login-form").style.display = "block";
    }
  </script>

</body>
</html>