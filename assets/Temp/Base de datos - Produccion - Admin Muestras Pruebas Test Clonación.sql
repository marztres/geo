-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2013 a las 00:36:37
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `geotecnia`
--
CREATE DATABASE IF NOT EXISTS `geotecnia` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `geotecnia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compresion`
--

CREATE TABLE IF NOT EXISTS `compresion` (
  `id_compresion` int(11) NOT NULL AUTO_INCREMENT,
  `diametro` float(9,2) DEFAULT NULL,
  `altura` float(9,2) DEFAULT NULL,
  `peso` float(9,2) DEFAULT NULL,
  `tipoFalla` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `fK_idmuestra` int(12) NOT NULL,
  PRIMARY KEY (`id_compresion`),
  KEY `fK_idmuestra` (`fK_idmuestra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `compresion`
--

INSERT INTO `compresion` (`id_compresion`, `diametro`, `altura`, `peso`, `tipoFalla`, `fecha_ingreso`, `estado`, `fK_idmuestra`) VALUES
(1, 11.25, 5.50, 496.80, 'Abomamiento', '2013-09-24 16:43:07', 1, 1),
(2, 0.00, 0.00, 0.00, '', '2013-09-24 17:41:44', 1, 2),
(3, 5.50, 11.00, 505.60, '', '2013-09-25 09:38:22', 1, 3),
(4, 0.00, 0.00, 0.00, '', '2013-09-25 09:40:02', 1, 4),
(5, 0.00, 0.00, 0.00, '', '2013-09-25 09:40:34', 1, 5),
(6, 1.00, 1.00, 0.00, '', '2013-09-25 09:49:07', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deformaciones`
--

CREATE TABLE IF NOT EXISTS `deformaciones` (
  `id_deformacion` int(11) NOT NULL AUTO_INCREMENT,
  `deformacion` int(11) NOT NULL,
  `carga` float(9,2) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fk_idcompresion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_deformacion`),
  KEY `fk_idcompresion` (`fk_idcompresion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=109 ;

--
-- Volcado de datos para la tabla `deformaciones`
--

INSERT INTO `deformaciones` (`id_deformacion`, `deformacion`, `carga`, `estado`, `fk_idcompresion`) VALUES
(1, 10, 8.00, 0, 1),
(2, 30, 26.00, 0, 1),
(3, 50, 48.00, 0, 1),
(4, 75, 72.00, 0, 1),
(5, 100, 99.00, 0, 1),
(6, 150, 150.00, 0, 1),
(7, 200, 206.00, 0, 1),
(8, 250, 236.00, 0, 1),
(9, 300, 0.00, 0, 1),
(10, 350, 0.00, 0, 1),
(11, 400, 0.00, 0, 1),
(12, 450, 0.00, 0, 1),
(13, 500, 0.00, 0, 1),
(14, 550, 0.00, 0, 1),
(15, 600, 0.00, 0, 1),
(16, 650, 0.00, 0, 1),
(17, 700, 0.00, 0, 1),
(18, 750, 0.00, 0, 1),
(19, 10, 0.00, 0, 2),
(20, 30, 0.00, 0, 2),
(21, 50, 0.00, 0, 2),
(22, 75, 0.00, 0, 2),
(23, 100, 0.00, 0, 2),
(24, 150, 0.00, 0, 2),
(25, 200, 0.00, 0, 2),
(26, 250, 0.00, 0, 2),
(27, 300, 0.00, 0, 2),
(28, 350, 0.00, 0, 2),
(29, 400, 0.00, 0, 2),
(30, 450, 0.00, 0, 2),
(31, 500, 0.00, 0, 2),
(32, 550, 0.00, 0, 2),
(33, 600, 0.00, 0, 2),
(34, 650, 0.00, 0, 2),
(35, 700, 0.00, 0, 2),
(36, 750, 0.00, 0, 2),
(37, 10, 0.00, 0, 3),
(38, 30, 0.00, 0, 3),
(39, 50, 0.00, 0, 3),
(40, 75, 0.00, 0, 3),
(41, 100, 0.00, 0, 3),
(42, 150, 0.00, 0, 3),
(43, 200, 0.00, 0, 3),
(44, 250, 0.00, 0, 3),
(45, 300, 0.00, 0, 3),
(46, 350, 0.00, 0, 3),
(47, 400, 0.00, 0, 3),
(48, 450, 0.00, 0, 3),
(49, 500, 0.00, 0, 3),
(50, 550, 0.00, 0, 3),
(51, 600, 0.00, 0, 3),
(52, 650, 0.00, 0, 3),
(53, 700, 0.00, 0, 3),
(54, 750, 0.00, 0, 3),
(55, 10, 0.00, 0, 4),
(56, 30, 0.00, 0, 4),
(57, 50, 0.00, 0, 4),
(58, 75, 0.00, 0, 4),
(59, 100, 0.00, 0, 4),
(60, 150, 0.00, 0, 4),
(61, 200, 0.00, 0, 4),
(62, 250, 0.00, 0, 4),
(63, 300, 0.00, 0, 4),
(64, 350, 0.00, 0, 4),
(65, 400, 0.00, 0, 4),
(66, 450, 0.00, 0, 4),
(67, 500, 0.00, 0, 4),
(68, 550, 0.00, 0, 4),
(69, 600, 0.00, 0, 4),
(70, 650, 0.00, 0, 4),
(71, 700, 0.00, 0, 4),
(72, 750, 0.00, 0, 4),
(73, 10, 0.00, 0, 5),
(74, 30, 0.00, 0, 5),
(75, 50, 0.00, 0, 5),
(76, 75, 0.00, 0, 5),
(77, 100, 0.00, 0, 5),
(78, 150, 0.00, 0, 5),
(79, 200, 0.00, 0, 5),
(80, 250, 0.00, 0, 5),
(81, 300, 0.00, 0, 5),
(82, 350, 0.00, 0, 5),
(83, 400, 0.00, 0, 5),
(84, 450, 0.00, 0, 5),
(85, 500, 0.00, 0, 5),
(86, 550, 0.00, 0, 5),
(87, 600, 0.00, 0, 5),
(88, 650, 0.00, 0, 5),
(89, 700, 0.00, 0, 5),
(90, 750, 0.00, 0, 5),
(91, 10, 0.00, 0, 6),
(92, 30, 0.00, 0, 6),
(93, 50, 0.00, 0, 6),
(94, 75, 0.00, 0, 6),
(95, 100, 0.00, 0, 6),
(96, 150, 0.00, 0, 6),
(97, 200, 0.00, 0, 6),
(98, 250, 0.00, 0, 6),
(99, 300, 0.00, 0, 6),
(100, 350, 0.00, 0, 6),
(101, 400, 0.00, 0, 6),
(102, 450, 0.00, 0, 6),
(103, 500, 0.00, 0, 6),
(104, 550, 0.00, 0, 6),
(105, 600, 0.00, 0, 6),
(106, 650, 0.00, 0, 6),
(107, 700, 0.00, 0, 6),
(108, 750, 0.00, 0, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firmas`
--

CREATE TABLE IF NOT EXISTS `firmas` (
  `idFirma` int(11) NOT NULL AUTO_INCREMENT,
  `persona` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tarjetaProfesional` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `imagenFirma` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(2) NOT NULL,
  PRIMARY KEY (`idFirma`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `firmas`
--

INSERT INTO `firmas` (`idFirma`, `persona`, `tarjetaProfesional`, `imagenFirma`, `estado`) VALUES
(1, 'Ing. Geotecnista PABLO CASTILLA NEGRETE		', 'M.P. 1320251172BLV		', 'assets/uploads/1378707048.jpg', 1),
(2, 'Ing. Civil NATHALIA HERNANDEZ R			', 'M.P. 22202166765COR			', 'assets/uploads/1378707028.jpg', 1),
(3, 'Prueba', '12426525', 'assets/uploads/1379444772.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `granulometria`
--

CREATE TABLE IF NOT EXISTS `granulometria` (
  `id_granulometria` int(11) NOT NULL AUTO_INCREMENT,
  `pesoRecipiente` float(9,2) DEFAULT NULL,
  `pesoRecipienteMasMuestra` float(9,2) DEFAULT NULL,
  `d60` float(9,2) DEFAULT NULL,
  `d30` float(9,2) DEFAULT NULL,
  `d10` float(9,2) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fechaIngreso` datetime NOT NULL,
  `fk_idmuestra` int(11) NOT NULL,
  PRIMARY KEY (`id_granulometria`),
  KEY `fk_idmuestra` (`fk_idmuestra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `granulometria`
--

INSERT INTO `granulometria` (`id_granulometria`, `pesoRecipiente`, `pesoRecipienteMasMuestra`, `d60`, `d30`, `d10`, `estado`, `fechaIngreso`, `fk_idmuestra`) VALUES
(1, 28.20, 28.20, 0.00, 0.00, 0.00, 1, '2013-09-24 16:43:08', 1),
(2, 0.00, 0.00, NULL, NULL, NULL, 1, '2013-09-24 17:41:45', 2),
(3, 0.00, 0.00, NULL, NULL, NULL, 1, '2013-09-25 09:38:23', 3),
(4, 0.00, 0.00, NULL, NULL, NULL, 1, '2013-09-25 09:40:02', 4),
(5, 0.00, 0.00, NULL, NULL, NULL, 1, '2013-09-25 09:40:34', 5),
(6, 2.00, 0.00, NULL, NULL, NULL, 1, '2013-09-25 09:49:08', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `muestras`
--

CREATE TABLE IF NOT EXISTS `muestras` (
  `id_muestra` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Id de las muestras\r\n',
  `profundidad_inicial` float NOT NULL COMMENT 'Profundidad inicial de la muestra',
  `profundidad_final` float NOT NULL COMMENT 'Profundidad final de la muestra',
  `descripcion` varchar(200) NOT NULL COMMENT 'Descripcion de la muestra\r\n',
  `material_de_relleno` int(11) DEFAULT '0' COMMENT '0 sino es material de relleno  \r\n1 si es material de relleno\r\n2 si es estrato de roca',
  `numero_golpes` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL,
  `fk_idsondeo` int(11) NOT NULL COMMENT 'Llave foranea sondeo\r\n',
  PRIMARY KEY (`id_muestra`),
  KEY `fk_idsondeo` (`fk_idsondeo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de muestras ' AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `muestras`
--

INSERT INTO `muestras` (`id_muestra`, `profundidad_inicial`, `profundidad_final`, `descripcion`, `material_de_relleno`, `numero_golpes`, `estado`, `fk_idsondeo`) VALUES
(1, 0.45, 1, 'Pardo vetas rojas', 1, '12', 1, 1),
(2, 1.5, 2.5, 'Pardo vetas rojas', 1, '50', 1, 1),
(3, 0.5, 1, 'PARDO ROJIZO Y VETAS GRISES', 1, '0', 1, 3),
(4, 1.5, 2, 'PARDO Y VETAS GRISES', 0, '0', 1, 3),
(5, 3.5, 4, 'PARDO Y VETAS GRISES', 0, '0', 0, 3),
(6, 3.5, 4, 'PARDO Y VETAS GRISES', 0, '0', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pesosretenidos`
--

CREATE TABLE IF NOT EXISTS `pesosretenidos` (
  `idPesoRetenido` int(11) NOT NULL AUTO_INCREMENT,
  `tamiz` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tamanoTamiz` float(9,2) NOT NULL,
  `pesoRetenido` float(9,2) DEFAULT NULL,
  `fk_id_granulometria` int(11) NOT NULL,
  PRIMARY KEY (`idPesoRetenido`),
  KEY `fk_id_granulometria` (`fk_id_granulometria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=109 ;

--
-- Volcado de datos para la tabla `pesosretenidos`
--

INSERT INTO `pesosretenidos` (`idPesoRetenido`, `tamiz`, `tamanoTamiz`, `pesoRetenido`, `fk_id_granulometria`) VALUES
(1, '(3")', 76.20, 0.00, 1),
(2, '(2 1/2")', 63.50, 0.00, 1),
(3, '(2")', 50.80, 0.00, 1),
(4, '(1 1/2")', 38.10, 0.00, 1),
(5, '(1")', 25.40, 0.00, 1),
(6, '(3/4")', 19.05, 37.70, 1),
(7, '(1/2")', 12.70, 45.60, 1),
(8, '(3/8")', 9.52, 37.40, 1),
(9, '(1/4")', 6.35, 0.00, 1),
(10, 'NÂ°4', 4.75, 49.80, 1),
(11, 'NÂ°10', 2.00, 5.00, 1),
(12, 'NÂ°16', 1.19, 38.10, 1),
(13, 'NÂ°20', 0.84, 0.00, 1),
(14, 'NÂ°30', 0.60, 40.20, 1),
(15, 'NÂ°40', 0.43, 35.30, 1),
(16, 'NÂ°60', 0.25, 0.00, 1),
(17, 'NÂ°100', 0.15, 43.90, 1),
(18, 'NÂ°200', 0.08, 34.40, 1),
(19, '(3")', 76.20, 0.00, 2),
(20, '(2 1/2")', 63.50, 0.00, 2),
(21, '(2")', 50.80, 0.00, 2),
(22, '(1 1/2")', 38.10, 0.00, 2),
(23, '(1")', 25.40, 0.00, 2),
(24, '(3/4")', 19.05, 0.00, 2),
(25, '(1/2")', 12.70, 0.00, 2),
(26, '(3/8")', 9.52, 0.00, 2),
(27, '(1/4")', 6.35, 0.00, 2),
(28, 'NÂ°4', 4.75, 0.00, 2),
(29, 'NÂ°10', 2.00, 0.00, 2),
(30, 'NÂ°16', 1.19, 0.00, 2),
(31, 'NÂ°20', 0.84, 0.00, 2),
(32, 'NÂ°30', 0.60, 0.00, 2),
(33, 'NÂ°40', 0.43, 0.00, 2),
(34, 'NÂ°60', 0.25, 0.00, 2),
(35, 'NÂ°100', 0.15, 0.00, 2),
(36, 'NÂ°200', 0.08, 0.00, 2),
(37, '(3")', 76.20, 0.00, 3),
(38, '(2 1/2")', 63.50, 0.00, 3),
(39, '(2")', 50.80, 0.00, 3),
(40, '(1 1/2")', 38.10, 0.00, 3),
(41, '(1")', 25.40, 0.00, 3),
(42, '(3/4")', 19.05, 0.00, 3),
(43, '(1/2")', 12.70, 0.00, 3),
(44, '(3/8")', 9.52, 0.00, 3),
(45, '(1/4")', 6.35, 0.00, 3),
(46, 'NÂ°4', 4.75, 0.00, 3),
(47, 'NÂ°10', 2.00, 0.00, 3),
(48, 'NÂ°16', 1.19, 0.00, 3),
(49, 'NÂ°20', 0.84, 0.00, 3),
(50, 'NÂ°30', 0.60, 0.00, 3),
(51, 'NÂ°40', 0.43, 0.00, 3),
(52, 'NÂ°60', 0.25, 0.00, 3),
(53, 'NÂ°100', 0.15, 0.00, 3),
(54, 'NÂ°200', 0.08, 0.00, 3),
(55, '(3")', 76.20, 0.00, 4),
(56, '(2 1/2")', 63.50, 0.00, 4),
(57, '(2")', 50.80, 0.00, 4),
(58, '(1 1/2")', 38.10, 0.00, 4),
(59, '(1")', 25.40, 0.00, 4),
(60, '(3/4")', 19.05, 0.00, 4),
(61, '(1/2")', 12.70, 0.00, 4),
(62, '(3/8")', 9.52, 0.00, 4),
(63, '(1/4")', 6.35, 0.00, 4),
(64, 'NÂ°4', 4.75, 0.00, 4),
(65, 'NÂ°10', 2.00, 0.00, 4),
(66, 'NÂ°16', 1.19, 0.00, 4),
(67, 'NÂ°20', 0.84, 0.00, 4),
(68, 'NÂ°30', 0.60, 0.00, 4),
(69, 'NÂ°40', 0.43, 0.00, 4),
(70, 'NÂ°60', 0.25, 0.00, 4),
(71, 'NÂ°100', 0.15, 0.00, 4),
(72, 'NÂ°200', 0.08, 0.00, 4),
(73, '(3")', 76.20, 0.00, 5),
(74, '(2 1/2")', 63.50, 0.00, 5),
(75, '(2")', 50.80, 0.00, 5),
(76, '(1 1/2")', 38.10, 0.00, 5),
(77, '(1")', 25.40, 0.00, 5),
(78, '(3/4")', 19.05, 0.00, 5),
(79, '(1/2")', 12.70, 0.00, 5),
(80, '(3/8")', 9.52, 0.00, 5),
(81, '(1/4")', 6.35, 0.00, 5),
(82, 'NÂ°4', 4.75, 0.00, 5),
(83, 'NÂ°10', 2.00, 0.00, 5),
(84, 'NÂ°16', 1.19, 0.00, 5),
(85, 'NÂ°20', 0.84, 0.00, 5),
(86, 'NÂ°30', 0.60, 0.00, 5),
(87, 'NÂ°40', 0.43, 0.00, 5),
(88, 'NÂ°60', 0.25, 0.00, 5),
(89, 'NÂ°100', 0.15, 0.00, 5),
(90, 'NÂ°200', 0.08, 0.00, 5),
(91, '(3")', 76.20, 0.00, 6),
(92, '(2 1/2")', 63.50, 0.00, 6),
(93, '(2")', 50.80, 0.00, 6),
(94, '(1 1/2")', 38.10, 0.00, 6),
(95, '(1")', 25.40, 0.00, 6),
(96, '(3/4")', 19.05, 0.00, 6),
(97, '(1/2")', 12.70, 0.00, 6),
(98, '(3/8")', 9.52, 0.00, 6),
(99, '(1/4")', 6.35, 0.00, 6),
(100, 'NÂ°4', 4.75, 0.00, 6),
(101, 'NÂ°10', 2.00, 0.00, 6),
(102, 'NÂ°16', 1.19, 0.00, 6),
(103, 'NÂ°20', 0.84, 0.00, 6),
(104, 'NÂ°30', 0.60, 0.00, 6),
(105, 'NÂ°40', 0.43, 0.00, 6),
(106, 'NÂ°60', 0.25, 0.00, 6),
(107, 'NÂ°100', 0.15, 0.00, 6),
(108, 'NÂ°200', 0.08, 0.00, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Id del proyecto\r\n',
  `codigo_proyecto` int(30) NOT NULL COMMENT 'Codigo unico de proyecto',
  `nombre_proyecto` varchar(200) DEFAULT NULL COMMENT 'Nombre del proyecto',
  `lugar` varchar(200) DEFAULT NULL COMMENT 'Lugar donde se realiza el proyecto\r\n',
  `contratista` varchar(100) DEFAULT NULL COMMENT 'Nombre del contratista\r\n',
  `fecha` date NOT NULL COMMENT 'Fecha del proyecto\r\n',
  `fk_id_autor` int(11) NOT NULL,
  `fk_id_responsable` int(19) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_proyecto`),
  UNIQUE KEY `codigo_proyecto` (`codigo_proyecto`),
  KEY `fk_id_autor` (`fk_id_autor`),
  KEY `fk_id_responsable` (`fk_id_responsable`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `codigo_proyecto`, `nombre_proyecto`, `lugar`, `contratista`, `fecha`, `fk_id_autor`, `fk_id_responsable`, `estado`) VALUES
(1, 123456, 'Monteverde ', 'MonterÃ¬a', 'Geotecnia', '2013-09-24', 18, 18, 0),
(2, 1234, 'PLACAS DEPORTIVAS', 'BRR PANZENU', '', '2013-09-14', 18, 18, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados`
--

CREATE TABLE IF NOT EXISTS `resultados` (
  `id_resultados` int(11) NOT NULL AUTO_INCREMENT,
  `humedad` float(9,2) DEFAULT NULL,
  `limiteLiquido` float(9,2) DEFAULT NULL,
  `limitePlastico` float(9,2) DEFAULT NULL,
  `indicePlasticidad` float(9,2) DEFAULT NULL,
  `cohesion` float(9,2) DEFAULT NULL,
  `pesoUnitario` float(9,2) DEFAULT NULL,
  `N200` float(9,2) DEFAULT NULL,
  `N4` float(9,2) DEFAULT NULL,
  `N10` float(9,2) DEFAULT NULL,
  `N40` float(9,2) DEFAULT NULL,
  `notacionSucs` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcionSucs` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `aashto` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagenPerfil` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Imagen de el patro del suelo\r\n',
  `fechaIngreso` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `fk_idMuestra` int(11) NOT NULL,
  PRIMARY KEY (`id_resultados`),
  KEY `fk_idMuestra` (`fk_idMuestra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `resultados`
--

INSERT INTO `resultados` (`id_resultados`, `humedad`, `limiteLiquido`, `limitePlastico`, `indicePlasticidad`, `cohesion`, `pesoUnitario`, `N200`, `N4`, `N10`, `N40`, `notacionSucs`, `descripcionSucs`, `aashto`, `imagenPerfil`, `fechaIngreso`, `estado`, `fk_idMuestra`) VALUES
(1, 13.00, 31.00, 23.00, 8.00, 10.50, 9.09, 0.00, 0.00, 0.00, 0.00, 'GP', 'Grava mal graduada con arena', 'A-2-4', 'arenoso', '2013-09-24 16:43:08', 1, 1),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'blanco', '2013-09-24 17:41:45', 1, 2),
(3, 13.00, 31.00, 23.00, 8.00, 0.00, 19.35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'blanco', '2013-09-25 09:38:23', 1, 3),
(4, 29.00, 55.00, 32.00, 23.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'blanco', '2013-09-25 09:40:03', 1, 4),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'blanco', '2013-09-25 09:40:35', 1, 5),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'blanco', '2013-09-25 09:49:08', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sondeos`
--

CREATE TABLE IF NOT EXISTS `sondeos` (
  `id_sondeo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de sondeo\r\n',
  `nivel_freatico` float DEFAULT NULL COMMENT 'Nivel freatico del suelo',
  `profundidad_superficie` float NOT NULL,
  `estado` int(11) NOT NULL,
  `fk_id_tipo_superficie` int(11) NOT NULL,
  `fk_idproyecto` int(11) NOT NULL COMMENT 'llave foranea del id del proyecto\r\n',
  PRIMARY KEY (`id_sondeo`),
  KEY `fk_idproyecto` (`fk_idproyecto`),
  KEY `fk_id_tipo_superficie` (`fk_id_tipo_superficie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de sondeos ' AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `sondeos`
--

INSERT INTO `sondeos` (`id_sondeo`, `nivel_freatico`, `profundidad_superficie`, `estado`, `fk_id_tipo_superficie`, `fk_idproyecto`) VALUES
(1, 5, 50, 1, 4, 1),
(2, 15, 15, 0, 3, 1),
(3, 160, 0, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testlimites`
--

CREATE TABLE IF NOT EXISTS `testlimites` (
  `id_test` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id de limite liquido',
  `tipo_muestra` int(11) NOT NULL,
  `nom_capsula` varchar(20) DEFAULT NULL COMMENT 'Nombre de capsula ej: CV34',
  `peso_capsula` varchar(20) DEFAULT NULL COMMENT 'peso de la capsula',
  `peso_capsula_suelo_humedo` varchar(20) DEFAULT NULL COMMENT 'Peso de capsula + suelo humedo',
  `peso_capsula_suelo_seco` varchar(20) DEFAULT NULL COMMENT 'Peso capsula + suelo seco',
  `num_golpes` varchar(20) DEFAULT NULL COMMENT 'Numero de golpes',
  `fecha_ingreso` datetime NOT NULL COMMENT 'Fecha de ingreso',
  `estado` int(11) NOT NULL,
  `fk_id_muestra` int(11) NOT NULL COMMENT 'Llave foranea id muestra',
  PRIMARY KEY (`id_test`),
  KEY `fk_id_muestra` (`fk_id_muestra`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de limites liquidos ' AUTO_INCREMENT=55 ;

--
-- Volcado de datos para la tabla `testlimites`
--

INSERT INTO `testlimites` (`id_test`, `tipo_muestra`, `nom_capsula`, `peso_capsula`, `peso_capsula_suelo_humedo`, `peso_capsula_suelo_seco`, `num_golpes`, `fecha_ingreso`, `estado`, `fk_id_muestra`) VALUES
(1, 0, 'v192', '4.2', '16.7', '15.3', '0', '2013-09-24 16:43:07', 1, 1),
(2, 0, 'D12', '3.6', '24.7', '22.4', '0', '2013-09-24 16:43:07', 1, 1),
(3, 0, 'c310', '4.2', '16.5', '15.1', '0', '2013-09-24 16:43:07', 1, 1),
(4, 1, '26', '12.79', '24.48', '21.83', '34', '2013-09-24 16:43:07', 1, 1),
(5, 1, '87', '12.90', '25.83', '22.75', '23', '2013-09-24 16:43:07', 1, 1),
(6, 1, 'H9', '19.45', '31.11', '28.22', '16', '2013-09-24 16:43:07', 1, 1),
(7, 2, '38', '12.86', '16.56', '15.86', '0', '2013-09-24 16:43:07', 1, 1),
(8, 2, 'A23', '12.79', '15.90', '15.33', '0', '2013-09-24 16:43:07', 1, 1),
(9, 2, 'L15', '12.82', '17.39', '16.53', '0', '2013-09-24 16:43:07', 1, 1),
(10, 0, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(11, 0, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(12, 0, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(13, 1, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(14, 1, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(15, 1, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(16, 2, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(17, 2, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(18, 2, '', '', '', '', '', '2013-09-24 17:41:44', 1, 2),
(19, 0, 'V192', '4.2', '16.7', '15.3', '0', '2013-09-25 09:38:22', 1, 3),
(20, 0, 'D12', '3.6', '24.7', '22.4', '0', '2013-09-25 09:38:22', 1, 3),
(21, 0, 'C310', '4.2', '16.5', '15.1', '0', '2013-09-25 09:38:22', 1, 3),
(22, 1, '26', '12.79', '24.48', '21.83', '34', '2013-09-25 09:38:22', 1, 3),
(23, 1, '87', '12.90', '25.83', '22.75', '23', '2013-09-25 09:38:22', 1, 3),
(24, 1, 'H9', '19.45', '31.11', '28.22', '16', '2013-09-25 09:38:22', 1, 3),
(25, 2, '38', '12.86', '16.56', '15.86', '0', '2013-09-25 09:38:22', 1, 3),
(26, 2, 'A23', '12.79', '15.90', '15.33', '0', '2013-09-25 09:38:22', 1, 3),
(27, 2, 'L5', '12.82', '17.39', '16.53', '0', '2013-09-25 09:38:22', 1, 3),
(28, 0, 'C411', '3.5', '20.6', '16.8', '0', '2013-09-25 09:40:02', 1, 4),
(29, 0, 'C1', '4.2', '18.1', '14.9', '0', '2013-09-25 09:40:02', 1, 4),
(30, 0, 'V13', '3.6', '20.7', '16.9', '0', '2013-09-25 09:40:02', 1, 4),
(31, 1, '85', '12.63', '22.83', '19.29', '34', '2013-09-25 09:40:02', 1, 4),
(32, 1, '56', '12.86', '24.10', '20.08', '24', '2013-09-25 09:40:02', 1, 4),
(33, 1, '76', '12.85', '23.39', '19.58', '17', '2013-09-25 09:40:02', 1, 4),
(34, 2, 'N3', '19.59', '22.70', '21.94', '0', '2013-09-25 09:40:02', 1, 4),
(35, 2, 'A2115', '12.79', '18.25', '16.95', '0', '2013-09-25 09:40:02', 1, 4),
(36, 2, '21', '12.85', '19.48', '17.90', '0', '2013-09-25 09:40:02', 1, 4),
(37, 0, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(38, 0, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(39, 0, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(40, 1, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(41, 1, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(42, 1, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(43, 2, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(44, 2, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(45, 2, '', '', '', '', '', '2013-09-25 09:40:34', 1, 5),
(46, 0, 'C411', '3.5', '21.6', '16.8', '9', '2013-09-25 09:49:07', 1, 6),
(47, 0, 'C1', '5.2', '18.1', '15.9', '6', '2013-09-25 09:49:07', 1, 6),
(48, 0, 'V13', '4.6', '21.7', '16.9', '10', '2013-09-25 09:49:07', 1, 6),
(49, 1, '85', '12.63', '23.83', '20.29', '37', '2013-09-25 09:49:07', 1, 6),
(50, 1, '56', '12.86', '24.1', '21.08', '28', '2013-09-25 09:49:07', 1, 6),
(51, 1, '76', '13.85', '23.39', '20.58', '24', '2013-09-25 09:49:07', 1, 6),
(52, 2, 'N3', '20.59', '23.7', '21.94', '10', '2013-09-25 09:49:07', 1, 6),
(53, 2, 'A2115', '12.79', '18.25', '16.95', '6', '2013-09-25 09:49:07', 1, 6),
(54, 2, '21', '13.85', '19.48', '18.9', '3', '2013-09-25 09:49:07', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_superficie`
--

CREATE TABLE IF NOT EXISTS `tipo_superficie` (
  `id_tipo_superficie` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id tipo de superficie\r\n',
  `tipo_superficie` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo_superficie`),
  UNIQUE KEY `tipo_superficie` (`tipo_superficie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipo_superficie`
--

INSERT INTO `tipo_superficie` (`id_tipo_superficie`, `tipo_superficie`) VALUES
(3, 'Capa de alfasto'),
(2, 'Capa vegetal'),
(4, 'Loza de concreto'),
(1, 'Ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Id del usuario',
  `cedula` int(30) NOT NULL COMMENT 'Cedula de los usuarios del sistema\r\n',
  `nombres` varchar(100) NOT NULL COMMENT 'Nombres del usuario',
  `apellidos` varchar(100) NOT NULL COMMENT 'Apellidos usuario',
  `tipo` varchar(100) NOT NULL COMMENT 'Tipo de usuario: Laboratorista , Ingeniero , Administrador.',
  `nombre_usuario` varchar(100) NOT NULL COMMENT 'Nombre de usuario',
  `password` varchar(50) NOT NULL COMMENT 'Contraseña',
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cedula` (`cedula`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=4096 AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `tipo`, `nombre_usuario`, `password`, `estado`) VALUES
(0, 3212312, 'Super', 'Usuario', 'Administrador', 'root', '10697224', 1),
(1, 1234567891, 'No', 'Asignado', 'Ingeniero', 'N/A___', '_____________', 1),
(17, 123456789, 'Administrador', 'Geotecnia', 'Administrador', 'admin', '123456789', 1),
(18, 1067905175, 'Luis David', 'Rivero Perez', 'Ingeniero', 'LuisDavid', 'luix12149', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compresion`
--
ALTER TABLE `compresion`
  ADD CONSTRAINT `compresion_ibfk_1` FOREIGN KEY (`fK_idmuestra`) REFERENCES `muestras` (`id_muestra`);

--
-- Filtros para la tabla `deformaciones`
--
ALTER TABLE `deformaciones`
  ADD CONSTRAINT `deformaciones_ibfk_1` FOREIGN KEY (`fk_idcompresion`) REFERENCES `compresion` (`id_compresion`);

--
-- Filtros para la tabla `granulometria`
--
ALTER TABLE `granulometria`
  ADD CONSTRAINT `[muestra]_fk[granulometria]` FOREIGN KEY (`fk_idmuestra`) REFERENCES `muestras` (`id_muestra`);

--
-- Filtros para la tabla `muestras`
--
ALTER TABLE `muestras`
  ADD CONSTRAINT `[fk_id_sondeo]_fk[id_sondeo]` FOREIGN KEY (`fk_idsondeo`) REFERENCES `sondeos` (`id_sondeo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pesosretenidos`
--
ALTER TABLE `pesosretenidos`
  ADD CONSTRAINT `[granulometria]_fk[pesos]` FOREIGN KEY (`fk_id_granulometria`) REFERENCES `granulometria` (`id_granulometria`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `autor` FOREIGN KEY (`fk_id_autor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `responsables` FOREIGN KEY (`fk_id_responsable`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `[resultados]_fk[muestaras]` FOREIGN KEY (`fk_idMuestra`) REFERENCES `muestras` (`id_muestra`);

--
-- Filtros para la tabla `sondeos`
--
ALTER TABLE `sondeos`
  ADD CONSTRAINT `sondeos_ibfk_1` FOREIGN KEY (`fk_idproyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `[OwnerName]_fk[num_for_dup]` FOREIGN KEY (`fk_id_tipo_superficie`) REFERENCES `tipo_superficie` (`id_tipo_superficie`);

--
-- Filtros para la tabla `testlimites`
--
ALTER TABLE `testlimites`
  ADD CONSTRAINT `[fk_id_muestras]_fk[id_muestras]` FOREIGN KEY (`fk_id_muestra`) REFERENCES `muestras` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
