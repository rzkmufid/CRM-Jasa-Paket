-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 08:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shipment_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `nama_client` varchar(100) NOT NULL,
  `jenis_barang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `nama_client`, `jenis_barang`) VALUES
(8, 'PT. Cendana Sembilan', 'Semen'),
(9, 'PT. Meroke Tetap Jaya', 'Pupuk'),
(10, 'PT. Dohar Hara Indonesia', 'Batu Bara');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` int(11) NOT NULL,
  `nama_supir` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `plat` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `nama_supir`, `alamat`, `plat`) VALUES
(9, 'Novriansyah Ega Saputra', 'Padang', 'BA 8219 QU'),
(10, 'Bobby Efendi', 'Payakumbuh', 'BE 9766 GM'),
(11, 'Doli', 'Padang', 'B 9296 UYT'),
(12, 'Randi Putra', 'Solok', 'BH 8806 LK'),
(13, 'Muhammad Faud', 'Solok', 'BA 8810 MJ'),
(14, 'Bara Erlangga Putra', 'Solok', 'BA 9709 MZ'),
(15, 'Romi Zelmiko', 'Padang', 'BA 9705 MZ'),
(16, 'Evan Galista', 'Pariaman', 'BA 9711 MP'),
(17, 'Jony Putra', 'Painan', 'BM 9308 RO'),
(18, 'Jerry Gustian', 'Pesisir Selatan', 'BA 8584 LU'),
(19, 'Jasril', 'Medan', 'BA 8742 GB'),
(20, 'Arusman', 'Pesisir Selatan', 'BA 8685 MZ'),
(21, 'Rinto', 'Bukittinggi', 'BD 8126 CK'),
(22, 'Yurnadi', 'Jambi', 'BM 9965 ZU');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `warehouse_id` int(11) NOT NULL,
  `nama_gudang` varchar(100) NOT NULL,
  `alamat_gudang` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`warehouse_id`, `nama_gudang`, `alamat_gudang`) VALUES
(6, 'PT. Semen Padang', 'Padang'),
(7, 'PT. HABI', 'Dumai'),
(8, 'PT. Caritas Energi Indonesia', 'Jambi');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `pengiriman_id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `muatan` float DEFAULT NULL,
  `jenis_barang` varchar(255) DEFAULT NULL,
  `target_pengiriman` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `tujuan_bongkar` varchar(255) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `realisasi_pengiriman` int(11) DEFAULT NULL,
  `tanggal_bongkar` date DEFAULT NULL,
  `keterlambatan` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`pengiriman_id`, `tanggal`, `client_id`, `muatan`, `jenis_barang`, `target_pengiriman`, `warehouse_id`, `tujuan_bongkar`, `driver_id`, `realisasi_pengiriman`, `tanggal_bongkar`, `keterlambatan`, `harga`) VALUES
(20, '2024-07-02', 9, 18.75, 'Pupuk', 4, 7, 'Muara Enim', 19, 4, '2024-07-06', 0, 9375000.00),
(21, '2024-07-02', 9, 22.5, 'Pupuk', 4, 8, 'Padang', 21, NULL, NULL, NULL, 4950000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `asal` varchar(225) NOT NULL,
  `tujuan` varchar(225) NOT NULL,
  `tarif_perton` int(11) NOT NULL,
  `estimasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `asal`, `tujuan`, `tarif_perton`, `estimasi`) VALUES
(1, 'Padang', 'Jambi', 220000, 3),
(2, 'Padang', 'Bengkulu', 250000, 3),
(3, 'Dumai', 'Jambi', 320000, 3),
(4, 'Dumai', 'Bengkulu', 450000, 4),
(5, 'Padang', 'Sungai Penuh', 180000, 2),
(6, 'Dumai', 'Muara Enim', 500000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(3, 'admin', 'admin@admin.com', 'admin'),
(4, 'mufid', 'mufid@gmail', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`pengiriman_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `pengiriman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `pengiriman_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `gudang` (`warehouse_id`),
  ADD CONSTRAINT `pengiriman_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
