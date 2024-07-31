-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2016 at 10:43 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;


--
-- Database: `db_penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `pj_akses`
--

CREATE TABLE `pj_akses` (
  `id_akses` tinyint(1) UNSIGNED NOT NULL,
  `label` varchar(10) NOT NULL,
  `level_akses` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_akses`
--

INSERT INTO `pj_akses` (`id_akses`, `label`, `level_akses`) VALUES
(1, 'admin', 'Administrator'),
(2, 'kasir', 'Staff Kasir'),
(3, 'inventory', 'Staff Inventory'),
(4, 'keuangan', 'Staff Keuangan');

-- --------------------------------------------------------

--
-- Table structure for table `pj_menu`
--

CREATE TABLE `pj_menu` (
  `id_menu` int(1) UNSIGNED NOT NULL,
  `kode_menu` varchar(40) NOT NULL,
  `nama_menu` varchar(60) NOT NULL,
  `total_stok` int(6) UNSIGNED NOT NULL,
  `harga` int(10) NOT NULL,
  `id_kategori_menu` int(1) UNSIGNED NOT NULL,
  `id_list_menu` int(1) UNSIGNED DEFAULT NULL,
  `keterangan` text NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_menu`
--

INSERT INTO `pj_menu` (`id_menu`, `kode_menu`, `nama_menu`, `total_stok`, `harga`, `id_kategori_menu`, `id_list_menu`, `keterangan`, `dihapus`) VALUES
(1, '001', 'Ayam Original', 4, '10000', 1, 2, '', 'tidak'),
(2, '002', 'Ayam Geprek', 45, '15000', 3, 6, '', 'tidak'),
(3, '003', 'Nasi', 30, '5000', 2, 3, '', 'tidak'),

-- --------------------------------------------------------

--
-- Table structure for table `pj_ci_sessions`
--

CREATE TABLE `pj_ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_kategori_menu`
--

CREATE TABLE `pj_kategori_menu` (
  `id_kategori_menu` int(1) UNSIGNED NOT NULL,
  `kategori` varchar(40) NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_kategori_menu`
--

INSERT INTO `pj_kategori_menu` (`id_kategori_menu`, `kategori`, `dihapus`) VALUES
(1, 'Makanan', 'ya'),
(2, 'Minuman', 'tidak'),
(3, 'Paket Biasa', 'tidak'),
(4, 'Paket Mantab', 'tidak'),

-- --------------------------------------------------------

--
-- Table structure for table `pj_list_menu`
--

CREATE TABLE `pj_list_menu` (
  `id_list_menu` int(1) UNSIGNED NOT NULL,
  `list` varchar(40) NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_list_menu`
--

INSERT INTO `pj_list_menu` (`id_list_menu`, `list`, `dihapus`) VALUES
(1, 'Ayam Original', 'tidak'),
(2, 'Ayam Geprek', 'tidak'),


-- --------------------------------------------------------

--
-- Table structure for table `pj_pelanggan`
--

CREATE TABLE `pj_pelanggan` (
  `id_pelanggan` int(6) UNSIGNED NOT NULL,
  `nama` varchar(40) NOT NULL,
  `alamat` text,
  `telp` varchar(40) DEFAULT NULL,
  `info_tambahan` text,
  `kode_unik` varchar(30) NOT NULL,
  `waktu_input` datetime NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_pelanggan`
--

INSERT INTO `pj_pelanggan` (`id_pelanggan`, `nama`, `alamat`, `telp`, `info_tambahan`, `kode_unik`, `waktu_input`, `dihapus`) VALUES
(1, 'Pak Udin', 'Jalan Kayumanis 2 Baru', '08838493439', 'Testtt', '', '2016-05-07 22:44:25', 'ya'),
(2, 'Pak Jarwo', 'Kemanggisan deket binus', '4353535353', NULL, '', '2016-05-07 22:44:49', 'tidak'),
(3, 'Joko', 'Kayumanis', '08773682882', '', '', '2016-05-23 16:31:47', 'tidak'),

-- --------------------------------------------------------

--
-- Table structure for table `pj_penjualan_detail`
--

CREATE TABLE `pj_penjualan_detail` (
  `id_penjualan_d` int(1) UNSIGNED NOT NULL,
  `id_penjualan_m` int(1) UNSIGNED NOT NULL,
  `id_menu` varchar(30) NOT NULL,
  `jumlah_beli` int(60) UNSIGNED NOT NULL,
  `harga_satuan` int(10) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_penjualan_detail`
--

INSERT INTO `pj_penjualan_detail` (`id_penjualan_d`, `id_penjualan_m`, `id_menu`, `jumlah_beli`, `harga_satuan`, `total`) VALUES
(2, 2, 2, 1, '120000', '120000'),
(3, 2, 4, 1, '35000', '35000'),
(4, 3, 3, 1, '350000', '350000'),
(5, 4, 2, 1, '120000', '120000'),
(6, 4, 11, 2, '30000', '60000'),
(7, 4, 4, 2, '35000', '70000'),
(11, 6, 2, 1, '120000', '120000'),
(10, 6, 1, 1, '400000', '400000'),
(12, 7, 4, 1, '35000', '35000'),
(13, 8, 3, 1, '350000', '350000'),
(14, 9, 1, 1, '400000', '400000'),
(15, 9, 2, 1, '120000', '120000'),
(16, 9, 3, 1, '350000', '350000'),
(17, 9, 4, 1, '35000', '35000'),
(18, 10, 1, 1, '400000', '400000'),
(19, 10, 2, 1, '120000', '120000'),
(20, 10, 3, 1, '350000', '350000'),
(21, 11, 1, 1, '400000', '400000'),
(22, 11, 3, 1, '350000', '350000'),
(23, 12, 3, 2, '350000', '700000'),
(26, 15, 1, 1, '400000', '400000');

-- --------------------------------------------------------

--
-- Table structure for table `pj_penjualan_master`
--

CREATE TABLE `pj_penjualan_master` (
  `id_penjualan_m` int(1) UNSIGNED NOT NULL,
  `nomor_nota` varchar(40) NOT NULL,
  `tanggal` datetime NOT NULL,
  `grand_total` int(60) NOT NULL,
  `bayar` int(10) NOT NULL,
  `keterangan_lain` text,
  `id_pelanggan` mediumint(1) UNSIGNED DEFAULT NULL,
  `id_user` mediumint(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_penjualan_master`
--

INSERT INTO `pj_penjualan_master` (`id_penjualan_m`, `nomor_nota`, `tanggal`, `grand_total`, `bayar`, `keterangan_lain`, `id_pelanggan`, `id_user`) VALUES
(2, '57431A97D5DF8', '2016-05-23 16:58:31', '155000', '160000', '', 3, 1),
(3, '57431BDDAFA9D2', '2016-05-23 17:03:57', '350000', '400000', '', 3, 2),
(4, '57445D46655AB1', '2016-05-24 15:55:18', '250000', '260000', '', NULL, 1),
(6, '576406086CB611', '2016-06-17 16:15:36', '520000', '550000', '', NULL, 1),
(7, '57655546C37441', '2016-06-18 16:05:58', '35000', '40000', '', NULL, 1),
(8, '57655552ABF781', '2016-06-18 16:06:10', '350000', '400000', '', NULL, 1),
(9, '577A31BABCDC51', '2016-07-04 11:51:54', '905000', '910000', '', NULL, 1),
(10, '577A3327991DC1', '2016-07-04 11:57:59', '870000', '880000', 'Dibayar Langsung', NULL, 1),
(11, '577A3793C67CB1', '2016-07-04 12:16:51', '750000', '750000', '', NULL, 1),
(12, '57CA627F897FB1', '2016-09-03 07:41:19', '700000', '800000', '', NULL, 1),
(15, '57CBD697806F61', '2016-09-04 10:08:55', '400000', '500000', '', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pj_user`
--

CREATE TABLE `pj_user` (
  `id_user` mediumint(1) UNSIGNED NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_akses` tinyint(1) UNSIGNED NOT NULL,
  `status` enum('Aktif','Non Aktif') NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_user`
--

INSERT INTO `pj_user` (`id_user`, `username`, `password`, `nama`, `id_akses`, `status`, `dihapus`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Bang Admin', 1, 'Aktif', 'tidak'),
(2, 'kasir', '8691e4fc53b99da544ce86e22acba62d13352eff', 'Centini', 2, 'Aktif', 'tidak'),
(3, 'kasir2', '08dfc5f04f9704943a423ea5732b98d3567cbd49', 'Kasir Dua', 2, 'Aktif', 'ya'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pj_akses`
--
ALTER TABLE `pj_akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `pj_menu`
--
ALTER TABLE `pj_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pj_ci_sessions`
--
ALTER TABLE `pj_ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `pj_kategori_menu`
--
ALTER TABLE `pj_kategori_menu`
  ADD PRIMARY KEY (`id_kategori_menu`);

--
-- Indexes for table `pj_list_menu`
--
ALTER TABLE `pj_list_menu`
  ADD PRIMARY KEY (`id_list_menu`);

--
-- Indexes for table `pj_pelanggan`
--
ALTER TABLE `pj_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pj_penjualan_detail`
--
ALTER TABLE `pj_penjualan_detail`
  ADD PRIMARY KEY (`id_penjualan_d`);

--
-- Indexes for table `pj_penjualan_master`
--
ALTER TABLE `pj_penjualan_master`
  ADD PRIMARY KEY (`id_penjualan_m`);

--
-- Indexes for table `pj_user`
--
ALTER TABLE `pj_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pj_akses`
--
ALTER TABLE `pj_akses`
  MODIFY `id_akses` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pj_menu`
--
ALTER TABLE `pj_menu`
  MODIFY `id_menu` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pj_kategori_menu`
--
ALTER TABLE `pj_kategori_menu`
  MODIFY `id_kategori_menu` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pj_list_menu`
--
ALTER TABLE `pj_list_menu`
  MODIFY `id_list_menu` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pj_pelanggan`
--
ALTER TABLE `pj_pelanggan`
  MODIFY `id_pelanggan` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `pj_penjualan_detail`
--
ALTER TABLE `pj_penjualan_detail`
  MODIFY `id_penjualan_d` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `pj_penjualan_master`
--
ALTER TABLE `pj_penjualan_master`
  MODIFY `id_penjualan_m` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `pj_user`
--
ALTER TABLE `pj_user`
  MODIFY `id_user` mediumint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
