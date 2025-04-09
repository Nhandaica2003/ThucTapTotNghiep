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

-- Dumping structure for table nhan.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `semester_id` int NOT NULL,
  `comment_bcs` text,
  `comment_teacher` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.comments: ~0 rows (approximately)

-- Dumping structure for table nhan.diem_ren_luyen
CREATE TABLE IF NOT EXISTS `diem_ren_luyen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `max_score` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `semester_id` int DEFAULT NULL,
  `parent_id` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.diem_ren_luyen: ~50 rows (approximately)
INSERT INTO `diem_ren_luyen` (`id`, `name`, `max_score`, `created_at`, `semester_id`, `parent_id`) VALUES
	(118, 'a) Ý thức và thái độ trong học tập', 4.00, '2025-04-01 03:46:40', 29, 0),
	(119, '- Có đi học chuyên cần, đúng giờ, nghiêm túc trong giờ học; đủ điều kiện dự thi tất cả các học phần\n (Không đủ điều kiện dự thi 01 học phần bị trừ 02 điểm. Không đủ điều kiện dự thi từ 02 học phần trở lên bị trừ hết số điểm còn lại của tiêu chí)', 4.00, '2025-04-01 03:46:40', 29, 0),
	(120, 'b. Ý thức và thái độ tham gia các câu lạc bộ học thuật, hoạt động học thuật, hoạt động ngoại khoá, hoạt động nghiên cứu khoa học', 4.00, '2025-04-01 03:46:40', 29, 0),
	(121, '- Có đăng ký, thực hiện, báo cáo đề tài nghiên cứu khoa học đúng tiến độ hoặc có đăng ký, tham dự kỳ thi sinh viên giỏi các cấp', 2.00, '2025-04-01 03:46:40', 29, 0),
	(122, '- Có ý thức tham gia các câu lạc bộ học thuật, các hoạt động học thuật, hoạt động ngoại khoá', 2.00, '2025-04-01 03:46:40', 29, 0),
	(123, 'c. Ý thức và thái độ trong kỳ thi, kiểm tra đánh giá các học phần', 6.00, '2025-04-01 03:46:40', 29, 0),
	(124, '- Không vi phạm quy chế thi và kiểm tra \n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 6.00, '2025-04-01 03:46:40', 29, 0),
	(125, 'd. Tinh thần vượt khó, phấn đấu vươn lên trong học tập', 2.00, '2025-04-01 03:46:40', 29, 0),
	(126, '- Được tập thể lớp công nhận có tinh thần vượt khó, phấn đấu vươn lên trong học tập', 2.00, '2025-04-01 03:46:40', 29, 0),
	(127, 'e. Kết quả học tập  0 điểm', 4.00, '2025-04-01 03:46:40', 29, 0),
	(128, '- Điểm TBCHK từ 3,2 đến 4,0 \n - Điểm TBCHK từ 2,0 đến 3,19 \n - Điểm TBCHK dưới 2,0', 4.00, '2025-04-01 03:46:40', 29, 0),
	(129, 'Cộng mục 1', 20.00, '2025-04-01 03:46:40', 29, 0),
	(130, '2. Đánh giá về ý thức chấp hành nội quy, quy chế, quy định được thực hiện trong nhà trường', 25.00, '2025-04-01 03:46:40', 29, 0),
	(131, 'a) Ý thức chấp hành các văn bản chỉ đạo của ngành, của cấp trên và ĐHĐN được thực hiện trong nhà trường', 10.00, '2025-04-01 03:46:40', 29, 0),
	(132, '- Có ý thức chấp hành các văn bản chỉ đạo của ngành, cấp trên và ĐHĐN được thực hiện trong nhà trường\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 6.00, '2025-04-01 03:46:40', 29, 0),
	(133, '- Có ý thức tham gia đầy đủ, đạt yêu cầu các cuộc vận động, sinh hoạt chính trị theo chủ trương, của cấp trên, ĐHĐN và nhà trường\n (Không tham gia 01 lần hoặc vi phạm quy định của các cuộc vận động bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 4.00, '2025-04-01 03:46:40', 29, 0),
	(134, 'b. Ý thức chấp hành nội quy, quy chế và các quy định của nhà trường', 15.00, '2025-04-01 03:46:40', 29, 0),
	(135, '- Có ý thức chấp hành nội quy, quy chế và các quy định của nhà trường\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ ba trở đi bị trừ hết số điểm còn lại của tiêu chí)', 10.00, '2025-04-01 03:46:40', 29, 0),
	(136, '- Có ý thức chấp hành quy định về đóng học phí\n (Không đóng học phí hoặc đóng học phí trễ hạn (không có phép) bị trừ 05 điểm)', 5.00, '2025-04-01 03:46:40', 29, 0),
	(137, 'Cộng mục 2', 25.00, '2025-04-01 03:46:40', 29, 0),
	(138, '3. Đánh giá về ý thức tham gia các hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao, phòng chống tội phạm và các tệ nạn xã hội', 20.00, '2025-04-01 03:46:40', 29, 0),
	(139, 'a. Ý thức và hiệu quả tham gia các hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao', 16.00, '2025-04-01 03:46:40', 29, 0),
	(140, '- Tham gia đầy đủ, đạt yêu cầu “Tuần sinh hoạt công dân sinh viên” (đánh giá chung cho cả hai học kỳ trong năm học)\n (Vắng 01 lần (không có phép) bị trừ 02 điểm; Tham gia nhưng kết quả không đạt thì phải học lại và bị trừ 04 điểm; Không tham gia thì phải học lại và bị trừ 10 điểm)', 10.00, '2025-04-01 03:46:40', 29, 0),
	(141, '- Có ý thức tham gia đầy đủ, nghiêm túc hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao do nhà trường và ĐHĐN tổ chức, điều động\n (Vắng 01 lần (không có phép) bị trừ 02 điểm)', 6.00, '2025-04-01 03:46:40', 29, 0),
	(142, 'b) Ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong nhà trường', 2.00, '2025-04-01 03:46:40', 29, 0),
	(143, '- Có ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong nhà trường', 2.00, '2025-04-01 03:46:40', 29, 0),
	(144, 'c) Ý thức tham gia các hoạt động tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội trong nhà trường', 2.00, '2025-04-01 03:46:40', 29, 0),
	(145, '- Có ý thức tham gia các hoạt động tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội trong nhà trường', 2.00, '2025-04-01 03:46:40', 29, 0),
	(146, 'Cộng mục 3', 20.00, '2025-04-01 03:46:40', 29, 0),
	(147, '4. Đánh giá về ý thức công dân trong quan hệ cộng đồng', 25.00, '2025-04-01 03:46:40', 29, 0),
	(148, 'a) Ý thức chấp hành và tham gia tuyên truyền các chủ trương của Đảng, chính sách, pháp luật của Nhà nước', 19.00, '2025-04-01 03:46:40', 29, 0),
	(149, '- Có ý thức chấp hành, tham gia tuyên truyền các chủ trương của Đảng, chính sách, pháp luật của Nhà nước\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 4.00, '2025-04-01 03:46:40', 29, 0),
	(150, '- Có tham gia bảo hiểm y tế (bắt buộc) theo Luật bảo hiểm y tế \n (Không tham gia bảo hiểm y tế (bắt buộc) bị trừ 10 điểm)', 10.00, '2025-04-01 03:46:40', 29, 0),
	(151, '- Có ý thức chấp hành, tham gia tuyên truyền các quy định về bảo đảm an toàn giao thông và “văn hóa giao thông”\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 5.00, '2025-04-01 03:46:40', 29, 0),
	(152, 'b) Có ý thức tham gia các hoạt động xã hội, có thành tích được ghi nhận, biểu dương, khen thưởng', 4.00, '2025-04-01 03:46:40', 29, 0),
	(153, '- Có ý thức tham gia các hoạt động xã hội có thành tích được ghi nhận, biểu dương, khen thưởng', 4.00, '2025-04-01 03:46:40', 29, 0),
	(154, 'c) Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn', 2.00, '2025-04-01 03:46:40', 29, 0),
	(155, '- Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn', 2.00, '2025-04-01 03:46:40', 29, 0),
	(156, 'Cộng mục 4', 25.00, '2025-04-01 03:46:40', 29, 0),
	(157, '5. Đánh giá về ý thức và kết quả khi tham gia công tác cán bộ lớp, các đoàn thể, tổ chức trong nhà trường hoặc sinh viên đạt được thành tích trong học tập, rèn luyện', 10.00, '2025-04-01 03:46:40', 29, 0),
	(158, 'a) Có ý thức, tinh thần, thái độ, uy tín và đạt hiệu quả công việc khi sinh viên được phân công nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong nhà trường', 3.00, '2025-04-01 03:46:40', 29, 0),
	(159, '- Có ý thức, uy tín và hoàn thành tốt nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên, tổ chức khác trong nhà trường', 3.00, '2025-04-01 03:46:40', 29, 0),
	(160, 'b) Kỹ năng tổ chức, quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong nhà trường', 2.00, '2025-04-01 03:46:40', 29, 0),
	(161, '- Có kỹ năng tổ chức, quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong nhà trường', 2.00, '2025-04-01 03:46:40', 29, 0),
	(162, 'c) Hỗ trợ và tham gia tích cực các hoạt động chung của tập thể lớp, khoa, trường và ĐHĐN', 3.00, '2025-04-01 03:46:40', 29, 0),
	(163, '- Hỗ trợ và tham gia tích cực các hoạt động chung của tập thể lớp, khoa, trường và ĐHĐN', 3.00, '2025-04-01 03:46:40', 29, 0),
	(164, 'd) Đạt được thành tích trong học tập, rèn luyện', 2.00, '2025-04-01 03:46:40', 29, 0),
	(165, '- Đạt thành tích trong học tập, rèn luyện (được tặng bằng khen, giấy khen, chứng nhận, thư khen của các cấp)', 2.00, '2025-04-01 03:46:40', 29, 0),
	(166, 'Cộng mục 5', 10.00, '2025-04-01 03:46:40', 29, 0),
	(167, 'Tổng cộng (mục 1 đến mục 5)', 100.00, '2025-04-01 03:46:40', 29, 0);

-- Dumping structure for table nhan.diem_ren_luyen_user_id
CREATE TABLE IF NOT EXISTS `diem_ren_luyen_user_id` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `diem_ren_luyen_id` int NOT NULL,
  `semester_id` int NOT NULL,
  `student_self_assessment_score` decimal(20,2) DEFAULT NULL,
  `class_assessment_score` decimal(20,2) DEFAULT NULL,
  `evidence` text,
  `teacher_assessment_score` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.diem_ren_luyen_user_id: ~50 rows (approximately)
INSERT INTO `diem_ren_luyen_user_id` (`id`, `user_id`, `diem_ren_luyen_id`, `semester_id`, `student_self_assessment_score`, `class_assessment_score`, `evidence`, `teacher_assessment_score`) VALUES
	(1, 4, 118, 29, 4.00, 2.00, '', '4'),
	(2, 4, 119, 29, 4.00, 2.00, '', '3'),
	(3, 4, 120, 29, 4.00, 4.00, '', '2'),
	(4, 4, 121, 29, 2.00, 0.00, '', '2'),
	(5, 4, 122, 29, 2.00, 0.00, '', '1'),
	(6, 4, 123, 29, 6.00, 0.00, '', '6'),
	(7, 4, 124, 29, 6.00, 0.00, '', '6'),
	(8, 4, 125, 29, 2.00, 0.00, '', '2'),
	(9, 4, 126, 29, 2.00, 0.00, '', '0'),
	(10, 4, 127, 29, 4.00, 0.00, '', '4'),
	(11, 4, 128, 29, 4.00, 0.00, '', '4'),
	(12, 4, 129, 29, 0.00, 0.00, '', '0'),
	(13, 4, 130, 29, 0.00, 0.00, '', '0'),
	(14, 4, 131, 29, 10.00, 0.00, '', '0'),
	(15, 4, 132, 29, 5.00, 0.00, '', '5.00'),
	(16, 4, 133, 29, 4.00, 0.00, '', '4'),
	(17, 4, 134, 29, 0.00, 0.00, '', '0'),
	(18, 4, 135, 29, 10.00, 0.00, '', '10'),
	(19, 4, 136, 29, 5.00, 0.00, '', '5'),
	(20, 4, 137, 29, -1.00, 0.00, '', '0'),
	(21, 4, 138, 29, 0.00, 0.00, '', '0'),
	(22, 4, 139, 29, 0.00, 0.00, '', '0'),
	(23, 4, 140, 29, 10.00, 0.00, '', '10'),
	(24, 4, 141, 29, 4.00, 0.00, '', '6'),
	(25, 4, 142, 29, 0.00, 0.00, '', '0'),
	(26, 4, 143, 29, 2.00, 0.00, '', '2'),
	(27, 4, 144, 29, 0.00, 0.00, '', '0'),
	(28, 4, 145, 29, 2.00, 0.00, '', '2'),
	(29, 4, 146, 29, -1.00, 0.00, '', '0'),
	(30, 4, 147, 29, 0.00, 0.00, '', '0'),
	(31, 4, 148, 29, 0.00, 0.00, '', '0'),
	(32, 4, 149, 29, 4.00, 0.00, '', '4'),
	(33, 4, 150, 29, 10.00, 0.00, '', '10'),
	(34, 4, 151, 29, 9.00, 0.00, '', '9'),
	(35, 4, 152, 29, 0.00, 0.00, '', '0'),
	(36, 4, 153, 29, 4.00, 0.00, '', '4'),
	(37, 4, 154, 29, 2.00, 0.00, '', '0'),
	(38, 4, 155, 29, 2.00, 0.00, '', '2'),
	(39, 4, 156, 29, 0.00, 0.00, '', '0'),
	(40, 4, 157, 29, 0.00, 0.00, '', '0'),
	(41, 4, 158, 29, 0.00, 0.00, '', '3'),
	(42, 4, 159, 29, 3.00, 0.00, '', '3'),
	(43, 4, 160, 29, 0.00, 0.00, '', '0'),
	(44, 4, 161, 29, 2.00, 0.00, '', '2'),
	(45, 4, 162, 29, 0.00, 0.00, '', '0'),
	(46, 4, 163, 29, 3.00, 0.00, '', '3.00'),
	(47, 4, 164, 29, 0.00, 0.00, '', '0'),
	(48, 4, 165, 29, 2.00, 0.00, '', '2'),
	(49, 4, 166, 29, 0.00, 0.00, '', '0'),
	(50, 4, 167, 29, 0.00, 0.00, '', '0');

-- Dumping structure for table nhan.duyets
CREATE TABLE IF NOT EXISTS `duyets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `diem_gv_cham` float DEFAULT NULL,
  `xep_loai` varchar(255) DEFAULT NULL,
  `nhan_xet` text,
  `duyet` tinyint(1) DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `semester_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nhan_xet_bcs` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.duyets: ~1 rows (approximately)
INSERT INTO `duyets` (`id`, `diem_gv_cham`, `xep_loai`, `nhan_xet`, `duyet`, `user_id`, `semester_id`, `created_at`, `nhan_xet_bcs`) VALUES
	(1, 31, 'Yếu', '', 1, 1, 29, '2025-04-08 06:51:40', NULL),
	(2, 120, 'Kém', '', 1, 4, 29, '2025-04-09 02:41:43', ' Nhận xét của Ban Can sự 222');

-- Dumping structure for table nhan.form_danh_gia
CREATE TABLE IF NOT EXISTS `form_danh_gia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `max_score` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.form_danh_gia: ~45 rows (approximately)
INSERT INTO `form_danh_gia` (`id`, `name`, `max_score`, `parent_id`) VALUES
	(127, '1. Đánh giá về ý thức học tập', 4, 0),
	(128, 'a) Ý thức và thái độ trong học tập', 9, 127),
	(129, '- Có đi học chuyên cần, đúng giờ, nghiêm túc trong giờ học; đủ điều kiện dự thi tất cả các học phần\n (Không đủ điều kiện dự thi 01 học phần bị trừ 02 điểm. Không đủ điều kiện dự thi từ 02 học phần trở lên bị trừ hết số điểm còn lại của tiêu chí)', 4, 127),
	(130, 'b. Ý thức và thái độ tham gia các câu lạc bộ học thuật, hoạt động học thuật, hoạt động ngoại khoá, hoạt động nghiên cứu khoa học', 4, 127),
	(131, '- Có đăng ký, thực hiện, báo cáo đề tài nghiên cứu khoa học đúng tiến độ hoặc có đăng ký, tham dự kỳ thi sinh viên giỏi các cấp', 2, 127),
	(132, '- Có ý thức tham gia các câu lạc bộ học thuật, các hoạt động học thuật, hoạt động ngoại khoá', 2, 127),
	(133, 'c. Ý thức và thái độ trong kỳ thi, kiểm tra đánh giá các học phần', 6, 127),
	(134, '- Không vi phạm quy chế thi và kiểm tra \n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 6, 127),
	(135, 'd. Tinh thần vượt khó, phấn đấu vươn lên trong học tập', 2, 127),
	(136, '- Được tập thể lớp công nhận có tinh thần vượt khó, phấn đấu vươn lên trong học tập', 2, 127),
	(137, 'e. Kết quả học tập  0 điểm', 4, 127),
	(138, '- Điểm TBCHK từ 3,2 đến 4,0 \n - Điểm TBCHK từ 2,0 đến 3,19 \n - Điểm TBCHK dưới 2,0', 4, 127),
	(140, '2. Đánh giá về ý thức chấp hành nội quy, quy chế, quy định được thực hiện trong nhà trường', 25, 0),
	(141, 'a) Ý thức chấp hành các văn bản chỉ đạo của ngành, của cấp trên và ĐHĐN được thực hiện trong nhà trường', 10, 140),
	(142, '- Có ý thức chấp hành các văn bản chỉ đạo của ngành, cấp trên và ĐHĐN được thực hiện trong nhà trường\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 6, 140),
	(143, '- Có ý thức tham gia đầy đủ, đạt yêu cầu các cuộc vận động, sinh hoạt chính trị theo chủ trương, của cấp trên, ĐHĐN và nhà trường\n (Không tham gia 01 lần hoặc vi phạm quy định của các cuộc vận động bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 4, 140),
	(144, 'b. Ý thức chấp hành nội quy, quy chế và các quy định của nhà trường', 15, 140),
	(145, '- Có ý thức chấp hành nội quy, quy chế và các quy định của nhà trường\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ ba trở đi bị trừ hết số điểm còn lại của tiêu chí)', 10, 140),
	(146, '- Có ý thức chấp hành quy định về đóng học phí\n (Không đóng học phí hoặc đóng học phí trễ hạn (không có phép) bị trừ 05 điểm)', 5, 140),
	(148, '3. Đánh giá về ý thức tham gia các hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao, phòng chống tội phạm và các tệ nạn xã hội', 20, 0),
	(149, 'a. Ý thức và hiệu quả tham gia các hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao', 16, 148),
	(150, '- Tham gia đầy đủ, đạt yêu cầu “Tuần sinh hoạt công dân sinh viên” (đánh giá chung cho cả hai học kỳ trong năm học)\n (Vắng 01 lần (không có phép) bị trừ 02 điểm; Tham gia nhưng kết quả không đạt thì phải học lại và bị trừ 04 điểm; Không tham gia thì phải học lại và bị trừ 10 điểm)', 10, 148),
	(151, '- Có ý thức tham gia đầy đủ, nghiêm túc hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao do nhà trường và ĐHĐN tổ chức, điều động\n (Vắng 01 lần (không có phép) bị trừ 02 điểm)', 6, 148),
	(152, 'b) Ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong nhà trường', 2, 148),
	(153, '- Có ý thức tham gia các hoạt động công ích, tình nguyện, công tác xã hội trong nhà trường', 2, 148),
	(154, 'c) Ý thức tham gia các hoạt động tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội trong nhà trường', 2, 148),
	(155, '- Có ý thức tham gia các hoạt động tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội trong nhà trường', 2, 148),
	(157, '4. Đánh giá về ý thức công dân trong quan hệ cộng đồng', 25, 0),
	(158, 'a) Ý thức chấp hành và tham gia tuyên truyền các chủ trương của Đảng, chính sách, pháp luật của Nhà nước', 19, 157),
	(159, '- Có ý thức chấp hành, tham gia tuyên truyền các chủ trương của Đảng, chính sách, pháp luật của Nhà nước\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 4, 157),
	(160, '- Có tham gia bảo hiểm y tế (bắt buộc) theo Luật bảo hiểm y tế \n (Không tham gia bảo hiểm y tế (bắt buộc) bị trừ 10 điểm)', 10, 157),
	(161, '- Có ý thức chấp hành, tham gia tuyên truyền các quy định về bảo đảm an toàn giao thông và “văn hóa giao thông”\n (Vi phạm 01 lần bị trừ 02 điểm, từ lần vi phạm thứ hai trở đi bị trừ hết số điểm còn lại của tiêu chí)', 5, 157),
	(162, 'b) Có ý thức tham gia các hoạt động xã hội, có thành tích được ghi nhận, biểu dương, khen thưởng', 4, 157),
	(163, '- Có ý thức tham gia các hoạt động xã hội có thành tích được ghi nhận, biểu dương, khen thưởng', 4, 157),
	(164, 'c) Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn', 2, 157),
	(165, '- Có tinh thần chia sẻ, giúp đỡ người gặp khó khăn, hoạn nạn', 2, 157),
	(167, '5. Đánh giá về ý thức và kết quả khi tham gia công tác cán bộ lớp, các đoàn thể, tổ chức trong nhà trường hoặc sinh viên đạt được thành tích trong học tập, rèn luyện', 10, 0),
	(168, 'a) Có ý thức, tinh thần, thái độ, uy tín và đạt hiệu quả công việc khi sinh viên được phân công nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong nhà trường', 3, 167),
	(169, '- Có ý thức, uy tín và hoàn thành tốt nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên, tổ chức khác trong nhà trường', 3, 167),
	(170, 'b) Kỹ năng tổ chức, quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong nhà trường', 2, 167),
	(171, '- Có kỹ năng tổ chức, quản lý lớp, các tổ chức Đảng, Đoàn Thanh niên, Hội Sinh viên và các tổ chức khác trong nhà trường', 2, 167),
	(172, 'c) Hỗ trợ và tham gia tích cực các hoạt động chung của tập thể lớp, khoa, trường và ĐHĐN', 3, 167),
	(173, '- Hỗ trợ và tham gia tích cực các hoạt động chung của tập thể lớp, khoa, trường và ĐHĐN', 3, 167),
	(174, 'd) Đạt được thành tích trong học tập, rèn luyện', 2, 167),
	(175, '- Đạt thành tích trong học tập, rèn luyện (được tặng bằng khen, giấy khen, chứng nhận, thư khen của các cấp)', 2, 167),
	(178, '2222', 0, 0);

-- Dumping structure for table nhan.groupes
CREATE TABLE IF NOT EXISTS `groupes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `khoa_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.khoa: ~4 rows (approximately)
INSERT INTO `khoa` (`id`, `name`, `created_at`) VALUES
	(1, 'Khóa 50K', '2025-03-28 14:05:25'),
	(2, 'Khóa 49k', '2025-03-28 14:05:45'),
	(3, 'Khóa 48K', '2025-03-28 14:06:03'),
	(4, 'Khóa 47K', '2025-03-28 14:06:20');

-- Dumping structure for table nhan.lop_chu_nhiem
CREATE TABLE IF NOT EXISTS `lop_chu_nhiem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.lop_chu_nhiem: ~6 rows (approximately)
INSERT INTO `lop_chu_nhiem` (`id`, `user_id`, `group_id`, `created_at`) VALUES
	(8, 1, 4, '2025-04-06 06:08:49'),
	(9, 1, 8, '2025-04-06 06:08:49'),
	(12, 6, 3, '2025-04-06 06:10:54'),
	(13, 6, 4, '2025-04-06 06:10:54'),
	(14, 7, 3, '2025-04-06 06:14:56'),
	(15, 7, 7, '2025-04-06 06:14:56');

-- Dumping structure for table nhan.semester
CREATE TABLE IF NOT EXISTS `semester` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `point` int DEFAULT '0',
  `point_class` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `point_teacher` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.semester: ~1 rows (approximately)
INSERT INTO `semester` (`id`, `name`, `point`, `point_class`, `group_id`, `point_teacher`) VALUES
	(29, 'Học kỳ mới 2092', 0, NULL, 1, NULL);

-- Dumping structure for table nhan.semester_scores
CREATE TABLE IF NOT EXISTS `semester_scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `semester_id` int NOT NULL,
  `group_id` int NOT NULL,
  `excellent_count` int DEFAULT '0',
  `good_count` int DEFAULT '0',
  `fairly_good_count` int DEFAULT '0',
  `average_count` int DEFAULT '0',
  `weak_count` int DEFAULT '0',
  `poor_count` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.semester_scores: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table nhan.users: ~7 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role_name`, `group_id`, `chuyennganh`, `he_dao_tao`, `full_name`, `birthday`, `ma_sinh_vien`) VALUES
	(1, 'nguyenvana@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-03-15 14:51:08', 'ban can su', 1, 'công nghệ thông tin', 'Chính quy', 'Nguyễn Văn B', '2005-03-08', '14551231222'),
	(4, 'hungrandy', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-03-31 03:19:01', 'sinh vien', 1, 'Công Nghệ thông tin', 'Chính quy', 'Lê Quốc Hưng', '2001-01-15', '152155322'),
	(6, 'nguyenvanc@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-04-06 06:10:54', 'sinh vien', 1, 'công nghệ thông tin', 'Chính quy', 'Nguyễn Văn D', '2025-04-02', NULL),
	(7, 'nguyenvana2w@gmail.com', 'e2a1715ac00b5e872a2191fb13f69a69', '2025-04-06 06:14:56', 'ban can su', 1, NULL, NULL, 'Nguyễn Văn Lan', NULL, NULL),
	(8, 'bancansua@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-04-06 06:24:15', 'ban can su', NULL, NULL, NULL, 'Ban can su a', NULL, NULL),
	(9, 'bancansu2@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2025-04-06 06:31:12', 'ban can su', 4, NULL, NULL, 'Ban can su C', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
