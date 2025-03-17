CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_name VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, role_name) VALUES
('admin1', MD5('password'), "admin"),
('admin2', MD5('password'), 'admin'),
('admin3', MD5('password'), 'admin');


CREATE TABLE semester (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    activity_count INT DEFAULT 0
);
INSERT INTO semester (name, start_date, end_date, activity_count) 
VALUES 
('Học kì 1', '2024-02-01', '2024-06-01', 10),
('Học kì 2', '2023-06-15', '2023-08-30', 5),
('Fall 2025', '2025-09-10', '2026-01-15', 12);
