-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2020 at 04:26 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` char(10) NOT NULL,
  `nama_barang` varchar(40) DEFAULT NULL,
  `kode_kategori` char(5) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `kode_kategori`, `harga`, `keterangan`, `id_member`, `foto`) VALUES
('B0001', 'Coca-Cola', 'K0001', 5000, '-', 'P0001', NULL),
('B0002', 'Nasi+Ayam Goreng', 'K0002', 12000, '-', 'P0001', NULL),
('B0003', 'Nasi TO+Ayam Goreng', 'K0002', 13000, '-', 'P0001', NULL),
('B0004', 'Kerupuk Kulit (Bks)', 'K0003', 2000, '-', 'P0001', NULL),
('B0005', 'Keripik Singkong', 'K0003', 1000, '-', 'P0001', NULL),
('B0006', 'Air Mineral (Aqua)', 'K0001', 3000, '-', 'P0001', NULL),
('B0007', 'Teh Kotak', 'K0001', 4000, '-', 'P0001', NULL),
('B0008', 'Nasi Kuning', 'K0002', 6000, '-', 'P0001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kode_kategori` char(5) NOT NULL,
  `nama_kategori` varchar(35) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kode_kategori`, `nama_kategori`, `ket`, `id_member`) VALUES
('K0001', 'Minuman', '-', 'P001'),
('K0002', 'Makanan Berat', '-', 'P001'),
('K0003', 'Makanan Ringan', '-', 'P001');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_fak_penj` char(15) DEFAULT NULL,
  `kode_pelanggan` char(5) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `potongan` float DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`no_fak_penj`, `kode_pelanggan`, `tgl_transaksi`, `potongan`, `id_member`, `keterangan`) VALUES
('FAK-1020001', '-', '2020-10-09', NULL, 'P0001', ''),
('FAK-1020002', '-', '2020-10-09', NULL, 'P0001', '-');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `no_fak_penj` char(15) DEFAULT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`no_fak_penj`, `kode_barang`, `qty`, `harga`, `id_member`) VALUES
('FAK-1020001', 'B0004', 1, 2000, 'P0001'),
('FAK-1020001', 'B0004', 1, 2000, 'P0001'),
('FAK-1020001', 'B0004', 1, 2000, 'P0001'),
('FAK-1020002', 'B0004', 1, 2000, 'P0001'),
('FAK-1020002', 'B0004', 1, 2000, 'P0001'),
('FAK-1020002', 'B0004', 1, 2000, 'P0001');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_histori_bayar`
--

CREATE TABLE `penjualan_histori_bayar` (
  `no_fak_penj` char(15) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_histori_bayar`
--

INSERT INTO `penjualan_histori_bayar` (`no_fak_penj`, `tgl_bayar`, `jumlah`, `id_member`) VALUES
('FAK-1020001', '2020-09-10', 0, 'P0001'),
('FAK-1020002', '2020-09-10', 0, 'P0001');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_temp`
--

CREATE TABLE `penjualan_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_temp`
--

INSERT INTO `penjualan_temp` (`kode_barang`, `qty`, `harga`, `id_user`) VALUES
('B0004', 1, 2000, '1'),
('B0004', 1, 2000, '1'),
('B0004', 1, 2000, '1'),
('B0003', 1, 13000, '1'),
('B0003', 1, 13000, '1'),
('B0003', 1, 13000, '1'),
('B0008', 1, 6000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `kode_perusahaan` char(5) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `desa` int(11) NOT NULL,
  `kecamatan` int(11) NOT NULL,
  `kota` int(11) NOT NULL,
  `provinsi` int(11) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `exp_date` date NOT NULL,
  `foto` text NOT NULL,
  `email` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`kode_perusahaan`, `nama_perusahaan`, `alamat`, `desa`, `kecamatan`, `kota`, `provinsi`, `no_hp`, `exp_date`, `foto`, `email`) VALUES
('P0001', 'Administrator', '', 0, 0, 0, 0, '', '0000-00-00', '', NULL),
('P0002', 'Jazz', '0', 0, 0, 0, 0, '0', '2020-10-30', 'P00021.PNG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` char(35) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `username` char(20) NOT NULL,
  `password` char(35) NOT NULL,
  `kode_perusahaan` char(5) NOT NULL,
  `level` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `email`, `no_hp`, `username`, `password`, `kode_perusahaan`, `level`) VALUES
(1, 'Administrator', 'admin@gmail.com', '089655244585', 'jazman', '4a3261b127c4c2d0ad4632190ebbc4f4', 'P0001', 'Administrator'),
(2, 'Member', 'admin@gmail.com', '089655244585', 'member', 'aa08769cdcb26674c6706093503ff0a3', 'P0001', 'Member'),
(3, 'Model Simulasi', 'admin@gmail.com', '089655244585', 'simulasi', 'aa08769cdcb26674c6706093503ff0a3', 'P0001', 'Simulasi'),
(4, 'Admin Member', 'admin@gmail.com', '089655244585', 'admin', 'aa08769cdcb26674c6706093503ff0a3', 'P0001', 'Admin Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`kode_perusahaan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
