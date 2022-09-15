-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Sep 2022 pada 08.51
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_po`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_po`
--

CREATE TABLE `t_po` (
  `id_po` int(11) NOT NULL,
  `kode_po` varchar(20) NOT NULL,
  `tanggal_po` date NOT NULL,
  `supplier` varchar(200) NOT NULL,
  `payment_method` enum('transfer','cash') NOT NULL DEFAULT 'cash',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_po_detail`
--

CREATE TABLE `t_po_detail` (
  `id_item` int(11) NOT NULL,
  `id_po` int(11) NOT NULL,
  `nama_barang` varchar(120) NOT NULL,
  `merk_barang` varchar(120) NOT NULL,
  `satuan_barang` varchar(15) NOT NULL DEFAULT 'pcs',
  `qty` int(11) NOT NULL,
  `harga_satuan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`id_user`, `nama_lengkap`, `email`, `password`) VALUES
(1, 'Administrator', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_po`
--
ALTER TABLE `t_po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indeks untuk tabel `t_po_detail`
--
ALTER TABLE `t_po_detail`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_po` (`id_po`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_po`
--
ALTER TABLE `t_po`
  MODIFY `id_po` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `t_po_detail`
--
ALTER TABLE `t_po_detail`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_po_detail`
--
ALTER TABLE `t_po_detail`
  ADD CONSTRAINT `t_po_detail_ibfk_1` FOREIGN KEY (`id_po`) REFERENCES `t_po` (`id_po`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
