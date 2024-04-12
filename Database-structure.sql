-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-04-2024 a las 15:27:34
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bts_weather`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id_city` int NOT NULL AUTO_INCREMENT,
  `name_city` varchar(20) NOT NULL,
  `date_created_city` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated_city` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_city`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id_city`, `name_city`, `date_created_city`, `date_updated_city`) VALUES
(1, 'Miami', '2024-04-11 02:28:38', '2024-04-11 02:28:38'),
(2, 'Orlando', '2024-04-11 02:28:38', '2024-04-11 02:28:38'),
(3, 'New York', '2024-04-11 02:28:38', '2024-04-11 02:28:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `records`
--

DROP TABLE IF EXISTS `records`;
CREATE TABLE IF NOT EXISTS `records` (
  `id_record` int NOT NULL AUTO_INCREMENT,
  `id_city_record` int NOT NULL,
  `humidity_record` tinyint NOT NULL,
  `date_created_record` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated_record` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_record`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `records`
--

INSERT INTO `records` (`id_record`, `id_city_record`, `humidity_record`, `date_created_record`, `date_updated_record`) VALUES
(1, 3, 10, '2024-04-11 05:02:33', '2024-04-11 05:02:33'),
(2, 2, 98, '2024-04-11 05:02:33', '2024-04-11 05:02:33'),
(3, 1, 50, '2024-04-11 05:02:33', '2024-04-11 05:02:33'),
(20, 3, 92, '2024-04-12 03:46:23', '2024-04-12 03:46:23'),
(21, 1, 89, '2024-04-12 04:01:28', '2024-04-12 04:01:28'),
(22, 2, 80, '2024-04-12 04:01:28', '2024-04-12 04:01:28'),
(23, 3, 92, '2024-04-12 04:01:28', '2024-04-12 04:01:28'),
(24, 1, 89, '2024-04-12 04:02:33', '2024-04-12 04:02:33'),
(18, 2, 79, '2024-04-12 03:46:23', '2024-04-12 03:46:23'),
(19, 1, 88, '2024-04-12 03:46:23', '2024-04-12 03:46:23'),
(25, 2, 80, '2024-04-12 04:02:33', '2024-04-12 04:02:33'),
(26, 3, 92, '2024-04-12 04:02:33', '2024-04-12 04:02:33'),
(27, 2, 79, '2024-04-12 04:04:17', '2024-04-12 04:04:17'),
(28, 1, 89, '2024-04-12 04:04:17', '2024-04-12 04:04:17'),
(29, 3, 92, '2024-04-12 04:04:17', '2024-04-12 04:04:17'),
(30, 3, 92, '2024-04-12 04:05:34', '2024-04-12 04:05:34'),
(31, 2, 79, '2024-04-12 04:05:34', '2024-04-12 04:05:34'),
(32, 1, 89, '2024-04-12 04:05:34', '2024-04-12 04:05:34'),
(33, 3, 93, '2024-04-12 06:14:27', '2024-04-12 06:14:27'),
(34, 1, 84, '2024-04-12 06:14:27', '2024-04-12 06:14:27'),
(35, 2, 78, '2024-04-12 06:14:28', '2024-04-12 06:14:28'),
(36, 3, 93, '2024-04-12 06:15:30', '2024-04-12 06:15:30'),
(37, 2, 78, '2024-04-12 06:15:30', '2024-04-12 06:15:30'),
(38, 1, 84, '2024-04-12 06:15:30', '2024-04-12 06:15:30'),
(39, 3, 96, '2024-04-12 14:00:33', '2024-04-12 14:00:33'),
(40, 2, 59, '2024-04-12 14:00:33', '2024-04-12 14:00:33'),
(41, 1, 70, '2024-04-12 14:00:33', '2024-04-12 14:00:33'),
(42, 1, 69, '2024-04-12 14:01:44', '2024-04-12 14:01:44'),
(43, 2, 59, '2024-04-12 14:01:44', '2024-04-12 14:01:44'),
(44, 3, 96, '2024-04-12 14:01:44', '2024-04-12 14:01:44'),
(45, 1, 69, '2024-04-12 14:06:34', '2024-04-12 14:06:34'),
(46, 2, 56, '2024-04-12 14:06:34', '2024-04-12 14:06:34'),
(47, 3, 96, '2024-04-12 14:06:34', '2024-04-12 14:06:34'),
(48, 1, 69, '2024-04-12 14:19:45', '2024-04-12 14:19:45'),
(49, 2, 56, '2024-04-12 14:19:45', '2024-04-12 14:19:45'),
(50, 3, 96, '2024-04-12 14:19:45', '2024-04-12 14:19:45'),
(51, 2, 46, '2024-04-12 15:18:48', '2024-04-12 15:18:48'),
(52, 1, 58, '2024-04-12 15:18:48', '2024-04-12 15:18:48'),
(53, 3, 92, '2024-04-12 15:18:48', '2024-04-12 15:18:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
