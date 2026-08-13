-- Database Schema and Seed Data for AI-ERGO
-- Version 1.0

CREATE DATABASE IF NOT EXISTS `ai_ergo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ai_ergo`;

-- 1. companies
CREATE TABLE IF NOT EXISTS `companies` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `address` TEXT NULL,
  `phone` VARCHAR(50) NULL,
  `email` VARCHAR(100) NULL,
  `logo` VARCHAR(255) NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. positions
CREATE TABLE IF NOT EXISTS `positions` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` BIGINT UNSIGNED NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `last_login` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `module` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. role_permissions
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `role_id` BIGINT UNSIGNED NOT NULL,
  `permission_id` BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `role_id` BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` BIGINT UNSIGNED NOT NULL,
  `department_id` BIGINT UNSIGNED NOT NULL,
  `position_id` BIGINT UNSIGNED NOT NULL,
  `employee_number` VARCHAR(50) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `gender` ENUM('L', 'P') NOT NULL DEFAULT 'L',
  `birth_date` DATE NULL,
  `age` INT NOT NULL DEFAULT 30,
  `height` DECIMAL(5,2) NOT NULL DEFAULT 168.00,
  `weight` DECIMAL(5,2) NOT NULL DEFAULT 65.00,
  `years_of_service` INT NOT NULL DEFAULT 3,
  `phone` VARCHAR(50) NULL,
  `email` VARCHAR(191) NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. job_profiles
CREATE TABLE IF NOT EXISTS `job_profiles` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `job_type` VARCHAR(255) NOT NULL,
  `sitting_hours` DECIMAL(4,2) DEFAULT 4.00,
  `standing_hours` DECIMAL(4,2) DEFAULT 3.00,
  `computer_hours` DECIMAL(4,2) DEFAULT 5.00,
  `shift_type` VARCHAR(50) DEFAULT 'Non-Shift',
  `work_duration` DECIMAL(4,2) DEFAULT 8.00,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. assessments
CREATE TABLE IF NOT EXISTS `assessments` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `assessor_id` BIGINT UNSIGNED NULL,
  `assessment_date` DATE NOT NULL,
  `total_score` INT NOT NULL DEFAULT 0,
  `risk_level` ENUM('Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi') NOT NULL DEFAULT 'Rendah',
  `dominant_body_area` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`assessor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. assessment_details
CREATE TABLE IF NOT EXISTS `assessment_details` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `assessment_id` BIGINT UNSIGNED NOT NULL,
  `body_part_code` VARCHAR(50) NOT NULL,
  `body_part_name` VARCHAR(100) NOT NULL,
  `score` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. ai_recommendations
CREATE TABLE IF NOT EXISTS `ai_recommendations` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `assessment_id` BIGINT UNSIGNED NOT NULL,
  `ai_provider` VARCHAR(50) NOT NULL DEFAULT 'gemini',
  `ai_model` VARCHAR(100) NOT NULL DEFAULT 'gemini-1.5-flash',
  `prompt_text` LONGTEXT NULL,
  `recommendation_text` LONGTEXT NOT NULL,
  `generated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` LONGTEXT NULL,
  `description` TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. activity_logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NULL,
  `module` VARCHAR(50) NOT NULL,
  `action` VARCHAR(50) NOT NULL,
  `description` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- SEED DATA
-- ========================================================

-- Roles
INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Super Admin', 'Super Admin Sistem dengan hak akses penuh seluruh organisasi'),
(2, 'Admin K3', 'Admin K3 Organisasi yang mengelola pekerja dan assessment'),
(3, 'HRD', 'Monitoring kesehatan dan rekomendasi ergonomi pekerja'),
(4, 'Ergonomist', 'Assessor pakar ergonomi yang memvalidasi hasil assessment'),
(5, 'Employee', 'Pekerja pengguna aplikasi untuk self assessment')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Permissions
INSERT INTO `permissions` (`id`, `name`, `module`) VALUES
(1, 'company.view', 'companies'),
(2, 'company.create', 'companies'),
(3, 'company.edit', 'companies'),
(4, 'company.delete', 'companies'),
(5, 'employee.view', 'employees'),
(6, 'employee.create', 'employees'),
(7, 'employee.edit', 'employees'),
(8, 'employee.delete', 'employees'),
(9, 'assessment.view', 'assessments'),
(10, 'assessment.create', 'assessments'),
(11, 'assessment.edit', 'assessments'),
(12, 'assessment.delete', 'assessments'),
(13, 'ai.generate', 'ai'),
(14, 'ai.settings', 'ai'),
(15, 'report.view', 'reports'),
(16, 'report.export', 'reports'),
(17, 'user.manage', 'users'),
(18, 'role.manage', 'roles'),
(19, 'system.settings', 'settings'),
(20, 'audit.view', 'audit')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Role Permissions
-- Assign all permissions to Super Admin (Role 1)
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 1, id FROM `permissions`;

-- Assign relevant permissions to Admin K3 (Role 2)
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(2, 5), (2, 6), (2, 7), (2, 8),
(2, 9), (2, 10), (2, 11), (2, 12),
(2, 13), (2, 15), (2, 16);

-- Assign relevant permissions to HRD (Role 3)
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(3, 5), (3, 9), (3, 15), (3, 16);

-- Assign relevant permissions to Ergonomist (Role 4)
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(4, 5), (4, 9), (4, 10), (4, 11), (4, 13), (4, 15), (4, 16);

-- Assign relevant permissions to Employee (Role 5)
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(5, 9), (5, 10);

-- Default Settings
INSERT INTO `settings` (`setting_group`, `setting_key`, `setting_value`, `description`) VALUES
('general', 'APP_NAME', 'AI-ERGO System', 'Nama Aplikasi Ergonomi'),
('general', 'APP_LOGO', 'assets/images/logo.png', 'Path Logo Aplikasi'),
('ai', 'AI_PROVIDER', 'gemini', 'Provider Utama AI (gemini / groq)'),
('ai', 'GEMINI_API_KEY', '', 'API Key Google Gemini'),
('ai', 'GROQ_API_KEY', '', 'API Key Groq API'),
('ai', 'AI_MODEL', 'gemini-1.5-flash', 'Model AI Default'),
('ai', 'AI_TEMPERATURE', '0.7', 'Temperature Model AI'),
('risk', 'RISK_THRESHOLD_LOW', '20', 'Batas Maksimum Skor Risiko Rendah'),
('risk', 'RISK_THRESHOLD_MEDIUM', '41', 'Batas Maksimum Skor Risiko Sedang'),
('risk', 'RISK_THRESHOLD_HIGH', '62', 'Batas Maksimum Skor Risiko Tinggi')
ON DUPLICATE KEY UPDATE `setting_value`=VALUES(`setting_value`);

-- Initial Company
INSERT INTO `companies` (`id`, `name`, `address`, `phone`, `email`, `status`) VALUES
(1, 'PT Industri Ergonomi Indonesia', 'Jl. Jend. Sudirman No. 123, Jakarta Pusat', '021-5550199', 'info@ergonomi.co.id', 'active')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Initial Departments
INSERT INTO `departments` (`id`, `company_id`, `name`, `description`) VALUES
(1, 1, 'Teknologi Informasi', 'Departemen Pengembangan & Infrastructure IT'),
(2, 1, 'Produksi & Manufaktur', 'Departemen Operasional Pabrik & Produksi'),
(3, 1, 'K3 & HSE', 'Departemen Keselamatan & Kesehatan Kerja')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Initial Positions
INSERT INTO `positions` (`id`, `company_id`, `name`, `description`) VALUES
(1, 1, 'Software Engineer', 'Pengembang Perangkat Lunak'),
(2, 1, 'Operator Perakitan', 'Operator Garis Produksi'),
(3, 1, 'Spesialis K3', 'Ahli Keselamatan Kerja')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Default Users (Password: password123)
-- Hash generated via password_hash('password123', PASSWORD_BCRYPT)
INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `password`, `status`) VALUES
(1, NULL, 'Super Administrator', 'admin@aiergo.com', '$2y$10$cAwVT.B9VqYpTF4Dc6Pcu.5qIowIBR7UZeb8H2wh1U0awISTuv1qq', 'active'),
(2, 1, 'Budi K3 Manager', 'k3@ergonomi.co.id', '$2y$10$cAwVT.B9VqYpTF4Dc6Pcu.5qIowIBR7UZeb8H2wh1U0awISTuv1qq', 'active'),
(3, 1, 'Siti HRD', 'hrd@ergonomi.co.id', '$2y$10$cAwVT.B9VqYpTF4Dc6Pcu.5qIowIBR7UZeb8H2wh1U0awISTuv1qq', 'active'),
(4, 1, 'Dr. Ahmad Ergonomist', 'ergonomist@ergonomi.co.id', '$2y$10$cAwVT.B9VqYpTF4Dc6Pcu.5qIowIBR7UZeb8H2wh1U0awISTuv1qq', 'active'),
(5, 1, 'Eko Pekerja', 'eko@ergonomi.co.id', '$2y$10$cAwVT.B9VqYpTF4Dc6Pcu.5qIowIBR7UZeb8H2wh1U0awISTuv1qq', 'active')
ON DUPLICATE KEY UPDATE `email`=`email`;

-- Assign Roles
INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5)
ON DUPLICATE KEY UPDATE `role_id`=VALUES(`role_id`);

-- Initial Employees
INSERT INTO `employees` (`id`, `company_id`, `department_id`, `position_id`, `employee_number`, `name`, `gender`, `birth_date`, `age`, `height`, `weight`, `years_of_service`, `phone`, `email`, `status`) VALUES
(1, 1, 1, 1, 'EMP-001', 'Eko Prasetyo', 'L', '1995-05-14', 31, 172.00, 70.00, 5, '08123456789', 'eko@ergonomi.co.id', 'active'),
(2, 1, 2, 2, 'EMP-002', 'Rina Wati', 'P', '1998-08-20', 28, 160.00, 55.00, 3, '08129876543', 'rina@ergonomi.co.id', 'active'),
(3, 1, 3, 3, 'EMP-003', 'Andi Pratama', 'L', '1990-12-01', 36, 175.00, 80.00, 8, '08131122334', 'andi@ergonomi.co.id', 'active')
ON DUPLICATE KEY UPDATE `employee_number`=`employee_number`;

-- Initial Job Profiles
INSERT INTO `job_profiles` (`id`, `employee_id`, `job_type`, `sitting_hours`, `standing_hours`, `computer_hours`, `shift_type`, `work_duration`) VALUES
(1, 1, 'Desk Worker / Programmer', 7.50, 0.50, 8.00, 'Non-Shift', 8.00),
(2, 2, 'Assembly Line Operator', 1.00, 7.00, 1.00, 'Shift 1', 8.00),
(3, 3, 'Safety Inspector', 4.00, 4.00, 4.00, 'Non-Shift', 8.00)
ON DUPLICATE KEY UPDATE `employee_id`=`employee_id`;

-- Sample Assessment 1 (High Risk Desktop Worker)
INSERT INTO `assessments` (`id`, `employee_id`, `assessor_id`, `assessment_date`, `total_score`, `risk_level`, `dominant_body_area`, `notes`) VALUES
(1, 1, 2, '2026-08-10', 48, 'Tinggi', 'Leher Atas, Punggung, Pinggang, Pergelangan Tangan Kanan', 'Keluhan berat akibat posisi duduk komputer > 7 jam sehari tanpa kursi ergonomik.')
ON DUPLICATE KEY UPDATE `employee_id`=`employee_id`;

-- 28 Body Parts Assessment Details for Assessment 1
INSERT INTO `assessment_details` (`assessment_id`, `body_part_code`, `body_part_name`, `score`) VALUES
(1, 'neck_upper', 'Leher Atas', 3),
(1, 'neck_lower', 'Leher Bawah', 2),
(1, 'shoulder_left', 'Bahu Kiri', 2),
(1, 'shoulder_right', 'Bahu Kanan', 3),
(1, 'arm_upper_left', 'Lengan Atas Kiri', 1),
(1, 'back_upper', 'Punggung', 3),
(1, 'arm_upper_right', 'Lengan Atas Kanan', 2),
(1, 'waist', 'Pinggang', 3),
(1, 'hips', 'Pinggul', 2),
(1, 'bottom', 'Pantat', 2),
(1, 'elbow_left', 'Siku Kiri', 1),
(1, 'elbow_right', 'Siku Kanan', 2),
(1, 'forearm_left', 'Lengan Bawah Kiri', 1),
(1, 'forearm_right', 'Lengan Bawah Kanan', 2),
(1, 'wrist_left', 'Pergelangan Tangan Kiri', 1),
(1, 'wrist_right', 'Pergelangan Tangan Kanan', 3),
(1, 'hand_left', 'Tangan Kiri', 1),
(1, 'hand_right', 'Tangan Kanan', 2),
(1, 'thigh_left', 'Paha Kiri', 1),
(1, 'thigh_right', 'Paha Kanan', 1),
(1, 'knee_left', 'Lutut Kiri', 1),
(1, 'knee_right', 'Lutut Kanan', 1),
(1, 'calf_left', 'Betis Kiri', 1),
(1, 'calf_right', 'Betis Kanan', 1),
(1, 'ankle_left', 'Pergelangan Kaki Kiri', 1),
(1, 'ankle_right', 'Pergelangan Kaki Kanan', 1),
(1, 'foot_left', 'Kaki Kiri', 1),
(1, 'foot_right', 'Kaki Kanan', 1);

-- AI Recommendation for Assessment 1
INSERT INTO `ai_recommendations` (`id`, `assessment_id`, `ai_provider`, `ai_model`, `prompt_text`, `recommendation_text`) VALUES
(1, 1, 'gemini', 'gemini-1.5-flash', 'Prompt data Eko Prasetyo...', 
'### 1. Analisis Kondisi Ergonomi & Risiko Dominan
Pekerja (Eko Prasetyo, 31 th, Software Engineer) mengalami risiko ergonomi tingkat **TINGGI** (Total Skor NBM: 48). Keluhan dominan berada di **Leher Atas, Punggung, Pinggang, dan Pergelangan Tangan Kanan**. Hal ini dikarenakan paparan durasi duduk 7.5 jam dan komputer 8 jam per hari tanpa istirahat mikro yang teratur.

### 2. Rekomendasi Perbaikan Postur (Posture Adjustments)
- **Posisi Monitor**: Naikkan tinggi monitor sejajar dengan garis mata (eye level) untuk mengurangi fleksi leher atas.
- **Posisi Duduk**: Atur sandaran kursi (lumbar support) membentuk sudut 100-110 derajat untuk menyangga pinggang.
- **Posisi Tangan**: Gunakan armrest kursi setinggi meja agar pergelangan tangan kanan berada dalam posisi netral saat mengetik/mouse.

### 3. Rekomendasi Aktivitas & Peregangan (Stretching & Break)
- **Aturan 20-20-20**: Setiap 20 menit, lihat objek sejauh 20 kaki (6 meter) selama 20 detik.
- **Microbreak**: Lakukan peregangan otot leher (chin tucks) dan pemutaran pergelangan tangan setiap 1 jam sekali selama 2 menit.
- **Walking Break**: Berdiri dan berjalan singkat setiap 2 jam.

### 4. Rekomendasi Peralatan Ergonomi (Ergonomic Equipment)
- Kursi Ergonomis dengan adjustable lumbar support & armrest.
- Mouse Vertikal Ergonomis untuk mengurangi tekanan pada pergelangan tangan kanan (Carpal Tunnel prevention).
- Footrest jika kaki tidak menapak sempurna di lantai.

### 5. Tindakan Preventif & Evaluasi
- Lakukan evaluasi ulang Nordic Body Map setelah 30 hari penerapan rekomendasi.
- Ikuti pelatihan postur kerja ergonomik untuk pekerja kantoran.')
ON DUPLICATE KEY UPDATE `assessment_id`=`assessment_id`;
