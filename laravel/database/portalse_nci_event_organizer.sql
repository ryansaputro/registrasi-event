-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Sep 2020 pada 14.02
-- Versi server: 5.7.31
-- Versi PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portalse_nci_event_organizer`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `id_divisi` int(11) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_kelamin` smallint(6) DEFAULT NULL,
  `id_marital` tinyint(1) DEFAULT NULL,
  `id_status_aktif` tinyint(1) DEFAULT NULL,
  `nik` varchar(20) NOT NULL,
  `no_ktp` varchar(30) DEFAULT NULL,
  `alamat` varchar(190) DEFAULT NULL,
  `kodepos` varchar(10) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(30) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `simpanan_pokok` float NOT NULL,
  `simpanan_wajib` float NOT NULL,
  `simpanan_sukarela` float NOT NULL,
  `simpanan_harkop` float NOT NULL,
  `simpanan_kematian` float NOT NULL,
  `tgl_aktif` datetime DEFAULT NULL,
  `tgl_non_aktif` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `id_divisi`, `id_jabatan`, `id_kelamin`, `id_marital`, `id_status_aktif`, `nik`, `no_ktp`, `alamat`, `kodepos`, `notelp`, `tempat_lahir`, `tgl_lahir`, `email`, `full_name`, `password`, `foto`, `simpanan_pokok`, `simpanan_wajib`, `simpanan_sukarela`, `simpanan_harkop`, `simpanan_kematian`, `tgl_aktif`, `tgl_non_aktif`) VALUES
(1, 1, 1, 1, 1, 1, '147006087', '3207011804960002', 'Jln.Bojonghuni No.116 Rt.01/12 Kel.Maleber Kec.Ciamis Kab.Ciamis', '46211', '082214716209', 'Indramayu', '1996-04-19', 'ilmanhilmioriza@gmail.com', 'Ilman Hilmi Oriza', '$2y$10$mIXnoLSqpzHAnrA3Bs2b9.iJyXK4wklxX5j02OZDx3yip7hw9IATW', 'profil-1.png', 100000, 100000, 30000, 100000, 20000, '2019-04-23 00:00:00', NULL),
(2, 2, 2, 2, 2, 1, '147006088', '111222333444555', 'Ciamis', '46222', '081222333444', 'Ciamis', '1996-04-19', 'ilman19@gmail.com', 'Anggota Baru', '$2y$10$mIXnoLSqpzHAnrA3Bs2b9.iJyXK4wklxX5j02OZDx3yip7hw9IATW', 'profil-2.png', 100000, 100000, 20000, 100000, 20000, '1960-04-29 00:00:00', NULL),
(3, 1, 1, 1, 1, 1, '147006089', '124354646575474', 'Jln.Bojonghuni No.116 Rt.01/12 Kel.Maleber Kec.Ciamis Kab.Ciamis', '34563', '325364758799', 'Bandung', '2019-05-02', 'ilman@gmail.com', 'Anggota Lagi', '$2y$10$mO/Wr.1S4kk.alCwa2DzRen2AMO6hPHqcj4Bb699p3abqUffSLuCu', 'profil-3.png', 100000, 100000, 10000, 100000, 20000, '2010-05-02 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_bank`
--

CREATE TABLE `daftar_bank` (
  `id` int(11) NOT NULL,
  `nama_bank` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `daftar_bank`
--

INSERT INTO `daftar_bank` (`id`, `nama_bank`) VALUES
(1, 'BCA'),
(2, 'BRI'),
(3, 'Mandiri'),
(4, 'Muamalat'),
(5, 'Panin'),
(6, 'BJB'),
(7, 'BTN'),
(8, 'Bank DKI'),
(9, 'Bank JABAR'),
(10, 'Bank JATIM'),
(11, 'Bank JATENG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_checking`
--

CREATE TABLE `payment_checking` (
  `id` int(11) NOT NULL,
  `id_pay_request` int(11) NOT NULL,
  `merchant_id` varchar(8) NOT NULL,
  `pay_date` varchar(14) DEFAULT NULL,
  `invoice` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `sof_id` varchar(20) DEFAULT NULL,
  `result_code` varchar(4) DEFAULT NULL,
  `result_desc` varchar(30) DEFAULT NULL,
  `payment_code` varchar(18) DEFAULT NULL,
  `ref_no` varchar(16) DEFAULT NULL,
  `add_info1` varchar(100) NOT NULL,
  `add_info2` varchar(100) NOT NULL,
  `add_info3` varchar(100) NOT NULL,
  `add_info4` varchar(100) NOT NULL,
  `add_info5` varchar(100) NOT NULL,
  `payment_source` varchar(16) DEFAULT NULL,
  `landing_page` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment_checking`
--

INSERT INTO `payment_checking` (`id`, `id_pay_request`, `merchant_id`, `pay_date`, `invoice`, `amount`, `sof_id`, `result_code`, `result_desc`, `payment_code`, `ref_no`, `add_info1`, `add_info2`, `add_info3`, `add_info4`, `add_info5`, `payment_source`, `landing_page`) VALUES
(1, 1, 'PSD2660', '20200515125415', 'INVPSR054755', 10000, 'briva', '00', 'Success', '1004800000029542', '6781460', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'PORTALSEPEDA RIDE', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', 'simulator', 'https://sandbox.finpay.co.id/servicescode/api/checkOutFinpay.php?access=17e5506773f628849fea3bd92be2cb65939eb260a1fe9ff3c35c942a25b3734f'),
(2, 2, 'PSD2660', NULL, 'INVPSR0507137', 10000, 'vamandiri', '03', 'Failed/Expired', '880270000030525', NULL, 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'PORTALSEPEDA RIDE', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', NULL, 'https://sandbox.finpay.co.id/servicescode/api/checkOutFinpay.php?access=980660c174e6908aa378fe140a457a8aefeecb4ced88f86a3a305db8b00168e2'),
(3, 3, 'PSD2660', 'null', 'INVPSR0536137', 10000, 'null', 'null', 'null', 'null', 'null', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'PORTALSEPEDA RIDE', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', 'null', 'https://sandbox.finpay.co.id/servicescode/api/checkOutFinpay.php?access=bb7062ab8991455ff82806464f51c3e573e8ee914a0c684b74e69932f00563f0'),
(6, 6, 'PSP3048', NULL, 'INVABC0906137', 300000, 'vamandiri', '01', 'Pending Payment', '880446001808870', '', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'abc-2020', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', NULL, 'https://billhosting.finnet-indonesia.com/prepaidsystem/api/checkOutFinpay.php?access=677cc252181fe3ce2f56f964af3a925a48b104064b62bad539be29b97aee1b28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_request`
--

CREATE TABLE `payment_request` (
  `id` int(11) NOT NULL,
  `id_users` bigint(20) NOT NULL,
  `id_event` int(11) NOT NULL,
  `amount` float NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_id` varchar(20) NOT NULL,
  `cust_msisdn` varchar(15) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `merchant_id` varchar(8) NOT NULL,
  `items` varchar(30) NOT NULL,
  `return_url` varchar(200) NOT NULL,
  `success_url` varchar(200) NOT NULL,
  `failed_url` varchar(200) NOT NULL,
  `back_url` varchar(200) NOT NULL,
  `timeout` varchar(10) NOT NULL,
  `trans_date` varchar(14) NOT NULL,
  `add_info1` varchar(100) NOT NULL,
  `add_info2` varchar(100) NOT NULL,
  `add_info3` varchar(100) NOT NULL,
  `add_info4` varchar(100) NOT NULL,
  `add_info5` varchar(100) NOT NULL,
  `mer_signature` varchar(100) NOT NULL,
  `result_code` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment_request`
--

INSERT INTO `payment_request` (`id`, `id_users`, `id_event`, `amount`, `cust_email`, `cust_id`, `cust_msisdn`, `cust_name`, `invoice`, `merchant_id`, `items`, `return_url`, `success_url`, `failed_url`, `back_url`, `timeout`, `trans_date`, `add_info1`, `add_info2`, `add_info3`, `add_info4`, `add_info5`, `mer_signature`, `result_code`) VALUES
(1, 55, 7, 10000, 'androidoriza@gmail.com', '000055', '082214716209', 'Ilman Hilmi Oriza', 'INVPSR054755', 'PSD2660', 'PSR', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', 'https://api-all.portalsepeda.com/payment_success', 'https://api-all.portalsepeda.com/payment_failed', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', '120', '20200515054847', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'PORTALSEPEDA RIDE', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', '3d51be4689b8756b3c12f4af2b2ec54ce2c66c142b8a3ed8ca8c41c21d891ecd', '00'),
(2, 137, 7, 10000, 'ilmanhilmioriza@gmail.com', '0000137', '082214716209', 'Ilman Hilmi Oriza', 'INVPSR0507137', 'PSD2660', 'PSR', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', 'https://api-all.portalsepeda.com/payment_success', 'https://api-all.portalsepeda.com/payment_failed', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', '120', '20200515061107', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'PORTALSEPEDA RIDE', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', '398b9d2f2639630eea1f2b00ff813aad8fe43af5e39b000d8d671393209cf585', '03'),
(3, 137, 7, 10000, 'ilmanhilmioriza@gmail.com', '0000137', '082214716209', 'Ilman Hilmi Oriza', 'INVPSR0536137', 'PSD2660', 'PSR', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', 'https://api-all.portalsepeda.com/payment_success', 'https://api-all.portalsepeda.com/payment_failed', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', '120', '20200519034236', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'PORTALSEPEDA RIDE', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', '638d018a8eae4a7d25b05c3c8735d5713bf691cabef935dfbf62fd1562a5f57e', '01'),
(6, 137, 8, 300000, 'ilmanhilmioriza@gmail.com', '0000137', '082214716209', 'Ilman Hilmi Oriza', 'INVABC0906137', 'PSP3048', 'ABC', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', 'https://api-all.portalsepeda.com/payment_success', 'https://api-all.portalsepeda.com/payment_failed', 'https://sandbox.finpay.co.id/simdev/finpay/result/tangkapCurl.php', '120', '20200914040006', 'Hai Ilman Hilmi Oriza,', 'Anda berhasil melakukan Registrasi Event', 'abc-2020', 'Tahap selanjutnya silahkan melakukan pembayaran', 'Terimakasih.', '3bbe048b65e788c156f4a7c72ddc288a6a757e8f35a9b1629297e6c7b9286c5d', '01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jersey`
--

CREATE TABLE `pengaturan_jersey` (
  `id` int(11) NOT NULL,
  `id_jersey_model` int(11) NOT NULL,
  `id_jersey_tipe` int(11) NOT NULL,
  `id_jersey_size` int(11) NOT NULL,
  `id_jersey_darimana` int(11) NOT NULL,
  `ukuran` varchar(20) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan_jersey`
--

INSERT INTO `pengaturan_jersey` (`id`, `id_jersey_model`, `id_jersey_tipe`, `id_jersey_size`, `id_jersey_darimana`, `ukuran`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '47 X 64 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(2, 1, 1, 2, 1, '50 X 66 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(3, 1, 1, 3, 1, '53 X 68 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(4, 1, 1, 4, 1, '65 X 70 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(5, 2, 1, 1, 1, '38 X 30 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(6, 2, 1, 2, 1, '48 X 30 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(7, 2, 1, 3, 1, '58 X 30 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(8, 2, 1, 4, 1, '68 X 30 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(9, 1, 1, 1, 2, '47 X 64 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(10, 1, 1, 2, 2, '50 X 66 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(11, 1, 1, 3, 2, '53 X 68 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(12, 1, 1, 4, 2, '55 X 70 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(13, 1, 2, 1, 2, '47 X 64 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(14, 1, 2, 2, 2, '50 X 66 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(15, 1, 2, 3, 2, '53 X 68 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(16, 1, 2, 4, 2, '55 X 70 CM', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(17, 1, 1, 5, 1, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(18, 1, 1, 6, 1, '59 X 74 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(19, 1, 1, 5, 2, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(20, 1, 1, 6, 2, '59 X 74 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(21, 3, 1, 1, 1, '53 X 68 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(22, 3, 1, 2, 1, '55 X 70 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(23, 3, 1, 3, 1, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(24, 3, 1, 4, 1, '59 X 73 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(25, 3, 1, 5, 1, '61 X 75 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(26, 3, 1, 6, 1, '63 X 77 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(27, 1, 2, 1, 1, '47 X 64 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(28, 1, 2, 2, 1, '50 X 66 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(29, 1, 2, 3, 1, '53 X 68 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(30, 1, 2, 4, 1, '55 X 70 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(31, 1, 2, 5, 1, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(32, 1, 2, 6, 1, '59 X 74 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(33, 1, 2, 5, 2, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(34, 1, 2, 6, 2, '59 X 74 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(35, 3, 2, 1, 1, '53 X 68 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(36, 3, 2, 2, 1, '55 X 70 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(37, 3, 2, 3, 1, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(38, 3, 2, 4, 1, '59 X 73 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(39, 3, 2, 5, 1, '61 X 75 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(40, 3, 2, 6, 1, '63 X 77 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(41, 3, 1, 1, 2, '53 X 68 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(42, 3, 1, 2, 2, '55 X 70 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(43, 3, 1, 3, 2, '57 X 72 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(44, 3, 1, 4, 2, '59 X 73 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(45, 3, 1, 5, 2, '61 X 75 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00'),
(46, 3, 1, 6, 2, '63 X 77 CM', '1', '2020-02-25 00:00:00', '2020-02-25 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jersey_darimana`
--

CREATE TABLE `pengaturan_jersey_darimana` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan_jersey_darimana`
--

INSERT INTO `pengaturan_jersey_darimana` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LC', 'lokal indonesia', 'ukuran lokal orang indonesia', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(2, 'INT', 'internasional', 'ukuran internasional', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jersey_model`
--

CREATE TABLE `pengaturan_jersey_model` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `deskripsi` text,
  `status` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan_jersey_model`
--

INSERT INTO `pengaturan_jersey_model` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'XC', 'Cross Country', 'jersey untuk pesepeda cross country', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(2, 'RB', 'Road Bike', 'jersey untuk pesepeda road bike', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(3, 'DH', 'Down Hill', 'jersey untuk pesepeda downhill', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jersey_size`
--

CREATE TABLE `pengaturan_jersey_size` (
  `id` int(11) NOT NULL,
  `kode` varchar(5) NOT NULL,
  `nama` varchar(10) NOT NULL,
  `deskripsi` text,
  `status` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan_jersey_size`
--

INSERT INTO `pengaturan_jersey_size` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'XS', 'extra smal', 'ukuran paling kecil', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(2, 'S', 'small', 'ukuran kecil', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(3, 'M', 'medium', 'ukuran sedang', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(4, 'L', 'large', 'ukuran besar', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(5, 'XL', 'extra larg', 'ukuran ekstra besar', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(6, 'XXL', 'double ext', 'ukuran ekstra ekstra besar', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jersey_tipe`
--

CREATE TABLE `pengaturan_jersey_tipe` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text,
  `status` enum('1','0') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan_jersey_tipe`
--

INSERT INTO `pengaturan_jersey_tipe` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'P', 'Panjang', 'Ukuran panjang', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(2, 'PD', 'Pendek', 'Ukuran pendek', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00'),
(3, '3/4', 'Tiga per Empat', 'Ukuran tiga per empat', '1', '2020-02-05 00:00:00', '2020-02-05 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_syarat_dan_ketentuan`
--

CREATE TABLE `pengaturan_syarat_dan_ketentuan` (
  `id` int(11) NOT NULL,
  `syarat_dan_ketentuan` text NOT NULL,
  `id_eo` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengaturan_syarat_dan_ketentuan`
--

INSERT INTO `pengaturan_syarat_dan_ketentuan` (`id`, `syarat_dan_ketentuan`, `id_eo`, `created_at`, `updated_at`) VALUES
(1, 'Pembalap Men dan Women yang masih aktif berlomba di kategori elite, tidak diperbolehkan mengikuti kategori usia, (Age Category 30-34, 35-39, 40-44, 45-49, 50-54, 55+)\r\nSetiap peserta diwajibkan sudah berusia di atas 15 tahun pada saat pelaksanaan BROMO KOM CHALLENGE 2019 dan dinyatakan sehat (dengan menunjukkan surat keterangan dokter) untuk mengikuti rangkaian kegiatan serta tidak punya masalah medis apapun yang dapat mempengaruhi partisipasi pada kegiatan BROMO KOM CHALLENGE 2019\r\nPeserta harus melakukan registrasi online melalui website www.mainsepeda.com dengan mengirimkan data/informasi asli diri meliputi nama lengkap, tanggal/bulan dan tahun lahir. Dengan mengisi formulir yang telah disediakan pada website serta melampirkan bukti orisinil  KTP/Pasport.\r\nSepeda yang dipergunakan adalah Sepeda Jalan Raya / Road Bike (untuk lomba KOM & QOM ), tidak terdapat mesin serta dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\nKhusus untuk lomba folding bike (Non Brompton), menggunakan ring roda max 20 X 1.75, termasuk ban 20-451, sepeda bisa dilipat serta tidak terdapat mesin dan dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\nKhusus untuk lomba folding bike (Brompton) harus memakai frame Brompton asli, sepeda bisa dilipat serta tidak terdapat mesin dan dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\nPeserta wajib menggunakan helm pengaman selama dalam rangkaian perlombaan.\r\nSeluruh peserta wajib menggunakan jersey dan starter kit yang telah disediakan oleh panitia dan tidak diperbolehkan memakai jersey dan identitas di luar yang disediakan panitia dengan alasan apapun.\r\nPeserta wajib menggunakan nomor peserta dan nomor sepeda yang dipasang dengan benar dan sesuai dengan ketentuan lomba. Apabila terjadi kesalahan pemasangan yang menyebabkan tidak terekam pada kamera finish, maka segala kerugian  yang yang dialami oleh peserta menjadi tanggung jawab peserta tersebut.\r\nNomor peserta dan nomor sepeda apabila digunakan bukan atas nama pendaftar, maka yang terdaftar dan yang menggunakan nomor tersebut akan dikenakan sanksi diskualifikasi pada nomor lomba yang diikuti tersebut.\r\nPeserta wajib melakukan Sign On (menandatangani daftar hadir) satu jam sebelum lomba dimulai dan ditutup 25 menit sebelum start dilaksanakan.\r\nKecepatan saat Neutralized Start akan ditentukan/dipandu oleh Commissaire.\r\nSeluruh peserta Road bike wajib start dari Lapangan Kodam Surabaya dan Brompton/Selly start dari GOR Untung Surapati Pasuruan. Peserta yang melanggar/ kedapatan Loading baik dengan mobil Evacuation atau kendaraan pribadi dengan alasan apapun, dianggap tidak masuk finish/ do not finish (DNF), dan tidak berhak memperoleh Finisher Medals.\r\nApabila pembalap mengalami mechanical problem saat neutralized start maka dianggap A Normal Race Incident dan neutralized start tetap berjalan seperti biasa.\r\nReal Start dilaksanakan dengan cara Flying Start/ tanpa berhenti.\r\nPembalap yang diketahui/ kedapatan berangkat terlebih dahulu/ jump start (sebelum kelompok kategorinya) sebelum pemberangkatan/ flag off di garis start KOM, dianggap gugur/ didiskualifikasi.\r\nTidak ada pengawalan atau personal support dari official untuk peserta lomba.\r\nPembalap bisa mengambil sendiri refreshment atau supply di area feeding zone ( 2 tempat feeding zone ) yang telah disediakan oleh organizer.\r\nManuver pada saat sprint tidak diperbolehkan, karena mengganggu/membahayakan pembalap lain.\r\nSanksi atas pelanggaran akan diputuskan oleh Panel Commissaire, yaitu sanksi penggeseran posisi/relegation sampai dengan diskualifikasi.\r\nPemenang lomba adalah peserta yang berhasil menduduki peringkat 1-3 pada kategori usia  30-34, 35-39, 40-44, 45-49, 50-54, 55+ dan Folding Bike. Dan berhasil menunjukkan keaslian kelengkapan data diri.\r\nPemenang lomba adalah peserta yang berhasil menduduki peringkat 1-5 pada kategori Men Elite dan Women Elite. Dan berhasil menunjukkan keaslian kelengkapan data diri.\r\nPenentuan juara ditentukan atas urutan kedatangan (placing) di garis finish.\r\nApa bila terjadi force majeure yang mengakibatkan perlombaan dihentikan, maka penentuan poin/pemenang akan diputuskan oleh tim Commissaire.\r\nHasil Perlombaan akan diumumkan 10 menit sebelum dilakukan upacara penganugrahan pemenang (UPP), peserta dapat mengajukan protes dalam kurun waktu tersebut, protes tidak akan ditanggapi pada saat/setelah UPP.\r\nPeserta yang menjadi juara wajib hadir dalam UPP (Upacara Penganugerahan Pemenang) dan tidak boleh diwakilkan. Harus mengenakan jersey sesuai katagori lomba yang telah ditentukan dan bersepatu, kecuali dengan alasan dan atau pertimbangan tertentu (keputusan akan ditentukan oleh tim Commissaire dan Penyelenggara).\r\nPeserta yang tidak mengikuti UPP (Upacara Penganugerahan Pemenang), hadiah tidak akan diberikan.\r\nProtes dapat diajukan secara tertulis disertai bukti-bukti dengan membayar uang protes sebesar Rp. 1.000.000 (satu juta rupiah) sebagai jaminan. Jika protes diterima, uang protes akan dikembalikan dan jika protes ditolak, uang protes menjadi hak panitia.\r\nPeserta wajib mentaati semua peraturan lomba yang telah ditetapkan dan telah menjadi keputusan Penyelenggara dan Commissaire.\r\nKetentuan lain yang belum tercantum dalam peraturan ini, pihak penyelenggara/ organizer akan memberitahukan lebih lanjut via email dan / atau media lainnya.\r\n \r\n\r\nPERATURAN BIG RIDE (PELOTON NON COMPETITIVE)\r\n\r\nPeserta\r\n\r\nSetiap peserta diwajibkan sudah berusia di atas 15 tahun pada saat pelaksanaan BROMO KOM CHALLENGE 2019 dan dinyatakan sehat (dengan menunjukkan surat keterangan dokter) untuk mengikuti rangkaian kegiatan serta tidak punya masalah medis apapun yang dapat mempengaruhi partisipasi pada kegiatan BROMO KOM CHALLENGE 2019\r\n\r\nJenis Sepeda\r\n\r\nPeserta BROMO KOM CHALLENGE 2019 katagori Big ride (Peloton Non Competitive) diperbolehkan memakai segala jenis sepeda dan tidak di dapati menggunakan mesin di dalamnya, dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\n\r\nPemimpin Rombongan\r\n\r\nSeluruh peserta yang mengikuti BROMO KOM CHALLENGE 2019, mulai dari start  sampai  finish dipandu oleh pemimpin rombongan (Road Captain) dengan kecepatan yang mengacu pada ketentuan tim Commissaire.\r\n\r\nSelama perjalanan,  peserta dilarang mendahului pemimpin rombongan (Road Captain) serta harus patuh kepada perintah pemimpin rombongan (Road Captain) dan tim Commissaire.\r\n\r\nMobil pendukung peserta tidak diijinkan mengikuti rangkaian pesepeda dari start sampai finish melainkan dengan waktu yang telah ditentukan oleh Panitia dan Tim Commissaire.\r\nJersey dan Starter kit\r\nSeluruh peserta yang sudah teregistrasi dengan benar akan mendapatkan jersey dan starter kit sesuai dengan kategori yang dipilih, meliputi kategori competitive maupun non-competitive sesuai dengan ukuran dan kelengkapan pada saat registrasi.\r\n\r\nSeluruh peserta wajib menggunakan jersey dan starter kit yang telah disediakan oleh panitia dan tidak diperbolehkan memakai jersey dan identitas di luar yang disediakan panitia dengan alasan apapun.\r\n\r\nApabila terdapat peserta yang tidak memakai kelengkapan yang meliputi jersey dan starter kit sesuai ketentuan yang berlaku selama kegiatan BROMO KOM CHALLENGE 2019, maka peserta tersebut akan dikeluarkan dari rombongan peserta BROMO KOM CHALLENGE 2019.\r\n\r\nBatas waktu bersepeda\r\n\r\nTime limit untuk seluruh peserta adalah jam satu siang (13.00) di Wonokitri.\r\n\r\nAsuransi\r\n\r\nSeluruh peserta kegiatan BROMO KOM CHALLENGE 2019 terlindungi asuransi selama pelaksanaan dengan batas waktu (1 x 24 Jam).\r\n\r\nMakanan dan Minuman\r\n\r\nSelama kegiatan  BROMO KOM CHALLENGE 2019, panitia menyediakan cukup makanan dan minuman untuk seluruh peserta dari start, sampai pada finish, serta memberikan 2 tempat pemberhentian makanan (Feeding Zone), meskipun peserta tidak berkewajiban untuk berhenti di kedua tempat makanan (Feeding Zone) tersebut.\r\n\r\nLain-lain\r\n\r\nPanitia kegiatan BROMO KOM CHALLENGE 2019 tidak bertanggungjawab atas kerusakan dan kehilangan barang pribadi peserta dalam bentuk apapun selama pelaksanaan kegiatan BROMO KOM CHALLENGE 2019\r\n\r\nSeluruh peserta diharuskan untuk selalu menjaga ketertiban dan keamanan selama kegiatan BROMO KOM CHALLENGE 2019 dilaksanakan.\r\n\r\nSaran\r\n\r\nPeserta disarankan untuk membawa jas hujan (raincoat)\r\nPeserta disarankan memakai pelindung tangan (arm sleeve)\r\nPeserta disarankan memakai cream anti sinar UV (sunblock)\r\nPeserta disarankan membawa ban dalam cadangan\r\nPeserta disarankan membawa lampu sepeda (depan dan belakang)\r\nPeserta disarankan membawa tool kit pribadi ', 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_divisi`
--

CREATE TABLE `ref_divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_divisi`
--

INSERT INTO `ref_divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'BENGKEL ALTEK & TERA'),
(2, 'KEUANGAN'),
(3, 'LANGGANAN'),
(4, 'LITBANG'),
(5, 'LPKL'),
(6, 'OPERASIONAL AIR KOTOR'),
(7, 'PEL. UMUM AIR KOTOR'),
(8, 'PELAYANAN WIL. BARAT'),
(9, 'PELAYANAN WIL. TIMUR'),
(10, 'PELAYANAN WIL. UTARA'),
(11, 'PENAGIHAN'),
(12, 'PENCATATAN METER'),
(13, 'PENGOLAHAN AIR LIMBAH'),
(14, 'PERBEKALAN & PERAWATAN'),
(15, 'PERENCANAAN TEKNIK AIR LIMBAH'),
(16, 'PERENCANAAN TEKNIK AIR MINUM'),
(17, 'PRODUKSI I'),
(18, 'PRODUKSI II'),
(19, 'SATUAN PEMERIKSAAN INTERNAL'),
(20, 'SEKRETARIAT'),
(21, 'SISTEM & TEKNOLOGI INFORMASI'),
(22, 'HUKUM & SDM'),
(23, 'TAM'),
(24, 'HONORER'),
(25, 'DIREKSI'),
(26, 'KOPERASI'),
(27, 'STAF KHUSUS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_jabatan`
--

CREATE TABLE `ref_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_jabatan`
--

INSERT INTO `ref_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'STAF'),
(2, 'KEPALA SEKSI'),
(3, 'KEPALA BAGIAN'),
(4, 'DIREKSI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_jenis_angsuran`
--

CREATE TABLE `ref_jenis_angsuran` (
  `id_jenis_angsuran` int(11) NOT NULL,
  `jenis_angsuran` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_jenis_angsuran`
--

INSERT INTO `ref_jenis_angsuran` (`id_jenis_angsuran`, `jenis_angsuran`) VALUES
(1, 'Datar (Flat)'),
(2, 'Menurun (Sliding Rate)');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_kelamin`
--

CREATE TABLE `ref_kelamin` (
  `id_kelamin` smallint(6) NOT NULL,
  `jenis_kelamin` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_kelamin`
--

INSERT INTO `ref_kelamin` (`id_kelamin`, `jenis_kelamin`) VALUES
(1, 'Laki-Laki'),
(2, 'Perempuan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_status_aktif`
--

CREATE TABLE `ref_status_aktif` (
  `id_status_aktif` tinyint(1) NOT NULL,
  `nama_status_aktif` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_status_aktif`
--

INSERT INTO `ref_status_aktif` (`id_status_aktif`, `nama_status_aktif`) VALUES
(1, 'Aktif'),
(2, 'Tidak aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_status_marital`
--

CREATE TABLE `ref_status_marital` (
  `id_marital` tinyint(1) NOT NULL,
  `status_marital` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ref_status_marital`
--

INSERT INTO `ref_status_marital` (`id_marital`, `status_marital`) VALUES
(1, 'Lajang'),
(2, 'Menikah'),
(3, 'Janda'),
(4, 'Duda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_eo`
--

CREATE TABLE `registrasi_eo` (
  `id` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `kontak` varchar(25) NOT NULL,
  `no_hp_kontak` varchar(12) NOT NULL,
  `no_wa_kontak` varchar(12) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kota` int(11) NOT NULL,
  `alamat` text,
  `kode_pos` varchar(10) NOT NULL,
  `alamat_web` varchar(50) DEFAULT NULL,
  `logo` varchar(100) NOT NULL,
  `identitas` varchar(100) NOT NULL,
  `buku_rekening` varchar(100) NOT NULL,
  `no_rekening` varchar(25) NOT NULL,
  `pemilik_rekening` varchar(50) NOT NULL,
  `nama_bank` varchar(20) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi_eo`
--

INSERT INTO `registrasi_eo` (`id`, `id_member`, `kode`, `nama`, `kontak`, `no_hp_kontak`, `no_wa_kontak`, `id_provinsi`, `id_kota`, `alamat`, `kode_pos`, `alamat_web`, `logo`, `identitas`, `buku_rekening`, `no_rekening`, `pemilik_rekening`, `nama_bank`, `status`, `created_at`, `updated_at`) VALUES
(40, 1, NULL, 'admin', 'adik aku', '0865432123', '085649184363', 35, 3518, 'nganjuuk coy', '123456', 'ryani.com', '1576473724_admin.png', '', '', '', '', '', '1', '2019-12-16 05:22:05', '2019-12-16 05:22:05'),
(42, 38, NULL, 'erikfaisal ryan', 'adikku', '086758392648', '086758392648', 33, 3320, 'jepara jaya', '1223', 'jep.com', '1576552254_erikfaisal_ryan.jpeg', '', '', '', '', '', '1', '2019-12-17 03:10:55', '2019-12-17 03:10:55'),
(44, 14, NULL, 'portalsepeda Indonesia', 'agus', '081312415588', '081312415588', 32, 3273, 'Jl. Pelajar Pejuang 45, no. 43', '1122', 'portalsepeda.com', '1577762558_portalsepeda_Indonesia.jpg', '1577762558_portalsepeda_Indonesia.jpg', '1577762559_portalsepeda_Indonesia.jpg', '1234567890', 'portalsepeda', 'BRI', '1', '2019-12-31 03:22:39', '2019-12-31 03:22:39'),
(47, 501, NULL, 'erikfaisalryan', 'erik', '085654567876', '085654567876', 35, 3519, 'madiun', '31241', NULL, '1582536460_erikfaisalryan.png', '1582536460_erikfaisalryan.jpg', '1582536461_erikfaisalryan.jpg', '23243243243243242', 'ryan', 'BANK JATIM', '1', '2020-02-24 16:27:41', '2020-02-24 16:27:41'),
(48, 34, NULL, 'Imam Rohiman', '085659777888', '085659777888', '085659777888', 32, 3271, 'oke', '46211', NULL, '1582536561_Imam_Rohiman.png', '1582536561_Imam_Rohiman.png', '1582536562_Imam_Rohiman.png', '544544540990', 'imam', 'BANK DKI', '1', '2020-02-24 16:29:22', '2020-02-24 16:29:22'),
(49, 679, NULL, 'Bayu Hanggoro', 'Bayu', '082220207130', '082220207130', 32, 3273, 'Jl. Cisitu Indah I no 5\r\nDago - Coblong', '40135', NULL, '1582537830_Bayu_Hanggoro.jpg', '1582537831_Bayu_Hanggoro.jpeg', '1582537831_Bayu_Hanggoro.jpg', '5770385140', 'Bayu Hanggoro', 'BCA', '1', '2020-02-24 16:50:31', '2020-02-24 16:50:31'),
(50, 11, NULL, 'mohrezaadityap', '085659555111', '085659555111', '085659555111', 32, 3204, 'Bandung', '46211', NULL, '1585535393_mohrezaadityap.jpg', '1585535393_mohrezaadityap.jpg', '1585535393_mohrezaadityap.jpg', '0182727890', 'Reza', 'BRI', '1', '2020-03-30 09:29:53', '2020-03-30 09:29:53'),
(51, 137, NULL, 'Ilman Hilmi Oriza', 'Ilman Hilmi Oriza', '082214716209', '082214716209', 32, 3207, 'CIAMIS', '46211', 'orzdevs.com', '1600058395_Ilman_Hilmi_Oriza.png', '1600058396_Ilman_Hilmi_Oriza.png', '1600058396_Ilman_Hilmi_Oriza.png', '010401041964500', 'Ilman Hilmi Oriza', 'BRI', '1', '2020-09-14 11:39:56', '2020-09-14 11:39:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_event`
--

CREATE TABLE `registrasi_event` (
  `id` int(11) NOT NULL,
  `id_eo` int(11) NOT NULL,
  `kode_event` varchar(10) NOT NULL,
  `nama_event` varchar(200) NOT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_akhir` datetime NOT NULL,
  `tanggal_awal_pendaftaran` datetime NOT NULL,
  `tanggal_akhir_pendaftaran` datetime NOT NULL,
  `tempat_event` text NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kota` int(11) NOT NULL,
  `id_kecamatan` int(11) NOT NULL,
  `id_desa` bigint(20) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `waktu_kumpul` datetime NOT NULL,
  `tempat_kumpul` varchar(100) NOT NULL,
  `deskripsi_event` text,
  `url_event` varchar(100) DEFAULT NULL,
  `url_lain` varchar(100) DEFAULT NULL,
  `id_jenis_event` int(11) NOT NULL,
  `sponsor` varchar(255) DEFAULT NULL,
  `jumlah_peserta` int(11) DEFAULT NULL,
  `e_poster` varchar(100) NOT NULL,
  `status` enum('1','0','2') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `desain_mockup` varchar(100) DEFAULT NULL,
  `syarat_dan_ketentuan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi_event`
--

INSERT INTO `registrasi_event` (`id`, `id_eo`, `kode_event`, `nama_event`, `tanggal_mulai`, `tanggal_akhir`, `tanggal_awal_pendaftaran`, `tanggal_akhir_pendaftaran`, `tempat_event`, `id_provinsi`, `id_kota`, `id_kecamatan`, `id_desa`, `kode_pos`, `waktu_kumpul`, `tempat_kumpul`, `deskripsi_event`, `url_event`, `url_lain`, `id_jenis_event`, `sponsor`, `jumlah_peserta`, `e_poster`, `status`, `created_at`, `updated_at`, `desain_mockup`, `syarat_dan_ketentuan`) VALUES
(3, 47, 'XXX', 'xxx', '2020-02-29 09:00:00', '2020-02-29 17:00:00', '2020-02-24 00:00:00', '2020-02-29 08:00:00', 'bandung', 32, 3204, 3204140, 3204140003, '11226', '2020-02-29 08:30:00', 'warnas', 'test xxx', 'https://eo.portalsepeda.com/event/xxx', NULL, 2, 'portalsepeda', 1, '1582537676_XXX.jpg', '0', '2020-02-24 16:47:56', '2020-09-14 11:42:02', '1582537676_XXX_JERSEY.jpg', 'Pembalap Men dan Women yang masih aktif berlomba di kategori elite, tidak diperbolehkan mengikuti kategori usia, (Age Category 30-34, 35-39, 40-44, 45-49, 50-54, 55+)\r\nSetiap peserta diwajibkan sudah berusia di atas 15 tahun pada saat pelaksanaan BROMO KOM CHALLENGE 2019 dan dinyatakan sehat (dengan menunjukkan surat keterangan dokter) untuk mengikuti rangkaian kegiatan serta tidak punya masalah medis apapun yang dapat mempengaruhi partisipasi pada kegiatan BROMO KOM CHALLENGE 2019\r\nPeserta harus melakukan registrasi online melalui website www.mainsepeda.com dengan mengirimkan data/informasi asli diri meliputi nama lengkap, tanggal/bulan dan tahun lahir. Dengan mengisi formulir yang telah disediakan pada website serta melampirkan bukti orisinil  KTP/Pasport.\r\nSepeda yang dipergunakan adalah Sepeda Jalan Raya / Road Bike (untuk lomba KOM & QOM ), tidak terdapat mesin serta dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\nKhusus untuk lomba folding bike (Non Brompton), menggunakan ring roda max 20 X 1.75, termasuk ban 20-451, sepeda bisa dilipat serta tidak terdapat mesin dan dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\nKhusus untuk lomba folding bike (Brompton) harus memakai frame Brompton asli, sepeda bisa dilipat serta tidak terdapat mesin dan dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\nPeserta wajib menggunakan helm pengaman selama dalam rangkaian perlombaan.\r\nSeluruh peserta wajib menggunakan jersey dan starter kit yang telah disediakan oleh panitia dan tidak diperbolehkan memakai jersey dan identitas di luar yang disediakan panitia dengan alasan apapun.\r\nPeserta wajib menggunakan nomor peserta dan nomor sepeda yang dipasang dengan benar dan sesuai dengan ketentuan lomba. Apabila terjadi kesalahan pemasangan yang menyebabkan tidak terekam pada kamera finish, maka segala kerugian  yang yang dialami oleh peserta menjadi tanggung jawab peserta tersebut.\r\nNomor peserta dan nomor sepeda apabila digunakan bukan atas nama pendaftar, maka yang terdaftar dan yang menggunakan nomor tersebut akan dikenakan sanksi diskualifikasi pada nomor lomba yang diikuti tersebut.\r\nPeserta wajib melakukan Sign On (menandatangani daftar hadir) satu jam sebelum lomba dimulai dan ditutup 25 menit sebelum start dilaksanakan.\r\nKecepatan saat Neutralized Start akan ditentukan/dipandu oleh Commissaire.\r\nSeluruh peserta Road bike wajib start dari Lapangan Kodam Surabaya dan Brompton/Selly start dari GOR Untung Surapati Pasuruan. Peserta yang melanggar/ kedapatan Loading baik dengan mobil Evacuation atau kendaraan pribadi dengan alasan apapun, dianggap tidak masuk finish/ do not finish (DNF), dan tidak berhak memperoleh Finisher Medals.\r\nApabila pembalap mengalami mechanical problem saat neutralized start maka dianggap A Normal Race Incident dan neutralized start tetap berjalan seperti biasa.\r\nReal Start dilaksanakan dengan cara Flying Start/ tanpa berhenti.\r\nPembalap yang diketahui/ kedapatan berangkat terlebih dahulu/ jump start (sebelum kelompok kategorinya) sebelum pemberangkatan/ flag off di garis start KOM, dianggap gugur/ didiskualifikasi.\r\nTidak ada pengawalan atau personal support dari official untuk peserta lomba.\r\nPembalap bisa mengambil sendiri refreshment atau supply di area feeding zone ( 2 tempat feeding zone ) yang telah disediakan oleh organizer.\r\nManuver pada saat sprint tidak diperbolehkan, karena mengganggu/membahayakan pembalap lain.\r\nSanksi atas pelanggaran akan diputuskan oleh Panel Commissaire, yaitu sanksi penggeseran posisi/relegation sampai dengan diskualifikasi.\r\nPemenang lomba adalah peserta yang berhasil menduduki peringkat 1-3 pada kategori usia  30-34, 35-39, 40-44, 45-49, 50-54, 55+ dan Folding Bike. Dan berhasil menunjukkan keaslian kelengkapan data diri.\r\nPemenang lomba adalah peserta yang berhasil menduduki peringkat 1-5 pada kategori Men Elite dan Women Elite. Dan berhasil menunjukkan keaslian kelengkapan data diri.\r\nPenentuan juara ditentukan atas urutan kedatangan (placing) di garis finish.\r\nApa bila terjadi force majeure yang mengakibatkan perlombaan dihentikan, maka penentuan poin/pemenang akan diputuskan oleh tim Commissaire.\r\nHasil Perlombaan akan diumumkan 10 menit sebelum dilakukan upacara penganugrahan pemenang (UPP), peserta dapat mengajukan protes dalam kurun waktu tersebut, protes tidak akan ditanggapi pada saat/setelah UPP.\r\nPeserta yang menjadi juara wajib hadir dalam UPP (Upacara Penganugerahan Pemenang) dan tidak boleh diwakilkan. Harus mengenakan jersey sesuai katagori lomba yang telah ditentukan dan bersepatu, kecuali dengan alasan dan atau pertimbangan tertentu (keputusan akan ditentukan oleh tim Commissaire dan Penyelenggara).\r\nPeserta yang tidak mengikuti UPP (Upacara Penganugerahan Pemenang), hadiah tidak akan diberikan.\r\nProtes dapat diajukan secara tertulis disertai bukti-bukti dengan membayar uang protes sebesar Rp. 1.000.000 (satu juta rupiah) sebagai jaminan. Jika protes diterima, uang protes akan dikembalikan dan jika protes ditolak, uang protes menjadi hak panitia.\r\nPeserta wajib mentaati semua peraturan lomba yang telah ditetapkan dan telah menjadi keputusan Penyelenggara dan Commissaire.\r\nKetentuan lain yang belum tercantum dalam peraturan ini, pihak penyelenggara/ organizer akan memberitahukan lebih lanjut via email dan / atau media lainnya.\r\n \r\n\r\nPERATURAN BIG RIDE (PELOTON NON COMPETITIVE)\r\n\r\nPeserta\r\n\r\nSetiap peserta diwajibkan sudah berusia di atas 15 tahun pada saat pelaksanaan BROMO KOM CHALLENGE 2019 dan dinyatakan sehat (dengan menunjukkan surat keterangan dokter) untuk mengikuti rangkaian kegiatan serta tidak punya masalah medis apapun yang dapat mempengaruhi partisipasi pada kegiatan BROMO KOM CHALLENGE 2019\r\n\r\nJenis Sepeda\r\n\r\nPeserta BROMO KOM CHALLENGE 2019 katagori Big ride (Peloton Non Competitive) diperbolehkan memakai segala jenis sepeda dan tidak di dapati menggunakan mesin di dalamnya, dilengkapi dengan 2 rem (depan dan belakang) yang berfungsi dengan baik.\r\n\r\nPemimpin Rombongan\r\n\r\nSeluruh peserta yang mengikuti BROMO KOM CHALLENGE 2019, mulai dari start  sampai  finish dipandu oleh pemimpin rombongan (Road Captain) dengan kecepatan yang mengacu pada ketentuan tim Commissaire.\r\n\r\nSelama perjalanan,  peserta dilarang mendahului pemimpin rombongan (Road Captain) serta harus patuh kepada perintah pemimpin rombongan (Road Captain) dan tim Commissaire.\r\n\r\nMobil pendukung peserta tidak diijinkan mengikuti rangkaian pesepeda dari start sampai finish melainkan dengan waktu yang telah ditentukan oleh Panitia dan Tim Commissaire.\r\nJersey dan Starter kit\r\nSeluruh peserta yang sudah teregistrasi dengan benar akan mendapatkan jersey dan starter kit sesuai dengan kategori yang dipilih, meliputi kategori competitive maupun non-competitive sesuai dengan ukuran dan kelengkapan pada saat registrasi.\r\n\r\nSeluruh peserta wajib menggunakan jersey dan starter kit yang telah disediakan oleh panitia dan tidak diperbolehkan memakai jersey dan identitas di luar yang disediakan panitia dengan alasan apapun.\r\n\r\nApabila terdapat peserta yang tidak memakai kelengkapan yang meliputi jersey dan starter kit sesuai ketentuan yang berlaku selama kegiatan BROMO KOM CHALLENGE 2019, maka peserta tersebut akan dikeluarkan dari rombongan peserta BROMO KOM CHALLENGE 2019.\r\n\r\nBatas waktu bersepeda\r\n\r\nTime limit untuk seluruh peserta adalah jam satu siang (13.00) di Wonokitri.\r\n\r\nAsuransi\r\n\r\nSeluruh peserta kegiatan BROMO KOM CHALLENGE 2019 terlindungi asuransi selama pelaksanaan dengan batas waktu (1 x 24 Jam).\r\n\r\nMakanan dan Minuman\r\n\r\nSelama kegiatan  BROMO KOM CHALLENGE 2019, panitia menyediakan cukup makanan dan minuman untuk seluruh peserta dari start, sampai pada finish, serta memberikan 2 tempat pemberhentian makanan (Feeding Zone), meskipun peserta tidak berkewajiban untuk berhenti di kedua tempat makanan (Feeding Zone) tersebut.\r\n\r\nLain-lain\r\n\r\nPanitia kegiatan BROMO KOM CHALLENGE 2019 tidak bertanggungjawab atas kerusakan dan kehilangan barang pribadi peserta dalam bentuk apapun selama pelaksanaan kegiatan BROMO KOM CHALLENGE 2019\r\n\r\nSeluruh peserta diharuskan untuk selalu menjaga ketertiban dan keamanan selama kegiatan BROMO KOM CHALLENGE 2019 dilaksanakan.\r\n\r\nSaran\r\n\r\nPeserta disarankan untuk membawa jas hujan (raincoat)\r\nPeserta disarankan memakai pelindung tangan (arm sleeve)\r\nPeserta disarankan memakai cream anti sinar UV (sunblock)\r\nPeserta disarankan membawa ban dalam cadangan\r\nPeserta disarankan membawa lampu sepeda (depan dan belakang)\r\nPeserta disarankan membawa tool kit pribadi'),
(4, 49, 'Z2Z', 'Zero to Zero Lintang ITB', '2020-06-20 05:00:00', '2020-06-20 19:00:00', '2020-02-24 00:00:00', '2020-03-20 00:00:00', 'Km 0 Bogor', 32, 3273, 3273230, 3273230006, '40135', '2020-06-20 05:00:00', 'Kantor Walikota Bogor', 'DIGUNAKAN OLEH INTERNAL ITB LINTANG\r\nSelamat datang di Pendaftaran Tour Zero 2 Zero Bogor Bandung, 20 Juni 2020.\r\nKegiatan ini terbuka untuk semua kalangan dan semua jenis sepeda. Start dari Km 0 Bogor dan Finish di Km 0 Bandung. Gowes ini melalui jalur Bogor - Puncak - Cianjur - Ciranjang - Padalarang - Cimahi - Bandung, menempuh jarak kurang lebih sekitar 140 Km. \r\n\r\nAcara gowes ini bersifat mandiri, panitia hanya menyediakan Pit Stop berupa Water Station untuk mengisi air minum dan menyediakan perlengkapan keselamatan seperti Ambulans dan Tenaga Medik serta bantuan Tenaga Mekanik. \r\n\r\nPara peserta diharapkan mematuhi semua aturan yang dikeluarkan oleh Pihak Panitia Zero 2 Zero 2020 dan peraturan lalu lintas, untuk menghindari hal-hal yang tidak diinginkan. \r\n\r\nData ini hanya digunakan oleh Panitia Zero 2 Zero untuk memudahkan pendataan peserta dan tidak akan disebarluaskan.', 'https://eo.portalsepeda.com/event/z2z', NULL, 1, NULL, NULL, '1582538769_ZERO_TO_ZERO_BOGOR_-_BANDUNG.jpeg', '0', '2020-02-24 17:06:09', '2020-09-14 11:42:02', NULL, '<p>testing syarat</p>'),
(7, 44, 'PSR', 'PORTALSEPEDA RIDE', '2020-03-30 09:30:00', '2020-03-30 12:00:00', '2020-03-11 09:30:00', '2020-03-30 12:00:00', 'Kantor Portal Sepeda', 32, 3273, 3273160, 3273160001, '40125', '2020-03-11 07:30:00', 'Gedung Sate Bandung', 'gowes alon alon cari siomay', 'https://eo.portalsepeda.com/event/psr', NULL, 8, 'Federalove', 50, '1583895798_PORTALSEPEDA_RIDE.png', '0', '2020-03-11 10:03:19', '2020-09-14 11:42:02', '1583895799_PORTALSEPEDA_RIDE_JERSEY.png', '<p>jangan kebut2an, tertib lalu lintas, safety rideng, omat sanguan !<br></p>'),
(8, 40, 'ABC', 'abc-2020', '2020-09-30 07:00:00', '2020-09-30 16:00:00', '2020-09-14 00:30:00', '2020-09-29 23:30:00', 'bandung kabupaten', 32, 3204, 3204130, 3204130012, '36545', '2020-09-30 06:00:00', 'warjok', 'event jos', 'https://eo.portalsepeda.com/event/abc', NULL, 2, 'enduro', 2, '1600051264_ABC-2020.png', '2', '2020-09-14 09:41:04', '2020-09-14 10:00:11', NULL, '<p>event yahud</p>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_event_jenis_pembayaran`
--

CREATE TABLE `registrasi_event_jenis_pembayaran` (
  `id` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `jenis_pembayaran` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `tanggal_bayar` date NOT NULL,
  `harga` int(11) NOT NULL,
  `tanggal_ekstra` date DEFAULT NULL,
  `tanggal_bayar_ekstra` date DEFAULT NULL,
  `harga_ekstra` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi_event_jenis_pembayaran`
--

INSERT INTO `registrasi_event_jenis_pembayaran` (`id`, `id_event`, `jenis_pembayaran`, `tanggal`, `tanggal_bayar`, `harga`, `tanggal_ekstra`, `tanggal_bayar_ekstra`, `harga_ekstra`, `updated_by`, `updated_at`) VALUES
(1, 6, 'normal', '2019-12-18', '0000-00-00', 10000, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'eb', '2019-12-23', '0000-00-00', 100000, NULL, NULL, NULL, NULL, NULL),
(3, 1, 'normal', '2019-12-26', '0000-00-00', 200000, NULL, NULL, NULL, NULL, NULL),
(4, 1, 'otr', '2020-01-31', '0000-00-00', 300000, NULL, NULL, NULL, NULL, NULL),
(8, 16, 'normal', '2020-01-14', '2020-01-31', 150000, NULL, NULL, NULL, NULL, NULL),
(10, 3, 'normal', NULL, '2020-02-29', 250000, NULL, NULL, NULL, NULL, NULL),
(11, 4, 'normal', NULL, '2020-03-20', 300, NULL, NULL, NULL, NULL, NULL),
(12, 5, 'normal', NULL, '2020-03-29', 200000, NULL, NULL, NULL, NULL, NULL),
(14, 7, 'normal', NULL, '2020-03-11', 10000, NULL, NULL, NULL, NULL, NULL),
(15, 8, 'normal', NULL, '2020-09-29', 300000, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_event_jersey`
--

CREATE TABLE `registrasi_event_jersey` (
  `id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `id_event` int(11) NOT NULL,
  `size` varchar(5) NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `id_jersey_darimana` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi_event_jersey`
--

INSERT INTO `registrasi_event_jersey` (`id`, `model`, `id_event`, `size`, `ukuran`, `id_jersey_darimana`) VALUES
(1, 'RB Panjang', 3, 'XS', '38 X 30 CM', 0),
(2, 'RB Panjang', 3, 'S', '48 X 30 CM', 0),
(3, 'RB Panjang', 3, 'M', '58 X 30 CM', 0),
(4, 'RB Panjang', 3, 'L', '68 X 30 CM', 0),
(5, 'RB Panjang', 5, 'XS', '38 X 30 CM', 0),
(6, 'RB Panjang', 5, 'S', '48 X 30 CM', 0),
(7, 'RB Panjang', 5, 'M', '58 X 30 CM', 0),
(8, 'RB Panjang', 5, 'L', '68 X 30 CM', 0),
(9, 'DH Panjang', 7, 'M', '57 X 72 CM', 0),
(10, 'DH Panjang', 7, 'L', '59 X 73 CM', 0),
(11, 'DH Panjang', 7, 'XL', '61 X 75 CM', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_peserta_event`
--

CREATE TABLE `registrasi_peserta_event` (
  `id` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `nama_kontak` varchar(100) NOT NULL,
  `hubungan_kontak` varchar(100) NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `is_free` enum('ya','tidak') NOT NULL,
  `status_pembayaran` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0->blm bayar, 1->sukses, 2->tolak',
  `jumlah_bayar` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `konfirmasi` enum('1') DEFAULT NULL,
  `ip_address` varchar(25) DEFAULT NULL,
  `tanggal_konfirmasi` datetime DEFAULT NULL,
  `komunitas` varchar(200) NOT NULL,
  `model_jersey` varchar(50) DEFAULT NULL,
  `size_jersey` varchar(10) DEFAULT NULL,
  `status_pendaftaran` enum('0','1') NOT NULL,
  `no_unik` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi_peserta_event`
--

INSERT INTO `registrasi_peserta_event` (`id`, `id_event`, `id_member`, `tanggal`, `nama_kontak`, `hubungan_kontak`, `no_telp`, `is_free`, `status_pembayaran`, `jumlah_bayar`, `created_at`, `updated_at`, `konfirmasi`, `ip_address`, `tanggal_konfirmasi`, `komunitas`, `model_jersey`, `size_jersey`, `status_pendaftaran`, `no_unik`) VALUES
(1, 7, 55, '2020-05-15 05:48:44', 'Reza', 'Teman', '085666555888', 'tidak', '1', 10000, '2020-05-15 05:48:44', '2020-05-15 05:48:44', NULL, NULL, NULL, 'busdev', 'DH Panjang', 'XL', '1', ''),
(2, 7, 137, '2020-05-15 06:11:04', 'Reza', 'Teman', '085666555888', 'tidak', '0', 10000, '2020-05-15 06:11:04', '2020-08-05 03:04:40', NULL, NULL, NULL, 'busdev', 'DH Panjang', 'XL', '1', ''),
(4, 8, 1, '2020-09-14 10:05:51', 'aris', 'teman', '086456452423', 'tidak', '1', 300000, '2020-09-14 10:05:51', '2020-09-14 10:10:13', '1', '66.102.8.7', '2020-09-14 10:09:00', 'NCI-Gowes', NULL, NULL, '1', 'ABCPAY2'),
(6, 8, 137, '2020-09-14 04:00:03', 'ryan', 'tenab', '959494994949', 'tidak', '0', 300000, '2020-09-14 04:00:03', '2020-09-14 04:00:03', NULL, NULL, NULL, 'vsbsbsn', '', '', '1', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi_peserta_event_pembayaran`
--

CREATE TABLE `registrasi_peserta_event_pembayaran` (
  `id` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `atas_nama` varchar(50) NOT NULL,
  `bukti` varchar(100) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `status_approval` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0->blm di approve, 1->telah diapprove, 2->tolak',
  `approval_oleh` int(11) DEFAULT NULL COMMENT 'approval oleh diambil dari id eo yang melakukan approval',
  `jumlah_approval` int(11) NOT NULL,
  `tanggal_approval` datetime DEFAULT NULL,
  `no_unik` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `registrasi_peserta_event_pembayaran`
--

INSERT INTO `registrasi_peserta_event_pembayaran` (`id`, `id_event`, `id_member`, `bank`, `atas_nama`, `bukti`, `jumlah`, `status_approval`, `approval_oleh`, `jumlah_approval`, `tanggal_approval`, `no_unik`, `created_at`, `updated_at`) VALUES
(1, 7, 55, 'briva', 'Ilman Hilmi Oriza', NULL, 10000, '0', NULL, 0, NULL, NULL, '2020-05-15 05:54:25', '2020-05-15 05:54:25'),
(2, 8, 1, 'Muamalat', 'ryan', '1600052985_ABC-2020_RYAN.png', 300000, '1', 1, 300000, '2020-09-14 10:10:13', NULL, '2020-09-14 10:09:46', '2020-09-14 10:10:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `zgroup`
--

CREATE TABLE `zgroup` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(1024) DEFAULT NULL,
  `group_desc` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `zgroup`
--

INSERT INTO `zgroup` (`group_id`, `group_name`, `group_desc`) VALUES
(1, 'admin', 'administrator'),
(2, 'operator', 'operator'),
(3, 'reporting', 'reporting'),
(4, 'anggota', 'anggota');

-- --------------------------------------------------------

--
-- Struktur dari tabel `zmember`
--

CREATE TABLE `zmember` (
  `group_id` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `zmember`
--

INSERT INTO `zmember` (`group_id`, `id_anggota`) VALUES
(1, 1),
(4, 2),
(4, 3),
(4, 5),
(4, 10),
(4, 11),
(4, 14),
(4, 34),
(4, 38),
(4, 73),
(4, 137),
(4, 501),
(4, 613),
(4, 679),
(4, 685),
(4, 692),
(4, 705),
(4, 879),
(4, 1059),
(4, 1606);

-- --------------------------------------------------------

--
-- Struktur dari tabel `zmodule`
--

CREATE TABLE `zmodule` (
  `mod_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `mod_name` varchar(1024) DEFAULT NULL,
  `mod_desc` varchar(1024) DEFAULT NULL,
  `mod_key` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `zmodule`
--

INSERT INTO `zmodule` (`mod_id`, `parent_id`, `mod_name`, `mod_desc`, `mod_key`) VALUES
(1, NULL, 'Dashboard', 'Dashboard', 'mod_dashboard'),
(2, NULL, 'Simpan pinjam', 'Simpan pinjam', 'mod_simpan_pinjam'),
(3, NULL, 'Bendahara', 'Bendahara', 'mod_bendahara'),
(4, NULL, 'Master data', 'Master data', 'mod_master_data'),
(201, 2, 'Simpanan Sukarela', 'Simpanan Sukarela', 'mod_simpanan_sukarela'),
(202, 2, 'Pengajuan Pinjaman', 'Pengajuan Pinjaman', 'mod_pengajuan_pinjaman'),
(203, 2, 'Pembayaran Angsuran', 'Pembayaran Angsuran', 'mod_pembayaran_angsuran'),
(204, 2, 'Sandang Pangan', 'Sandang Pangan', 'mod_sandang_pangan'),
(301, 3, 'Tagihan', 'Tagihan', 'mod_tagihan'),
(302, 3, 'Penerimaan Piutang', 'Penerimaan Piutang', 'mod_penerimaan_piutang'),
(303, 3, 'Penerimaan Kas', 'Penerimaan Kas', 'mod_penerimaankas'),
(304, 3, 'Account', 'Account', 'mod_account'),
(401, 4, 'Data Anggota', 'Data Anggota', 'mod_data_anggota'),
(402, 4, 'Data Jabatan', 'Data Jabatan', 'mod_data_jabatan'),
(403, 4, 'Data Divisi', 'Data Divisi', 'mod_data_divisi'),
(404, 4, 'Data Status Marital', 'Data Status Marital', 'mod_data_status_marital'),
(405, 4, 'Data Jenis Angsuran', 'Data Jenis Angsuran', 'mod_data_jenis_angsuran'),
(406, 4, 'Data Jenis Pinjaman', 'Data Jenis Pinjaman', 'mod_data_jenis_pinjaman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ztrustee`
--

CREATE TABLE `ztrustee` (
  `group_id` int(11) NOT NULL,
  `mod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ztrustee`
--

INSERT INTO `ztrustee` (`group_id`, `mod_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 201),
(1, 202),
(1, 203),
(1, 204);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_rel_kelamin_anggota` (`id_kelamin`),
  ADD KEY `fk_rel_divisi_anggota` (`id_divisi`),
  ADD KEY `fk_rel_jabatan_anggota` (`id_jabatan`),
  ADD KEY `fk_rel_status_aktif` (`id_status_aktif`),
  ADD KEY `fk_rel_marital_anggota` (`id_marital`) USING BTREE;

--
-- Indeks untuk tabel `daftar_bank`
--
ALTER TABLE `daftar_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment_checking`
--
ALTER TABLE `payment_checking`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment_request`
--
ALTER TABLE `payment_request`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_jersey`
--
ALTER TABLE `pengaturan_jersey`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_jersey_darimana`
--
ALTER TABLE `pengaturan_jersey_darimana`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_jersey_model`
--
ALTER TABLE `pengaturan_jersey_model`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_jersey_size`
--
ALTER TABLE `pengaturan_jersey_size`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_jersey_tipe`
--
ALTER TABLE `pengaturan_jersey_tipe`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_syarat_dan_ketentuan`
--
ALTER TABLE `pengaturan_syarat_dan_ketentuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ref_divisi`
--
ALTER TABLE `ref_divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `ref_jenis_angsuran`
--
ALTER TABLE `ref_jenis_angsuran`
  ADD PRIMARY KEY (`id_jenis_angsuran`);

--
-- Indeks untuk tabel `ref_kelamin`
--
ALTER TABLE `ref_kelamin`
  ADD PRIMARY KEY (`id_kelamin`);

--
-- Indeks untuk tabel `ref_status_aktif`
--
ALTER TABLE `ref_status_aktif`
  ADD PRIMARY KEY (`id_status_aktif`);

--
-- Indeks untuk tabel `ref_status_marital`
--
ALTER TABLE `ref_status_marital`
  ADD PRIMARY KEY (`id_marital`);

--
-- Indeks untuk tabel `registrasi_eo`
--
ALTER TABLE `registrasi_eo`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrasi_event`
--
ALTER TABLE `registrasi_event`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrasi_event_jenis_pembayaran`
--
ALTER TABLE `registrasi_event_jenis_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrasi_event_jersey`
--
ALTER TABLE `registrasi_event_jersey`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrasi_peserta_event`
--
ALTER TABLE `registrasi_peserta_event`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrasi_peserta_event_pembayaran`
--
ALTER TABLE `registrasi_peserta_event_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `zgroup`
--
ALTER TABLE `zgroup`
  ADD PRIMARY KEY (`group_id`);

--
-- Indeks untuk tabel `zmember`
--
ALTER TABLE `zmember`
  ADD KEY `fk_rel_member_group` (`group_id`),
  ADD KEY `fk_rel_anggota_group` (`id_anggota`,`group_id`) USING BTREE;

--
-- Indeks untuk tabel `zmodule`
--
ALTER TABLE `zmodule`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indeks untuk tabel `ztrustee`
--
ALTER TABLE `ztrustee`
  ADD KEY `fk_rel_module_ztrustee` (`mod_id`),
  ADD KEY `fk_rel_zgroup_ztrustee` (`group_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_bank`
--
ALTER TABLE `daftar_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `payment_checking`
--
ALTER TABLE `payment_checking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `payment_request`
--
ALTER TABLE `payment_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jersey`
--
ALTER TABLE `pengaturan_jersey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jersey_darimana`
--
ALTER TABLE `pengaturan_jersey_darimana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jersey_model`
--
ALTER TABLE `pengaturan_jersey_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jersey_size`
--
ALTER TABLE `pengaturan_jersey_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jersey_tipe`
--
ALTER TABLE `pengaturan_jersey_tipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_syarat_dan_ketentuan`
--
ALTER TABLE `pengaturan_syarat_dan_ketentuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ref_status_marital`
--
ALTER TABLE `ref_status_marital`
  MODIFY `id_marital` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `registrasi_eo`
--
ALTER TABLE `registrasi_eo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `registrasi_event`
--
ALTER TABLE `registrasi_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `registrasi_event_jenis_pembayaran`
--
ALTER TABLE `registrasi_event_jenis_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `registrasi_event_jersey`
--
ALTER TABLE `registrasi_event_jersey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `registrasi_peserta_event`
--
ALTER TABLE `registrasi_peserta_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `registrasi_peserta_event_pembayaran`
--
ALTER TABLE `registrasi_peserta_event_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_kelamin`) REFERENCES `ref_kelamin` (`id_kelamin`),
  ADD CONSTRAINT `anggota_ibfk_2` FOREIGN KEY (`id_status_aktif`) REFERENCES `ref_status_aktif` (`id_status_aktif`),
  ADD CONSTRAINT `anggota_ibfk_3` FOREIGN KEY (`id_marital`) REFERENCES `ref_status_marital` (`id_marital`),
  ADD CONSTRAINT `fk_rel_divisi_anggota` FOREIGN KEY (`id_divisi`) REFERENCES `ref_divisi` (`id_divisi`),
  ADD CONSTRAINT `fk_rel_jabatan_anggota` FOREIGN KEY (`id_jabatan`) REFERENCES `ref_jabatan` (`id_jabatan`);

--
-- Ketidakleluasaan untuk tabel `zmember`
--
ALTER TABLE `zmember`
  ADD CONSTRAINT `fk_rel_member_group` FOREIGN KEY (`group_id`) REFERENCES `zgroup` (`group_id`);

--
-- Ketidakleluasaan untuk tabel `ztrustee`
--
ALTER TABLE `ztrustee`
  ADD CONSTRAINT `fk_rel_module_ztrustee` FOREIGN KEY (`mod_id`) REFERENCES `zmodule` (`mod_id`),
  ADD CONSTRAINT `fk_rel_zgroup_ztrustee` FOREIGN KEY (`group_id`) REFERENCES `zgroup` (`group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
