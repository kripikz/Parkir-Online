-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Okt 2025 pada 11.07
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkinc_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `plat` varchar(50) NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `durasi` int(11) NOT NULL,
  `slot` varchar(50) NOT NULL,
  `kendaraan` varchar(50) NOT NULL,
  `pembayaran` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal_keluar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `nama`, `plat`, `tanggal_masuk`, `durasi`, `slot`, `kendaraan`, `pembayaran`, `harga`, `created_at`, `tanggal_keluar`) VALUES
(20, 12, 'cessari damova', '1222', '2025-07-09 03:02:00', 1, 'C01', 'motor', 'Cash', 5000, '2025-06-30 20:02:00', '2025-07-09 04:02:00'),
(21, 12, 'cess', 'f 1313 pp', '2025-07-03 10:38:00', 5, 'C02', 'mobil', 'QRIS', 50000, '2025-07-03 01:39:09', '2025-07-03 14:39:00'),
(23, 17, 'cessaro', 'f 1313 pp', '2025-10-22 21:37:00', 143, 'C01', 'motor', 'Cash', 715000, '2025-10-09 11:37:43', '2025-10-29 20:37:00'),
(24, 17, 'cessaro', 'f 1238 cc', '2025-10-22 23:37:00', 143, 'C01', 'motor', 'QRIS', 715000, '2025-10-09 11:38:15', '2025-10-28 21:38:00'),
(25, 18, 'fikri', 'f1492kg', '2025-10-09 11:00:00', 72, 'C01', 'truk', 'BCA', 936000, '2025-10-16 13:21:57', '2025-10-12 11:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `login_time`, `ip_address`) VALUES
(1, 11, '2025-06-09 14:16:07', '::1'),
(2, 11, '2025-06-10 03:23:39', '::1'),
(3, 11, '2025-06-10 10:20:30', '::1'),
(4, 12, '2025-06-10 13:19:11', '::1'),
(5, 12, '2025-06-10 13:32:29', '::1'),
(6, 12, '2025-06-10 17:14:04', '::1'),
(7, 12, '2025-06-11 01:16:04', '::1'),
(8, 13, '2025-06-11 02:29:48', '::1'),
(9, 12, '2025-06-11 12:05:44', '::1'),
(10, 12, '2025-06-11 17:08:34', '::1'),
(11, 12, '2025-06-12 05:27:53', '::1'),
(12, 12, '2025-06-12 05:36:28', '::1'),
(13, 14, '2025-06-12 11:52:58', '::1'),
(14, 12, '2025-06-14 11:47:26', '::1'),
(15, 12, '2025-06-14 13:44:01', '::1'),
(16, 12, '2025-06-18 21:35:37', '::1'),
(17, 12, '2025-06-18 21:48:55', '::1'),
(18, 12, '2025-06-19 04:18:11', '::1'),
(19, 12, '2025-06-19 04:19:28', '::1'),
(20, 12, '2025-06-19 04:35:51', '::1'),
(21, 12, '2025-06-19 05:42:08', '::1'),
(22, 12, '2025-06-19 07:42:58', '::1'),
(23, 12, '2025-06-19 10:47:20', '::1'),
(24, 12, '2025-06-22 15:55:46', '::1'),
(25, 12, '2025-06-22 16:00:50', '::1'),
(26, 12, '2025-06-22 17:50:31', '::1'),
(27, 12, '2025-06-23 09:30:24', '::1'),
(28, 12, '2025-06-23 09:37:35', '::1'),
(29, 12, '2025-06-26 04:23:02', '::1'),
(30, 12, '2025-06-26 04:24:17', '::1'),
(31, 12, '2025-06-26 04:40:12', '::1'),
(32, 12, '2025-06-26 23:50:10', '::1'),
(33, 12, '2025-06-27 08:12:39', '::1'),
(34, 12, '2025-06-30 19:53:08', '::1'),
(35, 12, '2025-07-03 01:35:31', '::1'),
(36, 16, '2025-07-03 04:32:37', '::1'),
(37, 17, '2025-10-09 11:37:00', '::1'),
(38, 18, '2025-10-16 13:21:01', '::1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tempat_parkir`
--

CREATE TABLE `tempat_parkir` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `status` enum('tersedia','terisi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`) VALUES
(9, 'cessaro damova', 'damova712@gmail.com', 'ero', '1234'),
(10, 'rii', 'cessarodamova76@sma.belajar.id', 'rii', '$2y$10$MQEMFJm4E245H1JicmA/8evQUFfJ5ph/t1urW85RHEh'),
(11, 'ff', 'ffgg@gmail.com', 'ffr', 'ffr12345'),
(12, 'cessaro damova', 'admin@gmail.com', 'admin', 'admin12345'),
(13, 'julius', 'julius@gmail.com', 'jupet', '2810'),
(14, 'fikri darmawan', 'fikcoy14@gmail.com', 'kripikz', 'darmawan14'),
(15, 'ero', 'erliccodmva@gmail.com', 'ero', 'ero12345'),
(16, 'css', 'da213@gmail.com', 'acc', 'acc'),
(17, 'oces', 'oces@gmail.com', 'oces', '12345678'),
(18, 'fikri', 'fik14@gmail.com', 'fikri', '1234');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`created_at`);

--
-- Indeks untuk tabel `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tempat_parkir`
--
ALTER TABLE `tempat_parkir`
  ADD KEY `id` (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `tempat_parkir`
--
ALTER TABLE `tempat_parkir`
  ADD CONSTRAINT `tempat_parkir_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
