-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-07-2013 a las 19:31:02
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `geotecnia`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=74 ;

--
-- Volcado de datos para la tabla `compresion`
--

INSERT INTO `compresion` (`id_compresion`, `diametro`, `altura`, `peso`, `tipoFalla`, `fecha_ingreso`, `estado`, `fK_idmuestra`) VALUES
(72, 5.50, 10.40, 438.60, 'Abonbamiento', '2013-07-12 11:15:27', 1, 192),
(73, 0.00, 0.00, 0.00, '', '2013-07-12 11:15:56', 1, 193);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=998 ;

--
-- Volcado de datos para la tabla `deformaciones`
--

INSERT INTO `deformaciones` (`id_deformacion`, `deformacion`, `carga`, `estado`, `fk_idcompresion`) VALUES
(962, 10, 18.00, 0, 72),
(963, 30, 30.00, 0, 72),
(964, 50, 48.00, 0, 72),
(965, 75, 69.00, 0, 72),
(966, 100, 95.00, 0, 72),
(967, 150, 126.00, 0, 72),
(968, 200, 160.00, 0, 72),
(969, 250, 188.00, 0, 72),
(970, 300, 215.00, 0, 72),
(971, 350, 220.00, 0, 72),
(972, 400, 225.00, 0, 72),
(973, 450, 0.00, 0, 72),
(974, 500, 0.00, 0, 72),
(975, 550, 0.00, 0, 72),
(976, 600, 0.00, 0, 72),
(977, 650, 0.00, 0, 72),
(978, 700, 0.00, 0, 72),
(979, 750, 0.00, 0, 72),
(980, 10, 0.00, 0, 73),
(981, 30, 0.00, 0, 73),
(982, 50, 0.00, 0, 73),
(983, 75, 0.00, 0, 73),
(984, 100, 0.00, 0, 73),
(985, 150, 0.00, 0, 73),
(986, 200, 0.00, 0, 73),
(987, 250, 0.00, 0, 73),
(988, 300, 0.00, 0, 73),
(989, 350, 0.00, 0, 73),
(990, 400, 0.00, 0, 73),
(991, 450, 0.00, 0, 73),
(992, 500, 0.00, 0, 73),
(993, 550, 0.00, 0, 73),
(994, 600, 0.00, 0, 73),
(995, 650, 0.00, 0, 73),
(996, 700, 0.00, 0, 73),
(997, 750, 0.00, 0, 73);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `granulometria`
--

CREATE TABLE IF NOT EXISTS `granulometria` (
  `id_granulometria` int(11) NOT NULL AUTO_INCREMENT,
  `pesoRecipiente` float(9,2) DEFAULT NULL,
  `pesoRecipienteMasMuestra` float(9,2) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fechaIngreso` datetime NOT NULL,
  `fk_idmuestra` int(11) NOT NULL,
  PRIMARY KEY (`id_granulometria`),
  KEY `fk_idmuestra` (`fk_idmuestra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=56 ;

--
-- Volcado de datos para la tabla `granulometria`
--

INSERT INTO `granulometria` (`id_granulometria`, `pesoRecipiente`, `pesoRecipienteMasMuestra`, `estado`, `fechaIngreso`, `fk_idmuestra`) VALUES
(54, 0.00, 0.00, 1, '2013-07-12 11:15:27', 192),
(55, 0.00, 0.00, 1, '2013-07-12 11:15:56', 193);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `muestras`
--

CREATE TABLE IF NOT EXISTS `muestras` (
  `id_muestra` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Id de las muestras\r\n',
  `profundidad_inicial` float NOT NULL COMMENT 'Profundidad inicial de la muestra',
  `profundidad_final` float NOT NULL COMMENT 'Profundidad final de la muestra',
  `descripcion` varchar(200) NOT NULL COMMENT 'Descripcion de la muestra\r\n',
  `material_de_relleno` int(11) DEFAULT '0' COMMENT '0 sino es material de relleno o 1 si es material de relleno',
  `numero_golpes` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL,
  `fk_idsondeo` int(11) NOT NULL COMMENT 'Llave foranea sondeo\r\n',
  PRIMARY KEY (`id_muestra`),
  KEY `fk_idsondeo` (`fk_idsondeo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de muestras ' AUTO_INCREMENT=194 ;

--
-- Volcado de datos para la tabla `muestras`
--

INSERT INTO `muestras` (`id_muestra`, `profundidad_inicial`, `profundidad_final`, `descripcion`, `material_de_relleno`, `numero_golpes`, `estado`, `fk_idsondeo`) VALUES
(192, 0.1, 0.2, 'Pardo vetas Amarillas', 1, '10', 1, 1),
(193, 0.3, 0.4, 'Pardo vetas Marro', 1, '1', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=771 ;

--
-- Volcado de datos para la tabla `pesosretenidos`
--

INSERT INTO `pesosretenidos` (`idPesoRetenido`, `tamiz`, `tamanoTamiz`, `pesoRetenido`, `fk_id_granulometria`) VALUES
(743, '(2 1/2")', 63.50, 0.00, 54),
(744, '(2")', 50.80, 0.00, 54),
(745, '(1 1/2")', 38.10, 0.00, 54),
(746, '(1")', 25.40, 0.00, 54),
(747, '(3/4")', 19.05, 0.00, 54),
(748, '(1/2")', 12.70, 0.00, 54),
(749, '(3/8")', 9.52, 0.00, 54),
(750, 'NÂ°4', 4.75, 0.00, 54),
(751, 'NÂ°10', 2.00, 0.00, 54),
(752, 'NÂ°16', 1.19, 0.00, 54),
(753, 'NÂ°30', 0.60, 0.00, 54),
(754, 'NÂ°40', 0.43, 0.00, 54),
(755, 'NÂ°100', 0.15, 0.00, 54),
(756, 'NÂ°200', 0.08, 0.00, 54),
(757, '(2 1/2")', 63.50, 0.00, 55),
(758, '(2")', 50.80, 0.00, 55),
(759, '(1 1/2")', 38.10, 0.00, 55),
(760, '(1")', 25.40, 0.00, 55),
(761, '(3/4")', 19.05, 0.00, 55),
(762, '(1/2")', 12.70, 0.00, 55),
(763, '(3/8")', 9.52, 0.00, 55),
(764, 'NÂ°4', 4.75, 0.00, 55),
(765, 'NÂ°10', 2.00, 0.00, 55),
(766, 'NÂ°16', 1.19, 0.00, 55),
(767, 'NÂ°30', 0.60, 0.00, 55),
(768, 'NÂ°40', 0.43, 0.00, 55),
(769, 'NÂ°100', 0.15, 0.00, 55),
(770, 'NÂ°200', 0.08, 0.00, 55);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `codigo_proyecto`, `nombre_proyecto`, `lugar`, `contratista`, `fecha`, `fk_id_autor`, `fk_id_responsable`, `estado`) VALUES
(65, 8520, 'Estadio de futbol de Maracana', 'MonterÃ­a - CÃ³rdoba', 'Jader Mecino', '2013-04-17', 7, 10, 1),
(66, 976464356, 'Torres del este', 'Montelibano', 'Emarcosas', '2013-06-24', 7, 7, 0),
(67, 32457689, 'UrbanizaciÃ³n La gloria', 'CÃ©rete', 'Eder Montesino', '2013-06-26', 8, 8, 0),
(68, 9864346, 'Monteria amable ', 'Sincelejos', 'Miguel Acosta', '2013-06-26', 8, 8, 0),
(69, 2147483647, 'Torres de pasatiempo ', 'Cienaga de Oro', 'Constructora Bolivar', '2013-06-26', 8, 8, 0),
(71, 12334, 'Chirretrodromo ', 'Montelibano', 'Monteria amable', '2013-06-26', 8, 8, 0),
(72, 23232, 'Luis Andres Vega', 'Clinica MonterÃ­a', 'Luis Bula', '2013-06-26', 8, 7, 0),
(73, 9876897, 'Sanchopan', 'Monteria', 'Miguel Acosta', '2013-06-26', 8, 7, 0),
(74, 4564, 'Urbanizacion la gloria', 'CoveÃ±itas', 'Monteria amable', '2013-06-26', 8, 7, 0),
(75, 2323, '2323', '2323', '23', '2013-06-18', 8, 9, 0),
(76, 0, '', '', '', '0000-00-00', 8, 7, 0),
(84, 232323, '2323', '23232', '23232', '0000-00-00', 8, 7, 0),
(85, 12345, 'Pablo Castilla Negrette', 'Montelibano', 'Torcoroma', '2013-06-26', 8, 10, 0),
(86, 1243, 'sede', 'sd', 'sd', '2013-06-26', 7, 10, 0),
(103, 12345678, 'Almacenes Exito S.A.S', '', 'Emarcosas', '2013-06-27', 8, 10, 0),
(106, 123455, 'Almacenes exito', 'Monteria ', 'Emarcosas', '2013-06-27', 8, 10, 0),
(108, 3234, '23423', '234324', '23434', '2013-06-11', 8, 10, 0),
(109, 2324234, 'ExcavaciÃ³n en torres de monteverde Numero 2 troncal 3', 'Monteria', 'Monteria', '2013-06-28', 8, 8, 1),
(110, 7854154, 'Geotecnia y ambiente', 'Monteria', 'Geotecnia', '2013-06-20', 8, 8, 0);

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
  `descripcionSucs` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `aashto` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaIngreso` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `fk_idMuestra` int(11) NOT NULL,
  PRIMARY KEY (`id_resultados`),
  KEY `fk_idMuestra` (`fk_idMuestra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `resultados`
--

INSERT INTO `resultados` (`id_resultados`, `humedad`, `limiteLiquido`, `limitePlastico`, `indicePlasticidad`, `cohesion`, `pesoUnitario`, `N200`, `N4`, `N10`, `N40`, `notacionSucs`, `descripcionSucs`, `aashto`, `fechaIngreso`, `estado`, `fk_idMuestra`) VALUES
(25, 1.00, 2.00, 3.00, 4.00, 42.50, 17.75, 0.00, 0.00, 0.00, 0.00, '', '', '', '2013-07-12 11:15:27', 1, 192),
(26, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '', '', '2013-07-12 11:15:56', 1, 193);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sondeos`
--

CREATE TABLE IF NOT EXISTS `sondeos` (
  `id_sondeo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de sondeo\r\n',
  `nivel_freatico` float DEFAULT NULL COMMENT 'Nivel freatico del suelo',
  `profundidad_superficie` float DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fk_id_tipo_superficie` int(11) DEFAULT NULL,
  `fk_idproyecto` int(11) NOT NULL COMMENT 'llave foranea del id del proyecto\r\n',
  PRIMARY KEY (`id_sondeo`),
  KEY `fk_idproyecto` (`fk_idproyecto`),
  KEY `fk_id_tipo_superficie` (`fk_id_tipo_superficie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de sondeos ' AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `sondeos`
--

INSERT INTO `sondeos` (`id_sondeo`, `nivel_freatico`, `profundidad_superficie`, `estado`, `fk_id_tipo_superficie`, `fk_idproyecto`) VALUES
(1, 2.3, 10.5, 1, 1, 65);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de limites liquidos ' AUTO_INCREMENT=1129 ;

--
-- Volcado de datos para la tabla `testlimites`
--

INSERT INTO `testlimites` (`id_test`, `tipo_muestra`, `nom_capsula`, `peso_capsula`, `peso_capsula_suelo_humedo`, `peso_capsula_suelo_seco`, `num_golpes`, `fecha_ingreso`, `estado`, `fk_id_muestra`) VALUES
(1111, 0, '1', '3.50', '22.20', '15.30', '0', '2013-07-12 11:15:27', 1, 192),
(1112, 0, '2', '4.40', '23.80', '17.60', '0', '2013-07-12 11:15:27', 1, 192),
(1113, 0, '3', '4.20', '25.10', '19', '0', '2013-07-12 11:15:27', 1, 192),
(1114, 1, '1', '19.56', '32.60', '28.30', '16', '2013-07-12 11:15:27', 1, 192),
(1115, 1, '2', '12.86', '26.20', '21.89', '23', '2013-07-12 11:15:27', 1, 192),
(1116, 1, '3', '16.63', '32.40', '28.10', '34', '2013-07-12 11:15:27', 1, 192),
(1117, 2, '1', '19.53', '27.30', '25.57', '0', '2013-07-12 11:15:27', 1, 192),
(1118, 2, '2', '12.78', '20.60', '30.10', '0', '2013-07-12 11:15:27', 1, 192),
(1119, 2, '3', '12.69', '21.80', '19.86', '0', '2013-07-12 11:15:27', 1, 192),
(1120, 0, '1', '3.60', '23.60', '20.00', '0', '2013-07-12 11:15:56', 1, 193),
(1121, 0, '2', '4.50', '22.00', '19.00', '0', '2013-07-12 11:15:56', 1, 193),
(1122, 0, '3', '4.50', '25.10', '21.40', '0', '2013-07-12 11:15:56', 1, 193),
(1123, 1, '1', '14.30', '28.20', '22.80', '16', '2013-07-12 11:15:56', 1, 193),
(1124, 1, '2', '14.20', '29.53', '23.70', '23', '2013-07-12 11:15:56', 1, 193),
(1125, 1, '3', '15', '30.20', '24.60', '34', '2013-07-12 11:15:56', 1, 193),
(1126, 2, '1', '15.40', '19.10', '18.20', '0', '2013-07-12 11:15:56', 1, 193),
(1127, 2, '2', '15', '18.20', '17.50', '0', '2013-07-12 11:15:56', 1, 193),
(1128, 2, '3', '15.30', '21.50', '20.10', '0', '2013-07-12 11:15:56', 1, 193);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_superficie`
--

CREATE TABLE IF NOT EXISTS `tipo_superficie` (
  `id_tipo_superficie` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id tipo de superficie\r\n',
  `tipo_superficie` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo_superficie`),
  UNIQUE KEY `tipo_superficie` (`tipo_superficie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo_superficie`
--

INSERT INTO `tipo_superficie` (`id_tipo_superficie`, `tipo_superficie`) VALUES
(2, 'Capa vegetal'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=4096 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `tipo`, `nombre_usuario`, `password`, `estado`) VALUES
(7, 123, 'Luis Andres', 'Vega Gonzales', 'Administrador', 'admin', '123', 1),
(8, 1067856106, 'Amaury Jose', 'Guzman Ramos', 'Ingeniero', 'aj123', '123', 1),
(9, 1067892548, 'Marcel Fidel ', 'Solera Ayala', 'Laboratorista', 'marztres', '123', 1),
(10, 10687223, 'Pablo ', 'Castilla', 'Ingeniero', 'pablocastilla', '123', 123);

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
