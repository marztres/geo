-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-07-2013 a las 13:49:45
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=48 ;

--
-- Volcado de datos para la tabla `compresion`
--

INSERT INTO `compresion` (`id_compresion`, `diametro`, `altura`, `peso`, `tipoFalla`, `fecha_ingreso`, `estado`, `fK_idmuestra`) VALUES
(44, 5.50, 12.10, 514.00, 'Abombamiento', '2013-07-09 00:16:08', 1, 174),
(45, 5.50, 10.40, 438.60, 'abombamiento', '2013-07-09 00:16:37', 1, 175),
(46, 0.00, 0.00, 0.00, '', '2013-07-09 01:46:27', 1, 176),
(47, 0.00, 0.00, 0.00, '', '2013-07-09 01:50:04', 1, 177);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=530 ;

--
-- Volcado de datos para la tabla `deformaciones`
--

INSERT INTO `deformaciones` (`id_deformacion`, `deformacion`, `carga`, `estado`, `fk_idcompresion`) VALUES
(458, 10, 14.00, 0, 44),
(459, 30, 64.00, 0, 44),
(460, 50, 116.00, 0, 44),
(461, 75, 156.00, 0, 44),
(462, 100, 188.00, 0, 44),
(463, 150, 133.00, 0, 44),
(464, 200, 174.00, 0, 44),
(465, 250, 303.00, 0, 44),
(466, 300, 330.00, 0, 44),
(467, 350, 0.00, 0, 44),
(468, 400, 0.00, 0, 44),
(469, 450, 0.00, 0, 44),
(470, 500, 0.00, 0, 44),
(471, 550, 0.00, 0, 44),
(472, 600, 0.00, 0, 44),
(473, 650, 0.00, 0, 44),
(474, 700, 0.00, 0, 44),
(475, 750, 0.00, 0, 44),
(476, 10, 13.00, 0, 45),
(477, 30, 32.00, 0, 45),
(478, 50, 48.00, 0, 45),
(479, 75, 69.00, 0, 45),
(480, 100, 87.00, 0, 45),
(481, 150, 126.00, 0, 45),
(482, 200, 160.00, 0, 45),
(483, 250, 188.00, 0, 45),
(484, 300, 215.00, 0, 45),
(485, 350, 0.00, 0, 45),
(486, 400, 0.00, 0, 45),
(487, 450, 0.00, 0, 45),
(488, 500, 0.00, 0, 45),
(489, 550, 0.00, 0, 45),
(490, 600, 0.00, 0, 45),
(491, 650, 0.00, 0, 45),
(492, 700, 0.00, 0, 45),
(493, 750, 0.00, 0, 45),
(494, 10, 0.00, 0, 46),
(495, 30, 0.00, 0, 46),
(496, 50, 0.00, 0, 46),
(497, 75, 0.00, 0, 46),
(498, 100, 0.00, 0, 46),
(499, 150, 0.00, 0, 46),
(500, 200, 0.00, 0, 46),
(501, 250, 0.00, 0, 46),
(502, 300, 0.00, 0, 46),
(503, 350, 0.00, 0, 46),
(504, 400, 0.00, 0, 46),
(505, 450, 0.00, 0, 46),
(506, 500, 0.00, 0, 46),
(507, 550, 0.00, 0, 46),
(508, 600, 0.00, 0, 46),
(509, 650, 0.00, 0, 46),
(510, 700, 0.00, 0, 46),
(511, 750, 0.00, 0, 46),
(512, 10, 0.00, 0, 47),
(513, 30, 0.00, 0, 47),
(514, 50, 0.00, 0, 47),
(515, 75, 0.00, 0, 47),
(516, 100, 0.00, 0, 47),
(517, 150, 0.00, 0, 47),
(518, 200, 0.00, 0, 47),
(519, 250, 0.00, 0, 47),
(520, 300, 0.00, 0, 47),
(521, 350, 0.00, 0, 47),
(522, 400, 0.00, 0, 47),
(523, 450, 0.00, 0, 47),
(524, 500, 0.00, 0, 47),
(525, 550, 0.00, 0, 47),
(526, 600, 0.00, 0, 47),
(527, 650, 0.00, 0, 47),
(528, 700, 0.00, 0, 47),
(529, 750, 0.00, 0, 47);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `granulometria`
--

INSERT INTO `granulometria` (`id_granulometria`, `pesoRecipiente`, `pesoRecipienteMasMuestra`, `estado`, `fechaIngreso`, `fk_idmuestra`) VALUES
(26, 5.00, 300.00, 1, '2013-07-09 00:16:08', 174),
(27, 0.00, 0.00, 1, '2013-07-09 00:16:37', 175),
(28, 23.70, 651.80, 1, '2013-07-09 01:46:27', 176),
(29, 38.80, 437.90, 1, '2013-07-09 01:50:05', 177);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de muestras ' AUTO_INCREMENT=178 ;

--
-- Volcado de datos para la tabla `muestras`
--

INSERT INTO `muestras` (`id_muestra`, `profundidad_inicial`, `profundidad_final`, `descripcion`, `material_de_relleno`, `numero_golpes`, `estado`, `fk_idsondeo`) VALUES
(174, 1, 2, 'Pardo vetas Rojas', 1, '50', 1, 1),
(175, 3, 4, 'Pardo vetas negras', 1, '15', 1, 1),
(176, 5, 6, 'Pardo Vetas grises', 1, '15', 1, 1),
(177, 7, 8, 'Pardo vetas grisaseas', 1, '50', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=407 ;

--
-- Volcado de datos para la tabla `pesosretenidos`
--

INSERT INTO `pesosretenidos` (`idPesoRetenido`, `tamiz`, `tamanoTamiz`, `pesoRetenido`, `fk_id_granulometria`) VALUES
(351, '1', 63.50, 4.00, 26),
(352, '2', 50.80, 4.00, 26),
(353, '3', 38.10, 12.00, 26),
(354, '4', 25.40, 51.00, 26),
(355, '5', 19.05, 1.00, 26),
(356, '6', 12.70, 12.00, 26),
(357, '7', 9.52, 21.00, 26),
(358, '8', 4.75, 10.00, 26),
(359, '9', 2.00, 21.00, 26),
(360, '10', 1.19, 10.00, 26),
(361, '11', 0.60, 12.00, 26),
(362, '12', 0.43, 10.00, 26),
(363, '13', 0.15, 5.00, 26),
(364, '14', 0.08, 41.00, 26),
(365, '15', 63.50, 0.00, 27),
(366, '16', 50.80, 0.00, 27),
(367, '17', 38.10, 0.00, 27),
(368, '18', 25.40, 0.00, 27),
(369, '19', 19.05, 0.00, 27),
(370, '20', 12.70, 0.00, 27),
(371, '21', 9.52, 0.00, 27),
(372, '22', 4.75, 0.00, 27),
(373, '23', 2.00, 0.00, 27),
(374, '24', 1.19, 0.00, 27),
(375, '25', 0.60, 0.00, 27),
(376, '26', 0.43, 0.00, 27),
(377, '27', 0.15, 0.00, 27),
(378, '28', 0.08, 0.00, 27),
(379, '(2 1/2")', 63.50, 0.00, 28),
(380, '(2")', 50.80, 0.00, 28),
(381, '(1 1/2")', 38.10, 0.00, 28),
(382, '(1")', 25.40, 147.79, 28),
(383, '(3/4")', 19.05, 0.00, 28),
(384, '(1/2")', 12.70, 18.87, 28),
(385, '(3/8")', 9.52, 25.25, 28),
(386, 'NÂ°4', 4.75, 39.11, 28),
(387, 'NÂ°10', 2.00, 39.99, 28),
(388, 'NÂ°16', 1.19, 19.86, 28),
(389, 'NÂ°30', 0.60, 19.20, 28),
(390, 'NÂ°40', 0.43, 12.49, 28),
(391, 'NÂ°100', 0.15, 24.37, 28),
(392, 'NÂ°200', 0.08, 22.17, 28),
(393, '(2 1/2")', 63.50, 0.00, 29),
(394, '(2")', 50.80, 0.00, 29),
(395, '(1 1/2")', 38.10, 61.60, 29),
(396, '(1")', 25.40, 32.80, 29),
(397, '(3/4")', 19.05, 29.20, 29),
(398, '(1/2")', 12.70, 48.40, 29),
(399, '(3/8")', 9.52, 15.10, 29),
(400, 'NÂ°4', 4.75, 18.80, 29),
(401, 'NÂ°10', 2.00, 14.70, 29),
(402, 'NÂ°16', 1.19, 6.60, 29),
(403, 'NÂ°30', 0.60, 6.00, 29),
(404, 'NÂ°40', 0.43, 2.20, 29),
(405, 'NÂ°100', 0.15, 4.90, 29),
(406, 'NÂ°200', 0.08, 3.00, 29);

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
(1, 2.3, 10.5, 1, 1, 65),
(4, 1, 0, 1, 2, 65),
(7, 1, 0, 1, 2, 65),
(9, 12, 2, 1, 2, 65),
(10, 12, 2, 1, 2, 65),
(11, 12, 12, 1, 2, 65),
(12, 123, 1, 0, 2, 109),
(13, 12, 5, 0, 2, 109),
(14, 4, 7, 1, 2, 109),
(15, 3, 4, 0, 2, 109),
(16, 11, 0, 1, 1, 109),
(17, 23, 12, 1, 2, 109),
(18, 23, 12, 1, 2, 109),
(19, 14, 20, 1, 2, 109),
(20, 1, 1, 1, 2, 109),
(22, 1, 0, 1, 1, 109),
(23, 1, 0, 1, 1, 109),
(25, 1, 1, 1, 2, 109),
(26, 2, 1, 1, 2, 109),
(27, 15, 0, 1, 1, 109),
(28, 15, 0, 1, 2, 109),
(30, 15, 0, 1, 1, 109),
(31, 15, 0, 1, 2, 109),
(33, 15, 0, 1, 1, 109),
(34, 15, 0, 1, 2, 109),
(36, 12, 0, 1, 2, 109),
(37, 12, 0, 1, 1, 109),
(38, 1, 0, 0, 1, 109),
(39, 5, 0, 0, 1, 65);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de limites liquidos ' AUTO_INCREMENT=895 ;

--
-- Volcado de datos para la tabla `testlimites`
--

INSERT INTO `testlimites` (`id_test`, `tipo_muestra`, `nom_capsula`, `peso_capsula`, `peso_capsula_suelo_humedo`, `peso_capsula_suelo_seco`, `num_golpes`, `fecha_ingreso`, `estado`, `fk_id_muestra`) VALUES
(859, 0, 'c318', '4.20', '36.20', '21.00', '0', '2013-07-09 00:16:08', 1, 174),
(860, 0, 'c333', '4.10', '21.60', '17.50', '0', '2013-07-09 00:16:08', 1, 174),
(861, 0, 'v109', '4.30', '22.20', '18.00', '0', '2013-07-09 00:16:08', 1, 174),
(862, 1, 'h1', '19.60', '38.30', '32.10', '16', '2013-07-09 00:16:08', 1, 174),
(863, 1, 'h2', '19.50', '37.16', '31.50', '26', '2013-07-09 00:16:08', 1, 174),
(864, 1, 'h3', '19.50', '41.20', '34.50', '33', '2013-07-09 00:16:08', 1, 174),
(865, 2, 'z8', '19.30', '30.30', '27.90', '0', '2013-07-09 00:16:08', 1, 174),
(866, 2, 'z13', '19.30', '31.40', '28.70', '0', '2013-07-09 00:16:08', 1, 174),
(867, 2, 'z10', '19.40', '32.86', '29.90', '0', '2013-07-09 00:16:08', 1, 174),
(868, 0, 'V38', '4.2', '19.00', '14.70', '0', '2013-07-09 00:16:37', 1, 175),
(869, 0, 'V57', '4.3', '20.40', '15.80', '0', '2013-07-09 00:16:37', 1, 175),
(870, 0, 'C19', '3.70', '15.60', '12.20', '0', '2013-07-09 00:16:37', 1, 175),
(871, 1, 'A13', '12.86', '23.36', '18.76', '17', '2013-07-09 00:16:37', 1, 175),
(872, 1, 'A224', '13.54', '24.78', '19.93', '26', '2013-07-09 00:16:37', 1, 175),
(873, 1, '11', '12.79', '25.13', '19.86', '34', '2013-07-09 00:16:37', 1, 175),
(874, 2, 'L12', '12.82', '21.36', '19.23', '0', '2013-07-09 00:16:37', 1, 175),
(875, 2, 'A226', '12.78', '20.33', '18.40', '0', '2013-07-09 00:16:37', 1, 175),
(876, 2, 'A202', '12.74', '19.05', '17.43', '0', '2013-07-09 00:16:37', 1, 175),
(877, 0, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(878, 0, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(879, 0, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(880, 1, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(881, 1, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(882, 1, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(883, 2, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(884, 2, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(885, 2, '', '', '', '', '', '2013-07-09 01:46:27', 1, 176),
(886, 0, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(887, 0, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(888, 0, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(889, 1, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(890, 1, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(891, 1, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(892, 2, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(893, 2, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177),
(894, 2, '', '', '', '', '', '2013-07-09 01:50:04', 1, 177);

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
