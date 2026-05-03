-- Respaldo generado automáticamente
-- Fecha: 2026-05-03 12:07:41

-- Estructura para tabla `asistencia`
DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL AUTO_INCREMENT,
  `id_empleado` int(11) NOT NULL,
  `entrada` datetime DEFAULT NULL,
  `salida` datetime DEFAULT NULL,
  PRIMARY KEY (`id_asistencia`),
  KEY `fk2` (`id_empleado`),
  CONSTRAINT `fk2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Datos para tabla `asistencia`
INSERT INTO `asistencia` VALUES ('70','11','2026-04-29 13:05:53','0000-00-00 00:00:00');
INSERT INTO `asistencia` VALUES ('71','20','2026-05-01 13:30:10','2026-05-01 13:30:26');
INSERT INTO `asistencia` VALUES ('72','11','2026-05-03 06:06:33','2026-05-03 06:06:36');

-- Estructura para tabla `cargo`
DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Datos para tabla `cargo`
INSERT INTO `cargo` VALUES ('10','secretaria ejecutiva');
INSERT INTO `cargo` VALUES ('11','asistente ejecutiva');
INSERT INTO `cargo` VALUES ('28','promotor social');

-- Estructura para tabla `empleado`
DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `ci` varchar(255) NOT NULL,
  `cargo` int(11) NOT NULL,
  `num_tlf` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_ingreso` varchar(255) DEFAULT NULL,
  `anio_servicio` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  KEY `fk1` (`cargo`),
  CONSTRAINT `fk1` FOREIGN KEY (`cargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Datos para tabla `empleado`
INSERT INTO `empleado` VALUES ('11','Luis','ilario','24697884','10','','','','1','sarmientoxluis1@gmail.com');
INSERT INTO `empleado` VALUES ('20','jose','perez','14517979','11','04128760722','calle los andes','','2','sarmientoxluis2@gmail.com');
INSERT INTO `empleado` VALUES ('21','jose','perez','14517978','28','04128760722','calle los andes','','2','sarmientoxluis2@gmail.com');

-- Estructura para tabla `empresa`
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `ruc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Datos para tabla `empresa`
INSERT INTO `empresa` VALUES ('1','Informatica Studios','925310896','av. los incas','78945612378');

-- Estructura para tabla `respaldos`
DROP TABLE IF EXISTS `respaldos`;
CREATE TABLE `respaldos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Datos para tabla `respaldos`
INSERT INTO `respaldos` VALUES ('3','sistema_asistencia_2026-05-01_19-29-28.sql','2026-05-01');

-- Estructura para tabla `roles`
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id_roles` int(11) NOT NULL AUTO_INCREMENT,
  `nom_rol` text NOT NULL,
  PRIMARY KEY (`id_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos para tabla `roles`
INSERT INTO `roles` VALUES ('1','Administrador');
INSERT INTO `roles` VALUES ('2','Empleado');

-- Estructura para tabla `usuarios`
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `nombre` text NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `foto` text NOT NULL,
  `rol` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos para tabla `usuarios`
INSERT INTO `usuarios` VALUES ('26','luis123','$5$rounds=5000$usesomesillystri$7VNjR/j/wRmxpQjJE0eapwy/8GRQYwggddiREa77dp2','luis','sarmiento','vistas/imagenes/usuarios/983.jpg','2','');
INSERT INTO `usuarios` VALUES ('27','luen','$5$rounds=5000$usesomesillystri$akvoUUACn.j2j3K8332rfBM7cNkqVGP4JiJD2jRh7hB','luis','sarmiento','vistas/imagenes/usuarios/835.png','1','');

