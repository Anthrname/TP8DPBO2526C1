-- Database: tp_mvc25
-- Tugas Praktikum 8 DPBO 2024/2025
-- Dibuat oleh: Najib Nurohman (2509653) - Kelas C1

CREATE DATABASE IF NOT EXISTS `tp_mvc25`;
USE `tp_mvc25`;

-- --------------------------------------------------------
-- 1. Struktur Tabel `departments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `lecturers`;
DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(20) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `faculty` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data Dummy Tabel `departments`
-- --------------------------------------------------------
INSERT INTO `departments` (`id`, `code`, `name`, `faculty`) VALUES
(1, 'IK', 'Ilmu Komputer', 'FPMIPA'),
(2, 'PTE', 'Pendidikan Teknik Elektro', 'FPTK'),
(3, 'SI', 'Sistem Informasi', 'FPMIPA'),
(4, 'MTK', 'Matematika', 'FPMIPA');

-- --------------------------------------------------------
-- 2. Struktur Tabel `lecturers`
--    (Menggunakan tabel bawaan dengan penambahan kolom department_id)
-- --------------------------------------------------------
CREATE TABLE `lecturers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `nidn` VARCHAR(30) NOT NULL UNIQUE,
  `phone` VARCHAR(25) NOT NULL,
  `join_date` DATE NOT NULL,
  `department_id` INT NULL,
  CONSTRAINT `fk_lecturers_departments` FOREIGN KEY (`department_id`) 
    REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data Dummy Tabel `lecturers`
-- --------------------------------------------------------
INSERT INTO `lecturers` (`id`, `name`, `nidn`, `phone`, `join_date`, `department_id`) VALUES
(1, 'Dr. Rosa Ariani Sukamto, M.T.', '0015018001', '081234567890', '2015-08-01', 1),
(2, 'Yudi Wibisono, S.T., M.T.', '0020057802', '081234567891', '2012-03-15', 1),
(3, 'Erna Piantari, S.Kom., M.T.', '0008068503', '081234567892', '2017-09-01', 1),
(4, 'Dr. H. Dadang Lukman Hakim, M.T.', '0011027004', '081234567893', '2010-02-20', 2),
(5, 'Eddy Prasetyo Nugroho, M.T.', '0005047905', '081234567894', '2014-06-10', 3);

-- --------------------------------------------------------
-- 3. Struktur Tabel `courses`
-- --------------------------------------------------------
CREATE TABLE `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(20) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `credits` INT NOT NULL,
  `semester` INT NOT NULL,
  `lecturer_id` INT NULL,
  CONSTRAINT `fk_courses_lecturers` FOREIGN KEY (`lecturer_id`) 
    REFERENCES `lecturers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data Dummy Tabel `courses`
-- --------------------------------------------------------
INSERT INTO `courses` (`id`, `code`, `name`, `credits`, `semester`, `lecturer_id`) VALUES
(1, 'IK201', 'Desain Pemrograman Berorientasi Objek', 3, 3, 1),
(2, 'IK202', 'Struktur Data dan Algoritma', 3, 2, 2),
(3, 'IK305', 'Kecerdasan Buatan', 3, 5, 2),
(4, 'IK101', 'Pengantar Rekayasa Perangkat Lunak', 2, 1, 3),
(5, 'TE104', 'Dasar Sistem Digital', 3, 2, 4),
(6, 'SI208', 'Manajemen Basis Data Relasional', 3, 4, 5);
