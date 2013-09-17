-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2013 a las 20:22:01
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=26 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=26 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de muestras ' AUTO_INCREMENT=40 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de sondeos ' AUTO_INCREMENT=13 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de limites liquidos ' AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=4096 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombres`, `apellidos`, `tipo`, `nombre_usuario`, `password`, `estado`) VALUES
(0, 3212312, 'Super', 'Usuario', 'Administrador', 'root', '10697224', 1),
(1, 1234567891, 'No', 'Asignado', 'Ingeniero', 'N/A___', '_____________', 1),
(17, 123456789, 'Administrador', 'Geotecnia', 'Administrador', 'admin', '123456789', 1);

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
