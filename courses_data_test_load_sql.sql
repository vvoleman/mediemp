-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 09. led 2022, 21:13
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `skola_dbs_mediemp`
--

--
-- Vyprázdnit tabulku před vkládáním `course_appointment`
--

TRUNCATE TABLE `course_appointment`;
--
-- Vypisuji data pro tabulku `course_appointment`
--

INSERT INTO `course_appointment` (`id`, `employer_course_id`, `date`, `place`, `capacity`) VALUES
(1, 1, '1100-01-01 00:00:00', 'Liberec', 15),
(2, 1, '2021-01-10 15:00:00', 'Praha', 100),
(3, 1, '2022-01-01 00:00:00', 'Brno', 20),
(4, 2, '1015-01-01 00:00:00', 'Praha', 10),
(5, 4, '1200-10-01 15:00:00', 'Praha', 20),
(6, 7, '2021-01-11 15:00:00', 'Liberec', 20),
(7, 9, '1000-01-01 00:00:00', '', 100),
(8, 10, '1000-01-01 00:00:00', 'po', 10),
(9, 11, '2021-01-01 00:00:00', 'Praha', 10),
(10, 12, '2021-02-01 20:20:00', 'Praha', 10),
(11, 13, '2021-02-01 13:00:00', 'Liberec', 30);

--
-- Vyprázdnit tabulku před vkládáním `course_registration`
--

TRUNCATE TABLE `course_registration`;
--
-- Vypisuji data pro tabulku `course_registration`
--

INSERT INTO `course_registration` (`id`, `course_appointment_id`, `employee_id`, `absence`, `test_done`, `notification_status`) VALUES
(1, 1, 1, 0, 0, 'pending'),
(2, 1, 2, 0, 0, 'pending'),
(3, 1, 3, 0, 0, 'pending'),
(4, 1, 4, 0, 0, 'pending'),
(6, 7, 1, 0, 1, 'pending'),
(7, 7, 22, 1, 0, 'pending'),
(8, 7, 2, 0, 0, 'pending'),
(9, 7, 6, 0, 1, 'pending'),
(10, 7, 10, 0, 1, 'pending'),
(11, 7, 10, 0, 1, 'pending');

--
-- Vyprázdnit tabulku před vkládáním `employer_course`
--

TRUNCATE TABLE `employer_course`;
--
-- Vypisuji data pro tabulku `employer_course`
--

INSERT INTO `employer_course` (`id`, `employer_id`, `course_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 3, 2),
(8, 1, 2),
(9, 4, 3),
(10, 1, 3),
(11, 5, 3),
(12, 6, 3),
(13, 1, 3);

--
-- Vyprázdnit tabulku před vkládáním `global_course`
--

TRUNCATE TABLE `global_course`;
--
-- Vypisuji data pro tabulku `global_course`
--

INSERT INTO `global_course` (`id`, `name`, `focus`, `specialization`, `keywords`) VALUES
(1, 'Test course 0', 'Test focus 0', 'Test specialization 0', 'keyword1, keyword0'),
(2, 'Test course 1', 'Test focus 1', 'Test specialization 1', 'keyword1, keyword1'),
(3, 'Test course 2', 'Test focus 2', 'Test specialization 2', 'keyword1, keyword2'),
(4, 'Test course 3', 'Test focus 3', 'Test specialization 3', 'keyword1, keyword3'),
(5, 'Test course 4', 'Test focus 4', 'Test specialization 4', 'keyword1, keyword4'),
(6, 'Test course 5', 'Test focus 5', 'Test specialization 5', 'keyword1, keyword5'),
(7, 'Test course 6', 'Test focus 6', 'Test specialization 6', 'keyword1, keyword6'),
(8, 'Test course 7', 'Test focus 7', 'Test specialization 7', 'keyword1, keyword7'),
(9, 'Test course 8', 'Test focus 8', 'Test specialization 8', 'keyword1, keyword8'),
(10, 'Test course 9', 'Test focus 9', 'Test specialization 9', 'keyword1, keyword9'),
(11, 'Test course 10', 'Test focus 10', 'Test specialization 10', 'keyword1, keyword10'),
(12, 'Test course 11', 'Test focus 11', 'Test specialization 11', 'keyword1, keyword11'),
(13, 'Test course 12', 'Test focus 12', 'Test specialization 12', 'keyword1, keyword12'),
(14, 'Test course 13', 'Test focus 13', 'Test specialization 13', 'keyword1, keyword13'),
(15, 'Test course 14', 'Test focus 14', 'Test specialization 14', 'keyword1, keyword14'),
(16, 'Test course 15', 'Test focus 15', 'Test specialization 15', 'keyword1, keyword15'),
(17, 'Test course 16', 'Test focus 16', 'Test specialization 16', 'keyword1, keyword16'),
(18, 'Test course 17', 'Test focus 17', 'Test specialization 17', 'keyword1, keyword17'),
(19, 'Test course 18', 'Test focus 18', 'Test specialization 18', 'keyword1, keyword18'),
(20, 'Test course 19', 'Test focus 19', 'Test specialization 19', 'keyword1, keyword19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
