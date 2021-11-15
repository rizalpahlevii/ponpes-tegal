-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2021 at 10:17 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ponpes`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi_guru`
--

CREATE TABLE IF NOT EXISTS `absensi_guru` (
`id` int(11) NOT NULL,
  `idkelas` int(11) NOT NULL,
  `idpelajaran` int(11) NOT NULL,
  `idrpp` int(11) NOT NULL,
  `idguru` int(11) NOT NULL,
  `mulai` time NOT NULL,
  `selesai` time NOT NULL,
  `date` date NOT NULL,
  `kehadiran` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `absensi_siswa`
--

CREATE TABLE IF NOT EXISTS `absensi_siswa` (
`id` int(11) NOT NULL,
  `id_jenisabsensi` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `kehadiran` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agama`
--

CREATE TABLE IF NOT EXISTS `agama` (
`id` int(10) unsigned NOT NULL,
  `agama` varchar(20) NOT NULL,
  `urutan` tinyint(1) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agama`
--

INSERT INTO `agama` (`id`, `agama`, `urutan`) VALUES
(34, 'Budha', 5),
(33, 'Hindu', 4),
(30, 'Islam', 1),
(31, 'Katolik', 2),
(32, 'Protestan', 3);

-- --------------------------------------------------------

--
-- Table structure for table `aspekkelompok`
--

CREATE TABLE IF NOT EXISTS `aspekkelompok` (
`id` int(10) unsigned NOT NULL,
  `kode` varchar(50) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `posisi` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aspekkelompok`
--

INSERT INTO `aspekkelompok` (`id`, `kode`, `keterangan`, `posisi`) VALUES
(5, 'KELA', 'WAJIB', '1'),
(7, 'KELB', 'Peminatan', '2');

-- --------------------------------------------------------

--
-- Table structure for table `aturannhb`
--

CREATE TABLE IF NOT EXISTS `aturannhb` (
`id` int(10) unsigned NOT NULL,
  `nipguru` varchar(30) NOT NULL,
  `idpelajaran` int(10) unsigned NOT NULL,
  `dasarpenilaian` varchar(50) NOT NULL,
  `idjenisujian` int(10) unsigned NOT NULL,
  `bobot` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aturannhb`
--

INSERT INTO `aturannhb` (`id`, `nipguru`, `idpelajaran`, `dasarpenilaian`, `idjenisujian`, `bobot`) VALUES
(259, '45', 46, '5', 109, 15),
(260, '45', 46, '5', 110, 10),
(261, '45', 46, '5', 111, 20),
(262, '45', 46, '5', 112, 20),
(263, '45', 46, '5', 113, 20),
(264, '45', 46, '5', 115, 15);

-- --------------------------------------------------------

--
-- Table structure for table `bayarcicilan`
--

CREATE TABLE IF NOT EXISTS `bayarcicilan` (
`id` int(11) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `harga` double(10,2) NOT NULL,
  `timestmp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
`id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `th_terbit` varchar(255) NOT NULL,
  `tmp_terbit` varchar(255) NOT NULL,
  `hal` varchar(255) NOT NULL,
  `tinggi` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sumber` varchar(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `no_inv` varchar(255) NOT NULL,
  `rak` varchar(255) NOT NULL,
  `ket` text NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_kejadian`
--

CREATE TABLE IF NOT EXISTS `daftar_kejadian` (
`id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `poin` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daftar_kejadian`
--

INSERT INTO `daftar_kejadian` (`id`, `nama`, `poin`) VALUES
(1, 'Acuh tak acuh/berbicara yang tidak ada kaitannya dengan pelajaran', 3),
(2, 'Tidur saat jam pelajaran', 5);

-- --------------------------------------------------------

--
-- Table structure for table `dasarpenilaian`
--

CREATE TABLE IF NOT EXISTS `dasarpenilaian` (
`id` int(10) unsigned NOT NULL,
  `dasarpenilaian` varchar(50) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `posisi` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dasarpenilaian`
--

INSERT INTO `dasarpenilaian` (`id`, `dasarpenilaian`, `keterangan`, `posisi`) VALUES
(5, 'AFEK', 'Afektif', ''),
(9, 'PRAK', 'Praktik', '');

-- --------------------------------------------------------

--
-- Table structure for table `datasewa`
--

CREATE TABLE IF NOT EXISTS `datasewa` (
`id` int(11) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `idbuku` varchar(255) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `denda` double NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE IF NOT EXISTS `detail_transaksi` (
`id` int(11) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `idpembayaran` int(11) NOT NULL,
  `harga` double(10,2) NOT NULL,
  `timestmp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi_tmp`
--

CREATE TABLE IF NOT EXISTS `detail_transaksi_tmp` (
`id` int(11) NOT NULL,
  `idpembayaran` int(11) NOT NULL,
  `harga` double(10,2) NOT NULL,
  `timestmp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE IF NOT EXISTS `guru` (
`id` int(10) unsigned NOT NULL,
  `nip` varchar(30) NOT NULL,
  `idpelajaran` int(10) unsigned NOT NULL,
  `statusguru` varchar(50) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `idpelajaran`, `statusguru`, `keterangan`) VALUES
(45, '101', 46, '9', '');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
`id` int(11) NOT NULL,
  `nis` varchar(20) CHARACTER SET utf8 NOT NULL,
  `idkelas` int(11) NOT NULL,
  `idtahunajaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_tmp`
--

CREATE TABLE IF NOT EXISTS `history_tmp` (
`id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `idkelas` int(11) NOT NULL,
  `idtahunajaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `infonap`
--

CREATE TABLE IF NOT EXISTS `infonap` (
`id` int(10) unsigned NOT NULL,
  `idpelajaran` int(10) unsigned NOT NULL DEFAULT '0',
  `idsemester` int(10) unsigned NOT NULL DEFAULT '0',
  `idkelas` int(10) unsigned NOT NULL DEFAULT '0',
  `nilaimin` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jam_absen`
--

CREATE TABLE IF NOT EXISTS `jam_absen` (
  `id` varchar(20) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `batas_telat` time NOT NULL,
  `akses_sekolah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam_absen`
--

INSERT INTO `jam_absen` (`id`, `jam_masuk`, `jam_pulang`, `batas_telat`, `akses_sekolah`) VALUES
('1', '06:30:00', '16:00:00', '06:45:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE IF NOT EXISTS `jawaban` (
`id` int(50) NOT NULL,
  `id_tq` int(50) NOT NULL,
  `id_quiz` int(50) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `jawaban` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenisabsensi`
--

CREATE TABLE IF NOT EXISTS `jenisabsensi` (
`id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `urutan` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenisabsensi`
--

INSERT INTO `jenisabsensi` (`id`, `nama`, `urutan`) VALUES
(1, 'Sorogan', 1),
(2, 'Musyawaroh', 2),
(3, 'Madrasah', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jenispekerjaan`
--

CREATE TABLE IF NOT EXISTS `jenispekerjaan` (
`id` int(10) unsigned NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `urutan` tinyint(2) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenispekerjaan`
--

INSERT INTO `jenispekerjaan` (`id`, `pekerjaan`, `urutan`) VALUES
(18, 'Ibu Rumah Tangga', 3),
(16, 'PNS', 1),
(17, 'Swasta', 2);

-- --------------------------------------------------------

--
-- Table structure for table `jenispembayaran`
--

CREATE TABLE IF NOT EXISTS `jenispembayaran` (
`id` int(11) NOT NULL,
  `pembayaran` varchar(100) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `urutan` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenispembayaran`
--

INSERT INTO `jenispembayaran` (`id`, `pembayaran`, `jenis`, `urutan`) VALUES
(1, 'Mahad', 'Lama', '1'),
(2, 'Mahad', 'Baru', '1'),
(3, 'Madrasah', 'Baru', '2'),
(4, 'Madrasah', 'Lama', '2'),
(5, 'Kearifan dan Kitap Wajib', 'Baru', '3'),
(6, 'Sorogan dan Idlofiyah', 'Lama', '3');

-- --------------------------------------------------------

--
-- Table structure for table `jenisujian`
--

CREATE TABLE IF NOT EXISTS `jenisujian` (
`id` int(10) unsigned NOT NULL,
  `kode` varchar(100) NOT NULL,
  `jenisujian` varchar(50) NOT NULL,
  `idpelajaran` int(10) unsigned NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenisujian`
--

INSERT INTO `jenisujian` (`id`, `kode`, `jenisujian`, `idpelajaran`, `keterangan`) VALUES
(109, 'KS', 'KUIS', 46, '-'),
(110, 'PR', 'Pekerjaan Rumah', 46, ''),
(111, 'TGS', 'Tugas', 46, ''),
(112, 'UAS', 'Ujian Akhir Semester', 46, ''),
(113, 'UTS', 'Ujian Tingkat Semester', 46, ''),
(115, 'UH', 'Ulangan Harian', 46, ''),
(116, 'MTK4001', 'UH', 47, '');

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE IF NOT EXISTS `kas` (
`id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` varchar(200) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
`id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'Agama'),
(2, 'politik'),
(4, 'hukum'),
(6, 'sejarah'),
(7, 'umum'),
(8, 'sosial'),
(9, 'bahasa'),
(10, 'majalah harian'),
(11, 'Teknik');

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE IF NOT EXISTS `kehadiran` (
`id` int(11) NOT NULL,
  `kehadiran` varchar(50) NOT NULL,
  `urutan` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kehadiran`
--

INSERT INTO `kehadiran` (`id`, `kehadiran`, `urutan`) VALUES
(1, 'Ghoib', '5'),
(2, 'Sakit', '2'),
(3, 'Ijin', '3'),
(4, 'Terlambat', '4'),
(5, 'Masuk', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kejadian_siswa`
--

CREATE TABLE IF NOT EXISTS `kejadian_siswa` (
`id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `iddaftarkejadian` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
`id` int(10) unsigned NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `idtahunajaran` int(10) unsigned NOT NULL,
  `kapasitas` int(10) unsigned NOT NULL,
  `nipwali` varchar(30) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas`, `idtahunajaran`, `kapasitas`, `nipwali`, `tingkat`, `keterangan`) VALUES
(47, '3 IBT Q', 21, 40, '101', '3', '-'),
(48, '3 IBT R', 21, 40, '101', '3', ''),
(49, '3 IBT S', 21, 40, '101', '3', ''),
(50, '3 IBT T', 21, 40, '101', '3', ''),
(51, '4 IBT A', 21, 40, '101', '4', ''),
(52, '4 IBT B', 21, 40, '101', '4', ''),
(53, '4 IBT C', 21, 40, '101', '4', ''),
(54, '4 IBT D', 21, 40, '101', '4', ''),
(55, '4 IBT E', 21, 40, '101', '4', ''),
(56, '4 IBT F', 21, 40, '101', '4', ''),
(57, '4 IBT G', 21, 40, '101', '4', ''),
(58, '4 IBT H', 21, 40, '101', '4', ''),
(59, '4 IBT I', 21, 40, '101', '4', ''),
(60, '4 IBT J', 21, 40, '101', '4', ''),
(61, '4 IBT K', 21, 40, '101', '4', ''),
(62, '4 IBT L', 21, 40, '101', '4', ''),
(63, '4 IBT M', 21, 40, '101', '4', ''),
(64, '5 IBT A', 21, 40, '101', '5', ''),
(65, '5 IBT B', 21, 40, '101', '5', ''),
(66, '5 IBT C', 21, 40, '101', '5', ''),
(67, '5 IBT D', 21, 40, '101', '5', ''),
(68, '5 IBT E', 21, 40, '101', '5', ''),
(69, '5 IBT F', 21, 40, '101', '5', ''),
(70, '5 IBT G', 21, 40, '101', '5', ''),
(71, '5 IBT H', 21, 40, '101', '5', ''),
(72, '5 IBT I', 21, 40, '101', '5', ''),
(73, 'XII MIPA 2', 21, 31, '', '12', ''),
(74, 'XII MIPA 3', 21, 36, '', '12', ''),
(75, 'XII MIPA 4', 21, 33, '', '12', ''),
(76, 'XII MIPA 5', 21, 34, '', '12', ''),
(77, 'XII MIPA 6', 21, 36, '', '12', ''),
(78, 'XII MIPA 7', 21, 34, '', '12', ''),
(79, 'XII MIPA 8', 21, 35, '', '12', ''),
(80, 'XII IPS 1', 21, 35, '', '12', ''),
(81, 'XII IPS 2', 21, 37, '', '12', ''),
(82, 'XII IPS 3', 21, 36, '', '12', ''),
(83, 'XII IPS 4', 21, 35, '', '12', ''),
(84, 'X MIPA 3', 21, 36, '197707062009022003', '10', ''),
(85, 'X MIPA 4', 21, 36, '196510122005011006', '10', ''),
(86, 'X MIPA 5', 21, 36, '197107152007011029', '10', ''),
(87, 'X MIPA 7', 21, 37, '196503082005011004', '10', ''),
(88, '5 IBT J', 21, 40, '101', '5', ''),
(89, 'X IPS 1', 21, 39, '196401131987032003', '10', ''),
(90, 'X IPS 2', 21, 39, '196506061988032015', '10', ''),
(91, 'X IPS 3', 21, 38, '1000024', '10', ''),
(92, 'X IBB', 21, 31, '196910272005012003', '10', ''),
(93, '6 IBT A', 21, 40, '101', '6', ''),
(94, 'XI MIPA 2', 21, 35, '196610031991022003', '11', ''),
(95, 'XI MIPA 3', 21, 35, '196210031987022003', '11', ''),
(96, '6 IBT B', 21, 40, '101', '6', ''),
(97, 'XI MIPA 5', 21, 36, '196501291990032005', '11', ''),
(98, '6 IBT C', 21, 40, '101', '6', ''),
(99, '6 IBT D', 21, 40, '101', '6', ''),
(100, 'XI MIPA 8', 21, 22, '197511212008012009', '11', ''),
(101, '6 IBT E', 21, 40, '101', '6', ''),
(102, 'XI IPS 2', 21, 36, '196406011985122002', '11', ''),
(103, 'XI IPS 3', 21, 36, '196908142000122003', '11', ''),
(104, 'XI IPS 4', 21, 36, '198402112009021006', '11', ''),
(105, 'XI IBB', 21, 24, '199202262015022002', '11', ''),
(106, 'XII MIPA 1', 21, 36, '196408151990032009', '12', ''),
(107, 'XII MIPA 2', 21, 31, '197811262008012008', '12', ''),
(108, 'XII MIPA 3', 21, 36, '197711172008012014', '12', ''),
(109, '6 IBT F', 21, 40, '101', '6', ''),
(110, '6 IBT G', 21, 40, '101', '6', ''),
(111, 'XII MIPA 6', 21, 36, '197004142008012021', '12', ''),
(112, 'XII MIPA 7', 21, 34, '197411251999032006', '12', ''),
(113, 'XII MIPA 8', 21, 35, '196304021987022003', '12', ''),
(114, '6 IBT H', 21, 40, '101', '6', ''),
(115, '6 IBT I', 21, 40, '101', '6', ''),
(116, 'XII IPS 3', 21, 36, '196810242005012008', '12', ''),
(117, '6 IBT J', 21, 40, '101', '6', ''),
(118, '1 TS A', 21, 40, '101', '7', ''),
(119, '1 TS B', 21, 40, '101', '7', ''),
(120, '1 TS C', 21, 40, '101', '7', ''),
(121, '1 TS D', 21, 40, '101', '7', ''),
(122, '1 TS E', 21, 40, '101', '7', ''),
(123, '1 TS F', 21, 40, '101', '7', ''),
(124, '1 TS G', 21, 40, '101', '7', ''),
(125, '2 TS A', 21, 40, '101', '8', ''),
(126, '2 TS B', 21, 40, '101', '8', ''),
(127, '2 TS C', 21, 40, '101', '8', ''),
(128, '2 TS D', 21, 40, '101', '8', ''),
(129, '2 TS E', 21, 40, '101', '8', ''),
(130, '2 TS F', 21, 40, '101', '8', ''),
(131, '3 TS A', 21, 40, '123456', '9', ''),
(132, '3 TS B', 21, 40, '101', '9', ''),
(133, '3 TS C', 21, 40, '101', '9', ''),
(134, '3 TS D', 21, 40, '101', '9', ''),
(135, '1 ALY A', 21, 40, '101', '10', ''),
(136, '1 ALY B', 21, 40, '101', '10', ''),
(137, '1 ALY C', 21, 40, '101', '10', ''),
(138, '2 ALY A', 21, 40, '101', '11', ''),
(139, '2 ALY B', 21, 40, '101', '11', ''),
(140, '3 ALY A', 21, 40, '101', '12', ''),
(141, '4 IBT A', 22, 40, '101', '4', ''),
(142, '4 IBT B', 22, 40, '101', '4', '');

-- --------------------------------------------------------

--
-- Table structure for table `kondisisiswa`
--

CREATE TABLE IF NOT EXISTS `kondisisiswa` (
`id` int(10) unsigned NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `urutan` tinyint(2) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kondisisiswa`
--

INSERT INTO `kondisisiswa` (`id`, `kondisi`, `urutan`) VALUES
(10, 'Berkecukupan', 1),
(11, 'Kurang Mampu', 2);

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE IF NOT EXISTS `materi` (
`id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `idkelas` varchar(5) NOT NULL,
  `idpelajaran` varchar(5) NOT NULL,
  `file` varchar(100) NOT NULL,
  `tgl_posting` date NOT NULL,
  `nip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `posisi` int(11) NOT NULL,
  `icon_menu` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `posisi`, `icon_menu`) VALUES
(1, 'Data Master', 1, 'fa fa-bookmark'),
(2, 'Pengaturan', 8, 'fa fa-gears'),
(3, 'Absensi', 2, 'fa fa-clock-o '),
(5, 'Nilai', 3, 'fa fa-list-alt'),
(16, 'Reverensi', 0, 'fa fa-cog'),
(17, 'Bimbingan Konseling', 4, 'fa fa-tasks'),
(18, 'Keuangan', 5, 'fa fa-money'),
(19, 'E-learning', 7, 'fa fa-headphones'),
(20, 'Perpustakaan', 6, 'fa fa-folder');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE IF NOT EXISTS `modul` (
`id_modul` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_modul` varchar(150) NOT NULL,
  `link_menu` text NOT NULL,
  `posisi` int(11) NOT NULL,
  `icon_menu` varchar(150) NOT NULL,
  `akses_sekolah` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id_modul`, `id_menu`, `nama_modul`, `link_menu`, `posisi`, `icon_menu`, `akses_sekolah`) VALUES
(1, 1, 'Data Siswa', 'med.php?mod=siswa', 5, 'fa fa-circle', ''),
(4, 2, 'Jam Absensi', 'med.php?mod=jamabsen', 3, 'fa fa-clock-o', ''),
(7, 1, 'Data Guru', 'med.php?mod=guru', 3, 'fa fa-circle', ''),
(8, 1, 'Data Kelas', 'med.php?mod=kelas', 4, 'fa fa-circle', ''),
(10, 1, 'Data Tahun Ajaran', 'med.php?mod=tahunajaran', 1, 'fa fa-circle', ''),
(11, 1, 'Data User', 'med.php?mod=user', 6, 'fa fa-circle', ''),
(12, 1, 'Data Pelajaran', 'med.php?mod=pelajaran', 2, 'fa fa-circle', ''),
(13, 5, 'Aspek Penilaian', 'med.php?mod=aspekpenilaian', 2, 'fa fa-circle', ''),
(14, 5, 'Program Pembelajaran', 'med.php?mod=program', 3, 'fa fa-circle', ''),
(15, 5, 'Jenis Pengujian', 'med.php?mod=jenispengujian', 4, 'fa fa-circle', ''),
(16, 5, 'Perhitungan NIlai', 'med.php?mod=perhitungan_nilai', 5, 'fa fa-circle', ''),
(17, 5, 'Input Nilai', 'med.php?mod=nilai', 6, 'fa fa-circle', ''),
(18, 5, 'Data Raport Katagori', 'med.php?mod=raport', 7, 'fa fa-circle', ''),
(19, 3, 'Data Absen', 'med.php?mod=absen', 1, 'fa fa-circle', ''),
(20, 3, 'Laporan Absensi', 'med.php?mod=laporan_absen', 2, 'fa fa-circle', ''),
(21, 15, 'Surat Pemberitahuan', 'med.php?mod=surat', 1, 'fa fa-circle', ''),
(22, 15, 'Pengumuman', 'med.php?mod=pengumuman', 2, 'fa fa-circle', ''),
(23, 15, 'Pengaturan Surat', 'med.php?mod=pengantarsurat', 3, 'fa fa-circle', ''),
(24, 15, 'Lampiran Surat', 'med.php?mod=lapiran', 4, 'fa fa-circle', ''),
(25, 16, 'Agama', 'med.php?mod=agama', 1, 'fa fa-circle', ''),
(26, 16, 'Pekerjaan', 'med.php?mod=pekerjaan', 2, 'fa fa-circle', ''),
(27, 16, 'Pendidikan', 'med.php?mod=pendidikan', 3, 'fa fa-circle', ''),
(28, 16, 'Status Siswa', 'med.php?mod=statusiswa', 4, 'fa fa-circle', ''),
(29, 16, 'Status Guru', 'med.php?mod=statusguru', 5, 'fa fa-circle', ''),
(30, 16, 'Kodisi Siswa', 'med.php?mod=kondisisiswa', 6, 'fa fa-circle', ''),
(31, 16, 'Data Pegawai', 'med.php?mod=pegawai', 7, 'fa fa-circle', ''),
(32, 16, 'Semester', 'med.php?mod=semester', 8, 'fa fa-circle', ''),
(33, 18, 'Pembayaran SPP', 'med.php?mod=spp', 1, 'fa fa-circle', ''),
(34, 18, 'Laporan SPP', 'med.php?mod=laporan', 2, 'fa fa-circle', ''),
(35, 17, 'Data Kejadian Sekolah', 'med.php?mod=kejadian_sekolah', 1, 'fa fa-circle', ''),
(36, 17, 'Data Kejadian Siswa', 'med.php?mod=kejadian_siswa&id=1', 2, 'fa fa-circle', ''),
(38, 17, 'Pengaturan', 'med.php?mod=pengaturan_bk&id=1', 4, 'fa fa-circle', ''),
(39, 20, 'Kategori Buku', 'med.php?mod=kategori_buku', 1, 'fa fa-circle', ''),
(40, 20, 'Sumber Buku', 'med.php?mod=sumber_buku', 2, 'fa fa-circle', ''),
(41, 20, 'Rak Buku', 'med.php?mod=rak_buku', 3, 'fa fa-circle', ''),
(42, 20, 'Data Buku', 'med.php?mod=buku', 4, 'fa fa-circle', ''),
(43, 20, 'Data Peminjaman', 'med.php?mod=peminjaman', 5, 'fa fa-circle', ''),
(44, 20, 'Data Kas', 'med.php?mod=kas', 7, 'fa fa-circle', ''),
(46, 20, 'Data Pengembalian', 'med.php?mod=pengembalian', 6, 'fa fa-circle', ''),
(47, 5, 'Aspek Kelompok', 'med.php?mod=kelompok', 0, 'fa fa-circle', ''),
(48, 19, 'Materi', 'med.php?mod=materi', 1, 'fa fa-circle', ''),
(49, 19, 'Quiz', 'med.php?mod=quiz', 2, 'fa fa-circle', '');

-- --------------------------------------------------------

--
-- Table structure for table `nap`
--

CREATE TABLE IF NOT EXISTS `nap` (
`id` int(10) unsigned NOT NULL,
  `nis` varchar(20) NOT NULL DEFAULT '',
  `idaturan` int(10) unsigned NOT NULL DEFAULT '0',
  `idinfo` int(10) unsigned NOT NULL DEFAULT '0',
  `nilaiangka` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nilaihuruf` varchar(2) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
`id` int(50) NOT NULL,
  `id_tq` int(50) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `benar` int(10) NOT NULL,
  `salah` int(10) NOT NULL,
  `tidak_dikerjakan` int(50) NOT NULL,
  `persentase` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nilaiujian`
--

CREATE TABLE IF NOT EXISTS `nilaiujian` (
`id` int(10) unsigned NOT NULL,
  `idujian` int(10) unsigned NOT NULL DEFAULT '0',
  `nis` varchar(20) NOT NULL,
  `nilaiujian` varchar(100) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nilai_soal_esay`
--

CREATE TABLE IF NOT EXISTS `nilai_soal_esay` (
`id` int(50) NOT NULL,
  `id_tq` int(50) NOT NULL,
  `id_siswa` int(50) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
`id` int(10) unsigned NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nrp` varchar(30) DEFAULT NULL,
  `nuptk` varchar(30) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `panggilan` varchar(50) DEFAULT NULL,
  `gelarawal` varchar(45) DEFAULT NULL,
  `gelarakhir` varchar(45) DEFAULT NULL,
  `tmplahir` varchar(50) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `noid` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `handphone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` blob,
  `bagian` varchar(50) NOT NULL,
  `nikah` varchar(50) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `kelamin` varchar(50) NOT NULL,
  `pinpegawai` varchar(100) DEFAULT NULL,
  `mulaikerja` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `ketnonaktif` varchar(45) DEFAULT NULL,
  `pensiun` date DEFAULT NULL,
  `doaudit` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nrp`, `nuptk`, `nama`, `panggilan`, `gelarawal`, `gelarakhir`, `tmplahir`, `tgllahir`, `agama`, `noid`, `alamat`, `handphone`, `email`, `foto`, `bagian`, `nikah`, `keterangan`, `kelamin`, `pinpegawai`, `mulaikerja`, `status`, `ketnonaktif`, `pensiun`, `doaudit`) VALUES
(24, '101', '', '', 'Sultan Abdullah', 'Sultan', 'S1', 'S1', 'surabaya', '1989-01-06', '30', '101', '0837492893', '0837492893', 'ABDULLAH@GMAIL.COM', 0x313536303738393632385f323934382e706e67, 'Akademik', 'Sudah Menikah', 'Laki - Laki', 'Laki - Laki', '81dc9bdb52d04dc20036dbd8313ed055', '0000-00-00', '', '', '0000-00-00', 0),
(25, '123456', '', '', 'ali', '', '', '', '', '0000-00-00', '30', '', '', '', '', 0x313633353233353034375f373437332e6a7067, 'Akademik', 'Pilih Status', '', 'Pilih Jenis Kelamin', '811ab705e275bb64300045c892c48289', '0000-00-00', '', '', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pelajaran`
--

CREATE TABLE IF NOT EXISTS `pelajaran` (
`id` int(10) unsigned NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `sifat` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `KKM` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pelajaran`
--

INSERT INTO `pelajaran` (`id`, `kode`, `nama`, `sifat`, `KKM`) VALUES
(46, 'HBA', 'HASYIATUL BAIJURI ALASSANUSIAH ( BIL MANTHIQ )', '5', '6'),
(47, 'MT1', 'MINHAJUT THALIBIN ( 1 )', '5', ''),
(48, 'AWN1', 'AL ASYBAH WAN NADZOIR  ( 1)', '5', ''),
(49, 'LU1', 'LUBBUL USHUL ( 1 )', '5', ''),
(50, 'SM1', 'SHAHIH MUSLIM ( 1 )', '5', ''),
(51, 'ISM', 'IHMIRAR SULLAMUL MUNAWRAQ', '5', ''),
(52, 'HS', 'HUSNUSH SHIAGHOH', '5', ''),
(53, 'FQ', 'FALAQ', '5', ''),
(54, 'ASAH', 'ASY-SYARQAWI ALAL HUDHUDI ( BIL MANTHIQ )', '5', ''),
(55, 'MT2', 'MINHAJUT THALIBIN ( 2 )', '5', ''),
(56, 'AWN2', 'AL ASYBAH WAN NADZOIR  (2)', '5', ''),
(57, 'LU2', 'LUBBUL USHUL ( 2 )', '5', ''),
(58, 'SM2', 'SHAHIH MUSLIM (2 )', '5', ''),
(59, 'AS1', 'ASY-SYAMSIYYAH 1 ( MANTHIQ )', '5', ''),
(60, 'AJM', 'AL-JAUHARUL MAKNUN', '5', ''),
(61, 'MT3', 'MINHAJUT THALIBIN ( 3 )', '5', ''),
(62, 'AWN3', 'AL ASYBAH WAN NADZOIR  ( 3 )', '5', ''),
(63, 'JJ', 'JAMUL JAWAMI', '5', ''),
(64, 'SM', 'SHAHIH MUSLIM (3 )', '5', ''),
(65, 'AS2', 'ASY-SYAMSIYYAH 2 ( MANTHIQ )', '5', ''),
(66, 'UJ', 'UQUDUL JUMAN', '5', ''),
(67, 'JT', 'JAUHARATUT TAUHID', '5', ''),
(68, 'A1', 'ALFIYYAH 1 ( SYARAH IBN AQIL )', '5', ''),
(69, 'FM', 'FATHUL MUIN 1 ( IRTHIBAATH )', '5', ''),
(70, 'JB1', 'JAWAHIRUL BUKHORI 1', '5', ''),
(71, 'BU1', 'BIDAYATUL USHULI ( 1 )', '5', ''),
(72, 'UF', 'UDDATUL FAARIDH', '5', ''),
(73, 'FM', 'FATHUL MAJID', '5', ''),
(74, 'A2', 'ALFIYYAH 2 ( SYARAH IBN AQIL )', '5', ''),
(75, 'FM2', 'FATHUL MUIN 2 ( IRTHIBAATH )', '5', ''),
(76, 'JB2', 'JAWAHIRUL BUKHORI 2', '5', ''),
(77, 'AW', 'AL WARAQAAT', '5', ''),
(78, 'MA', 'MANDZUMAH ALBAIQUNIYAH + AL QAWAIDUL ASASIYAH', '5', ''),
(79, 'AM', 'ANWARUL MUHAMMADIYYAH', '5', ''),
(80, 'KA', 'KIFAYATUL AWAM', '5', ''),
(81, 'IA', 'IHMIRAR ALFIYYAH + LAMIYATUL AFAL', '5', ''),
(82, 'FM3', 'FATHUL MUIN 3 ( IRTHIBAATH )', '5', ''),
(83, 'NZIR', 'NADZOM ZUBAD IBN RUSLAN ( TAHFIDZ )', '5', ''),
(84, 'BU2', 'BIDAYATUL USHULI ( 2 )', '5', ''),
(85, 'IQF', 'IDHOHUL QAWAIDIL FIQHIYYAH', '5', ''),
(86, 'BB', 'BIDAYATUL BALAGHAH', '5', ''),
(87, 'RA', 'RISALAH AWWAL', '5', ''),
(88, 'AJMT', 'AL JURUMIYAH MAAT TAKMILAH', '5', ''),
(89, 'SN', '( ZUBAD TA ARUF ) + SAFIINATUN NAJA', '5', ''),
(90, 'TK', 'TASHRIF KUMFIIK ( ISTHILAHI )', '5', ''),
(91, 'SJ', 'SYIFAUL JINAN', '5', ''),
(92, 'KI', 'KHATH IMLA + BAHASA ARAB', '5', ''),
(93, 'AA', 'AQIDATUL AWAM', '5', ''),
(94, 'AJMT', 'AL JURUMIYAH MAAT TAKMILAH', '5', ''),
(95, 'ST', '( ZUBAD TA ARUF ) + SULLAMUT TAUFIIQ', '5', ''),
(96, 'TK', 'TASHRIF KUMFIIK ( LUGHOWI )', '5', ''),
(97, 'AAA', 'AL ARBAIN ANNAWAWIYAH', '5', ''),
(98, 'QI', 'QAWAIDUL ILAL + BAHASA ARAB', '5', ''),
(99, 'QI', 'QAWAIDUL ILAL + BAHASA ARAB', '5', ''),
(100, 'KB', 'KHARIDATUL BAHIYYAH', '5', ''),
(101, 'AIMT', 'AL IMRITHI MAAT TAKMILAH', '5', ''),
(102, 'FQ1', 'FATHUL QARIIB ( 1 )', '5', ''),
(103, 'AAT', 'AL AMTSILATUT TASHRIFIYYAH', '5', ''),
(104, 'RS1', 'RIYADUSHOLIHIN ( 1 )', '5', ''),
(105, 'AI', 'AL ILAL + BAHASA ARAB', '5', ''),
(106, 'TM', 'TALIMUL MUTAALLIM', '5', ''),
(107, 'ASS', 'ASSANUSIYYAH', '5', ''),
(108, 'MI', 'MULHATUL IRAB ( TUHFATUL AHBAB )', '5', ''),
(109, 'FQ2', 'FATHUL QARIIB ( 2 )', '5', ''),
(110, 'AK', 'AL KAILANI', '5', ''),
(111, 'RS2', 'RIYADUSHOLIHIN ( 2 )', '5', ''),
(112, 'AG', 'ALFARAIDHUL GHAZALIYAH', '5', ''),
(113, 'AA', 'Al Ala', '5', '60');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE IF NOT EXISTS `pembayaran` (
`id` int(11) NOT NULL,
  `idjenispembayaran` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `idjenispembayaran`, `nama`, `harga`) VALUES
(1, 2, 'Pendafataran', '200000.00'),
(2, 2, 'Uang Gedung', '500000.00'),
(3, 3, 'Pendafataran', '110000.00'),
(4, 5, 'Pendafataran', '35000.00'),
(7, 1, 'Pendafataran', '150000.00'),
(8, 1, 'Syahriyah Ibtidaiyah', '65000.00'),
(9, 1, 'Syahriyah Tsanawiyah & Aliyah', '70000.00'),
(10, 4, 'Pendafataran Ibtidaiyah', '70000.00'),
(11, 4, 'Syahriyah Ibtidaiyah', '60000.00'),
(12, 4, 'Buku Tamrin Ibtidaiyah', '12000.00'),
(13, 2, 'Perlengkapan', '250000.00'),
(14, 2, 'Dana Kesehatan', '27000.00'),
(15, 2, 'Syahriyah', '65000.00'),
(16, 2, 'PHBI', '60000.00'),
(17, 2, 'Seragam', '180000.00'),
(18, 5, 'Rapor', '5000.00'),
(19, 5, 'Kartu Sorogan', '40000.00'),
(20, 5, 'Khomriyah', '5000.00'),
(21, 5, 'Majmu Aurod Sholat', '7000.00'),
(22, 5, 'Majmu Aurod Jumat', '8000.00'),
(23, 5, 'Durusul Idlofiyah', '35000.00'),
(24, 5, 'Awamil Al Jurjani', '5000.00'),
(25, 3, 'Syahriyah', '60000.00'),
(26, 3, 'Buku Tamrin', '12000.00'),
(27, 3, 'Rapor', '16000.00'),
(28, 1, 'Dana Kesehatan', '25000.00'),
(29, 1, 'Perawatan Gedung', '50000.00'),
(30, 1, 'PHBI', '60000.00'),
(31, 4, 'Pendaftaran Kelas I Tsanawiyah', '70000.00'),
(32, 4, 'Syahriyah Kelas I Tsanawiyah', '60000.00'),
(33, 4, 'Buku Tamrin Kelas I Tsanawiyah', '12000.00'),
(34, 4, 'Rapor Tamrin Kelas I Tsanawiyah', '16000.00'),
(35, 4, 'Pendafataran Kelas I Aliyah', '70000.00'),
(36, 4, 'Syahriyah Kelas I Aliyah', '60000.00'),
(37, 4, 'Rapor Kelas I Aliyah', '16000.00'),
(38, 6, 'Pendafataran', '35000.00'),
(39, 6, 'Kartu Sorogan', '40000.00'),
(40, 6, 'Durusul Idlofiyah', '35000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_bk`
--

CREATE TABLE IF NOT EXISTS `pengaturan_bk` (
`id` int(11) NOT NULL,
  `poinawal` varchar(100) NOT NULL,
  `reward` varchar(10) NOT NULL,
  `sistempelanggaran` varchar(50) NOT NULL,
  `text1` varchar(200) NOT NULL,
  `text2` varchar(200) NOT NULL,
  `text3` varchar(200) NOT NULL,
  `text4` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan_bk`
--

INSERT INTO `pengaturan_bk` (`id`, `poinawal`, `reward`, `sistempelanggaran`, `text1`, `text2`, `text3`, `text4`) VALUES
(1, '0', 'Tidak Ada', 'Ditambah', 'SEKOLAH TINGGI SURABAYA', 'NEGERI 1', 'jalan sukarno hata no 150 sidoarjo', 'website : smats.co.id');

-- --------------------------------------------------------

--
-- Table structure for table `pengembangan_prestasi`
--

CREATE TABLE IF NOT EXISTS `pengembangan_prestasi` (
`id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `info1` varchar(20) NOT NULL,
  `info2` varchar(20) NOT NULL,
  `info3` varchar(20) NOT NULL,
  `ket` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_esay`
--

CREATE TABLE IF NOT EXISTS `quiz_esay` (
`id` int(9) NOT NULL,
  `idquiz` int(9) NOT NULL,
  `pertanyaan` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `tgl_buat` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_pilganda`
--

CREATE TABLE IF NOT EXISTS `quiz_pilganda` (
`id` int(10) NOT NULL,
  `idquiz` int(9) NOT NULL,
  `pertanyaan` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `pil_a` text NOT NULL,
  `pil_b` text NOT NULL,
  `pil_c` text NOT NULL,
  `pil_d` text NOT NULL,
  `kunci` varchar(1) NOT NULL,
  `tgl_buat` date NOT NULL,
  `jenis_soal` varchar(50) NOT NULL DEFAULT 'pilganda'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE IF NOT EXISTS `rak` (
`id` int(11) NOT NULL,
  `rak` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`id`, `rak`) VALUES
(1, '101 -Teknik'),
(2, '102 - Agama');

-- --------------------------------------------------------

--
-- Table structure for table `raport_katagori`
--

CREATE TABLE IF NOT EXISTS `raport_katagori` (
`id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `idpelajaran` int(11) NOT NULL,
  `idrpp` int(11) NOT NULL,
  `jenisujian` varchar(50) NOT NULL,
  `uhke` varchar(15) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rpp`
--

CREATE TABLE IF NOT EXISTS `rpp` (
`id` int(10) unsigned NOT NULL,
  `idsemester` int(10) unsigned NOT NULL,
  `idpelajaran` int(10) unsigned NOT NULL,
  `koderpp` varchar(20) NOT NULL,
  `periode` varchar(100) NOT NULL,
  `rpp` varchar(255) NOT NULL,
  `deskripsi` text,
  `aktif` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rpp`
--

INSERT INTO `rpp` (`id`, `idsemester`, `idpelajaran`, `koderpp`, `periode`, `rpp`, `deskripsi`, `aktif`) VALUES
(1, 21, 46, 'AGM1001', '', 'Iman kepada Kitab-kitab Allah', '<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>A. </strong><strong>Standar Kompetensi</strong></p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; Meningkatkan keimanan kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>B. </strong><strong>Kompetensi Dasar</strong></p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">8.1. Menampilkan perilaku yang mencerminkan keimanan terhadap kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">8.2. Menerapkan hikmah beriman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>C. </strong><strong>Indikator Pencapaian Hasil Belajar</strong></p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">8.1.1. Mampu menjelaskan pengertian iman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">8.1.2. Mampu menunjukkan perilaku beriman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">8.2.1. Mampu menjelaskan hikmah beriman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">8.2.2. Mampu menerapkan hikmah beriman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>D. </strong><strong>Uraian Materi Pembelajaran</strong></p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">Materi pokok: Iman kepada Kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">Uraian materi pokok:</p>\r\n\r\n<ol>\r\n	<li>Pengertian iman kepada kitab-kitab Allah.</li>\r\n	<li>Sikap perilaku beriman kepada kitab-kitab Allah.</li>\r\n	<li>Hikmah beriman kepada kitab-kitab Allah.</li>\r\n</ol>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>E. </strong><strong>Pengalaman Belajar</strong></p>\r\n\r\n<ul>\r\n	<li>Membaca materi pembelajaran Bab 8 (Iman kepada Kitab-kitab Allah) dalam buku Pendidikan Agama Islam SMA Kelas XI, Penerbit Erlangga.</li>\r\n	<li>Mendiskusikan pengertian iman kepada kitab-kitab Allah.</li>\r\n	<li>Mempraktekkan perilaku beriman kepada kitab-kitab Allah.</li>\r\n	<li>Mendiskusikan hikmah beriman kepada kitab-kitab Allah dan menerapkannya dalam kehidupan sehari-hari.</li>\r\n	<li>Mengerjakan soal-soal latihan Bab 8 dan mengikuti ulangan harian Bab 8.</li>\r\n</ul>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>F. </strong><strong>Media Pembelajaran</strong></p>\r\n\r\n<ol>\r\n	<li>Alat: - Al-Qur`an dan terjemahnya</li>\r\n</ol>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- OHP dan lingkungan sekitar</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp;2. Sumber bahan: Buku Pendidikan Agama Islam SMA Kelas XI, Penerbit Erlangga</p>\r\n\r\n<ol>\r\n</ol>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>G. </strong><strong>Skenario Pembelajaran</strong></p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; a. Pendahuluan</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 1. Tadarus Al-Qur`an (5&ndash;10 menit).</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 2. Apersepsi dan motivasi belajar.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 3. Menyampaikan soal-soal tes awal (<em>pre test</em>).</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 4. Informasi indikator pencapaian hasil belajar.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; b. Kegiatan Inti</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 1. Membaca materi pembelajaran `Iman kepada Kitab-kitab Allah`</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; dalam buku Pendidikan Agama Islam SMA Kelas XI, Penerbit Erlangga.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 2. Diskusi dan tanya jawab tentang pengertian iman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 3. Diskusi dan tanya jawab tentang contoh-contoh perilaku</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; beriman kepada kitab-kitab Allah.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 4. Mendiskusikan hikmah-hikmah beriman kepada kitab-kitab Allah</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; kemudian menerapkannya dalam kehidupan sehari-hari.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; c. Penutup</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 1. Menyimpulkan materi pembelajaran.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 2. Menyampaikan tes akhir (<em>post test</em>).</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 3. Pemberian tugas untuk mengerjakan soal-soal latihan Bab 8.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp;</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;"><strong>H. </strong><strong>Penilaian</strong></p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; a. Prosedur</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 1. Penialain proses belajar melalui observasi, tanya jawab, dan tugas.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; 2. Penilaian hasil belajar melalui tugas mengerjakan soal-soal latihan Bab 8</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; dan ulangan harian.</p>\r\n\r\n<p style="color: rgb(0, 0, 0); font-size: 11px; font-weight: 400; font-style: normal;">&nbsp; &nbsp; b. Alat penilaian: lembar pengamatan dan soal-soal pilihan ganda dan esay.</p>\r\n', 'Aktif'),
(2, 21, 46, 'AGM1002', '2019', '25 Nabi dan Rosul', '<p>Mengenal Nama Nabi dan Rosul beserta Kisahnya</p>\r\n', 'Aktif'),
(3, 21, 47, 'MTK4001', '2019', 'Perkalian', '', 'Aktif'),
(7, 21, 49, 'X-MATW', 'Periode 2', '3.3  ', '<p>Menyusun sistem persamaan linier tiga variavel dari masalah konstektual&nbsp;</p>\r\n\r\n<p><strong>Materi :</strong> Persamaan linier tiga variabel</p>\r\n', 'Aktif'),
(8, 21, 49, 'X-MATW', 'Periode 2', '3.4  ', '<p>Menjelaskan dan menentukan penyelesaian sistem pertidaksanaan dua variabel (linier kwadrat dan kwadrat-kwadrat)</p>\r\n\r\n<p><strong>Materi :&nbsp;</strong> Pertidaksamaan dua variavel (Linier kwadrat-kwadrat)</p>\r\n', 'Aktif'),
(9, 21, 49, 'XI-MATW', 'Periode 2', '3.3', '<p>Menjelaskan dan kesamaan matriks dengan menggunakan masalah kontektual dan melakukan operasi pada matriks yang meliputi penjumlahan, pengurangan, perkalian skalar, dan perkalian serta transpos.</p>\r\n\r\n<p><strong>materi : Matriks</strong></p>\r\n', 'Aktif'),
(10, 21, 49, 'XI-MATW', 'Periode 2', '3.4', '<p>Menganalisis sifat-sifat determinan dan invers berodo 2x2 dan 3x3</p>\r\n\r\n<p><strong>materi :&nbsp;</strong>Determinan dan invers matriks</p>\r\n', 'Aktif'),
(11, 21, 46, 'X-PAI', 'Periode 2', '3.9', '<p>Pengelolaan haji, zakat, dan wakaf</p>\r\n', 'Aktif'),
(12, 21, 46, 'XI-PAI', 'Periode 2', '3.7', '<p>Pelaksanaan tatacara penyelenggaran jenazah</p>\r\n', 'Aktif'),
(13, 21, 47, 'X-PPKN', 'Periode 2', '3.3', '<p>Kewenangan lembaga-lembaga Negara menurut UUD NRI tahun 1945</p>\r\n', 'Aktif'),
(14, 21, 47, 'XI-PPKN', 'Periode 2', '3.2', '<p>Sistem dan dinamika demokrasi pancasila</p>\r\n', 'Aktif'),
(15, 21, 48, 'X-BIND', 'Periode 2', '3.4', '<p>EKSPOSISI</p>\r\n', 'Aktif'),
(16, 21, 48, 'X-BIND', 'Periode 2', '3.5', '<p>TEKS ANEKDOT</p>\r\n', 'Aktif'),
(17, 21, 48, 'X-BIND', 'Periode 2', '3.6', '<p>TEKS ANEKDOT</p>\r\n', 'Aktif'),
(18, 21, 48, 'XI-BIND', 'Periode 2', '3.14', '<p>EKSPLANASI</p>\r\n', 'Aktif'),
(19, 21, 48, 'XI-BIND', 'Periode 2', '3.15', '<p>Ceramah</p>\r\n', 'Aktif'),
(20, 21, 48, 'XI-BIND', 'Periode 2', '3.16', '<p>Ceramah</p>\r\n', 'Aktif'),
(21, 21, 48, 'XI-BIND', 'Periode 2', '3.17', '<p>Buku non fiksi (pengayaan)</p>\r\n', 'Aktif'),
(22, 21, 50, 'X-SEJINDO', 'Periode 2', '3.3', '<p>Kehidupan manusia purba dan asal-usul nenek moyang bangsa Indonesia (Melanesoid, Proto, dan Deutero Melayu)</p>\r\n', 'Aktif'),
(23, 21, 50, 'XI-SEJINDO', 'Periode 2', '3.2', '<p>Strategi perlawanan bangsa Indonesia terhadap penjajahan bangsa Eropa (Portugis, Spanyol, Belanda, Inggris) sampai dengan abad ke-20</p>\r\n', 'Aktif'),
(24, 21, 50, 'XI-SEJINDO', 'Periode 2', '3.3', '<p>Dampak politik, budaya, sosial, ekonomi, dan pendidikan&nbsp; pada masa penjajahan bangsa Eropa (Portugis, Spanyol, Belanda, Inggris)&nbsp; dalam kehidupan bangsa Indonesia masa kini</p>\r\n', 'Aktif'),
(25, 21, 51, 'X-BING', 'Periode 2', '3.3', '<p>I&rsquo;d like to..</p>\r\n', 'Aktif'),
(26, 21, 51, 'X-BING', 'Periode 2', '3.5', '<p>Announcement</p>\r\n', 'Aktif'),
(27, 21, 51, 'XI-BING', 'Periode 2', '3.3', '<p>Invitation/ party times</p>\r\n', 'Aktif'),
(28, 21, 51, 'XI-BING', 'Periode 2', '3.5', '<p>Passive</p>\r\n', 'Aktif'),
(29, 21, 52, 'X-SENBUD', 'Periode 2', '3.1', '<p>Berkarya seni rupa dua dimensi berdasar melihat model</p>\r\n', 'Aktif'),
(30, 21, 52, 'XI-SENBUD', 'Periode 2', '3.1', '<p>Berkarya seni rupa dua dimensi berdasar modifikasi</p>\r\n', 'Aktif'),
(31, 21, 53, 'X-PJOK', 'Periode 2', '3.2', '<p>Bulu tangkis</p>\r\n', 'Aktif'),
(32, 21, 53, 'X-PJOK', 'Periode 2', '3.3', '<p>Lompat Jauh</p>\r\n', 'Aktif'),
(33, 21, 53, 'XI-PJOK', 'Periode 2', '3.2', '<p>Tenis Meja</p>\r\n', 'Aktif'),
(34, 21, 53, 'XI-PJOK', 'Periode 2', '3.3', '<p>Lompat Tinggi</p>\r\n', 'Aktif'),
(35, 21, 54, 'X-PKWU', 'Periode 2', '3.3', '<p>Sistem produksi kerajinan dengan inspirasi budaya local non benda</p>\r\n', 'Aktif'),
(36, 21, 54, 'XI-PKWU', 'Periode 2', '3.3', '<p>Sistem produksi usaha kerajinan dari bahan limbah berbentuk bangun datar</p>\r\n', 'Aktif'),
(37, 21, 55, 'X-BJAWA', 'Periode 2', '3.2', '<p>Kawruh basal an sastra (Wayang)</p>\r\n', 'Aktif'),
(38, 21, 55, 'X-BJAWA', 'Periode 2', '3.3', '<p>Unggah-ungguh basa (Drama)</p>\r\n', 'Aktif'),
(39, 21, 55, 'XI-BJAWA', 'Periode 2', '3.2', '<p>Kebudayaan Jawa (Upacara adat)</p>\r\n', 'Aktif'),
(40, 21, 56, 'X-MATM', 'Periode 2', '3.1', '<p>Pertidaksamaan eksponen dan pertidaksamaan logaritma</p>\r\n', 'Aktif'),
(41, 21, 56, 'XI-MATM', 'Periode 2', '3.1', '<p>Persamaan trigonometri</p>\r\n', 'Aktif'),
(42, 21, 57, 'X-BIO', 'Periode 2', '3.3', '<p>Prinsip klasifikasi</p>\r\n', 'Aktif'),
(43, 21, 57, 'X-BIO', 'Periode 2', '3.4', '<p>Virus</p>\r\n', 'Aktif'),
(44, 21, 57, 'XI-BIO', 'Periode 2', '3.4', '<p>Jaringan hewan</p>\r\n', 'Aktif'),
(45, 21, 57, 'XI-BIO', 'Periode 2', '3.5', '<p>Sistem gerak</p>\r\n', 'Aktif'),
(46, 21, 58, 'X-FIS', 'Periode 2', '3.3', '<p>Vektor sebidang</p>\r\n', 'Aktif'),
(47, 21, 58, 'X-FIS', 'Periode 2', '3.4', '<p>Gerak lurus dan memadu gerak</p>\r\n', 'Aktif'),
(48, 21, 58, 'XI-FIS', 'Periode 2', '3.3', '<p>Fluida statis</p>\r\n', 'Aktif'),
(49, 21, 58, 'XI-FIS', 'Periode 2', '3.4', '<p>Fluida dinamis</p>\r\n', 'Aktif'),
(50, 21, 59, 'X-KIM', 'Periode 2', '3.3', '<p>Letak unsur dalam SP</p>\r\n', 'Aktif'),
(51, 21, 59, 'X-KIM', 'Periode 2', '3.4', '<p>Sifat periodic unsur</p>\r\n', 'Aktif'),
(52, 21, 59, 'XI-KIM', 'Periode 2', '3.2', '<p>Termokimia</p>\r\n', 'Aktif'),
(53, 21, 59, 'XI-KIM', 'Periode 2', '3.3', '<p>Laju reaksi</p>\r\n', 'Aktif'),
(54, 21, 60, 'X-SEJM', 'Periode 2', '3.4', '<p>Sejarah sebagai ilmu, kisah, peristiwa, dan seni.</p>\r\n', 'Aktif'),
(55, 21, 60, 'X-SEJM', 'Periode 2', '3.5', '<p>Berpikir sejarah diakronik dan sinkronik</p>\r\n', 'Aktif'),
(56, 21, 60, 'XI-SEJM', 'Periode 2', '3.3', '<p>Rennaisance, merkantilisme, reformasi gereja, aufklarung, revolusi industry, dan pengaruh faham-faham tersebut di Indonesia dan dunia pada masa kini</p>\r\n', 'Aktif'),
(57, 21, 61, 'X-EKO', 'Periode 2', '3.3', '<p>Peran pelaku ekonomi dalam kegiatan ekonomi</p>\r\n', 'Aktif'),
(58, 21, 61, 'X-EKO', 'Periode 2', '3.4', '<p>Keseimbangan dan struktur pasar</p>\r\n', 'Aktif'),
(59, 21, 61, 'XI-EKO', 'Periode 2', '3.3', '<p>Ketenagakerjaan</p>\r\n', 'Aktif'),
(60, 21, 61, 'XI-EKO', 'Periode 2', '3.5', '<p>Kebijakan moneter dan kebijakan fiskal</p>\r\n', 'Aktif'),
(61, 21, 62, 'X-SOS', 'Periode 2', '3.1', '<p>Fungsi sosiologi dalam mengkaji gejala sosial</p>\r\n', 'Aktif'),
(62, 21, 62, 'XI-SOS', 'Periode 2', '3.2', '<p>Masalah sosial</p>\r\n', 'Aktif'),
(63, 21, 63, 'X-GEO', 'Periode 2', '3.2', '<p>Pengetahuan dasar pemetaan</p>\r\n', 'Aktif'),
(64, 21, 63, 'X-GEO', 'Periode 2', '3.3', '<p>Langkah-langkah penelitian geografi</p>\r\n', 'Aktif'),
(65, 21, 63, 'XI-GEO', 'Periode 2', '3.2', '<p>Flora dan fauna Indonesia dan dunia</p>\r\n', 'Aktif'),
(66, 21, 64, 'X-SASIND', 'Periode 2', '3.2', '<p>Biografi</p>\r\n', 'Aktif'),
(67, 21, 64, 'X-SASIND', 'Periode 2', '3.3', '<p>Kategori kata</p>\r\n', 'Aktif'),
(68, 21, 64, 'XI-SASIND', 'Periode 2', '3.2', '<p>Makalah</p>\r\n', 'Aktif'),
(69, 21, 65, 'X-SASING', 'Periode 2', '3.3', '<p>Future tense</p>\r\n', 'Aktif'),
(70, 21, 65, 'X-SASING', 'Periode 2', '3.4', '<p>Not only&hellip; But also&hellip;</p>\r\n', 'Aktif'),
(71, 21, 65, 'XI-SASING', 'Periode 2', '3.3', '<p>Conditional sentence</p>\r\n', 'Aktif'),
(72, 21, 65, 'XI-SASING', 'Periode 2', '3.4', '<p>Poem</p>\r\n', 'Aktif'),
(73, 21, 67, 'X-ANTRO', 'Periode 2', '3.2', '<p>Penggolongan sosial</p>\r\n', 'Aktif'),
(74, 21, 67, 'XI-ANTRO', 'Periode 2', '3.1', '<p>Etnografi di Indonesia</p>\r\n', 'Aktif'),
(75, 21, 67, 'XI-ANTRO', 'Periode 2', '3.2', '<p>Persamaan dan perbedaan institusi sosial dalam etnik budaya</p>\r\n', 'Aktif'),
(76, 21, 69, 'X-JEP', 'Periode 2', '3.2', '<p>Jiko Shoukai</p>\r\n', 'Aktif'),
(77, 21, 69, 'XI-JEP', 'Periode 2', '3.1', '<p>Keluarga</p>\r\n', 'Aktif'),
(78, 21, 69, 'XI-JEP', 'Periode 2', '3.2', '<p>Kebiasaan sehari-hari</p>\r\n', 'Aktif'),
(79, 21, 68, 'X-MAND', 'Periode 2', '3.2', '<p>Perkenalan diri</p>\r\n', 'Aktif'),
(80, 21, 71, 'X-GEOLIN', 'Periode 2', '3.2', '<p>Pengetahuan dasar pemetaan</p>\r\n', 'Aktif'),
(81, 21, 71, 'X-GEOLIN', 'Periode 2', '3.3', '<p>Langkah-langkah penelitian geografi</p>\r\n', 'Aktif'),
(82, 21, 71, 'XI-GEOLIN', 'Periode 2', '3.2', '<p>Flora dan fauna Indonesia dan dunia</p>\r\n', 'Aktif'),
(83, 22, 46, 'agm5', '2', '1', '<p>bembelajaran alquran</p>\r\n', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE IF NOT EXISTS `sekolah` (
`id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `aktif` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id`, `nama`, `alamat`, `email`, `kota`, `kode`, `keterangan`, `aktif`, `date`, `last_login`) VALUES
(1, 'SMK PRAMBON', 'JL RAJAWALI', 'ilaaa.tuwe@gmail.com', 'SURABAYA', '2345', '', 'pending', '2019-05-21 02:16:35', '2019-05-21 02:16:35'),
(2, 'SMA PRAMBOS', 'JL RAJAWALI', 'ilaaa.tuwe@gmail.com', 'SURABAYA', '1234', '', '1', '2019-05-21 02:21:02', '2019-05-21 02:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE IF NOT EXISTS `semester` (
`id` int(10) unsigned NOT NULL,
  `semester` varchar(50) NOT NULL,
  `aktif` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester`, `aktif`, `keterangan`) VALUES
(21, 'Semester 1', 'Aktif', ''),
(22, 'Semester 2', 'Aktif', ''),
(23, 'Semester 3', 'Tidak Aktif', '');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
`id` int(10) unsigned NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `panggilan` varchar(30) DEFAULT NULL,
  `tahunmasuk` int(10) unsigned NOT NULL,
  `idangkatan` int(10) unsigned NOT NULL,
  `idkelas` int(10) unsigned NOT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `kondisi` varchar(100) DEFAULT NULL,
  `kelamin` varchar(20) DEFAULT NULL,
  `tmplahir` varchar(50) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `warga` varchar(5) DEFAULT NULL,
  `anakke` tinyint(2) unsigned DEFAULT '0',
  `jsaudara` tinyint(2) unsigned DEFAULT '0',
  `bahasa` varchar(60) DEFAULT NULL,
  `berat` decimal(4,1) unsigned DEFAULT '0.0',
  `tinggi` decimal(4,1) unsigned DEFAULT '0.0',
  `darah` varchar(2) DEFAULT NULL,
  `foto` mediumblob,
  `alamatsiswa` varchar(255) DEFAULT NULL,
  `kodepossiswa` varchar(8) DEFAULT NULL,
  `hpsiswa` varchar(20) DEFAULT NULL,
  `emailsiswa` varchar(100) DEFAULT NULL,
  `kesehatan` varchar(150) DEFAULT NULL,
  `asalsekolah` varchar(100) DEFAULT NULL,
  `noijasah` varchar(25) DEFAULT NULL,
  `tglijasah` varchar(25) DEFAULT NULL,
  `ketsekolah` varchar(100) DEFAULT NULL,
  `namaayah` varchar(60) DEFAULT NULL,
  `namaibu` varchar(60) DEFAULT NULL,
  `tmplahirayah` varchar(35) DEFAULT NULL,
  `tmplahiribu` varchar(35) DEFAULT NULL,
  `tgllahirayah` varchar(35) DEFAULT NULL,
  `tgllahiribu` varchar(35) DEFAULT NULL,
  `pendidikanayah` varchar(20) DEFAULT NULL,
  `pendidikanibu` varchar(20) DEFAULT NULL,
  `pekerjaanayah` varchar(60) DEFAULT NULL,
  `pekerjaanibu` varchar(60) DEFAULT NULL,
  `wali` varchar(60) DEFAULT NULL,
  `penghasilanayah` int(10) unsigned DEFAULT '0',
  `penghasilanibu` int(10) unsigned DEFAULT '0',
  `alamatortu` varchar(100) DEFAULT NULL,
  `hportu` varchar(20) DEFAULT NULL,
  `emailayah` varchar(100) DEFAULT NULL,
  `alamatsurat` varchar(100) DEFAULT NULL,
  `keterangan` text,
  `hobi` text,
  `frompsb` tinyint(1) unsigned DEFAULT '0',
  `ketpsb` varchar(100) DEFAULT NULL,
  `statusmutasi` int(10) unsigned DEFAULT NULL,
  `alumni` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 bukan alumni, 1 alumni',
  `pinsiswa` varchar(200) NOT NULL,
  `pinortu` varchar(200) NOT NULL,
  `pinortuibu` varchar(200) NOT NULL,
  `emailibu` varchar(100) DEFAULT NULL,
  `info` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `siswa_sudah_mengerjakan`
--

CREATE TABLE IF NOT EXISTS `siswa_sudah_mengerjakan` (
`id` int(20) NOT NULL,
  `id_tq` int(20) NOT NULL,
  `id_siswa` varchar(200) NOT NULL,
  `dikoreksi` varchar(1) NOT NULL DEFAULT 'B',
  `hits` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE IF NOT EXISTS `spp` (
`id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `idtahunajaran` int(10) NOT NULL,
  `bulanke` varchar(50) NOT NULL,
  `nominal` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `standartnilai`
--

CREATE TABLE IF NOT EXISTS `standartnilai` (
`id` int(11) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `standartnilai`
--

INSERT INTO `standartnilai` (`id`, `nilai`) VALUES
(1, '50');

-- --------------------------------------------------------

--
-- Table structure for table `statusguru`
--

CREATE TABLE IF NOT EXISTS `statusguru` (
`id` int(10) unsigned NOT NULL,
  `status` varchar(50) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statusguru`
--

INSERT INTO `statusguru` (`id`, `status`, `keterangan`) VALUES
(11, 'Asisten', '-'),
(12, 'Keuangan', ''),
(9, 'Ustad', '-'),
(10, 'Ustazah', '-');

-- --------------------------------------------------------

--
-- Table structure for table `statussiswa`
--

CREATE TABLE IF NOT EXISTS `statussiswa` (
`id` int(10) unsigned NOT NULL,
  `status` varchar(100) NOT NULL,
  `urutan` tinyint(2) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statussiswa`
--

INSERT INTO `statussiswa` (`id`, `status`, `urutan`) VALUES
(9, 'Ekslusif', 2),
(8, 'Reguler', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sumber`
--

CREATE TABLE IF NOT EXISTS `sumber` (
`id` int(11) NOT NULL,
  `sumber` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sumber`
--

INSERT INTO `sumber` (`id`, `sumber`) VALUES
(1, 'Bantuan pemerintah'),
(2, 'Bantuan Kepala sekolah'),
(3, 'Bantuan wali'),
(5, 'bantuan diknas jatim'),
(6, 'bantuan guru baik'),
(7, 'Donatur');

-- --------------------------------------------------------

--
-- Table structure for table `tahunajaran`
--

CREATE TABLE IF NOT EXISTS `tahunajaran` (
`id` int(10) unsigned NOT NULL,
  `tahunajaran` varchar(50) NOT NULL,
  `tglmulai` date NOT NULL,
  `tglakhir` date NOT NULL,
  `aktif` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tahunajaran`
--

INSERT INTO `tahunajaran` (`id`, `tahunajaran`, `tglmulai`, `tglakhir`, `aktif`, `keterangan`) VALUES
(21, '2020-2021', '2020-06-01', '2021-06-01', 'Aktif', '-'),
(22, '2021-2022', '2021-08-01', '2022-08-01', 'Tidak Aktif', '');

-- --------------------------------------------------------

--
-- Table structure for table `tingkatpendidikan`
--

CREATE TABLE IF NOT EXISTS `tingkatpendidikan` (
`id` int(10) unsigned NOT NULL,
  `pendidikan` varchar(20) NOT NULL,
  `urutan` tinyint(2) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tingkatpendidikan`
--

INSERT INTO `tingkatpendidikan` (`id`, `pendidikan`, `urutan`) VALUES
(22, 'D1', 7),
(21, 'D3', 6),
(20, 'D4', 5),
(16, 'S1', 1),
(19, 'SD', 4),
(17, 'SMA', 2),
(18, 'SMP', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_datasewa`
--

CREATE TABLE IF NOT EXISTS `tmp_datasewa` (
`id` int(11) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `idbuku` varchar(255) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topik_quiz`
--

CREATE TABLE IF NOT EXISTS `topik_quiz` (
`id` int(9) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `idkelas` varchar(5) NOT NULL,
  `idpelajaran` varchar(10) NOT NULL,
  `idjenis` int(11) NOT NULL,
  `idsemester` int(11) NOT NULL,
  `iddasarpenilaian` int(11) NOT NULL,
  `idrpp` int(11) NOT NULL,
  `tgl_buat` date NOT NULL,
  `pembuat` varchar(100) NOT NULL,
  `waktu_pengerjaan` int(50) NOT NULL,
  `info` text NOT NULL,
  `terbit` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
  `no_transaksi` varchar(20) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `bayar` double(10,2) NOT NULL,
  `potongan` double(10,2) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `timestmp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE IF NOT EXISTS `ujian` (
`id` int(10) unsigned NOT NULL,
  `idpelajaran` int(10) unsigned NOT NULL DEFAULT '0',
  `idkelas` int(10) unsigned NOT NULL DEFAULT '0',
  `idsemester` int(10) unsigned NOT NULL DEFAULT '0',
  `idjenis` int(10) unsigned NOT NULL DEFAULT '0',
  `deskripsi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL DEFAULT '0000-00-00',
  `idaturan` int(10) unsigned NOT NULL,
  `idrpp` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_sekolah` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL,
  `last_login` datetime NOT NULL,
  `akses_master` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_user`, `id_sekolah`, `nama`, `username`, `password`, `level`, `last_login`, `akses_master`) VALUES
(1, '1', 1, 'ADMINISTRATOR', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '2021-10-29 15:16:52', ''),
(2, '2', 0, 'CACA', 'caca', 'd2104a400c7f629a197f33bb33fe80c0', 'user', '2016-08-02 12:46:58', 'pelanggan, supplier'),
(3, '0', 2, 'AGUS', 'admin', '8c319f28d81d1527a9428e9a5c2195f5', 'admin', '2020-06-21 22:13:06', ''),
(7, '12345678910', 0, '', 'tohir', '550deef378183bc99e4200c7ac71e502', 'admin', '2020-06-15 11:33:25', ''),
(8, '1254521152', 0, '', 'sri', '81dc9bdb52d04dc20036dbd8313ed055', 'keuangan', '2020-08-15 07:57:56', ''),
(9, '123456', 0, '', 'ali', '81dc9bdb52d04dc20036dbd8313ed055', 'keuangan', '2021-10-26 14:59:11', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi_guru`
--
ALTER TABLE `absensi_guru`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `absensi_siswa`
--
ALTER TABLE `absensi_siswa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
 ADD PRIMARY KEY (`agama`), ADD UNIQUE KEY `UX_agama` (`id`);

--
-- Indexes for table `aspekkelompok`
--
ALTER TABLE `aspekkelompok`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aturannhb`
--
ALTER TABLE `aturannhb`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_aturannhb_jenisujian` (`idjenisujian`), ADD KEY `FK_aturannhb_dasarpenilaian` (`dasarpenilaian`), ADD KEY `FK_aturannhb_pelajaran` (`idpelajaran`), ADD KEY `FK_aturannhb_pegawai` (`nipguru`);

--
-- Indexes for table `bayarcicilan`
--
ALTER TABLE `bayarcicilan`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_transaksi_id` (`no_transaksi`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_kejadian`
--
ALTER TABLE `daftar_kejadian`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dasarpenilaian`
--
ALTER TABLE `dasarpenilaian`
 ADD PRIMARY KEY (`dasarpenilaian`), ADD UNIQUE KEY `UX_dasarpenilaian_id` (`id`);

--
-- Indexes for table `datasewa`
--
ALTER TABLE `datasewa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_transaksi_id` (`no_transaksi`), ADD KEY `FK_pembayaran_transaksi_id` (`idpembayaran`);

--
-- Indexes for table `detail_transaksi_tmp`
--
ALTER TABLE `detail_transaksi_tmp`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_pembayaran_id` (`idpembayaran`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_guru_pegawai` (`nip`), ADD KEY `FK_guru_pelajaran` (`idpelajaran`), ADD KEY `FK_guru_statusguru` (`statusguru`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_NIS_hs` (`nis`);

--
-- Indexes for table `history_tmp`
--
ALTER TABLE `history_tmp`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infonap`
--
ALTER TABLE `infonap`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_infonap_pelajaran` (`idpelajaran`), ADD KEY `FK_infonap_semester` (`idsemester`), ADD KEY `FK_infonap_kelas` (`idkelas`);

--
-- Indexes for table `jam_absen`
--
ALTER TABLE `jam_absen`
 ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenisabsensi`
--
ALTER TABLE `jenisabsensi`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenispekerjaan`
--
ALTER TABLE `jenispekerjaan`
 ADD PRIMARY KEY (`pekerjaan`), ADD UNIQUE KEY `UX_jenispekerjaan` (`id`);

--
-- Indexes for table `jenispembayaran`
--
ALTER TABLE `jenispembayaran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenisujian`
--
ALTER TABLE `jenisujian`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_jenisujian_pelajaran` (`idpelajaran`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kejadian_siswa`
--
ALTER TABLE `kejadian_siswa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_kelas_pegawai` (`nipwali`), ADD KEY `FK_kelas_tahunajaran` (`idtahunajaran`);

--
-- Indexes for table `kondisisiswa`
--
ALTER TABLE `kondisisiswa`
 ADD PRIMARY KEY (`kondisi`), ADD UNIQUE KEY `UX_kondisisiswa` (`id`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
 ADD PRIMARY KEY (`id_modul`);

--
-- Indexes for table `nap`
--
ALTER TABLE `nap`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_nap_infonap` (`idinfo`), ADD KEY `FK_nap_siswa` (`nis`), ADD KEY `FK_nap_aturannhb` (`idaturan`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilaiujian`
--
ALTER TABLE `nilaiujian`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_nilaiujian_idujian` (`idujian`), ADD KEY `FK_nilaiujian_nis` (`nis`);

--
-- Indexes for table `nilai_soal_esay`
--
ALTER TABLE `nilai_soal_esay`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
 ADD PRIMARY KEY (`nip`), ADD UNIQUE KEY `UX_pegawai_replid` (`id`), ADD KEY `FK_pegawai_agama` (`agama`), ADD KEY `FK_pegawai_bagian` (`bagian`);

--
-- Indexes for table `pelajaran`
--
ALTER TABLE `pelajaran`
 ADD PRIMARY KEY (`id`), ADD KEY `IX_daftarpelajaran_kode` (`kode`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_jenispembayaran_id` (`idjenispembayaran`);

--
-- Indexes for table `pengaturan_bk`
--
ALTER TABLE `pengaturan_bk`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengembangan_prestasi`
--
ALTER TABLE `pengembangan_prestasi`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_esay`
--
ALTER TABLE `quiz_esay`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_pilganda`
--
ALTER TABLE `quiz_pilganda`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raport_katagori`
--
ALTER TABLE `raport_katagori`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rpp`
--
ALTER TABLE `rpp`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_rpp_semester` (`idsemester`), ADD KEY `FK_rpp_pelajaran` (`idpelajaran`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
 ADD PRIMARY KEY (`nis`), ADD UNIQUE KEY `UX_siswa_id` (`id`);

--
-- Indexes for table `siswa_sudah_mengerjakan`
--
ALTER TABLE `siswa_sudah_mengerjakan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `standartnilai`
--
ALTER TABLE `standartnilai`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statusguru`
--
ALTER TABLE `statusguru`
 ADD PRIMARY KEY (`status`), ADD UNIQUE KEY `UX_statusguru_replid` (`id`);

--
-- Indexes for table `statussiswa`
--
ALTER TABLE `statussiswa`
 ADD PRIMARY KEY (`status`), ADD UNIQUE KEY `UX_statussiswa` (`id`);

--
-- Indexes for table `sumber`
--
ALTER TABLE `sumber`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahunajaran`
--
ALTER TABLE `tahunajaran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tingkatpendidikan`
--
ALTER TABLE `tingkatpendidikan`
 ADD PRIMARY KEY (`pendidikan`), ADD UNIQUE KEY `UX_tingkatpendidikan` (`id`);

--
-- Indexes for table `tmp_datasewa`
--
ALTER TABLE `tmp_datasewa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topik_quiz`
--
ALTER TABLE `topik_quiz`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
 ADD PRIMARY KEY (`no_transaksi`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_ujian_idpelajaran` (`idpelajaran`), ADD KEY `FK_ujian_idsemester` (`idsemester`), ADD KEY `FK_ujian_idjenis` (`idjenis`), ADD KEY `FK_ujian_idaturan` (`idaturan`), ADD KEY `FK_ujian_rpp` (`idrpp`), ADD KEY `FK_ujian_kelas` (`idkelas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi_guru`
--
ALTER TABLE `absensi_guru`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `absensi_siswa`
--
ALTER TABLE `absensi_siswa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agama`
--
ALTER TABLE `agama`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `aspekkelompok`
--
ALTER TABLE `aspekkelompok`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `aturannhb`
--
ALTER TABLE `aturannhb`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=265;
--
-- AUTO_INCREMENT for table `bayarcicilan`
--
ALTER TABLE `bayarcicilan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `daftar_kejadian`
--
ALTER TABLE `daftar_kejadian`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dasarpenilaian`
--
ALTER TABLE `dasarpenilaian`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `datasewa`
--
ALTER TABLE `datasewa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detail_transaksi_tmp`
--
ALTER TABLE `detail_transaksi_tmp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history_tmp`
--
ALTER TABLE `history_tmp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `infonap`
--
ALTER TABLE `infonap`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jenisabsensi`
--
ALTER TABLE `jenisabsensi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `jenispekerjaan`
--
ALTER TABLE `jenispekerjaan`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `jenispembayaran`
--
ALTER TABLE `jenispembayaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `jenisujian`
--
ALTER TABLE `jenisujian`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `kejadian_siswa`
--
ALTER TABLE `kejadian_siswa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `kondisisiswa`
--
ALTER TABLE `kondisisiswa`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `nap`
--
ALTER TABLE `nap`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nilaiujian`
--
ALTER TABLE `nilaiujian`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nilai_soal_esay`
--
ALTER TABLE `nilai_soal_esay`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `pelajaran`
--
ALTER TABLE `pelajaran`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `pengaturan_bk`
--
ALTER TABLE `pengaturan_bk`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pengembangan_prestasi`
--
ALTER TABLE `pengembangan_prestasi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quiz_esay`
--
ALTER TABLE `quiz_esay`
MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quiz_pilganda`
--
ALTER TABLE `quiz_pilganda`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `raport_katagori`
--
ALTER TABLE `raport_katagori`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rpp`
--
ALTER TABLE `rpp`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `siswa_sudah_mengerjakan`
--
ALTER TABLE `siswa_sudah_mengerjakan`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `standartnilai`
--
ALTER TABLE `standartnilai`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `statusguru`
--
ALTER TABLE `statusguru`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `statussiswa`
--
ALTER TABLE `statussiswa`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sumber`
--
ALTER TABLE `sumber`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tahunajaran`
--
ALTER TABLE `tahunajaran`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tingkatpendidikan`
--
ALTER TABLE `tingkatpendidikan`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tmp_datasewa`
--
ALTER TABLE `tmp_datasewa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topik_quiz`
--
ALTER TABLE `topik_quiz`
MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bayarcicilan`
--
ALTER TABLE `bayarcicilan`
ADD CONSTRAINT `FK_transaksi_id` FOREIGN KEY (`no_transaksi`) REFERENCES `transaksi` (`no_transaksi`);

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
ADD CONSTRAINT `FK_pembayaran_transaksi_id` FOREIGN KEY (`idpembayaran`) REFERENCES `pembayaran` (`id`);

--
-- Constraints for table `detail_transaksi_tmp`
--
ALTER TABLE `detail_transaksi_tmp`
ADD CONSTRAINT `FK_pembayaran_id` FOREIGN KEY (`idpembayaran`) REFERENCES `pembayaran` (`id`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
ADD CONSTRAINT `FK_NIS_hs` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`);

--
-- Constraints for table `infonap`
--
ALTER TABLE `infonap`
ADD CONSTRAINT `FK_infonap_kelas` FOREIGN KEY (`idkelas`) REFERENCES `kelas` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `FK_infonap_pelajaran` FOREIGN KEY (`idpelajaran`) REFERENCES `pelajaran` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `FK_infonap_semester` FOREIGN KEY (`idsemester`) REFERENCES `semester` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `nap`
--
ALTER TABLE `nap`
ADD CONSTRAINT `FK_nap_aturannhb` FOREIGN KEY (`idaturan`) REFERENCES `aturannhb` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `FK_nap_infonap` FOREIGN KEY (`idinfo`) REFERENCES `infonap` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `FK_nap_siswa` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON UPDATE CASCADE;

--
-- Constraints for table `nilaiujian`
--
ALTER TABLE `nilaiujian`
ADD CONSTRAINT `FK_nilaiujian_idujian` FOREIGN KEY (`idujian`) REFERENCES `ujian` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `FK_nilaiujian_nis` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
ADD CONSTRAINT `FK_jenispembayaran_id` FOREIGN KEY (`idjenispembayaran`) REFERENCES `jenispembayaran` (`id`);

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
ADD CONSTRAINT `FK_ujian_idaturan` FOREIGN KEY (`idaturan`) REFERENCES `aturannhb` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `FK_ujian_idjenis` FOREIGN KEY (`idjenis`) REFERENCES `jenisujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_ujian_idpelajaran` FOREIGN KEY (`idpelajaran`) REFERENCES `pelajaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_ujian_idsemester` FOREIGN KEY (`idsemester`) REFERENCES `semester` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_ujian_kelas` FOREIGN KEY (`idkelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_ujian_rpp` FOREIGN KEY (`idrpp`) REFERENCES `rpp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
