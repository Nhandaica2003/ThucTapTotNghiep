CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_name VARCHAR(50) NOT NULL DEFAULT 'user',
    group_id INT,
    chuyennganh VARCHAR(255),
    he_dao_tao VARCHAR(255),
    full_name VARCHAR(255),
    birthday DATE,
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


CREATE TABLE groupes (
    id SERIAL PRIMARY KEY,
    group_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE diem_ren_luyen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    max_score DECIMAL(10, 2) NOT NULL, -- Điểm tối đa
    student_self_assessment_score DECIMAL(10, 2) DEFAULT 0, -- Điểm sinh viên tự đánh giá
    class_assessment_score DECIMAL(10, 2) DEFAULT 0, -- Điểm lớp đánh giá
    evidence Text, -- Minh chứng
    teacher_comments TEXT, -- Nhận xét của giáo viên
    class_leader_comments TEXT, -- Nhận xét của ban cán sự
    teacher_assessment_score DECIMAL(10, 2), -- Điểm giáo viên đánh giá
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Thời gian tạo
    semester_id INT, -- ID học kỳ
    user_id INT -- ID người dùng
);

