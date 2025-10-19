-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql:3306
-- Tiempo de generación: 19-10-2025 a las 23:01:14
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
(51, 'Administrador', 'Administrador', '353535353', 'admin@biblioteca.com', '$2y$10$qFvXkhQKZRb.Se6ZPnfb9edN6VO2Tfkyerusv2.ggLuh9HYP7UK8a', '28804311953681a61f86845598002987', '2025-10-19 20:35:33', 'super_adm', 1, 0, 0);

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
