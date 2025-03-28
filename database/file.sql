-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table nhan.diem_ren_luyen
CREATE TABLE IF NOT EXISTS `diem_ren_luyen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `max_score` decimal(10,2) NOT NULL,
  `student_self_assessment_score` decimal(10,2) DEFAULT '0.00',
  `class_assessment_score` decimal(10,2) DEFAULT '0.00',
  `evidence` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `teacher_comments` text,
  `class_leader_comments` text,
  `teacher_assessment_score` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `semester_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `parent_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.diem_ren_luyen: ~0 rows (approximately)
INSERT INTO `diem_ren_luyen` (`id`, `name`, `max_score`, `student_self_assessment_score`, `class_assessment_score`, `evidence`, `teacher_comments`, `class_leader_comments`, `teacher_assessment_score`, `created_at`, `semester_id`, `user_id`, `parent_id`) VALUES
	(1, 'điểm tự đánh giá', 20.00, 4.00, 5.00, 'uploads/1742874153.jpg', NULL, NULL, NULL, '2025-03-25 03:42:33', 2, 1, 0);

-- Dumping structure for table nhan.groupes
CREATE TABLE IF NOT EXISTS `groupes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `khoa_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.groupes: ~8 rows (approximately)
INSERT INTO `groupes` (`id`, `group_name`, `created_at`, `khoa_id`) VALUES
	(1, '47K21.1', '2025-03-24 03:21:25', 4),
	(2, '47K21.2', '2025-03-28 14:06:43', 4),
	(3, '50K21.2', '2025-03-28 14:07:03', 1),
	(4, '50K21.1', '2025-03-28 14:07:11', 1),
	(5, '48K21.1', '2025-03-28 14:07:20', 3),
	(6, '48K21.2', '2025-03-28 14:07:28', 3),
	(7, '49K21.2', '2025-03-28 14:07:37', 2),
	(8, '49K21.1', '2025-03-28 14:07:44', 2);

-- Dumping structure for table nhan.khoa
CREATE TABLE IF NOT EXISTS `khoa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.khoa: ~4 rows (approximately)
INSERT INTO `khoa` (`id`, `name`, `created_at`) VALUES
	(1, 'Khóa 50K', '2025-03-28 14:05:25'),
	(2, 'Khóa 49k', '2025-03-28 14:05:45'),
	(3, 'Khóa 48K', '2025-03-28 14:06:03'),
	(4, 'Khóa 47K', '2025-03-28 14:06:20');

-- Dumping structure for table nhan.semester
CREATE TABLE IF NOT EXISTS `semester` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `point` int DEFAULT '0',
  `user_id` int DEFAULT '0',
  `point_class` int DEFAULT NULL,
  `point_teacher` int DEFAULT NULL,
  `comment_teacher` text,
  `comment_bcs` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.semester: ~3 rows (approximately)
INSERT INTO `semester` (`id`, `name`, `point`, `user_id`, `point_class`, `point_teacher`, `comment_teacher`, `comment_bcs`) VALUES
	(2, 'Học kì 2', 50, 1, NULL, NULL, 'em học này cũng ok', 'em rất tốt'),
	(4, 'hoc ky 2', 70, 1, NULL, NULL, 'em học này cũng ok', 'em rất tốt'),
	(5, 'học kỳ 3', 80, 1, NULL, NULL, 'em học này cũng ok', 'em rất tốt'),
	(6, 'Học ky 2', 30, 2, NULL, NULL, 'khả năng và kỹ thuật đã được cải thiện nhiều', 'cố gắng lên nữa bạn ơi');

-- Dumping structure for table nhan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role_name` varchar(50) DEFAULT 'user',
  `group_id` int DEFAULT NULL,
  `chuyennganh` varchar(255) DEFAULT NULL,
  `he_dao_tao` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `ma_sinh_vien` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role_name`, `group_id`, `chuyennganh`, `he_dao_tao`, `full_name`, `birthday`, `ma_sinh_vien`) VALUES
	(1, 'nguyenvana@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-03-15 14:51:08', 'ban can su', 1, 'Hệ thống thông tin', 'Chính quy', 'Nguyễn Văn A', '2005-03-24', '14551231222'),
	(2, 'dungtn@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-03-15 14:51:08', 'sinh vien', 1, 'Hệ thống thông tin', 'Chính quy', 'Nguyễn Ngọc Dũng', '2025-03-24', '14551231221'),
	(3, 'hoangngoclan@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-03-15 14:51:08', 'sinh vien', 1, 'Hệ thống thông tin', 'Chính quy', 'Hoàng Ngọc Lan', '2025-03-24', '12512151231');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
