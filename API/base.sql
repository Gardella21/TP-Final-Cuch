-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql:3306
-- Tiempo de generación: 24-10-2025 a las 13:21:49
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
(8, 'titulo-nuevo', 'descripcion-nueva', '', '2025-09-24', 1, 0),
(11, 'titulo', 'descripcion 1', 'http://localhost:9000/imagenes/ajedrez-20251022-114248.jpg', '2025-09-18', 1, 0),
(13, 'titulo', 'info', 'http://localhost:9000/imagenes/biblioteca-20251022-114055.jpg', '2026-06-25', 1, 0),
(15, 'Evento Ajedrez', 'Lunes Miercoles y Viernes.\n19hs a 21hs.', 'http://localhost:9000/imagenes/ajedrez-20251024-095134.jpg', '2025-12-20', 1, 0),
(16, 'Curos Teatro', 'Martes y Jueves.\nde 14:00hs a 15:30hs', 'http://localhost:9000/imagenes/biblioteca-20251024-100618.jpg', '2025-12-10', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `id_event` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inscriptions`
--

INSERT INTO `inscriptions` (`id`, `name`, `surname`, `email`, `phone`, `id_event`) VALUES
(10, 'Matias', 'Gardella', 'prueba1@gmail.com', 2346330076, 13),
(12, 'Prueba', 'prueb', 'prieba@mail.com', 2345982121, 13),
(13, 'matias', 'gardella', 'matias@hotmail.com', 2346459334, 11),
(14, 'Matias ', 'Gardella', 'matiasgardella5@gmail.com', 2346330076, 15);

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
  `failed_attempts` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `apellido`, `dni`, `email`, `password`, `token`, `token_auth_date`, `role`, `is_active`, `is_blocked`, `failed_attempts`) VALUES
(41, 'Cane', 'Corso', '808080808', 'canecorso@biblioteca.com', '$2y$10$bhqy.FxL6VAtnL/h2LAOd.BWAizKGheZTZ7ZIAAels7J9BMHPHlKO', NULL, '2025-10-19 08:32:17', 'visitor', 0, 0, 0),
(42, 'Dogo', 'Argentino', '404040404', 'dogoargentino@biblioteca.com', '$2y$10$tFSaV2xDOz8j0fehrQb4g.ZvWag7zcLEJfE8xlaZhNYDsVQJn3fme', NULL, '2025-10-19 08:33:18', 'visitor', 0, 0, 0),
(43, 'Mastin', 'Napolitano', '90909090', 'mastin_n@biblioteca.com', '$2y$10$OFDYWpKAHIZvbE6Fd6szaOaYeuviieUAemJPNyVoM6uMwkyHx4dfC', '3429012c07b871c91e74f62c5c9082e5', '2025-10-19 06:41:46', 'admin', 1, 1, 6),
(44, 'Kangal', 'Turco', '121212121', 'kangal@biblioteca.com', '$2y$10$fO2buUDi3SCFvlK61vDG/eMND84OvfHpFN6pOfIuOfAPG/QSqqavK', '32ed1371990e5f915c33ea44ef639995', '2025-10-19 18:08:00', 'super_adm', 1, 0, 0),
(45, 'Malinois', 'Pastor', '474747474', 'pastor@biblioteca.com', '$2y$10$xE8Ww9gk3lOBSH2cDAG1AOxSA7dsLyJlnB31FzkHMG2QgDPTi4g2e', '2a53e9920b28f7131d8c39f4ceeab83e', '2025-10-19 06:41:54', 'super_adm', 1, 0, 4),
(49, 'Klaus', 'Torres', '25252525', 'klaus@biblioteca.com', '$2y$10$tBmwf5B/JwHG9ko68L8pH.ZwJsnRf3HAVMQJ3WuD4mRmtik3NyOo6', '75e03856d6968b5582a350c6f2e3371b', '2025-10-19 18:41:33', 'super_adm', 1, 0, 0),
(50, 'micaela', 'torres', '363773738', 'mica@biblioteca.com', '$2y$10$KqHV2usJV29UFqpZtikeoe4hjrMLKssSpD8r4kItoQ5gBMZ28Wdv2', NULL, '2025-10-19 20:20:45', 'visitor', 0, 0, 0),
(51, 'Administrador', 'Administrador', '353535353', 'admin@biblioteca.com', '$2y$10$qFvXkhQKZRb.Se6ZPnfb9edN6VO2Tfkyerusv2.ggLuh9HYP7UK8a', 'fdc8fc61c4aeb801cc24ef115c42bccc', '2025-10-24 10:24:21', 'super_adm', 1, 0, 0);

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
-- Indices de la tabla `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_event` (`id_event`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `fk_inscriptions_events` FOREIGN KEY (`id_event`) REFERENCES `events` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
