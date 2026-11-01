-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2026 a las 17:19:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_juegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(3, 'Acción'),
(1, 'Aventura'),
(4, 'Casual'),
(2, 'Deportes'),
(5, 'Estrategia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `categoria_id` int(10) UNSIGNED NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `destacado`, `categoria_id`, `creado_en`) VALUES
(1, 'Bongo Cat', 'Bongo cat necesita tu ayuda. ¡Bongo cat necesita más gorros! Cada vez que pulses una tecla, Bongo cat dará un puñetazo a tu barra de tareas.', 2500.00, 50, '/parcial2-programacion-web-2/assets/bongo_cat.jpg', 1, 4, '2026-10-25 19:53:17'),
(2, 'Lego Batman', 'Renace como el Caballero Oscuro y vive la historia de Batman en una atrevida aventura de mundo abierto en Gotham City.', 45000.00, 20, '/parcial2-programacion-web-2/assets/lego_batman.jpg', 1, 1, '2026-10-25 19:53:17'),
(3, 'EA Sports FC 27', 'Te damos la bienvenida a The World\'s Game. Adéntrate en The Grounds y siente un mayor control en cada modo.', 60000.00, 30, '/parcial2-programacion-web-2/assets/ea_sports.jpg', 1, 2, '2026-10-25 19:53:17'),
(4, 'Hollow Knight', '¡Forja tu propio camino en Hollow Knight! Una aventura épica a través de un vasto reino de insectos y héroes que se encuentra en ruinas. Explora cavernas tortuosas, combate contra criaturas corrompidas y entabla amistad con extraños insectos, todo en un estilo clásico en 2D dibujado a mano.', 7500.00, 40, '/parcial2-programacion-web-2/assets/hollow_knight.jpg', 0, 1, '2026-11-01 13:30:00'),
(5, 'Hades', 'Desafía al dios de los muertos y protagoniza una salvaje fuga del Inframundo en este juego de exploración de mazmorras de los creadores de Bastion, Transistor y Pyre.', 15000.00, 35, '/parcial2-programacion-web-2/assets/hades.jpg', 0, 3, '2026-11-01 13:30:00'),
(6, 'Age of Empires II: Definitive Edition', 'Incluye «Los últimos khanes», que incorpora 3 campañas y 4 civilizaciones nuevas. Las frecuentes actualizaciones contienen eventos, contenido adicional, nuevos modos de juego y funciones mejoradas.', 18000.00, 25, '/parcial2-programacion-web-2/assets/age_of_empires_2.jpg', 0, 5, '2026-11-01 13:30:00'),
(7, 'Stardew Valley', 'Acabas de heredar la vieja parcela agrícola de tu abuelo de Stardew Valley. Decides partir hacia una nueva vida con unas herramientas usadas y algunas monedas. ¿Te ves capaz de vivir de la tierra y convertir estos campos descuidados en un hogar próspero?', 7500.00, 60, '/parcial2-programacion-web-2/assets/stardew_valley.jpg', 0, 4, '2026-11-01 13:30:00'),
(8, 'Rocket League', '¡El fútbol se une a los coches una vez más en la esperada continuación basada en la física del querido juego clásico en arenas Supersonic Acrobatic Rocket-Powered Battle-Cars!', 9000.00, 45, '/parcial2-programacion-web-2/assets/rocket_league.jpg', 0, 2, '2026-11-01 13:30:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_categorias_nombre` (`nombre`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_juegos_nombre` (`nombre`),
  ADD KEY `idx_juegos_categoria` (`categoria_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `fk_juegos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
