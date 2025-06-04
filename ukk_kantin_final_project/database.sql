CREATE DATABASE IF NOT EXISTS database_kantin;
USE database_kantin;

-- Tabel menu
CREATE TABLE IF NOT EXISTS menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_kantin INT DEFAULT 0,
  nama VARCHAR(100),
  harga INT,
  stok INT,
  gambar VARCHAR(100)
);

-- Data menu makanan/minuman
INSERT INTO menu (id_kantin, nama, harga, stok, gambar) VALUES
(1, 'Nasi Goreng', 15000, 5, 'nasi_goreng.jpg'),
(1, 'Mie Ayam', 12000, 3, 'mie_ayam.jpg'),
(2, 'Batagor', 10000, 7, 'batagor.jpg'),
(2, 'Jus Alpukat', 8000, 6, 'alpukat.jpg'),
(2, 'Susu Coklat', 7000, 4, 'susu.jpg'),
(3, 'Nasi Uduk', 14000, 8, 'uduk.jpg'),
(3, 'Ayam Goreng', 18000, 5, 'ayam.jpg'),
(3, 'Air Mineral', 3000, 12, 'air.jpg');

-- Tabel pesanan
CREATE TABLE IF NOT EXISTS pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_pemesan VARCHAR(100),
  email VARCHAR(100),
  total_harga INT,
  waktu_pesan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel detail pesanan
CREATE TABLE IF NOT EXISTS pesanan_detail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_pesanan INT,
  id_menu INT,
  jumlah INT,
  subtotal INT,
  FOREIGN KEY (id_pesanan) REFERENCES pesanan(id),
  FOREIGN KEY (id_menu) REFERENCES menu(id)
);
