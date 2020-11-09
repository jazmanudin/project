-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 03:04 AM
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
  `satuan` char(15) DEFAULT NULL,
  `kode_kategori` char(5) DEFAULT NULL,
  `harga_modal` float DEFAULT NULL,
  `grosir` float NOT NULL,
  `pelanggan_tetap` float NOT NULL,
  `eceran` float NOT NULL,
  `lainnya` float NOT NULL,
  `tidak_tetap` float NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL,
  `jenis_barang` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `satuan`, `kode_kategori`, `harga_modal`, `grosir`, `pelanggan_tetap`, `eceran`, `lainnya`, `tidak_tetap`, `keterangan`, `id_member`, `foto`, `diskon`, `id_user`, `jenis_barang`) VALUES
('B000001', 'Pulpen Castelo', 'PCS', 'K0001', 2000, 2200, 2500, 3000, 3000, 3000, '-', 'P0001', NULL, 0, '1', NULL),
('898912', 'Buku Sidu 58 lembar', 'PCS', 'K0001', 1500, 1700, 2000, 2500, 3000, 2500, '-', 'P0001', '', 0, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_detail`
--

CREATE TABLE `barang_detail` (
  `id` int(11) NOT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `stok` char(15) DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_detail`
--

INSERT INTO `barang_detail` (`id`, `kode_barang`, `exp_date`, `stok`, `id_member`, `id_user`) VALUES
(1, '898912', '2020-12-30', '10', 'P0001', '1'),
(2, '898912', '2020-11-30', '-10', 'P0001', '1'),
(3, 'B000001', '2020-11-30', '90', 'P0001', '1');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `kode_jenis` char(5) NOT NULL,
  `nama_jenis` varchar(35) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`kode_jenis`, `nama_jenis`, `ket`, `id_member`, `id_user`) VALUES
('K0001', 'Mnuman', '-', 'P0001', '1'),
('K0002', 'Makanan Berat', '-', 'P0001', '1'),
('K0003', 'Makanan Ringan', '-', 'P0001', '1');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` char(25) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `id_member` char(5) NOT NULL,
  `id_user` char(5) DEFAULT NULL,
  `jabatan` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama_karyawan`, `alamat`, `no_hp`, `keterangan`, `id_member`, `id_user`, `jabatan`) VALUES
('237658890', 'Saeful Anwar', 'Karangtega', '08965524435', '-', 'P0001', '1', 'Sales'),
('237658891', 'Ujang Irfan', 'Cihideung2', '08965524435', '-', 'P0001', '1', 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kode_kategori` char(5) NOT NULL,
  `nama_kategori` varchar(35) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kode_kategori`, `nama_kategori`, `ket`, `id_member`, `id_user`) VALUES
('K0001', 'ATK', '-', 'P0001', '1'),
('K0002', 'Makanan Ringan', '-', 'P0001', '1'),
('K0003', 'Titipan', '-', 'P0001', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `kode_pelanggan` char(10) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `id_member` char(5) NOT NULL,
  `id_user` char(5) DEFAULT NULL,
  `jenis_harga` char(20) DEFAULT NULL,
  `id_sales` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`kode_pelanggan`, `nama_pelanggan`, `alamat`, `no_hp`, `keterangan`, `id_member`, `id_user`, `jenis_harga`, `id_sales`) VALUES
('P0001', 'Jazmanudin', 'Jl. Mang Koko No 13', '089655244575', '-', 'P0001', '1', 'Pelanggan Tetap', '237658891'),
('P0002', 'Muhammad Indra', 'Jl. Mang Koko No 16', '0', '-', 'P0001', '1', 'Tidak Tetap', '237658891'),
('P0003', 'Abdul Aziz', '-', '0', '', 'P0001', '1', 'Grosir', '237658890');

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `no_pemasukan` char(15) NOT NULL,
  `jenis_pemasukan` char(50) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan_detail`
--

CREATE TABLE `pemasukan_detail` (
  `no_pemasukan` char(15) DEFAULT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `keterangan` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan_temp`
--

CREATE TABLE `pemasukan_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_hutang`
--

CREATE TABLE `pembayaran_hutang` (
  `nobukti` char(15) NOT NULL,
  `kode_supplier` char(5) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `jenis_pembayaran` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran_hutang`
--

INSERT INTO `pembayaran_hutang` (`nobukti`, `kode_supplier`, `tgl_bayar`, `jumlah`, `id_member`, `keterangan`, `jenis_pembayaran`) VALUES
('1120001', 'S0002', '2020-11-03', 150000, 'P0001', '-', 'Tunai');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_hutang_detail`
--

CREATE TABLE `pembayaran_hutang_detail` (
  `nobukti` char(15) NOT NULL,
  `no_fak_pemb` char(15) NOT NULL,
  `jumlah` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran_hutang_detail`
--

INSERT INTO `pembayaran_hutang_detail` (`nobukti`, `no_fak_pemb`, `jumlah`, `id_member`, `keterangan`) VALUES
('1120001', 'FAK-1120001', 150000, 'P0001', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_hutang_temp`
--

CREATE TABLE `pembayaran_hutang_temp` (
  `no_fak_pemb` char(15) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `no_fak_pemb` char(15) NOT NULL,
  `no_po` char(15) DEFAULT NULL,
  `kode_supplier` char(5) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `potongan` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `ppn` char(5) DEFAULT NULL,
  `jenis_transaksi` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_fak_pemb`, `no_po`, `kode_supplier`, `tgl_transaksi`, `potongan`, `total`, `id_member`, `keterangan`, `jatuh_tempo`, `ppn`, `jenis_transaksi`) VALUES
('FAK-1120001', '-', 'S0002', '2020-11-03', 0, 150000, 'P0001', '-', '2020-11-03', 'No', 'Tunai'),
('FAK-1120002', '-', 'S0001', '2020-11-03', 0, 18000, 'P0001', '', '2020-11-03', 'No', 'Kredit'),
('FAK-1120003', 'PO-1120001', 'S0003', '2020-11-03', 0, 140000, 'P0001', 'Tidak Ada', '2020-11-03', 'No', 'Kredit');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `no_fak_pemb` char(15) DEFAULT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_modal` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `exp_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`no_fak_pemb`, `kode_barang`, `qty`, `harga_modal`, `id_member`, `keterangan`, `exp_date`) VALUES
('FAK-1120001', '898912', 100, 1500, 'P0001', '-', '2020-11-30'),
('FAK-1120002', '898912', 12, 1500, 'P0001', '-', '2020-11-30'),
('FAK-1120003', 'B000001', 70, 2000, 'P0001', '', '2020-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_temp`
--

CREATE TABLE `pembelian_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_modal` float DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_user` char(10) DEFAULT NULL,
  `no_po` char(15) DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `exp_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `no_pengeluaran` char(15) NOT NULL,
  `jenis_pengeluaran` char(50) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_detail`
--

CREATE TABLE `pengeluaran_detail` (
  `no_pengeluaran` char(15) DEFAULT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_temp`
--

CREATE TABLE `pengeluaran_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_fak_penj` char(15) NOT NULL,
  `kode_pelanggan` char(5) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `potongan` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `no_meja` float DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_histori_bayar`
--

CREATE TABLE `penjualan_histori_bayar` (
  `nobukti` char(15) NOT NULL,
  `no_fak_penj` char(15) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_temp`
--

CREATE TABLE `penjualan_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_jual` float DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL,
  `no_so` char(15) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `id_member` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_temp`
--

INSERT INTO `penjualan_temp` (`kode_barang`, `qty`, `harga_jual`, `id_user`, `no_so`, `keterangan`, `id_member`) VALUES
('898912', 5, 2000, '1', 'SO-1120001', '', 'P0001');

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
  `email` varchar(40) DEFAULT NULL,
  `jenis_pembayaran` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`kode_perusahaan`, `nama_perusahaan`, `alamat`, `desa`, `kecamatan`, `kota`, `provinsi`, `no_hp`, `exp_date`, `foto`, `email`, `jenis_pembayaran`) VALUES
('P0001', 'Jazz', 'Kp. Cihideung', 0, 0, 0, 0, '0', '2020-10-30', '', 'jazz@gmail.com', 'Sekarang'),
('P0002', 'Administrator', 'Kp. Cihideung', 0, 0, 0, 0, '0', '0000-00-00', 'P0002.PNG', 'jazz@gmail.com', 'Nanti'),
('P0003', 'LeCafe', 'Kp. Cihideung', 0, 0, 0, 0, '089655244582', '2020-10-31', '', 'jazz@gmail.com', 'Sekarang');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `no_po` char(15) NOT NULL,
  `kode_supplier` char(5) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `total` float DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `ppn` char(5) DEFAULT NULL,
  `status` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_detail`
--

CREATE TABLE `purchaseorder_detail` (
  `no_po` char(15) DEFAULT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_modal` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_temp`
--

CREATE TABLE `purchaseorder_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_modal` float DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `saldoawal`
--

CREATE TABLE `saldoawal` (
  `kode_saldoawal` char(11) NOT NULL,
  `bulan` char(3) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL,
  `tgl_transaksi` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `saldoawal_detail`
--

CREATE TABLE `saldoawal_detail` (
  `kode_saldoawal` char(11) NOT NULL,
  `kode_barang` char(15) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salesorder`
--

CREATE TABLE `salesorder` (
  `no_so` char(15) NOT NULL,
  `kode_pelanggan` char(5) DEFAULT NULL,
  `id_sales` char(15) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `total` float DEFAULT NULL,
  `id_member` char(5) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `ppn` char(5) DEFAULT NULL,
  `status` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salesorder`
--

INSERT INTO `salesorder` (`no_so`, `kode_pelanggan`, `id_sales`, `tgl_transaksi`, `total`, `id_member`, `keterangan`, `ppn`, `status`) VALUES
('SO-1120001', 'P0002', NULL, '2020-11-09', 10000, 'P0001', '', 'No', 0);

-- --------------------------------------------------------

--
-- Table structure for table `salesorder_detail`
--

CREATE TABLE `salesorder_detail` (
  `no_so` char(15) DEFAULT NULL,
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_jual` float DEFAULT NULL,
  `id_member` char(10) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salesorder_detail`
--

INSERT INTO `salesorder_detail` (`no_so`, `kode_barang`, `qty`, `harga_jual`, `id_member`, `keterangan`) VALUES
('SO-1120001', '898912', 5, 2000, 'P0001', '');

-- --------------------------------------------------------

--
-- Table structure for table `salesorder_temp`
--

CREATE TABLE `salesorder_temp` (
  `kode_barang` char(10) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `harga_jual` float DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_user` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kode_supplier` char(10) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `id_member` char(5) NOT NULL,
  `id_user` char(5) DEFAULT NULL,
  `jatuh_tempo` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kode_supplier`, `nama_supplier`, `alamat`, `no_hp`, `keterangan`, `id_member`, `id_user`, `jatuh_tempo`) VALUES
('S0001', 'Toko Sari Dewi', 'Jl. Mang Koko No 13', '089655244575', '-', 'P0001', '1', '10'),
('S0002', 'Dua Saudara', 'Jl. Mang Koko No 16', '0', NULL, 'P0001', '1', '15'),
('S0003', 'UU', '-', '0', '', 'P0001', '1', '30');

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

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_bayar_hutang`
-- (See below for the actual view)
--
CREATE TABLE `v_bayar_hutang` (
`no_fak_pemb` char(15)
,`jumlahbayar` double
,`total` double
);

-- --------------------------------------------------------

--
-- Structure for view `v_bayar_hutang`
--
DROP TABLE IF EXISTS `v_bayar_hutang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_bayar_hutang`  AS  select `pembayaran_hutang_detail`.`no_fak_pemb` AS `no_fak_pemb`,sum(`pembayaran_hutang_detail`.`jumlah`) AS `jumlahbayar`,`pb`.`total` AS `total` from (`pembayaran_hutang_detail` left join (select `pembelian`.`no_fak_pemb` AS `no_fak_pemb`,sum(`pembelian`.`total`) AS `total` from `pembelian` group by `pembelian`.`no_fak_pemb`) `pb` on(`pb`.`no_fak_pemb` = `pembayaran_hutang_detail`.`no_fak_pemb`)) group by `pembayaran_hutang_detail`.`no_fak_pemb` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD KEY `i_kategori` (`kode_kategori`);

--
-- Indexes for table `barang_detail`
--
ALTER TABLE `barang_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`kode_jenis`) USING BTREE;

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nik`) USING BTREE;

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`kode_pelanggan`) USING BTREE;

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`no_pemasukan`) USING BTREE;

--
-- Indexes for table `pemasukan_detail`
--
ALTER TABLE `pemasukan_detail`
  ADD KEY `i_no_pemasukan` (`no_pemasukan`);

--
-- Indexes for table `pembayaran_hutang`
--
ALTER TABLE `pembayaran_hutang`
  ADD PRIMARY KEY (`nobukti`) USING BTREE;

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`no_fak_pemb`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`no_pengeluaran`) USING BTREE;

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_fak_penj`);

--
-- Indexes for table `penjualan_histori_bayar`
--
ALTER TABLE `penjualan_histori_bayar`
  ADD PRIMARY KEY (`nobukti`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`kode_perusahaan`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`no_po`) USING BTREE,
  ADD KEY `i_no_po` (`no_po`),
  ADD KEY `i_kode_supplier` (`kode_supplier`);

--
-- Indexes for table `purchaseorder_detail`
--
ALTER TABLE `purchaseorder_detail`
  ADD KEY `i_kode_barang` (`kode_barang`),
  ADD KEY `i_no_po` (`no_po`);

--
-- Indexes for table `purchaseorder_temp`
--
ALTER TABLE `purchaseorder_temp`
  ADD KEY `i_kode_barang` (`kode_barang`);

--
-- Indexes for table `saldoawal`
--
ALTER TABLE `saldoawal`
  ADD PRIMARY KEY (`kode_saldoawal`);

--
-- Indexes for table `salesorder`
--
ALTER TABLE `salesorder`
  ADD PRIMARY KEY (`no_so`) USING BTREE,
  ADD KEY `i_no_po` (`no_so`),
  ADD KEY `i_kode_supplier` (`kode_pelanggan`);

--
-- Indexes for table `salesorder_detail`
--
ALTER TABLE `salesorder_detail`
  ADD KEY `i_kode_barang` (`kode_barang`),
  ADD KEY `i_no_po` (`no_so`);

--
-- Indexes for table `salesorder_temp`
--
ALTER TABLE `salesorder_temp`
  ADD KEY `i_kode_barang` (`kode_barang`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_detail`
--
ALTER TABLE `barang_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
