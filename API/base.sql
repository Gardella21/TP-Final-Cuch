-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql:3306
-- Tiempo de generación: 10-10-2025 a las 02:01:13
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hexagonal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `body` longtext NOT NULL,
  `deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domains`
--

CREATE TABLE `domains` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `domains`
--

INSERT INTO `domains` (`id`, `name`, `code`, `deleted`) VALUES
(1, 'Mi primer dominio', 'domain-1', 0),
(2, 'Mi segundo dominio', 'domain-2', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_Active` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `image`, `end_date`, `is_Active`, `deleted`) VALUES
(7, 'Titulo 1', '21hs.\r\nLunes Miercoles y Viernes.\r\n', '', '2025-09-24', 1, 1),
(8, 'titulo-nuevo', 'descripcion-nueva', '', '2025-09-24', 1, 0),
(9, 'tiutlo 3', '21hs', '', '2025-09-20', 1, 1),
(10, 'titulo 4', 'lunes', '', '2025-09-22', 1, 0),
(11, 'titulo', 'descripcion 1', '', '2025-09-18', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_auth_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `token`, `token_auth_date`, `role`, `is_active`) VALUES
(3, 'usuario de prueba', 'test@mail.com', '', NULL, NULL, 'super_adm', 1),
(4, 'Molo', 'MoloKlaus27@gmail.com', '$2y$10$I5s8MPteQb/uEgyD.CHpBOTwEvXruHKRMK4rK3T/Gl9k3RiMVrIl.', 'f5552a5e4adbff895dae8e507ae01de8', '2025-10-08 20:48:50', 'super_adm', 1),
(10, 'natalia', 'natalia@bibloteca.com', '$2y$10$FYtYa9NnwpBIAOKYset2I.DuMFu9lGbdw2AGw9Wj83.LBTvgFjYVS', '317b469ce0eb233c8dcda5e0d784b362', '2025-10-02 08:48:23', 'visitor', 1),
(11, 'Sebastian', 'sebastian@mail.com', '$2y$10$CWi4.UftmUPC0UbuiDlUWOKaZPTI6Ls//GD5uzRtMQ83hueBY396m', 'df7f7116a1a9abb87a5e79ef1ba8394f', '2025-10-07 21:01:19', 'super_adm', 1),
(14, 'matias', 'matias@mail.com', '$2y$10$iJbd3ysqPjgWBKbULy8ey..oyfLhm8.3QB7UourowfOREqupbjaU.', 'e6eb86312cd56f14f7a2f66fc522eae8', '2025-10-08 19:44:32', 'admin', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
