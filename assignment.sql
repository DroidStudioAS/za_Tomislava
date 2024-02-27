-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 27, 2024 at 05:20 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--
CREATE DATABASE IF NOT EXISTS `assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `assignment`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_username` varchar(355) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_age` int NOT NULL,
  `user_password` varchar(500) NOT NULL,
  `user_is_admin` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_email`, `user_age`, `user_password`, `user_is_admin`) VALUES
(16, 'Leks19', 'johndoe@gmail.com', 33, '$2y$10$hdktiIbNiO3MyLRCg38r4O31GZnOOKgYS/GgnoyzG8k0MVo1yZixa', 0),
(17, 'Leks199', 'aleksandar.smiljanic19@hotmail.com', 22, '$2y$10$2ZvKEcOudHRi5h7cIJz4bOj7PwVqXDY.4cNrzQfn/USv.Yb.w0MCq', 0),
(18, 'Djordje', 'mail@gmail.com', 22, '$2y$10$V9j1NSX6obgPqDGaqoBbTe3cZYCwRMohSDXU0otMpNSS98/G9P2UG', 0),
(19, 'korisnik', 'novmail@gmail.com', 12, '$2y$10$yedFXLK58JRACtO83dTwPOctF1SlrcduWbfIlJZboEXHkE.kS5XTi', 0),
(22, 'new', 'newmail@gmail.com', 12, '$2y$10$66I.KwOdA2aEcOn5Kd3DpOko4hVLJT2kngXRW9wpYSEJq92lxPDJa', 0),
(20, 'mainAdmin', 'admin@mail.com', 22, '$2y$10$4PR0mEB705OYU7Vmf4Be0eErwdfrZwZxDmRM4YcSsKE8a1K4jnw3W', 1),
(21, 'user', '123@mail.com', 12, '$2y$10$mubNECF7k5srSxSyu85t/.fwBiSI5/.d4zI8hHlG8/ZSstD9hDQKO', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
