-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-09-2013 a las 03:09:54
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `geotecnia`
--
CREATE DATABASE IF NOT EXISTS `geotecnia` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `compresion`
--

INSERT INTO `compresion` (`id_compresion`, `diametro`, `altura`, `peso`, `tipoFalla`, `fecha_ingreso`, `estado`, `fK_idmuestra`) VALUES
(26, 5.50, 12.10, 540.60, 'Abombamiento', '2013-09-09 01:34:40', 1, 40),
(27, 5.50, 10.40, 438.60, 'ABOMBAMIENTO', '2013-09-09 01:50:06', 1, 41),
(28, 5.50, 11.90, 474.60, 'ABOMBAMIENTO', '2013-09-09 02:01:53', 1, 42);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=55 ;

--
-- Volcado de datos para la tabla `deformaciones`
--

INSERT INTO `deformaciones` (`id_deformacion`, `deformacion`, `carga`, `estado`, `fk_idcompresion`) VALUES
(1, 10, 20.00, 0, 26),
(2, 30, 76.00, 0, 26),
(3, 50, 133.00, 0, 26),
(4, 75, 180.00, 0, 26),
(5, 100, 220.00, 0, 26),
(6, 150, 313.00, 0, 26),
(7, 200, 399.00, 0, 26),
(8, 250, 476.00, 0, 26),
(9, 300, 530.00, 0, 26),
(10, 350, 0.00, 0, 26),
(11, 400, 0.00, 0, 26),
(12, 450, 0.00, 0, 26),
(13, 500, 0.00, 0, 26),
(14, 550, 0.00, 0, 26),
(15, 600, 0.00, 0, 26),
(16, 650, 0.00, 0, 26),
(17, 700, 0.00, 0, 26),
(18, 750, 0.00, 0, 26),
(19, 10, 13.00, 0, 27),
(20, 30, 32.00, 0, 27),
(21, 50, 48.00, 0, 27),
(22, 75, 69.00, 0, 27),
(23, 100, 87.00, 0, 27),
(24, 150, 126.00, 0, 27),
(25, 200, 160.00, 0, 27),
(26, 250, 188.00, 0, 27),
(27, 300, 215.00, 0, 27),
(28, 350, 0.00, 0, 27),
(29, 400, 0.00, 0, 27),
(30, 450, 0.00, 0, 27),
(31, 500, 0.00, 0, 27),
(32, 550, 0.00, 0, 27),
(33, 600, 0.00, 0, 27),
(34, 650, 0.00, 0, 27),
(35, 700, 0.00, 0, 27),
(36, 750, 0.00, 0, 27),
(37, 10, 20.00, 0, 28),
(38, 30, 70.00, 0, 28),
(39, 50, 146.00, 0, 28),
(40, 75, 229.00, 0, 28),
(41, 100, 268.00, 0, 28),
(42, 150, 302.00, 0, 28),
(43, 200, 328.00, 0, 28),
(44, 250, 0.00, 0, 28),
(45, 300, 0.00, 0, 28),
(46, 350, 0.00, 0, 28),
(47, 400, 0.00, 0, 28),
(48, 450, 0.00, 0, 28),
(49, 500, 0.00, 0, 28),
(50, 550, 0.00, 0, 28),
(51, 600, 0.00, 0, 28),
(52, 650, 0.00, 0, 28),
(53, 700, 0.00, 0, 28),
(54, 750, 0.00, 0, 28);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `firmas`
--

INSERT INTO `firmas` (`idFirma`, `persona`, `tarjetaProfesional`, `imagenFirma`, `estado`) VALUES
(1, 'Ing. Geotecnista PABLO CASTILLA NEGRETE		', 'M.P. 1320251172BLV		', 'assets/uploads/1378707048.jpg', 1),
(2, 'Ing. Civil NATHALIA HERNANDEZ R			', 'M.P. 22202166765COR			', 'assets/uploads/1378707028.jpg', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `granulometria`
--

INSERT INTO `granulometria` (`id_granulometria`, `pesoRecipiente`, `pesoRecipienteMasMuestra`, `d60`, `d30`, `d10`, `estado`, `fechaIngreso`, `fk_idmuestra`) VALUES
(26, 15.90, 155.40, 0.00, 0.00, 0.00, 1, '2013-09-09 01:34:40', 40),
(27, 28.30, 313.76, 0.00, 0.00, 0.00, 1, '2013-09-09 01:50:06', 41),
(28, 31.50, 339.52, 0.00, 0.00, 0.00, 1, '2013-09-09 02:01:53', 42);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de muestras ' AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `muestras`
--

INSERT INTO `muestras` (`id_muestra`, `profundidad_inicial`, `profundidad_final`, `descripcion`, `material_de_relleno`, `numero_golpes`, `estado`, `fk_idsondeo`) VALUES
(40, 0.5, 1, 'Pardo Vetas Rojas ', 0, '10', 1, 13),
(41, 2.5, 3, 'Pardo Vetas Grises ', 0, '8', 1, 13),
(42, 3.5, 4, 'Pardo oscuro y gris', 0, '9', 1, 13);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=55 ;

--
-- Volcado de datos para la tabla `pesosretenidos`
--

INSERT INTO `pesosretenidos` (`idPesoRetenido`, `tamiz`, `tamanoTamiz`, `pesoRetenido`, `fk_id_granulometria`) VALUES
(1, '(3")', 76.20, 0.00, 26),
(2, '(2 1/2")', 63.50, 0.00, 26),
(3, '(2")', 50.80, 0.00, 26),
(4, '(1 1/2")', 38.10, 0.00, 26),
(5, '(1")', 25.40, 0.00, 26),
(6, '(3/4")', 19.05, 0.00, 26),
(7, '(1/2")', 12.70, 0.00, 26),
(8, '(3/8")', 9.52, 0.00, 26),
(9, '(1/4")', 6.35, 0.00, 26),
(10, 'NÂ°4', 4.75, 0.00, 26),
(11, 'NÂ°10', 2.00, 0.00, 26),
(12, 'NÂ°16', 1.19, 0.00, 26),
(13, 'NÂ°20', 0.84, 0.00, 26),
(14, 'NÂ°30', 0.60, 0.00, 26),
(15, 'NÂ°40', 0.43, 0.00, 26),
(16, 'NÂ°60', 0.25, 0.00, 26),
(17, 'NÂ°100', 0.15, 0.00, 26),
(18, 'NÂ°200', 0.08, 6.90, 26),
(19, '(3")', 76.20, 0.00, 27),
(20, '(2 1/2")', 63.50, 0.00, 27),
(21, '(2")', 50.80, 0.00, 27),
(22, '(1 1/2")', 38.10, 0.00, 27),
(23, '(1")', 25.40, 0.00, 27),
(24, '(3/4")', 19.05, 0.00, 27),
(25, '(1/2")', 12.70, 0.00, 27),
(26, '(3/8")', 9.52, 0.00, 27),
(27, '(1/4")', 6.35, 0.00, 27),
(28, 'NÂ°4', 4.75, 0.00, 27),
(29, 'NÂ°10', 2.00, 0.00, 27),
(30, 'NÂ°16', 1.19, 0.00, 27),
(31, 'NÂ°20', 0.84, 0.00, 27),
(32, 'NÂ°30', 0.60, 0.00, 27),
(33, 'NÂ°40', 0.43, 0.00, 27),
(34, 'NÂ°60', 0.25, 0.00, 27),
(35, 'NÂ°100', 0.15, 0.00, 27),
(36, 'NÂ°200', 0.08, 2.30, 27),
(37, '(3")', 76.20, 0.00, 28),
(38, '(2 1/2")', 63.50, 0.00, 28),
(39, '(2")', 50.80, 0.00, 28),
(40, '(1 1/2")', 38.10, 0.00, 28),
(41, '(1")', 25.40, 0.00, 28),
(42, '(3/4")', 19.05, 0.00, 28),
(43, '(1/2")', 12.70, 0.00, 28),
(44, '(3/8")', 9.52, 0.00, 28),
(45, '(1/4")', 6.35, 0.00, 28),
(46, 'NÂ°4', 4.75, 0.00, 28),
(47, 'NÂ°10', 2.00, 0.00, 28),
(48, 'NÂ°16', 1.19, 0.00, 28),
(49, 'NÂ°20', 0.84, 0.00, 28),
(50, 'NÂ°30', 0.60, 0.00, 28),
(51, 'NÂ°40', 0.43, 0.00, 28),
(52, 'NÂ°60', 0.25, 0.00, 28),
(53, 'NÂ°100', 0.15, 0.00, 28),
(54, 'NÂ°200', 0.08, 4.20, 28);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `codigo_proyecto`, `nombre_proyecto`, `lugar`, `contratista`, `fecha`, `fk_id_autor`, `fk_id_responsable`, `estado`) VALUES
(116, 106541287, 'Proyecto UrbanizaciÃ³n la Gloria #1', 'MonterÃ­a-Cordoba ', 'Constructora Bolivar', '2013-09-09', 18, 18, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `resultados`
--

INSERT INTO `resultados` (`id_resultados`, `humedad`, `limiteLiquido`, `limitePlastico`, `indicePlasticidad`, `cohesion`, `pesoUnitario`, `N200`, `N4`, `N10`, `N40`, `notacionSucs`, `descripcionSucs`, `aashto`, `imagenPerfil`, `fechaIngreso`, `estado`, `fk_idMuestra`) VALUES
(1, 24.00, 56.00, 30.00, 26.00, 104.50, 18.81, 95.05, 100.00, 100.00, 100.00, 'MH', 'Limo elÃ¡stico arenoso', 'A-7-5', 'limoarcilloso', '2013-09-09 01:34:40', 1, 40),
(2, 35.00, 56.00, 30.00, 26.00, 42.00, 17.75, 99.19, 100.00, 100.00, 100.00, 'MH', 'Limo elÃ¡stico arenoso', 'A-7-5', 'limoarcilloso', '2013-09-09 01:50:06', 1, 41),
(3, 40.00, 76.00, 34.00, 42.00, 66.00, 16.79, 98.64, 100.00, 100.00, 100.00, 'CH', 'Arcilla gruesa arenosa', 'A-7-5', 'arcilloso', '2013-09-09 02:01:53', 1, 42);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de sondeos ' AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `sondeos`
--

INSERT INTO `sondeos` (`id_sondeo`, `nivel_freatico`, `profundidad_superficie`, `estado`, `fk_id_tipo_superficie`, `fk_idproyecto`) VALUES
(13, 5.2, 10, 1, 4, 116);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de limites liquidos ' AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `testlimites`
--

INSERT INTO `testlimites` (`id_test`, `tipo_muestra`, `nom_capsula`, `peso_capsula`, `peso_capsula_suelo_humedo`, `peso_capsula_suelo_seco`, `num_golpes`, `fecha_ingreso`, `estado`, `fk_id_muestra`) VALUES
(1, 0, 'V8', '4.20', '20.70', '17.60', '0', '2013-09-09 01:34:40', 1, 40),
(2, 0, 'V103', '4.20', '17.60', '15.00', '0', '2013-09-09 01:34:40', 1, 40),
(3, 0, 'V98', '4.40', '25.00', '20.90', '0', '2013-09-09 01:34:40', 1, 40),
(4, 1, '2', '12.76', '26.32', '21.35', '16', '2013-09-09 01:34:40', 1, 40),
(5, 1, '36', '13.03', '25.16', '20.80', '26', '2013-09-09 01:34:40', 1, 40),
(6, 1, '39', '12.84', '24.78', '20.57', '34', '2013-09-09 01:34:40', 1, 40),
(7, 2, 'A201', '12.86', '22.13', '20.03', '0', '2013-09-09 01:34:40', 1, 40),
(8, 2, '28', '12.74', '20.37', '18.63', '0', '2013-09-09 01:34:40', 1, 40),
(9, 2, 'L5', '12.76', '21.18', '19.25', '0', '2013-09-09 01:34:40', 1, 40),
(10, 0, 'V42', '3.80', '20.80', '16.20', '0', '2013-09-09 01:50:06', 1, 41),
(11, 0, 'C520', '3.50', '22.00', '16.90', '0', '2013-09-09 01:50:06', 1, 41),
(12, 0, 'C41', '3.60', '18.00', '14.40', '0', '2013-09-09 01:50:06', 1, 41),
(13, 1, 'H1', '19.25', '35.85', '29.80', '16', '2013-09-09 01:50:06', 1, 41),
(14, 1, 'N16', '19.65', '39.73', '32.50', '23', '2013-09-09 01:50:06', 1, 41),
(15, 1, 'N13', '19.67', '37.53', '31.20', '34', '2013-09-09 01:50:06', 1, 41),
(16, 2, 'H81', '12.74', '19.91', '18.25', '0', '2013-09-09 01:50:06', 1, 41),
(17, 2, 'N1', '19.46', '28.45', '26.35', '0', '2013-09-09 01:50:06', 1, 41),
(18, 2, 'A209', '13.53', '21.51', '19.67', '0', '2013-09-09 01:50:06', 1, 41),
(19, 0, 'V38', '4.20', '19', '14.70', '0', '2013-09-09 02:01:53', 1, 42),
(20, 0, 'V57', '4.30', '20.40', '15.80', '0', '2013-09-09 02:01:53', 1, 42),
(21, 0, 'C19', '3.70', '15.60', '12.20', '0', '2013-09-09 02:01:53', 1, 42),
(22, 1, 'A13', '12.86', '23.36', '18.76', '17', '2013-09-09 02:01:53', 1, 42),
(23, 1, 'A224', '13.54', '24.79', '19.93', '26', '2013-09-09 02:01:53', 1, 42),
(24, 1, '11', '12.79', '25.13', '19.86', '34', '2013-09-09 02:01:53', 1, 42),
(25, 2, 'L12', '12.82', '21.36', '19.23', '0', '2013-09-09 02:01:53', 1, 42),
(26, 2, 'A226', '12.78', '20.33', '18.33', '0', '2013-09-09 02:01:53', 1, 42),
(27, 2, 'A202', '12.74', '19.05', '17.43', '0', '2013-09-09 02:01:53', 1, 42);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=4096 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `tipo`, `nombre_usuario`, `password`, `estado`) VALUES
(0, 3212312, 'Super', 'Usuario', 'Administrador', 'root', '10697224', 1),
(1, 3009994, 'No', 'Asignado', 'Ingeniero', '_________NA', '_________NA', 1),
(17, 123456789, 'Administrador', 'Geotecnia', 'Administrador', 'admin', '123456789', 1),
(18, 1067892548, 'Marcel Fidel ', 'Solera Ayala', 'Ingeniero', 'marztres', '10697224', 1),
(19, 1067892245, 'Luis Andres', 'Vega Gonzales', 'Laboratorista', 'andresvega', '10697224', 1);

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
