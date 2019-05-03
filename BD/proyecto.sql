-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2019 a las 01:08:10
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`, `estatus`) VALUES
(1, 'Cuento', 1),
(2, 'Novela', 1),
(3, 'Diario', 1),
(4, 'Crónica', 1),
(5, 'Noticia', 1),
(6, 'Afectivo', 1),
(7, 'Confianza', 1),
(8, 'Experiencia Personal', 1),
(9, 'Causa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idPublicacion` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuerpo` text NOT NULL,
  `media` varchar(500) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacionreferencia`
--

CREATE TABLE `publicacionreferencia` (
  `idPublicacion` int(1) NOT NULL,
  `idReferencia` int(1) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencia`
--

CREATE TABLE `referencia` (
  `idReferencia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `referencia`
--

INSERT INTO `referencia` (`idReferencia`, `nombre`, `estatus`) VALUES
(1, 'Personal', 1),
(2, 'Internet', 1),
(3, 'Libro', 1),
(4, 'Otros', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '1',
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idPublicacion`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `publicacionreferencia`
--
ALTER TABLE `publicacionreferencia`
  ADD PRIMARY KEY (`idReferencia`),
  ADD KEY `idPublicacion` (`idPublicacion`);

--
-- Indices de la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD PRIMARY KEY (`idReferencia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `referencia`
--
ALTER TABLE `referencia`
  MODIFY `idReferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publicacion_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicacionreferencia`
--
ALTER TABLE `publicacionreferencia`
  ADD CONSTRAINT `publicacionreferencia_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publicacionreferencia_ibfk_2` FOREIGN KEY (`idReferencia`) REFERENCES `referencia` (`idReferencia`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
