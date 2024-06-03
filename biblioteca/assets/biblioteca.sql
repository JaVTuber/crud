-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2024 a las 17:46:14
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
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `ISBN` int(8) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `editorial` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `ejemplaresDisponibles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`ISBN`, `titulo`, `autor`, `editorial`, `categoria`, `ejemplaresDisponibles`) VALUES
(1, 'El nombre del viento', 'Patrick Rothfuss', 'Norma', 'Fantasía', 17),
(2, 'Cien años de soledad', 'Gabriel García Márquez', 'Norma', 'Realismo Mágico', 99),
(3, 'Harry Potter y la Piedra Filosofal', 'J.K. Rowling', 'Norma', 'Fantasía', 9),
(4, 'El laberinto de los espíritus', 'Carlos Ruiz Zafón', 'Norma', 'Novela', 15),
(5, 'El código Da Vinci', 'Dan Brown', 'Norma', 'Thriller', 67),
(6, '1984', 'George Orwell', 'Norma', 'Ficción Distópica', 84),
(7, 'Juego de Tronos', 'George R.R. Martin', 'Norma', 'Fantasía Épica', 8),
(8, 'Orgullo y Prejuicio', 'Jane Austen', 'Norma', 'Clásico', 2),
(9, 'Los pilares de La Tierra', 'Ken Follet', 'Norma', 'Novela Histórica', 36),
(10, 'Crimen y Castigo', 'Fiodor Dostoievski', 'Norma', 'Novela Psicológica', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `librosprestados`
--

CREATE TABLE `librosprestados` (
  `ID` int(8) NOT NULL,
  `codigoLibro` int(8) NOT NULL,
  `codigoPrestamo` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `ID` int(8) NOT NULL,
  `fechaPrestamo` date NOT NULL,
  `fechaDevolucion` date NOT NULL,
  `cantidadLibro` int(11) NOT NULL,
  `codigoUsuario` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(8) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `correoElectronico` varchar(255) NOT NULL,
  `DUI` int(9) NOT NULL,
  `telefono` int(8) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `empleado` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `nombre`, `apellido`, `correoElectronico`, `DUI`, `telefono`, `contrasena`, `empleado`, `admin`) VALUES
(1, 'Nombre', 'Apellido', '123456@ejemplo.com', 918273645, 81726354, 'walterwhite', 1, 0),
(2, 'Nombre', 'Apelldio', 'correo@ejemplo.com', 987654321, 87654321, 'password', 0, 0),
(3, 'Juan', 'Juan', 'juan@juan.com', 123456789, 12345678, 'juan', 0, 0),
(4, 'Uno', 'Dos', 'jaaa2670@gmail.com', 193847328, 68460600, 'qwerty', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indices de la tabla `librosprestados`
--
ALTER TABLE `librosprestados`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `codigoPrestamo` (`codigoPrestamo`),
  ADD KEY `codigoLibro` (`codigoLibro`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `codigoUsuario` (`codigoUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `ISBN` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `librosprestados`
--
ALTER TABLE `librosprestados`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `librosprestados`
--
ALTER TABLE `librosprestados`
  ADD CONSTRAINT `codigoLibro` FOREIGN KEY (`codigoLibro`) REFERENCES `libro` (`ISBN`),
  ADD CONSTRAINT `codigoPrestamo` FOREIGN KEY (`codigoPrestamo`) REFERENCES `prestamo` (`ID`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`codigoUsuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
