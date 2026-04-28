-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2026 at 06:11 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_minuman`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int NOT NULL,
  `transaksi_id` int DEFAULT NULL,
  `produk_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `qty`, `subtotal`) VALUES
(1, 1, 1, 1, 150000),
(2, 1, 2, 1, 200000),
(3, 2, 1, 1, 150000),
(4, 2, 2, 1, 200000),
(5, 3, 2, 1, 200000),
(6, 4, 2, 1, 200000),
(7, 4, 3, 1, 50000),
(8, 5, 1, 3, 450000),
(9, 6, 1, 2, 300000),
(10, 6, 3, 1, 50000),
(11, 6, 2, 1, 200000),
(12, 7, 1, 1, 150000),
(13, 7, 3, 1, 50000),
(14, 8, 3, 1, 50000),
(15, 9, 3, 1, 50000),
(16, 10, 2, 2, 400000),
(17, 11, 2, 1, 200000),
(18, 11, 3, 1, 50000),
(19, 12, 2, 1, 200000),
(20, 12, 3, 1, 50000),
(21, 13, 3, 1, 50000),
(22, 13, 2, 1, 200000),
(23, 14, 3, 1, 50000),
(24, 15, 5, 1, 150000),
(25, 15, 4, 1, 100000),
(26, 16, 2, 1, 200000),
(27, 17, 2, 1, 200000),
(28, 18, 5, 1, 150000),
(29, 19, 4, 1, 100000),
(30, 19, 3, 1, 50000),
(31, 20, 4, 1, 100000),
(32, 20, 5, 1, 150000),
(33, 20, 2, 1, 200000),
(34, 21, 5, 1, 150000),
(35, 21, 3, 1, 50000),
(36, 21, 1, 1, 200000),
(37, 22, 4, 1, 100000),
(38, 23, 4, 1, 100000),
(39, 24, 3, 1, 50000),
(40, 25, 3, 1, 50000),
(41, 26, 1, 1, 200000),
(42, 27, 4, 1, 100000),
(43, 27, 3, 1, 50000),
(44, 28, 2, 1, 200000),
(45, 28, 3, 1, 50000),
(46, 29, 1, 1, 200000),
(47, 29, 5, 1, 150000),
(48, 30, 1, 1, 200000),
(49, 30, 3, 1, 50000),
(50, 30, 4, 1, 100000),
(51, 31, 1, 1, 200000),
(52, 32, 4, 1, 100000),
(53, 32, 3, 1, 50000),
(54, 32, 2, 1, 200000),
(55, 33, 5, 1, 150000),
(56, 33, 2, 1, 200000),
(57, 33, 1, 1, 200000),
(58, 34, 4, 1, 100000),
(59, 34, 3, 1, 50000),
(60, 34, 5, 1, 150000),
(61, 35, 5, 1, 150000),
(62, 35, 2, 1, 200000),
(63, 36, 14, 1, 200000),
(64, 36, 10, 1, 200000),
(65, 37, 7, 1, 200000),
(66, 38, 8, 1, 200000),
(67, 39, 8, 1, 200000),
(68, 39, 12, 2, 400000),
(69, 39, 13, 1, 200000),
(70, 40, 11, 1, 200000),
(71, 40, 7, 1, 200000),
(72, 40, 13, 1, 200000),
(73, 41, 15, 1, 200000),
(74, 41, 16, 1, 200000),
(75, 42, 8, 1, 200000),
(76, 43, 8, 1, 200000),
(77, 44, 8, 1, 200000),
(78, 44, 13, 1, 200000),
(79, 45, 14, 1, 200000),
(80, 46, 8, 1, 200000),
(81, 47, 8, 1, 200000),
(82, 47, 14, 1, 200000),
(83, 47, 11, 1, 200000),
(84, 47, 20, 1, 200000),
(85, 47, 19, 1, 200000),
(86, 48, 26, 1, 200000),
(87, 48, 22, 1, 200000),
(88, 49, 26, 1, 200000),
(89, 49, 25, 2, 400000),
(90, 49, 22, 2, 400000),
(91, 49, 21, 1, 200000),
(92, 49, 24, 1, 200000),
(93, 49, 23, 1, 200000),
(94, 49, 20, 1, 200000),
(95, 49, 19, 1, 200000),
(96, 50, 13, 1, 200000),
(97, 51, 9, 1, 200000),
(98, 51, 8, 1, 200000),
(99, 52, 13, 1, 200000),
(100, 52, 11, 1, 200000),
(101, 53, 9, 1, 200000),
(102, 53, 13, 1, 200000),
(103, 54, 13, 1, 200000),
(104, 54, 9, 1, 200000),
(105, 54, 12, 1, 200000),
(106, 54, 11, 1, 200000),
(107, 54, 8, 1, 200000),
(108, 55, 13, 4, 800000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `modal` int DEFAULT NULL,
  `diskon` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`, `gambar`, `modal`, `diskon`) VALUES
(6, 'Singaraja besar botol 620ml', 200000, 'Singaraja besar botol.jpg', NULL, 0),
(7, 'Frost besar botol 620ml ', 200000, 'frost besar botol 620ml.jpg', NULL, 0),
(8, 'Rajawali frost 620ml ', 200000, 'Rajawali Frost 620ml.jpg', NULL, 0),
(9, 'bae soju original', 200000, 'bae soju ori.jpg', NULL, 0),
(10, 'bae soju lychee', 200000, 'bae soju leci.jpg', NULL, 0),
(11, 'bae soju plum', 200000, 'bae soju plum.jpg', NULL, 0),
(12, 'bae soju yuzu', 200000, 'bae soju yuzu.jpg', NULL, 0),
(13, 'Anggur merah besar 620ml', 200000, 'anggur merah besar 620ml.jpg', NULL, 0),
(14, 'anggur merah kecil 275ml', 200000, 'anggur merah kecil.jpg', NULL, 0),
(15, 'Anggur merah gold besar 620ml', 200000, 'anggur merah gold besar 620ml.jpg', NULL, 0),
(16, 'Anggur merah gold kecil 275ml', 200000, 'anggur merah gold kecil 275ml.jpg', NULL, 0),
(17, 'Anggur ketan hitam besar 620ml', 200000, 'anggur ketan hitam besar 620ml.png', NULL, 0),
(18, 'Anggur merah premium 620ml', 200000, 'anggur merah premium.jpg', NULL, 0),
(19, 'Arak obat besar 275ml ', 200000, 'arak obat kecil 275ml.jpg', NULL, 0),
(20, 'OT anggur hitam intisari 620ml', 200000, 'OT anggur hitam intisari 620ml.jpg', NULL, 0),
(21, 'OT anggur hitam intisari 275ml', 200000, 'OT anggur hitam intisari 275ml.jpg', NULL, 0),
(22, 'OT intisari black current 620ml', 200000, 'OT intisari black current 620ml.jpg', NULL, 0),
(23, 'OT intisari black current 275ml', 200000, 'OT intisari black current 275ml.jpg', NULL, 0),
(24, 'OT anggur hijau API putih', 200000, 'OT anggur hijau api putih 620ml.jpg', NULL, 0),
(25, 'OT anggur hijau API hijau 620ml', 200000, 'OT anggur hijau API hijau 620ml.jpg', NULL, 0),
(26, 'Intisari anggur hijau 620ml', 200000, 'intisari anggur hijau 620ml.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `total` int DEFAULT NULL,
  `metode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `total`, `metode`) VALUES
(54, '2026-04-23 18:33:05', 1000000, 'cash'),
(55, '2026-04-23 18:43:22', 800000, 'cash');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
