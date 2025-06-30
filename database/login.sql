-- Membuat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$O5.U0ogijV5UOQsC.Ds2y.G1tDx4tvdO/FdzKYBHQY9i4ct7IRaRK', 'admin'), -- Password: admin123
('user', '$2y$10$sqJZNEdZwaJt5gJ4DSDbnO0x2Msns9iwU8n4YqMTa3Ueu7m0D9Hty', 'user'); -- Password: user123

-- Buat tabel team untuk data Tim Kami
CREATE TABLE team (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    foto VARCHAR(255) -- bisa diisi URL gambar atau nama file gambar
);

CREATE TABLE pesan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pesan TEXT NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP
);