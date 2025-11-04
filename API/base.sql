-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql:3306
-- Tiempo de generación: 04-11-2025 a las 04:50:38
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.3.26

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

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `title`, `image`, `date`, `body`, `deleted`) VALUES
(17, 'TITULO 2', 'http://localhost:9000/imagenes/133861804548973604-20251019-173614.jpg', '2025-10-19 17:36:31', 'TEXTO', 1),
(18, 'NOTICIA 20', 'http://localhost:9000/imagenes/klaus-20251019-191933.jpg', '2025-10-19 19:19:45', 'TEXTO', 1),
(19, 'noticia 2', 'http://localhost:9000/imagenes/klaus-20251019-211151.jpg', '2025-10-19 21:12:16', 'texto', 1),
(20, 'hola 25', 'http://localhost:9000/imagenes/133861804548973604-20251021-173657.jpg', '2025-10-21 17:37:04', 'hola', 1),
(21, 'noticia 2', 'http://localhost:9000/imagenes/Fondo-SobreNosotros-20251028-191828.png', '2025-10-28 19:18:34', 's', 1),
(22, 'noticia 1 23', 'http://localhost:9000/imagenes/klaus-20251029-190606.jpg', '2025-10-29 19:06:32', 'texto hola', 1),
(23, 'noticia sol', 'http://localhost:9000/imagenes/klaus-20251029-205201.jpg', '2025-10-29 20:52:15', 'texto', 1),
(24, 'proxbhihuihi ', 'http://localhost:9000/imagenes/klaus-20251103-093717.jpg', '2025-11-03 09:37:38', 'texto', 1),
(25, 'noticia 45', 'http://localhost:9000/imagenes/klaus-20251103-145852.jpg', '2025-11-03 14:59:20', 'texto', 1),
(26, 'dbfjkfk999999', 'http://localhost:9000/imagenes/klaus-20251103-161944.jpg', '2025-11-03 16:19:53', 'efouqwefjqweio', 1),
(27, 'rwertsol', 'http://localhost:9000/imagenes/klaus-20251103-171442.jpg', '2025-11-03 17:14:52', 'rtert', 1),
(28, 'noticia sol', 'http://localhost:9000/imagenes/133861804548973604-20251103-172959.jpg', '2025-11-03 17:30:16', 'texto', 1),
(29, 'r', 'http://localhost:9000/imagenes/133861804548973604-20251103-174023.jpg', '2025-11-03 17:40:31', 't', 1),
(30, 'rt', 'http://localhost:9000/imagenes/klaus-20251103-182356.jpg', '2025-11-03 18:24:04', 'ert', 1),
(31, 'noticia', 'http://localhost:9000/imagenes/klaus-20251104-001822.jpg', '2025-11-04 00:18:48', 'texto', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `materia` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `editorial` varchar(255) NOT NULL,
  `edicion` varchar(255) NOT NULL,
  `anio` int(11) NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL,
  `reservada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`id`, `codigo`, `materia`, `titulo`, `autor`, `editorial`, `edicion`, `anio`, `disponibilidad`, `reservada`) VALUES
(23, 'LIT-001', 'Literatura', 'Cien años de soledad', 'Gabriel García Márquez', 'Sudamericana', '1a ed.', 1967, 1, 0),
(24, 'INF-002', 'Infantil', 'El principito', 'Antoine de Saint-Exupéry', 'Salamandra', 'Reimpresión', 1943, 0, 0),
(25, 'ENS-003', 'Ensayo', 'El Aleph', 'Jorge Luis Borges', 'Emecé', '3a ed.', 1949, 1, 0),
(26, 'HIS-004', 'Historia', 'Historia Argentina', 'Felipe Pigna', 'Planeta', '1a ed.', 2004, 1, 0),
(27, 'INF-005', 'Informática', 'Introducción a la Programación', 'Luis Joyanes', 'McGraw-Hill', '2a ed.', 2020, 1, 0),
(28, 'CIE-006', 'Ciencia', 'Breves respuestas a las grandes preguntas', 'Stephen Hawking', 'Crítica', '1a ed.', 2018, 1, 0),
(29, 'HIS-007', 'Historia', 'Constitución de la Nación Argentina (1853) – Facsímil', 'Varios', 'Edición facsimilar', 'Ed. especial', 1853, 1, 1),
(30, 'LIT-008', 'Literatura', 'Rayuela', 'Julio Cortázar', 'Sudamericana', '1a ed.', 1963, 0, 0);

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
(8, 'titulo-nuevo', 'descripcion-nueva', '', '2025-09-24', 1, 1),
(9, 'tiutlo 3', '21hs', '', '2025-09-20', 1, 1),
(10, 'titulo 4', 'lunes', '', '2025-09-22', 1, 1),
(11, 'titulo SOL', 'descripcion 1', '', '2025-09-18', 1, 1),
(12, 'Nuevos eventos 1', 'cartas para jubilados', 'http://localhost:9000/imagenes/133861804548973604-20251021-170323.jpg', '2026-12-26', 1, 1),
(13, 'evento 2', 'texto', 'http://localhost:9000/imagenes/133861804548973604-20251028-191657.jpg', '2005-11-11', 1, 1),
(14, 'evento proximo', 'texto', 'http://localhost:9000/imagenes/133861804548973604-20251029-191011.jpg', '2007-12-30', 1, 1),
(15, 'evento 2', 'texto', 'http://localhost:9000/imagenes/klaus-20251103-093450.jpg', '2026-12-29', 1, 1),
(16, 'dfdfg', 'etgaer', 'http://localhost:9000/imagenes/Fondo-SobreNosotros-20251103-094847.png', '2027-02-02', 1, 1),
(17, 'evento de cartas', 'texto', 'http://localhost:9000/imagenes/klaus-20251103-145436.jpg', '2027-12-24', 1, 0),
(18, 'gfbyh', 'gh', 'http://localhost:9000/imagenes/klaus-20251104-002134.jpg', '2026-12-23', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_auth_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(1) DEFAULT '0',
  `failed_attempts` int(11) DEFAULT '0',
  `failed_ip` varchar(64) DEFAULT NULL,
  `soft_block_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `apellido`, `dni`, `email`, `password`, `token`, `token_auth_date`, `role`, `is_active`, `is_blocked`, `failed_attempts`, `failed_ip`, `soft_block_until`) VALUES
(41, 'Cane', 'Corso', '808080808', 'canecorso@biblioteca.com', '$2y$10$bhqy.FxL6VAtnL/h2LAOd.BWAizKGheZTZ7ZIAAels7J9BMHPHlKO', 'eb359c48829128ea194df678c25a99b0', '2025-10-28 21:31:10', 'admin', 1, 0, 0, NULL, NULL),
(42, 'Dogo', 'Argentino', '404040404', 'dogoargentino@biblioteca.com', '$2y$10$tFSaV2xDOz8j0fehrQb4g.ZvWag7zcLEJfE8xlaZhNYDsVQJn3fme', '006ad1c4b8332e4b07cae964fa1cac35', '2025-11-03 11:05:04', 'admin', 1, 1, 0, NULL, NULL),
(44, 'Kangal', 'Turco', '121212121', 'kangal@biblioteca.com', '$2y$10$fO2buUDi3SCFvlK61vDG/eMND84OvfHpFN6pOfIuOfAPG/QSqqavK', '51e2ba0b3229604d677edce1381edd8b', '2025-11-03 17:40:45', 'admin', 1, 0, 0, NULL, NULL),
(51, 'Administrador', 'Administrador', '353535353', 'admin@biblioteca.com', '$2y$10$qFvXkhQKZRb.Se6ZPnfb9edN6VO2Tfkyerusv2.ggLuh9HYP7UK8a', '604feba9de08f20517d8000817b64c91', '2025-11-04 02:47:30', 'super_adm', 1, 0, 0, NULL, NULL),
(54, 'Maria', 'Maria', '84848484', 'maria@biblioteca.com', '$2y$10$2V.oDwU0470XtGGimvmwguSIgZNxun28qLtbD7j7PZA9DAN0Qplx.', NULL, '2025-11-03 19:29:52', 'visitor', 0, 0, 0, NULL, NULL),
(55, 'Presa', 'Canario', '656565565', 'presacanario@biblioteca.com', '$2y$10$76WPaSYLhvLFSlzi99o9sOn9dOP49NtwcI7e2g/mQOX/KPqeqQHXS', '8b2e878910d91e8e65ec8e46174e47c7', '2025-11-03 19:24:37', 'admin', 1, 0, 1, '172.18.0.1', NULL),
(56, 'Pastor', 'Belga', '12345678', 'pastor@biblioteca.com', '$2y$10$PzxFqQejr8rt30WXwXwlfelBmA5WxZDJB8wV2VYIT2f9mJpEXOrjq', NULL, '2025-11-04 03:13:57', 'visitor', 0, 0, 0, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD KEY `idx_users_soft_block_until` (`soft_block_until`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
