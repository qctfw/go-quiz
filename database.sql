-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Okt 2018 pada 11.17
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cbt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` varchar(8) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telp`, `email`, `gambar`) VALUES
('AD00001', 'Admin', 'L', 'Rumah', '2001-06-23', 'Alamatku Indah Sekali no hoax edan parah', '82109384010', 'abang@quiz.com', '5b441a9ebe12a.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` varchar(7) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_guru`
--

INSERT INTO `tb_guru` (`id_guru`, `nip`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telp`, `email`, `gambar`) VALUES
('GR00001', '198503302003121002', 'Heri Gunawan', 'L', 'Bumi', '1972-03-06', 'Alamat Jalan Gede Banget', '6281298980192', 'kuisamazing@mamang.com', '5ae04a16ceedd.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_konfigurasi`
--

CREATE TABLE `tb_konfigurasi` (
  `nama_aplikasi` varchar(20) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `tema` enum('default','blue','green','pink','red','sea','violet') NOT NULL,
  `izinpassword` tinyint(1) NOT NULL,
  `izinprofil` tinyint(1) NOT NULL,
  `izinlogoakhir` tinyint(1) NOT NULL,
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_konfigurasi`
--

INSERT INTO `tb_konfigurasi` (`nama_aplikasi`, `nama_perusahaan`, `deskripsi`, `tema`, `izinpassword`, `izinprofil`, `izinlogoakhir`, `last_updated`) VALUES
('GoQuiz', 'QCTFW', 'Description', 'default', 0, 0, 1, '2018-05-14 11:31:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_level`
--

CREATE TABLE `tb_level` (
  `id_level` varchar(6) NOT NULL,
  `nama_level` varchar(50) NOT NULL,
  `kesulitan` enum('Easy','Medium','Hard','Expert') NOT NULL,
  `waktu` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_level`
--

INSERT INTO `tb_level` (`id_level`, `nama_level`, `kesulitan`, `waktu`) VALUES
('LV0001', 'Untuk Pemula', 'Easy', 60),
('LV0004', 'Permulaan', 'Medium', 60),
('LV0005', 'Untuk Pemula II', 'Easy', 60),
('LV0006', 'Untuk Pemula III', 'Easy', 90),
('LV0007', 'CKEditor Test', 'Expert', 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` varchar(10) NOT NULL,
  `id_siswa` varchar(7) NOT NULL,
  `id_level` varchar(6) NOT NULL,
  `soal_terjawab` int(2) NOT NULL,
  `soal_total` int(2) NOT NULL,
  `nyawa` tinyint(1) NOT NULL,
  `nilai` int(3) NOT NULL,
  `tgl_nilai` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_progresskuis`
--

CREATE TABLE `tb_progresskuis` (
  `id_siswa` varchar(7) NOT NULL,
  `id_level` varchar(6) NOT NULL,
  `id_soal` text NOT NULL,
  `soal_ke` tinyint(2) NOT NULL,
  `nyawa` tinyint(1) NOT NULL,
  `waktu` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` varchar(7) NOT NULL,
  `nis` int(8) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nis`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telp`, `email`, `gambar`) VALUES
('SW00001', 18129099, 'Keceteefwe', 'L', 'Bumi', '2002-12-19', 'Alamatku ada di bumi tercinta', '6281298019287', 'abang@gmail.com', '5af9146cbdf1e.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_soal`
--

CREATE TABLE `tb_soal` (
  `id_soal` varchar(10) NOT NULL,
  `id_level` varchar(6) NOT NULL,
  `id_guru` varchar(7) NOT NULL,
  `deskripsi_soal` text NOT NULL,
  `jawaban_a` text NOT NULL,
  `jawaban_b` text NOT NULL,
  `jawaban_c` text NOT NULL,
  `jawaban_d` text NOT NULL,
  `jawaban_benar` varchar(1) NOT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `tgl_buat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_soal`
--

INSERT INTO `tb_soal` (`id_soal`, `id_level`, `id_guru`, `deskripsi_soal`, `jawaban_a`, `jawaban_b`, `jawaban_c`, `jawaban_d`, `jawaban_benar`, `gambar`, `tgl_buat`, `tgl_modif`) VALUES
('SA00000001', 'LV0001', 'GR00001', 'Jika Andi membeli 2 biji salak. Satu biji salak berharga Rp2.000,00. Berapa uang yang didapat penjual biji salak?', 'Rp 4.000,00', 'Rp 1.000,00', 'Rp 5.000,00', 'Rp 2.000,00', 'a', NULL, '2018-03-26 07:39:49', '2018-04-16 11:42:05'),
('SA00000002', 'LV0001', 'GR00001', 'Mamat membeli 2 buku. Diberi Nana 3 buku. Jadi, Mamat mempunyai...', '3 buku', '2 buku', '5 buku', '4 buku', 'c', NULL, '2018-04-03 11:30:00', '2018-04-11 12:44:14'),
('SA00000003', 'LV0001', 'GR00001', 'Budi menjual 50 buku. Setiap buku berharga Rp 20.000,00. Berapa harga seluruh buku Budi?', 'Rp 100.000,00', 'Rp 1.000.000,00', 'Rp 200.000,00', 'Rp 500.000,00', 'b', NULL, '2018-04-04 12:30:00', '2018-04-04 12:30:00'),
('SA00000004', 'LV0001', 'GR00001', '3 + 4 - 2 + 1 - 10 = ?', '-4', '9', '4', '10', 'a', NULL, '2018-04-09 14:45:01', '2018-04-19 11:45:51'),
('SA00000005', 'LV0001', 'GR00001', '<p>Mila membeli 5 buku. Ternyata, 2 buku yang dibeli Mila rusak. Mila mengembalikan buku yang rusak itu dengan harga penuh. Harga 1 buku adalah Rp5.000,00. Berapa uang yang didapat Mila setelah mengembalikan buku rusak tersebut?</p>\r\n', 'Rp15.000,00', 'Rp20.000,00', 'Rp5.000,00', 'Rp10.000,00', 'd', NULL, '2018-04-09 14:48:45', '2018-05-08 11:34:30'),
('SA00000006', 'LV0001', 'GR00001', '29 + 10 - 5 * 2 = ?', '29', '68', '10', '-10', 'a', NULL, '2018-04-09 14:52:07', '2018-04-12 09:33:51'),
('SA00000007', 'LV0001', 'GR00001', 'Adam mempunyai 5 pensil dan 2 penghapus. Adam memberi 2 pensil dan 1 penghapus ke Nata. Berapa banyak pensil Adam sekarang?', '4 pensil', '2 pensil', '1 pensil', '3 pensil', 'd', NULL, '2018-04-09 14:53:50', '2018-04-09 14:53:50'),
('SA00000008', 'LV0001', 'GR00001', 'Berapa banyak warna pelangi?', '7 warna', '5 warna', '6 warna', '1 warna', 'a', NULL, '2018-04-09 14:55:01', '2018-04-09 14:55:01'),
('SA00000009', 'LV0001', 'GR00001', '5 + 4 - 1 + 8 - 10 + 20 = ?', '21', '28', '26', '17', 'c', NULL, '2018-04-09 14:56:57', '2018-04-09 14:56:57'),
('SA00000010', 'LV0001', 'GR00001', 'Berapa jumlah jari tangan kita?', '10 jari', '5 jari', '8 jari', '6 jari', 'a', NULL, '2018-04-09 14:58:40', '2018-04-09 14:58:40'),
('SA00000011', 'LV0004', 'GR00001', 'Apa faktor dari 2x + 8?', 'x (2 + 4)', '2x (4)', '2 (x + 4)', 'x + 2 (2)', 'c', NULL, '2018-04-10 16:32:27', '2018-04-10 21:33:52'),
('SA00000012', 'LV0004', 'GR00001', 'Faktor dari 5x + 20y - 10 adalah..', '2 (2x + y - 5)', '10 (2x + 10y - 1)', '2 (3x + 5y - 5)', '5 (x + 4y - 2)', 'd', NULL, '2018-04-10 21:53:56', '2018-04-10 23:17:42'),
('SA00000013', 'LV0004', 'GR00001', '2/4 + 3/4 - 1/4 = ?', '5/4', '1', '-4/4', '3/4', 'b', NULL, '2018-04-11 11:55:25', '2018-04-11 11:55:25'),
('SA00000015', 'LV0005', 'GR00001', 'Test (Jawaban: B)', 'a', 'b', 'c', 'd', 'b', NULL, '2018-04-11 22:29:46', '2018-04-11 22:29:46'),
('SA00000016', 'LV0006', 'GR00001', 'Test (Jawaban: A)', 'A', 'B', 'C', 'D', 'a', NULL, '2018-04-11 22:30:06', '2018-04-11 22:30:06'),
('SA00000017', 'LV0005', 'GR00001', 'Soalnya', 'Jawaban A', 'Jawaban B', 'Jawaban C', 'Jawaban D', 'b', NULL, '2018-04-12 09:55:18', '2018-04-12 09:55:18'),
('SA00000018', 'LV0007', 'GR00001', '<p><strong>BOLD</strong><em>ITALIC</em><u>UNDERLINE</u><s>STRIKETROUGH</s><sub>SUB</sub><sup>SUPER</sup></p>\r\n', 'A', 'B', 'C', 'D', 'a', NULL, '2018-04-25 21:18:10', '2018-04-25 21:18:10'),
('SA00000019', 'LV0007', 'GR00001', '<p><strong>BOLD</strong><em>ITALIC</em><u>UNDERLINE</u><s>STRIKETROUGH<sup>22222222</sup></s></p>\r\n', 'A', 'B', 'C', 'D', 'a', '5ae9802d179fe.jpg', '2018-04-25 21:19:40', '2018-05-02 16:09:01'),
('SA00000020', 'LV0001', 'GR00001', '<p>1+1</p>\r\n', '2', '3', '4', '5', 'a', NULL, '2018-05-08 13:15:24', '2018-05-08 13:15:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_anggota` varchar(7) NOT NULL,
  `level` enum('Admin','Guru','Siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`username`, `password`, `id_anggota`, `level`) VALUES
('admin', '$2y$10$Vdm39M1qaftKtHdqotu2t.hybqLlILtfKEzzn/puqiVz7.lTugOf6', 'AD00001', 'Admin'),
('guru', '$2y$10$KD/T2lVkuItFFfC7PLmvM.XcmKgpmA4zHv9Ug/AY0cw7ZuvZydebC', 'GR00001', 'Guru'),
('siswa', '$2y$10$pTMUDomgEzIDcs7qogQzB.3BCSV9PnEyUziy1HB8fFqXrzqTc8n9e', 'SW00001', 'Siswa');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_nilai`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_nilai` (
`id_nilai` varchar(10)
,`id_siswa` varchar(7)
,`nama` varchar(50)
,`id_level` varchar(6)
,`nama_level` varchar(50)
,`kesulitan` enum('Easy','Medium','Hard','Expert')
,`soal_terjawab` int(2)
,`soal_total` int(2)
,`nyawa` tinyint(1)
,`nilai` int(3)
,`tgl_nilai` datetime
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_soal`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_soal` (
`id_soal` varchar(10)
,`id_level` varchar(6)
,`nama_level` varchar(50)
,`kesulitan` enum('Easy','Medium','Hard','Expert')
,`id_guru` varchar(7)
,`nama` varchar(50)
,`deskripsi_soal` text
,`jawaban_a` text
,`jawaban_b` text
,`jawaban_c` text
,`jawaban_d` text
,`jawaban_benar` varchar(1)
,`gambar` varchar(100)
,`tgl_buat` datetime
,`tgl_modif` datetime
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_nilai`
--
DROP TABLE IF EXISTS `v_nilai`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_nilai`  AS  select `tb_nilai`.`id_nilai` AS `id_nilai`,`tb_nilai`.`id_siswa` AS `id_siswa`,`tb_siswa`.`nama` AS `nama`,`tb_nilai`.`id_level` AS `id_level`,`tb_level`.`nama_level` AS `nama_level`,`tb_level`.`kesulitan` AS `kesulitan`,`tb_nilai`.`soal_terjawab` AS `soal_terjawab`,`tb_nilai`.`soal_total` AS `soal_total`,`tb_nilai`.`nyawa` AS `nyawa`,`tb_nilai`.`nilai` AS `nilai`,`tb_nilai`.`tgl_nilai` AS `tgl_nilai` from ((`tb_nilai` join `tb_siswa` on((`tb_nilai`.`id_siswa` = `tb_siswa`.`id_siswa`))) join `tb_level` on((`tb_nilai`.`id_level` = `tb_level`.`id_level`))) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_soal`
--
DROP TABLE IF EXISTS `v_soal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_soal`  AS  select `tb_soal`.`id_soal` AS `id_soal`,`tb_soal`.`id_level` AS `id_level`,`tb_level`.`nama_level` AS `nama_level`,`tb_level`.`kesulitan` AS `kesulitan`,`tb_soal`.`id_guru` AS `id_guru`,`tb_guru`.`nama` AS `nama`,`tb_soal`.`deskripsi_soal` AS `deskripsi_soal`,`tb_soal`.`jawaban_a` AS `jawaban_a`,`tb_soal`.`jawaban_b` AS `jawaban_b`,`tb_soal`.`jawaban_c` AS `jawaban_c`,`tb_soal`.`jawaban_d` AS `jawaban_d`,`tb_soal`.`jawaban_benar` AS `jawaban_benar`,`tb_soal`.`gambar` AS `gambar`,`tb_soal`.`tgl_buat` AS `tgl_buat`,`tb_soal`.`tgl_modif` AS `tgl_modif` from ((`tb_soal` join `tb_level` on((`tb_soal`.`id_level` = `tb_level`.`id_level`))) join `tb_guru` on((`tb_soal`.`id_guru` = `tb_guru`.`id_guru`))) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indeks untuk tabel `tb_konfigurasi`
--
ALTER TABLE `tb_konfigurasi`
  ADD UNIQUE KEY `nama_aplikasi` (`nama_aplikasi`);

--
-- Indeks untuk tabel `tb_level`
--
ALTER TABLE `tb_level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_level` (`id_level`),
  ADD KEY `id_level_2` (`id_level`),
  ADD KEY `id_level_3` (`id_level`);

--
-- Indeks untuk tabel `tb_progresskuis`
--
ALTER TABLE `tb_progresskuis`
  ADD UNIQUE KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- Indeks untuk tabel `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_level` (`id_level`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD CONSTRAINT `tb_nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nilai_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `tb_level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD CONSTRAINT `tb_soal_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_soal_ibfk_3` FOREIGN KEY (`id_level`) REFERENCES `tb_level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
