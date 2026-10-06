CREATE DATABASE IF NOT EXISTS internship_crud;
USE internship_crud;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO employees (name, email, phone, department) VALUES
('Amit Sharma', 'amit@example.com', '9876543210', 'IT'),
('Neha Patil', 'neha@example.com', '9876501234', 'HR');
