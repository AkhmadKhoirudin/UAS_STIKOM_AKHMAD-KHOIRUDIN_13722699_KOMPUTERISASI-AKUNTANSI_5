-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jan 2025 pada 12.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT 'unread',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `order_id`, `user_id`, `message`, `type`, `status`, `created_at`) VALUES
(3, 2, 1, 'Order ID 2 diubah status menjadi Terima.', 'status_update', 'unread', '2024-12-20 00:57:25'),
(4, 3, 0, '', '', 'Proses', '0000-00-00 00:00:00'),
(5, 3, 0, '', '', 'Proses', '0000-00-00 00:00:00'),
(6, 2, 0, '', '', 'Proses', '0000-00-00 00:00:00'),
(7, 3, 1, 'Order ID 3 diubah status menjadi Terima.', 'status_update', 'unread', '2025-01-15 12:37:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `shipping_method` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `name`, `address`, `phone`, `email`, `payment_method`, `shipping_method`, `created_at`, `status`) VALUES
(2, 'Akhmad Khoirudin', 'desa:kreyo block:2 kebon:saron', '081322878692', 'akhmadwibu05@outlook.com', 'credit_card', 'standard', '2024-12-19 23:28:24', 'Terima'),
(3, 'Akhmad Khoirudin', 'desa:kreyo block:2 kebon:saron', '081322878692', 'akhmadwibu05@outlook.com', 'bank_transfer', 'express', '2025-01-05 15:05:06', 'Terima');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(3, 2, 'Kue & Cupcake', 1, 90000.00),
(4, 2, 'Brownies & Bar', 1, 30000.00),
(5, 2, 'Bolen Keju', 1, 45000.00),
(6, 3, 'Kue & Cupcake', 1, 90000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stok`, `image`) VALUES
(14, 'kue bolean', 'rasa jawah asli', 900000.00, 9, 'src/img/prodak/bolencoklan.jpg'),
(15, 'Bolen Coklat', 'oklat lumer yang menggoda dalam balutan kue renyah. Camilan sempurna untuk setiap momen', 50000.00, 0, 'src/img/prodak/coklat.jpg'),
(16, 'Bolen Keju', 'Kue gurih dengan isian keju premium. Setiap gigitan membuat Anda ketagihan', 45000.00, 0, 'src/img/prodak/keju.jpg'),
(17, 'Bolen Keju  Coklat', 'Kombinasi nikmat antara gurihnya keju dan manisnya coklat. Rasakan kelezatan dalam satu gigitan', 60000.00, 0, 'src/img/prodak/coklatkeju.jpg'),
(18, 'Kue & Cupcake', 'Pilih dari koleksi kue rumahan kami yang\r\nluar biasa', 90000.00, 0, 'src/img/prodak/cake.png'),
(19, 'Brownies & Bar', 'Dibuat dengan banyak cinta dan ekstra\r\ncokelat fudge', 30000.00, 0, 'src/img/prodak/brownis.png'),
(20, 'Kue Kering', 'Kenyal, berisi, mewah, dan selalu dipanggang segar.', 20000.00, 0, 'src/img/prodak/cokis.png'),
(21, 'Craquelin Origina', 'Nikmati kelezatan renyah dari Craquelin Original. Camilan gurih klasik yang sempurna untuk setiap momen santai.', 80000.00, 0, 'src/img/prodak/originalCraquelin.jpg'),
(22, 'Craquelin Strawberry', 'Rasakan kesegaran stroberi dalam setiap gigitan Craquelin Strawberry. Camilan manis yang cocok untuk pencinta buah!', 80000.00, 0, 'src/img/prodak/strobery.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `foto` varchar(225) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `alamat`, `no`, `username`, `password`, `email`, `status`, `foto`, `created_at`) VALUES
(5, 'akhmad', 'desakre', '0813222878692', 'neko', '$2y$10$7kP1h2ukgqS0weoLD.hUMO9kpLD.d66B3bw0hzl/pxy1O4RotPTIu', 'neko@gmail.com', 'admin', 'uploads/Desain_tanpa_judul-removebg-preview.png', '2024-12-19 00:02:17'),
(9, 'Akhmad Khoirudin', 'desa:kreyo block:2 kebon:saron', '081322878692', 'nur', '$2y$10$6Ne4qajV.igcncYmS.OzP.cfkJ5WmRfF2NJc6bFIdeKw3CoCDbJdq', 'akhmadwibu05@outlook.com', 'admin', '', '2025-01-02 07:43:39'),
(24, 'akhmad', 'neko', '081322878692', 'admin', '$2y$10$L1Lq9Y0mq8nO/Zas6bn7e.wsS0hK7AFa5PfJkzKOT/nKebtwlGnJ2', 'dasd@gmail.com', 'aktif', '', '2025-01-13 09:39:44'),
(25, 'udin', 'desa:kreyo block:2 kebon:saron', '081322878692', 'nurkanda', '$2y$10$.6GyGaaOV.BVmO/1561F8uR/xgyzSXFdnD1ymdD5ngBNyjuWjJwPa', 'akhmaddfwibu05@outlook.com', 'aktif', '', '2025-01-13 09:50:12'),
(43, '', '', '', 'fsdfvdxvx', '$2y$10$IyBG2uPIHJ4VxVJFbeyCS.dJBVPJNWGwz8d9UnG44fETRDx91SFeC', 'fdsfds@gmail.com', '', '', '2025-01-22 13:16:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
