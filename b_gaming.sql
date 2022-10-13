-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-08-2022 a las 18:38:09
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `b_gaming`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `genero` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `genero`) VALUES
(1, 'Shooter'),
(2, 'Open World'),
(3, 'Racing'),
(4, 'Deportes'),
(5, 'Estratégia'),
(6, 'Simulación'),
(7, 'VR'),
(8, 'Arcade'),
(9, 'Aventura'),
(10, 'Combate'),
(11, 'Acción/Aventura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL,
  `id_genero` int(11) DEFAULT NULL,
  `id_plataforma` int(11) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `opinion` text DEFAULT NULL,
  `creado` timestamp NULL DEFAULT current_timestamp(),
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `id_usuario`, `titulo`, `portada`, `id_genero`, `id_plataforma`, `calificacion`, `opinion`, `creado`, `actualizado`) VALUES
(1, 1, 'The Last of Us', '60180024_61265319.jpg', 11, 2, 5, 'El mejor juego de la historia', '2022-08-22 06:23:20', '2022-08-24 20:10:53'),
(3, 2, 'Black Ops 5', '33961997_86338650.jpg', 1, 5, 2, 'El juego más famoso de genero shooter', '2022-08-24 08:27:41', '2022-08-25 18:52:09'),
(4, 1, 'Bioshok', '80662527_52839339.jpg', 11, 4, 4, 'Es un juego de acción bastante divertido, la historia es muy recomendable y todo el tiempo esta de suspenso. Lo recomiendo bastante!', '2022-08-25 06:51:21', '2022-08-25 18:51:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas`
--

CREATE TABLE `plataformas` (
  `id` int(11) NOT NULL,
  `plataforma` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `plataformas`
--

INSERT INTO `plataformas` (`id`, `plataforma`) VALUES
(1, 'PS4'),
(2, 'PS5'),
(3, 'PS Vita'),
(4, 'PC'),
(5, 'Xbox One'),
(6, 'Xbox Series S'),
(7, 'Xbox Series x'),
(8, 'Nintendo Switch');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `navbar_color` varchar(255) DEFAULT NULL,
  `creado` timestamp NULL DEFAULT current_timestamp(),
  `actualizado` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `pass`, `navbar_color`, `creado`, `actualizado`) VALUES
(1, 'Isaac Ruiz', 'isaac@localhost.com', '$2y$10$X2IgVIflZipDHgqolJMZKOz0Q8284O5kHQPiSPbQecMLuBNH//U.6', NULL, '2022-08-09 05:52:29', '2022-08-09 17:52:29'),
(2, 'Andrea Ruiz', 'andrea@localhost.com', '123456', NULL, '2022-08-25 17:17:03', '2022-08-25 17:17:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
