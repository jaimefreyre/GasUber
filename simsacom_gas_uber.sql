-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-07-2018 a las 04:33:01
-- Versión del servidor: 5.6.39
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `simsacom_gas_uber`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int(50) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(75) NOT NULL,
  `EDAD` int(10) NOT NULL,
  `DNI` bigint(50) NOT NULL,
  `FOTO` varchar(50) NOT NULL,
  `TELEFONO` bigint(50) NOT NULL,
  `DIRECCION` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='CLIENTES GASUBER' ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID`, `NOMBRE`, `EMAIL`, `PASSWORD`, `EDAD`, `DNI`, `FOTO`, `TELEFONO`, `DIRECCION`) VALUES
(2, 'jorge', 'jaime2@gmail.com', '$2y$10$FOO9cwHFSY9u0H0TXqhghOxC070iMy2mhZZ5kio3GAbgcn628YKim', 0, 34890707, '', 2202494088, 0),
(3, 'Danilo Cacoango', 'edi.danilo@hotmail.com', '$2y$10$.GAEM//Op9/XbEqZH62FoeW7COJfM78fBeY0PFSYo/agvnWQPzLIe', 0, 1726902362, '', 994417005, 0),
(13, '', '', '$2y$10$fK.gX7boIBCHe4IdWgs2OuD8broX.DbDWWHHWlDns.lWfYuHtAOsO', 0, 0, '', 0, 0),
(14, 'EzequielMiceli', 'jiju@gmail.com', '$2y$10$jtvPkQWS.dZDxxqe1H1NtO89D04mGdVG5839xZer2NL9VkpGslc1W', 0, 3455897, '', 44558789, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `ID` int(100) NOT NULL,
  `CLIENTE` int(11) NOT NULL,
  `LATITUD` decimal(9,6) NOT NULL,
  `LONGITUD` decimal(9,6) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `PLACEID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='DIRECCIONES';

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`ID`, `CLIENTE`, `LATITUD`, `LONGITUD`, `NOMBRE`, `PLACEID`) VALUES
(1, 2, '-34.851405', '-58.659301', 'Juan Manzanares 7150, B1764BTJ Virrey del Pino, Buenos Aires, Argentina', 'ChIJIwTa0ojcvJURIj4MDZWWyuM'),
(2, 2, '-34.851968', '-58.660675', 'Guardia Vieja 5599, B1764CRE Virrey del Pino, Buenos Aires, Argentina', 'EkVHdWFyZGlhIFZpZWphIDU1OTksIEIxNzY0Q1JFIFZpcnJleSBkZWwgUGlubywgQnVlbm9zIEFpcmVzLCBBcmdlbnRpbmEiGxIZ'),
(3, 2, '-34.851405', '-58.658100', 'Colastine 7100, B1764BSJ Virrey del Pino, Buenos Aires, Argentina', 'EkFDb2xhc3RpbmUgNzEwMCwgQjE3NjRCU0ogVmlycmV5IGRlbCBQaW5vLCBCdWVub3MgQWlyZXMsIEFyZ2VudGluYSIbEhkKFAoS'),
(4, 2, '-34.855988', '-58.673415', 'Mariano Fragueiro 5080, B1764DDR Virrey del Pino, Buenos Aires, Argentina', 'ChIJZS4YDvTcvJURiYfzm82d3WE'),
(5, 2, '-34.771990', '-58.629813', 'Carola Lorenzini 5202, B1759HWU González Catán, Buenos Aires, Argentina', 'EklDYXJvbGEgTG9yZW56aW5pIDUyMDIsIEIxNzU5SFdVIEdvbnrDoWxleiBDYXTDoW4sIEJ1ZW5vcyBBaXJlcywgQXJnZW50aW5h'),
(6, 3, '-0.117037', '-78.460458', 'Máximo Gómez, Quito 170133, Ecuador', 'ChIJBeb9UZqP1ZERMKefL73s7sQ'),
(7, 13, '-0.157074', '-78.476034', 'Mayas 160, Quito 170138, Ecuador', 'ChIJY_Y2g6ea1ZERxYR94nFS4zM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribuidores`
--

CREATE TABLE `distribuidores` (
  `ID` int(100) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `EDAD` int(10) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `TELEFONO` bigint(30) DEFAULT NULL,
  `DNI` bigint(30) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `PATENTE` varchar(50) DEFAULT NULL,
  `FOTO-PATENTE` varchar(30) DEFAULT NULL,
  `FOTO` varchar(100) DEFAULT NULL,
  `REPUTACION` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='DISTIBUIDORES' ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `distribuidores`
--

INSERT INTO `distribuidores` (`ID`, `NOMBRE`, `EDAD`, `EMAIL`, `TELEFONO`, `DNI`, `PASSWORD`, `PATENTE`, `FOTO-PATENTE`, `FOTO`, `REPUTACION`) VALUES
(2, 'Jorge', NULL, 'jaime3@gmail.com', 2202494088, 345587, '$2y$10$132vaolCB1xNyq.qsfV9fOTuLZLDtxLF8MIuEqdc29QngUhk.rz/u', NULL, NULL, NULL, NULL),
(3, 'Juan Pedro', NULL, 'juanp@hotmail.com', 994417005, 1726902362, '$2y$10$2jpVY5J3TEILwPE1NsA7WeJycqhAKNwN7RUW7ichNmi6ROyjyPOHG', '453658', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `IDOFERTA` int(11) NOT NULL,
  `ESTADO` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`IDOFERTA`, `ESTADO`) VALUES
(1, 2),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 2),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps`
--

CREATE TABLE `gps` (
  `ID` int(11) NOT NULL,
  `LAT` decimal(9,6) NOT NULL,
  `LNG` decimal(9,6) NOT NULL,
  `DISTRIBUIDORES` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `gps`
--

INSERT INTO `gps` (`ID`, `LAT`, `LNG`, `DISTRIBUIDORES`) VALUES
(1, '-34.855988', '-58.673415', 2),
(2, '-34.855988', '-58.673415', 2),
(3, '-34.855988', '-58.673415', 2),
(4, '-34.855988', '-58.673415', 2),
(5, '-0.117080', '-78.460599', 3),
(6, '-0.117080', '-78.460599', 3),
(7, '-0.117080', '-78.460599', 3),
(8, '-0.117080', '-78.460599', 3),
(9, '-0.117080', '-78.460599', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `ID` int(100) NOT NULL,
  `CLIENTE` int(100) NOT NULL,
  `DISTRIBUIDOR` int(100) NOT NULL,
  `PRECIO` int(11) NOT NULL,
  `DIRECCION` int(10) NOT NULL,
  `FECHA` date NOT NULL,
  `HORA` time NOT NULL,
  `DEMORA` tinyint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='OFERTAS-ONLINE-MAPAS-SEGUIMIENTO';

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`ID`, `CLIENTE`, `DISTRIBUIDOR`, `PRECIO`, `DIRECCION`, `FECHA`, `HORA`, `DEMORA`) VALUES
(1, 2, 2, 20, 1, '2018-07-23', '838:59:59', 0),
(2, 2, 0, 65, 2, '2018-07-23', '838:59:59', 0),
(3, 2, 2, 65, 3, '2018-07-23', '838:59:59', 0),
(4, 2, 2, 65, 4, '2018-07-23', '838:59:59', 0),
(5, 2, 2, 65, 5, '2018-07-23', '838:59:59', 0),
(6, 3, 3, 20, 6, '2018-07-23', '838:59:59', 0),
(7, 3, 0, 20, 0, '2018-07-23', '838:59:59', 0),
(8, 13, 0, 0, 7, '2018-07-26', '838:59:59', 0),
(9, 13, 0, 0, 0, '2018-07-26', '838:59:59', 0),
(10, 13, 0, 0, 0, '2018-07-26', '838:59:59', 0),
(11, 13, 0, 20, 0, '2018-07-26', '838:59:59', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID` int(11) NOT NULL,
  `P1` tinyint(11) NOT NULL,
  `P2` tinyint(11) NOT NULL,
  `OFERTA` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID`, `P1`, `P2`, `OFERTA`) VALUES
(1, 1, 0, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 1, 5),
(6, 1, 0, 6),
(7, 1, 0, 7),
(8, 0, 0, 8),
(9, 0, 0, 9),
(10, 0, 0, 10),
(11, 1, 0, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID` int(10) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `PRECIO` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='PRODUCTOS';

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `NOMBRE`, `PRECIO`) VALUES
(1, 'GARRAFA 10KG', 45),
(2, 'GARRAFA 25KG', 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `ID` int(10) NOT NULL,
  `IDOFERTA` int(11) NOT NULL,
  `VOTOC` int(11) NOT NULL,
  `VOTOD` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `MSJ` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='TABLA DE VOTOS';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PLACEID` (`PLACEID`);

--
-- Indices de la tabla `distribuidores`
--
ALTER TABLE `distribuidores`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD UNIQUE KEY `PATENTE` (`PATENTE`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`IDOFERTA`),
  ADD KEY `ESTADO` (`ESTADO`);

--
-- Indices de la tabla `gps`
--
ALTER TABLE `gps`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DISTRIBUIDORES` (`DISTRIBUIDORES`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `CLIENTE` (`CLIENTE`),
  ADD KEY `DISTRIBUIDOR` (`DISTRIBUIDOR`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `distribuidores`
--
ALTER TABLE `distribuidores`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gps`
--
ALTER TABLE `gps`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
