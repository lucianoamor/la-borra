CREATE TABLE IF NOT EXISTS `agrupaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `color` char(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `api_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `tabla` varchar(50) CHARACTER SET utf8 NOT NULL,
  `respuesta` char(3) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `candidatos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(150) NOT NULL,
  `agrupacion` char(17) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `elecciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `encuestadoras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `web` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `encuestas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  `encuestadora` char(17) NOT NULL,
  `eleccion` char(17) NOT NULL,
  `fuente` varchar(200) NOT NULL,
  `poblacion` char(17) NOT NULL,
  `muestra` int(10) unsigned NOT NULL,
  `esResultado` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `poblacion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) CHARACTER SET utf8 NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nivel` enum('País','Región','Provincia','Partido','Localidad') CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `resultados` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idAT` char(17) NOT NULL,
  `candidato` char(17) NOT NULL,
  `encuesta` char(17) NOT NULL,
  `intencion` decimal(4,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idAT` (`idAT`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;