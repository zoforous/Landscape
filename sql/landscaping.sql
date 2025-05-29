-- Create the database
CREATE DATABASE IF NOT EXISTS landscaping;
USE landscaping;

-- Users table: stores both regular users and admins
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact form submissions
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Estimates table for storing calculated estimates
CREATE TABLE IF NOT EXISTS estimates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    yard_size INT NOT NULL,
    design_option VARCHAR(100) NOT NULL,
    estimated_cost DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert default admin user with plaintext password
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@gmail.com', 'admin', 'admin');