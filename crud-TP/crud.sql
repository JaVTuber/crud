-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2024 a las 06:04:52
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
-- Base de datos: `crud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_productos`
--

CREATE TABLE `categoria_productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria_productos`
--

INSERT INTO `categoria_productos` (`id`, `nombre`) VALUES
(1, 'Electrónica'),
(2, 'Hogar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `categoria_id`) VALUES
(1, 'Smartphone Samsung Galaxy S21', 'Teléfono inteligente con pantalla de 6.2 pulgadas, 8 GB de RAM y 128 GB de almacenamiento interno', 999.99, 1),
(2, 'Laptop HP Pavilion 15', 'Laptop con pantalla de 15.6 pulgadas, procesador Intel Core i5, 8 GB de RAM y 512 GB de almacenamiento SSD', 899.99, 1),
(3, 'Smartwatch Apple Watch Series 6', 'Reloj inteligente con pantalla Retina siempre activa, GPS integrado y sensor de oxígeno en sangre', 399.99, 1),
(4, 'Cámara Canon EOS Rebel T7', 'Cámara réflex digital con sensor CMOS de 24.1 megapíxeles y grabación de video Full HD', 599.99, 1),
(5, 'Auriculares inalámbricos Sony WH-1000XM4', 'Auriculares con cancelación de ruido, batería de larga duración y calidad de sonido de alta resolución', 349.99, 1),
(6, 'Sofá de tres plazas', 'Sofá de tela con estructura de madera maciza y cojines de espuma de alta densidad', 799.99, 2),
(7, 'Mesa de comedor extensible', 'Mesa de comedor de madera maciza con capacidad para 6 personas, extensible a 8 personas', 599.99, 2),
(8, 'Juego de sábanas de algodón', 'Juego de sábanas de algodón egipcio de 400 hilos, incluye sábana bajera, sábana encimera y fundas de almohada', 149.99, 2),
(9, 'Aspiradora sin bolsa', 'Aspiradora sin bolsa con tecnología ciclónica y filtro HEPA, ideal para alérgicos', 199.99, 2),
(10, 'Set de ollas y sartenes antiadherentes', 'Set de 10 piezas de ollas y sartenes antiadherentes con tapas de vidrio templado', 299.99, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nom` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nom`, `correo`, `pass`) VALUES
('Rodrigo Cruz', 'rc533190@gmail.com', '123456');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria_productos`
--
ALTER TABLE `categoria_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria_productos`
--
ALTER TABLE `categoria_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
