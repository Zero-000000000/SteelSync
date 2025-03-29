CREATE DATABASE IF NOT EXISTS steelsync;

USE steelsync;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert a default user (Replace 'yourpassword' with your actual password)
INSERT INTO users (username, password) VALUES ('jen', MD5('jen'));
