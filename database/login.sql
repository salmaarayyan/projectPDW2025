-- Membuat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$eW5z1Zb1a8Q9F5f5d5f5d5e5f5d5f5d5f5d5f5d5f5d5f5d5f5d', 'admin'), -- Password: admin123
('user', '$2y$10$eW5z1Zb1a8Q9F5f5d5f5d5e5f5d5f5d5f5d5f5d5f5d5f5d5f', 'user'); -- Password: user123
