-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.144.246
-- Generation Time: Oct 31, 2024 at 12:29 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectroute`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `copiar_tabla_diaria` ()  BEGIN
    -- Insertar datos en la tabla backup desde guardar_check
    INSERT INTO backup 
    (fecha, semana, elemento_id, area, NameElemento, caracteristica1, caracteristica2, caracteristica3, caracteristica4, caracteristica5, caracteristica6, caracteristica7, caracteristica8, caracteristica9, caracteristica10, caracteristica11, identificador)
    SELECT 
        CURDATE(), -- Fecha actual
        WEEK(CURDATE() + INTERVAL 1 DAY, 1), -- Semana del día siguiente
        elemento_id, 
        area, 
        NameElemento, 
        caracteristica1,
        caracteristica2,
        caracteristica3,
        caracteristica4,
        caracteristica5,
        caracteristica6,
        caracteristica7,
        caracteristica8,
        caracteristica9,
        caracteristica10,
        caracteristica11,
        identificador_elemento
    FROM guardar_check;

    -- Borrar todos los datos en la tabla guardar_check
    DELETE FROM guardar_check;

    -- Copiar datos de la tabla guardar_dato a la tabla guardar_check
    INSERT INTO guardar_check 
    (elemento_id, NameElemento, caracteristica1, caracteristica2, caracteristica3, caracteristica4, caracteristica5, caracteristica6, caracteristica7, caracteristica8, caracteristica9, caracteristica10, caracteristica11, area)
    SELECT 
        elemento_id, 
        NameElemento, 
        caracteristica1,
        caracteristica2,
        caracteristica3,
        caracteristica4,
        caracteristica5,
        caracteristica6,
        caracteristica7,
        caracteristica8,
        caracteristica9,
        caracteristica10,
        caracteristica11,
        area
    FROM guardar_dato;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `alerta`
--

CREATE TABLE `alerta` (
  `id` int(11) NOT NULL,
  `id_elemento` int(11) DEFAULT NULL,
  `elemento` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `falla` varchar(255) DEFAULT NULL,
  `fecha_alerta` datetime DEFAULT NULL,
  `estatus` varchar(50) DEFAULT 'En espera...',
  `mes` varchar(20) NOT NULL,
  `hora_alerta` datetime DEFAULT NULL,
  `user_alert` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alerta`
--

INSERT INTO `alerta` (`id`, `id_elemento`, `elemento`, `area`, `falla`, `fecha_alerta`, `estatus`, `mes`, `hora_alerta`, `user_alert`) VALUES
(245, 28, 'GARBURG VARIO III JUNTO A TERMINALES', 'Stepp', 'No se seleccionó ', '2024-05-16 09:30:43', 'En espera...', 'Mayo', NULL, NULL),
(246, 18, 'Terminal MPDV-MX-315', 'Stepp', 'No se seleccionó ', '2024-05-16 09:34:03', 'En espera...', 'Mayo', NULL, NULL),
(247, 2, 'Legic Card', 'Recepción', 'Pantalla principal con daño', '2024-05-16 09:43:08', 'En espera...', 'Mayo', NULL, NULL),
(248, 106, 'Terminal MPDV-MX-316', 'Inyección', 'La terminal no esta cambiando de status', '2024-05-16 10:58:23', 'En espera...', 'Mayo', NULL, NULL),
(249, 1, 'Terminal MPDV-MX-317', 'Recepción', 'Scanner no enciende', '2024-05-16 11:46:49', 'En espera...', 'Mayo', NULL, NULL),
(250, 1, 'Terminal MPDV-MX-317', 'Recepción', 'No tiene red ', '2024-05-16 13:04:49', 'En espera...', 'Mayo', NULL, NULL),
(251, 30, 'GARBURG MAQUINA 4005', 'Stepp', 'No tiene red ', '2024-05-16 15:36:12', 'En espera...', 'Mayo', NULL, NULL),
(252, 1, 'Terminal MPDV-MX-317', 'Recepción', 'No tiene red ', '2024-05-16 16:48:47', 'En espera...', 'Mayo', NULL, NULL),
(253, 59, 'GARBURG ME12', 'Mezzanine', 'Pantalla principal con daño ', '2024-05-16 16:49:36', 'En espera...', 'Mayo', NULL, NULL),
(254, 25, 'Legic Card', 'Stepp', 'No lee la tarjeta ', '2024-05-16 17:09:23', 'En espera...', 'Mayo', NULL, NULL),
(255, 30, 'GARBURG MAQUINA 4005', 'Stepp', 'No tiene red ', '2024-05-16 17:10:45', 'En espera...', 'Mayo', NULL, NULL),
(256, 34, 'Terminal MPDV-MX-497 ', 'Extrucción', 'Terminal pasmada ', '2024-05-16 17:11:57', 'Aceptada', 'Mayo', NULL, NULL),
(257, 19, 'Legic Card', 'Stepp', 'No reconoce la tarjeta del operador ', '2024-05-16 17:15:13', 'En proceso...', 'Mayo', NULL, NULL),
(258, 88, 'Legic Card', 'Soplado', 'No reconoce el lector ', '2024-05-16 17:16:48', 'En proceso...', 'Mayo', NULL, NULL),
(259, 78, 'GARBURG ZEBRA', 'Carbón', 'Impresiones borrosas ', '2024-05-16 17:17:34', 'En proceso...', 'Mayo', NULL, NULL),
(260, 118, 'Terminal MPDV-MX-491', 'Inyección', 'La terminal tiene un golpe o rayón ', '2024-05-16 17:18:53', 'En proceso...', 'Mayo', NULL, NULL),
(261, 3, 'Terminal MPDV-MX-497', 'Hornos de Flexión', 'Derrame de liquido ', '2024-05-16 17:39:30', 'En proceso...', 'Mayo', NULL, NULL),
(262, 149, 'Scanner Keyebce-Skorpion', 'Embarques PT', 'No reconoce el Scanner ', '2024-05-17 09:56:36', 'En proceso...', 'Mayo', NULL, NULL),
(263, 78, 'GARBURG ZEBRA', 'Carbón', 'No tiene red ', '2024-05-17 11:25:55', 'En proceso...', 'Mayo', NULL, NULL),
(264, 1, 'Terminal MPDV-MX-317', 'Recepción', 'No tiene red ', '2024-05-17 14:45:10', 'En proceso...', 'Mayo', NULL, NULL),
(265, 1, 'Terminal MPDV-MX-317', 'Recepción', 'Esta pintada (Lapicero o Plumón) ', '2024-05-18 19:22:11', 'En proceso...', 'Mayo', NULL, NULL),
(266, 35, 'Legic Card', 'Extrucción', 'No reconoce el lector ', '2024-05-19 15:25:04', 'En proceso...', 'Mayo', NULL, NULL),
(267, 101, 'Terminal MPDV-MX-487', 'Conectores', 'La terminal no esta cambiando de status ', '2024-05-20 09:07:59', 'En proceso...', 'Mayo', NULL, NULL),
(268, 72, 'Scanner', 'Carbón', 'No escanea ', '2024-05-21 08:19:38', 'En proceso...', 'Mayo', NULL, NULL),
(269, 72, 'Scanner de Terminal MPDV-MX-493', 'Carbón', 'No lee la ordende producción', '2024-05-22 08:01:42', 'En proceso...', 'Mayo', NULL, NULL),
(270, 145, 'Legic Card de Terminal MPDV-MX-498', 'Moldes de Flexión', 'No lee la tarjeta ', '2024-05-22 08:50:16', 'En proceso...', 'Mayo', NULL, NULL),
(271, 125, 'Terminal MPDV-MX-496', 'Inyección', 'La terminal no esta cambiando de status ', '2024-05-24 07:36:35', 'En proceso...', 'Mayo', NULL, NULL),
(272, 124, 'Scanner de Terminal MPDV-MX-491', 'Inyección', 'No escanea ', '2024-05-24 07:39:28', 'En proceso...', 'Mayo', NULL, NULL),
(273, 64, 'Terminal MPDV-MX-490', 'Carbón', 'Derrame de liquido ', '2024-05-24 07:47:18', 'En proceso...', 'Mayo', NULL, NULL),
(274, 55, 'GARBURG ME18 MATERIALES', 'Vacio', 'No imprime ', '2024-05-24 08:24:19', 'En proceso...', 'Mayo', NULL, NULL),
(275, 44, 'GARBURG SUP VACIO', 'Vacio', 'Atasco de etiquetas ', '2024-05-24 08:25:15', 'En proceso...', 'Mayo', NULL, NULL),
(276, 18, 'Terminal MPDV-MX-315', 'Stepp', 'Terminal pasmada ', '2024-05-24 13:35:52', 'En proceso...', 'Mayo', NULL, NULL),
(277, 144, 'Terminal MPDV-MX-498', 'Moldes de Flexión', 'No funciona el touch ', '2024-05-27 09:04:45', 'En proceso...', 'Mayo', NULL, NULL),
(278, 85, 'GARBURG LINEA 2 VITA II', 'Carbón', 'Atasco de etiquetas ', '2024-05-28 10:04:39', 'En proceso...', 'Mayo', NULL, NULL),
(279, 61, 'Terminal MPDV-MX-481', 'Carbón', 'La terminal no esta prendida ', '2024-05-28 10:50:04', 'En proceso...', 'Mayo', NULL, NULL),
(280, 124, 'Scanner de Terminal MPDV-MX-491', 'Inyección', 'No escanea ', '2024-05-29 08:26:42', 'En proceso...', 'Mayo', NULL, NULL),
(281, 72, 'Scanner de Terminal MPDV-MX-493', 'Carbón', 'No se encuentra el Scanner en su lugar', '2024-05-30 07:57:18', 'En proceso...', 'Mayo', NULL, NULL),
(282, 70, 'Terminal MPDV-MX-493', 'Carbón', 'Derrame de liquido ', '2024-06-03 08:07:45', 'En proceso...', 'Junio', NULL, NULL),
(283, 147, 'GARBURG ME41', 'Embarques PT', 'Atasco de etiquetas ', '2024-06-03 16:55:30', 'En proceso...', 'Junio', NULL, NULL),
(284, 132, 'Basculas ', 'Inyección', 'No conecta con el servidor MTOPC ', '2024-06-04 08:07:06', 'En proceso...', 'Junio', NULL, NULL),
(285, 124, 'Scanner de Terminal MPDV-MX-491', 'Inyección', 'No escanea ', '2024-06-04 08:09:29', 'En proceso...', 'Junio', NULL, NULL),
(286, 72, 'Scanner de Terminal MPDV-MX-493', 'Carbón', 'No escanea ', '2024-06-05 08:11:02', 'En proceso...', 'Junio', NULL, NULL),
(287, 21, 'Terminal MPDV-MX-486', 'Stepp', 'No tiene red ', '2024-06-06 09:15:46', 'En espera...', 'Junio', NULL, NULL),
(290, 118, 'Terminal MPDV-MX-491', 'Inyección', 'La terminal no esta cambiando de status ', '2024-06-07 07:57:33', 'En espera...', 'Junio', NULL, NULL),
(291, 2, 'Legic Card de Terminal MPDV-MX-317', 'Recepción', 'No reconoce la tarjeta del operador ', '2024-06-10 16:24:29', 'En espera...', 'Junio', NULL, NULL),
(292, 85, 'Terminal MPDV-MX-498', 'Moldes de Flexión', ' ingreso de ordenes incorrectas', '2024-06-12 10:04:12', 'En espera...', 'Junio', NULL, NULL),
(293, 41, 'Terminal MPDV-MX-494', 'Vacio', 'La terminal no esta cambiando de status ', '2024-06-17 08:10:01', 'En espera...', 'Junio', NULL, NULL),
(294, 124, 'Scanner de Terminal MPDV-MX-491', 'Inyección', 'No escanea ', '2024-06-18 07:57:28', 'Aceptada', 'Junio', '2024-07-05 12:01:00', 'mx-azarate'),
(295, 108, 'Scanner de Terminal MPDV-MX-316', 'Inyección', 'No escanea ', '2024-06-28 07:33:17', 'Aceptada', 'Junio', '2024-07-05 11:54:31', 'mx-azarate'),
(296, 124, 'Scanner de Terminal MPDV-MX-491', 'Inyección', 'No escanea ', '2024-07-05 08:06:29', 'Aceptada', 'Julio', '2024-07-05 19:51:32', 'mx-rpablo '),
(297, 69, 'Scanner de Terminal MPDV-MX-492', 'Carbón', 'No escanea ', '2024-07-08 08:32:03', 'En espera...', 'Julio', NULL, NULL),
(298, 43, 'Scanner de Terminal MPDV-MX-494', 'Vacio', 'No escanea ', '2024-07-08 08:35:27', 'En espera...', 'Julio', NULL, NULL),
(299, 144, 'Terminal MPDV-MX-498', 'Moldes de Flexión', 'La terminal no esta prendida ', '2024-07-08 08:45:20', 'En espera...', 'Julio', NULL, NULL),
(301, 34, 'Terminal MPDV-MX-497 ', 'Extrucción', 'Terminal pasmada ', '2024-07-11 08:09:05', 'En espera...', 'julio', NULL, NULL),
(302, 37, 'GARBURG ME53', 'Extrucción', 'Salen lineas en las etiquetas ', '2024-07-11 08:10:21', 'En espera...', 'julio', NULL, NULL),
(303, 90, 'Terminal MPDV-MX-312', 'Soplado', 'La terminal no esta cambiando de status ', '2024-07-15 08:23:28', 'En espera...', 'julio', NULL, NULL),
(304, 147, 'GARBURG ME41', 'Embarques PT', 'No imprime ', '2024-07-15 08:38:27', 'En espera...', 'julio', NULL, NULL),
(305, 72, 'Scanner de Terminal MPDV-MX-493', 'Carbón', 'No escanea ', '2024-07-18 08:04:10', 'Aceptada', 'julio', '2024-07-22 19:32:14', 'mx-azarate'),
(306, 63, 'Scanner de Terminal MPDV-MX-481', 'Carbón', 'No escanea', '2024-08-07 14:43:39', 'En espera...', 'agosto', NULL, NULL),
(312, 2, 'Legic Card de Terminal MPDV-MX-317', 'Recepción', 'No se seleccionó ', '2024-08-12 17:48:21', 'En espera...', 'Agosto', NULL, NULL),
(322, 1, 'Terminal MPDV-MX-317', 'Recepción', 'No funciona el touch ', '2024-08-16 12:49:51', 'Aceptada', 'Agosto', '2024-08-19 11:36:49', 'mx-azarate'),
(329, 137, 'Terminal MPDV-MX-499', 'Bodega ', 'Aplicación cerrada ', '2024-08-21 11:38:12', 'En espera...', '', NULL, NULL),
(330, 1, 'Terminal MPDV-MX-317', 'Recepción', 'Aplicación cerrada ', '2024-08-22 11:44:44', 'Aceptada', '', '2024-08-22 11:53:45', 'mx-azarate'),
(331, 7, 'Basculas', 'Hornos de Flexión', 'No abre SAP ', '2024-09-04 15:57:34', 'En espera...', '', NULL, NULL),
(332, 1, 'Terminal MPDV-MX-317', 'Recepción', 'La terminal no tiene red  (C6A )', '2024-09-04 18:26:07', 'En espera...', '', NULL, NULL),
(333, 132, 'Basculas ', 'Inyección', 'Área con obstrucción de paso  (C5B)', '2024-09-04 18:27:40', 'En espera...', '', NULL, NULL),
(334, 1, 'Terminal MPDV-MX-317', 'Recepción', 'No se puede acceder a la terminal  (C7A)', '2024-09-05 10:46:22', 'En espera...', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `dia_checklist` date DEFAULT NULL,
  `elemento` varchar(255) NOT NULL,
  `descripcion` text,
  `lunes` date DEFAULT NULL,
  `martes` date DEFAULT NULL,
  `miercoles` date DEFAULT NULL,
  `jueves` date DEFAULT NULL,
  `viernes` date DEFAULT NULL,
  `reporte` text,
  `semana_actual` int(11) DEFAULT NULL,
  `Identificador` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `fecha`, `area`, `dia_checklist`, `elemento`, `descripcion`, `lunes`, `martes`, `miercoles`, `jueves`, `viernes`, `reporte`, `semana_actual`, `Identificador`) VALUES
(1, '2024-03-25', 'Recepción ', '2024-04-22', 'TNR 317', 'Revision Visual, TouchScreen, red, Pulsos(Color adecuado en Maquinas), Altas y Bajas de OP´s', NULL, NULL, NULL, NULL, NULL, '', 20, 'Re'),
(2, '2024-03-25', 'Flexión', '2024-04-22', 'TNR 497', 'Revision Visual, TouchScreen, red, Pulsos(Color adecuado en Maquinas), Altas y Bajas de OP´s', NULL, NULL, NULL, NULL, NULL, '', 20, 'Fl'),
(3, '2024-03-27', 'Flexión', '0000-00-00', 'Impresora Garburg m73', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, '', 20, 'Fl'),
(4, '2024-03-27', 'Flexión', NULL, 'Lectores de Barras', 'Lectura correcta de códigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Fl'),
(5, '2024-03-27', 'Flexión', NULL, 'Scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Fl'),
(6, '2024-03-27', 'Flexión', NULL, 'Basculas Materialista', 'Tara ok, Referencia	', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Fl'),
(7, '2024-03-27', 'Stepp', NULL, 'TNR 315', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(8, '2024-03-27', 'Stepp	', NULL, 'TNR 486', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(9, '2024-03-27', 'Stepp', NULL, 'TNR 488', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(10, '2024-03-27', 'Stepp', NULL, 'Lectores de barras	', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(12, '2024-03-27', 'Stepp', NULL, 'Impresora Garburg s/n', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(13, '2024-03-27', 'Stepp', '0000-00-00', 'Impresora Garburg s/n', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(14, '2024-03-27', 'Stepp', NULL, 'Impresora Garburg ME74', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(15, '2024-03-27', 'Stepp', NULL, 'Impresora Garburg ME15', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(16, '2024-03-27', 'Stepp', NULL, 'Impresora Garburg ME10', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(17, '2024-03-27', 'Stepp', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'St'),
(18, '2024-03-27', 'Vacio', NULL, 'TNR 307', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(19, '2024-03-27', 'Vacio', NULL, 'TNR 494', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(20, '2024-03-27', 'Vacio', NULL, 'Lectores de Barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(21, '2024-03-27', 'Vacio', NULL, 'Impresora Garburg ME14', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(22, '2024-03-27', 'Vacio', NULL, 'Impresora Garburg ME18', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(23, '2024-03-27', 'Vacio', NULL, 'Impresora Garburg ME08', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(24, '2024-03-27', 'Vacio', NULL, 'Impresora Garburg ME19', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(25, '2024-03-27', 'Vacio', NULL, 'Impresora Garburg ME07', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(26, '2024-03-27', 'Vacio', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(27, '2024-03-27', 'Vacio', NULL, 'Vacio Area', 'Tara ok, Referencia		', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Va'),
(28, '2024-03-27', 'Mezzanine', NULL, 'Impresora Garburg ME12', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Me'),
(29, '2024-03-27', 'Extrucción	', NULL, 'TNR 497', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ex'),
(30, '2024-04-01', 'Extruccón', NULL, 'Impresora Garburg ME73', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ex'),
(31, '2024-03-27', 'Extrucción', NULL, 'Lectores de Barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ex'),
(32, '2024-03-27', 'Extrucción', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario ', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ex'),
(33, '2024-03-27', 'Almacenistas Carbón', NULL, 'Impresora Garburg ME17', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ac'),
(34, '2024-03-27', 'Carbón', NULL, 'TNR 481', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(35, '2024-03-27', 'Carbón', NULL, 'TNR 490', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(36, '2024-03-27', 'Carbón', NULL, 'TNR 492', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(37, '2024-03-27', 'Carbón ', NULL, 'TNR 493', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(38, '2024-03-27', 'Carbón', NULL, 'TNR 495', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(39, '2024-03-27', 'Carbón', NULL, 'Lectores de Barras', 'Lectura correcta de códigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(40, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg s/n', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(41, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg ME09', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(42, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg ME13', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(43, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg S/N', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(44, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg AUDI', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(45, '2024-04-01', 'Carbón', NULL, 'Impresora Garburg S/N', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(46, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg S/N', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(47, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg S/N', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(48, '2024-03-27', 'Carbón', NULL, 'Impresora Garburg S/N', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(49, '2024-03-27', 'Carbón', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ca'),
(50, '2024-03-27', 'Inyección	', NULL, 'TNR 316', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(51, '2024-03-27', 'Inyección', NULL, 'TNR 322', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(52, '2024-03-27', 'Inyección', NULL, 'TNR 480', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(53, '2024-03-27', 'Inyección', NULL, 'TNR 484', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(54, '2024-03-27', 'Inyección', NULL, 'TNR 491', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(55, '2024-03-27', 'Inyección', NULL, 'TNR 496', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(56, '2024-03-27', 'Inyección', NULL, 'Lectores de Barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(57, '2024-03-27', 'Inyección', NULL, 'Impresora Garburg ME16', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(58, '2024-03-27', 'Inyección', NULL, 'Impresora Garburg ME03', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(59, '2024-03-27', 'Inyección', NULL, 'Impresora Garburg N/A', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(60, '2024-03-27', 'Inyección', NULL, 'Impresora Garburg N/A', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(61, '2024-03-27', 'Inyección', NULL, 'Impresora Garburg ME02', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(62, '2024-03-27', 'Inyección', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(63, '2024-03-27', 'Inyección', NULL, 'Inyeccion Area', 'Tara OK, Refeencia', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'In'),
(64, '2024-03-27', 'Soplado', NULL, 'TNR 309 ', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'So'),
(65, '2024-03-27', 'Soplado', NULL, 'TNR 312 ', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'So'),
(66, '2024-03-27', 'Soplado', NULL, 'Lectores de Barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'So'),
(67, '2024-03-27', 'Soplado', NULL, 'Impresora Garburg ME06', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'So'),
(68, '2024-03-27', 'Soplado', NULL, 'scaners Keyence-Skorpio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, 'So'),
(69, '2024-03-27', 'GP12', NULL, 'TNR 302 ', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Gp'),
(70, '2024-03-27', 'GP12', NULL, 'Lectores de Barras ', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Gp'),
(71, '2024-03-27', 'Conectores	', NULL, 'TNR 323', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Co'),
(72, '2024-03-27', 'Conectores	', NULL, 'TNR 325', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Co'),
(73, '2024-03-27', 'Conectores', NULL, 'TNR 487', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Co'),
(74, '2024-03-27', 'Conectores', NULL, 'Lectores de Barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Co'),
(75, '2024-03-27', 'Conectores', NULL, 'Impresora Garburg ME20', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Co'),
(76, '2024-03-27', 'Bodega', NULL, 'TNR 500', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Bo'),
(77, '2024-03-27', 'Bodega', NULL, 'TNR 499', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Bo'),
(78, '2024-03-27', 'Bodega', NULL, 'Lectores de barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Bo'),
(79, '2024-03-27', 'Moldes de Flexión', NULL, 'TNR 498 ', 'Revision Visual, Touch Screen, Red, Pulsos (Color adecuado en Maquinas), Altas y Bajas de OP\'s', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Mf'),
(80, '2024-03-27', 'Moldes de Flexión', NULL, 'Lectores de barras', 'Lectura correcta de codigos', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Mf'),
(81, '2024-03-27', 'Aduana Logística', NULL, 'Impresora Garburg ME42', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ad'),
(82, '2024-03-27', 'Aduana Logística', NULL, 'Impresora Garburg ME52', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ad'),
(83, '2024-04-01', 'Aduana Logística', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ad'),
(84, '2024-04-01', 'Embarques PT', NULL, 'Impresora Garburg ME41', 'Revision General de Funcionamiento Mecanico, Red, Consumibles y Prevencion de Fallas por mal uso', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ep'),
(85, '2024-04-01', 'Embarques PT', NULL, 'scaners Keyence-Skorpio', 'Revisar Funcionalidad y usuario', NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Ep');

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id` int(11) NOT NULL,
  `elemento_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `NameElemento` varchar(250) DEFAULT NULL,
  `caracteristica1` varchar(255) DEFAULT NULL,
  `caracteristica2` varchar(255) DEFAULT NULL,
  `caracteristica3` varchar(255) DEFAULT NULL,
  `caracteristica4` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `semana` int(11) DEFAULT NULL,
  `identificador` varchar(255) DEFAULT NULL,
  `caracteristica5` varchar(255) DEFAULT NULL,
  `caracteristica6` varchar(255) DEFAULT NULL,
  `caracteristica7` varchar(255) DEFAULT NULL,
  `caracteristica8` varchar(255) DEFAULT NULL,
  `caracteristica9` varchar(255) DEFAULT NULL,
  `caracteristica10` varchar(255) DEFAULT NULL,
  `caracteristica11` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`id`, `elemento_id`, `area`, `NameElemento`, `caracteristica1`, `caracteristica2`, `caracteristica3`, `caracteristica4`, `fecha`, `semana`, `identificador`, `caracteristica5`, `caracteristica6`, `caracteristica7`, `caracteristica8`, `caracteristica9`, `caracteristica10`, `caracteristica11`) VALUES
(33593, 1, 'Recepción', 'Terminal MPDV-MX-317', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33594, 2, 'Recepción', 'Legic Card de Terminal MPDV-MX-317', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33595, 3, 'Hornos de Flexión', 'Terminal MPDV-MX-497', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33596, 4, 'Hornos de Flexión', 'Legic Card  de Terminal MPDV-MX-497', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33597, 5, 'Hornos de Flexión', 'Scanner de Terminal MPDV-MX-497', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33598, 6, 'Hornos de Flexión', 'GARBURG ME73', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33599, 7, 'Hornos de Flexión', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33600, 8, 'Hornos de Flexión', 'Scanner Keyence-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33601, 18, 'Stepp', 'Terminal MPDV-MX-315', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33602, 19, 'Stepp', 'Legic Card de Terminal MPDV-MX-315', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33603, 20, 'Stepp', 'Scanner de Terminal MPDV-MX-315', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33604, 21, 'Stepp', 'Terminal MPDV-MX-486', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33605, 22, 'Stepp', 'Legic Card de Terminal MPDV-MX-486', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33606, 23, 'Stepp', 'Scanner de Terminal MPDV-MX-486', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33607, 24, 'Stepp', 'Terminal MPDV-MX-488 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33608, 25, 'Stepp', 'Legic Card de Terminal MPDV-MX-488 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33609, 26, 'Stepp', 'GARBURG ME15', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33610, 27, 'Stepp', 'GARBURG MAQUINA 4010', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33611, 28, 'Stepp', 'GARBURG VARIO III JUNTO A TERMINALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33612, 29, 'Stepp', 'GARBURG MAQUINA 4006', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33613, 30, 'Stepp', 'GARBURG MAQUINA 4005', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33614, 31, 'Stepp', 'GARBURG ME75', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33615, 32, 'Stepp', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33616, 33, 'Stepp', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33617, 34, 'Extrucción', 'Terminal MPDV-MX-497 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33618, 35, 'Extrucción', 'Legic Card de Terminal MPDV-MX-497 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33619, 36, 'Extrucción', 'Scanner de Terminal MPDV-MX-497 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33620, 37, 'Extrucción', 'GARBURG ME53', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33621, 38, 'Vacio', 'Terminal MPDV-MX-307', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33622, 39, 'Vacio', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33623, 40, 'Vacio', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33624, 41, 'Vacio', 'Terminal MPDV-MX-494', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33625, 42, 'Vacio', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33626, 43, 'Vacio', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33627, 44, 'Vacio', 'GARBURG SUP VACIO', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33628, 52, 'Vacio', 'GARBURG ME19', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33629, 53, 'Vacio', 'GARBURG CELULA I', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33630, 54, 'Vacio', 'GARBURG CELULA B', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33631, 55, 'Vacio', 'GARBURG ME18 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33632, 56, 'Vacio', 'GARBURG ME14 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33633, 57, 'Vacio', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33634, 58, 'Vacio', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33635, 59, 'Mezzanine', 'GARBURG ME12', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33636, 60, 'Suaje', 'GARBURG ME71', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33637, 61, 'Carbón', 'Terminal MPDV-MX-481', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33638, 62, 'Carbón', 'Legic Card de Terminal MPDV-MX-481 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33639, 63, 'Carbón', 'Scanner de Terminal MPDV-MX-481 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33640, 64, 'Carbón', 'Terminal MPDV-MX-490', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33641, 65, 'Carbón', 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33642, 66, 'Carbón', 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33643, 67, 'Carbón', 'Terminal MPDV-MX-492', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33644, 68, 'Carbón', 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33645, 69, 'Carbón', 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33646, 70, 'Carbón', 'Terminal MPDV-MX-493', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33647, 71, 'Carbón', 'Legic Card de Terminal MPDV-MX-493', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33648, 72, 'Carbón', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33649, 73, 'Carbón', 'Terminal MPDV-MX-495', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33650, 74, 'Carbón', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33651, 75, 'Carbón', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33652, 76, 'Carbón', 'GARBURG ATORNILLADORA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33653, 77, 'Carbón', 'GARBURG ME17 MATERIALISTA CORTINA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33654, 78, 'Carbón', 'GARBURG ZEBRA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33655, 79, 'Carbón', 'GARBURG ME13', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33656, 80, 'Carbón', 'GARBURG ME09', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33657, 84, 'Carbón', 'GARBURG FORD LINEA 2 VARIO III', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33658, 85, 'Carbón', 'GARBURG LINEA 2 VITA II', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33659, 86, 'Carbón', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33660, 87, 'Soplado', 'Terminal MPDV-MX-309 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33661, 88, 'Soplado', 'Legic Card de Terminal MPDV-MX-309 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33662, 89, 'Soplado', 'Scanner de Terminal MPDV-MX-309 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33663, 90, 'Soplado', 'Terminal MPDV-MX-312', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33664, 91, 'Soplado', 'Legic Card de Terminal MPDV-MX-312', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33665, 92, 'Soplado', 'Scanner de Terminal MPDV-MX-312', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33666, 93, 'Soplado', 'GARBURG ME06', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33667, 94, 'Soplado', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33668, 95, 'Conectores', 'Terminal MPDV-MX-323', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33669, 96, 'Conectores', 'Legic Card  de Terminal MPDV-MX-323', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33670, 97, 'Conectores', 'Scanner de Terminal MPDV-MX-323', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33671, 98, 'Conectores', 'Terminal MPDV-MX-325', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33672, 99, 'Conectores', 'Legic Card de Terminal MPDV-MX-325', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33673, 100, 'Conectores', 'Scanner de Terminal MPDV-MX-325', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33674, 101, 'Conectores', 'Terminal MPDV-MX-487', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33675, 102, 'Conectores', 'Legic Card de Terminal MPDV-MX-487', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33676, 103, 'Conectores', 'Scanner de Terminal MPDV-MX-487', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33677, 104, 'Conectores', 'GARBURG ME20', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33678, 105, 'Conectores', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33679, 106, 'Inyección', 'Terminal MPDV-MX-316', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33680, 107, 'Inyección', 'Legic Card de Terminal MPDV-MX-316', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33681, 108, 'Inyección', 'Scanner de Terminal MPDV-MX-316', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33682, 109, 'Inyección', 'Terminal MPDV-MX-322', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33683, 110, 'Inyección', 'Legic Card de Terminal MPDV-MX-322', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33684, 111, 'Inyección', 'Scanner de Terminal MPDV-MX-322', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33685, 112, 'Inyección', 'Terminal MPDV-MX-480 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33686, 113, 'Inyección', 'Legic Card de Terminal MPDV-MX-480 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33687, 114, 'Inyección', 'Scanner de Terminal MPDV-MX-480 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33688, 115, 'Inyección', 'Terminal MPDV-MX-484', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33689, 116, 'Inyección', 'Legic Card de Terminal MPDV-MX-484', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33690, 117, 'Inyección', 'Scanner de Terminal MPDV-MX-484', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33691, 118, 'Inyección', 'Terminal MPDV-MX-491', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33692, 119, 'Inyección', 'Legic Card de Terminal MPDV-MX-491', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33693, 124, 'Inyección', 'Scanner de Terminal MPDV-MX-491', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33694, 125, 'Inyección', 'Terminal MPDV-MX-496', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33695, 126, 'Inyección', 'Legic Scanner de Terminal MPDV-MX-496', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33696, 127, 'Inyección', 'Scanner de Terminal MPDV-MX-496', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33697, 128, 'Inyección', 'GARBURG ME02', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33698, 129, 'Inyección', 'GARBURG ME16', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33699, 130, 'Inyección', 'GARBURG ME03', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33700, 131, 'Inyección', 'GARBURG INYECTORA 14', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33701, 132, 'Inyección', 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33702, 133, 'Inyección', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33703, 134, 'GP12', 'Terminal MPDV-MX-302', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33704, 135, 'GP12', 'Legic Card de Terminal MPDV-MX-302 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33705, 136, 'GP12', 'Scanner de Terminal MPDV-MX-302', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33706, 137, 'Bodega', 'Terminal MPDV-MX-499', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33707, 138, 'Bodega', 'Legic Card de Terminal MPDV-MX-499', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33708, 139, 'Bodega', 'Scanner de Terminal MPDV-MX-499', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33709, 140, 'Bodega ', 'Terminal MPDV-MX-500', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33710, 141, 'Bodega', 'Legic Card Terminal MPDV-MX-500', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33711, 142, 'Bodega ', 'Scanner de Terminal MPDV-MX-500', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33712, 143, 'Bodega', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33713, 144, 'Moldes de Flexión', 'Terminal MPDV-MX-498', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-08', 32, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33714, 145, 'Moldes de Flexión', 'Legic Card de Terminal MPDV-MX-498', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33715, 146, 'Moldes de Flexión', 'Scanner de Terminal MPDV-MX-498', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33716, 147, 'Embarques PT', 'GARBURG ME41', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-08', 32, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33717, 148, 'Embarques PT', 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-08', 32, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33718, 149, 'Embarques PT', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-08', 32, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33719, 1, 'Recepción', 'Terminal MPDV-MX-317', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', '2024-08-13', '2024-08-19', 34, 'TNR', 'No funciona el Touch de la terminal', 'Error al introducir la orden', '2024-08-09', 'Tiene pegado etiquetas que no corresponden', '2024-08-13', 'no aplica', 'no aplica'),
(33720, 2, 'Recepción', 'Legic Card de Terminal MPDV-MX-317', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, 'SC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33721, 3, 'Hornos de Flexión', 'Terminal MPDV-MX-497', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33722, 4, 'Hornos de Flexión', 'Legic Card  de Terminal MPDV-MX-497', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33723, 5, 'Hornos de Flexión', 'Scanner de Terminal MPDV-MX-497', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33724, 6, 'Hornos de Flexión', 'GARBURG ME73', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33725, 7, 'Hornos de Flexión', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33726, 8, 'Hornos de Flexión', 'Scanner Keyence-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33727, 18, 'Stepp', 'Terminal MPDV-MX-315', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33728, 19, 'Stepp', 'Legic Card de Terminal MPDV-MX-315', '2024-08-12', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33729, 20, 'Stepp', 'Scanner de Terminal MPDV-MX-315', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33730, 21, 'Stepp', 'Terminal MPDV-MX-486', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33731, 22, 'Stepp', 'Legic Card de Terminal MPDV-MX-486', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33732, 23, 'Stepp', 'Scanner de Terminal MPDV-MX-486', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33733, 24, 'Stepp', 'Terminal MPDV-MX-488 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33734, 25, 'Stepp', 'Legic Card de Terminal MPDV-MX-488 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33735, 26, 'Stepp', 'GARBURG ME15', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33736, 27, 'Stepp', 'GARBURG MAQUINA 4010', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33737, 28, 'Stepp', 'GARBURG VARIO III JUNTO A TERMINALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33738, 29, 'Stepp', 'GARBURG MAQUINA 4006', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33739, 30, 'Stepp', 'GARBURG MAQUINA 4005', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33740, 31, 'Stepp', 'GARBURG ME75', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste');
INSERT INTO `backup` (`id`, `elemento_id`, `area`, `NameElemento`, `caracteristica1`, `caracteristica2`, `caracteristica3`, `caracteristica4`, `fecha`, `semana`, `identificador`, `caracteristica5`, `caracteristica6`, `caracteristica7`, `caracteristica8`, `caracteristica9`, `caracteristica10`, `caracteristica11`) VALUES
(33741, 32, 'Stepp', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33742, 33, 'Stepp', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33743, 34, 'Extrucción', 'Terminal MPDV-MX-497 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33744, 35, 'Extrucción', 'Legic Card de Terminal MPDV-MX-497 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33745, 36, 'Extrucción', 'Scanner de Terminal MPDV-MX-497 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33746, 37, 'Extrucción', 'GARBURG ME53', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33747, 38, 'Vacio', 'Terminal MPDV-MX-307', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33748, 39, 'Vacio', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33749, 40, 'Vacio', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33750, 41, 'Vacio', 'Terminal MPDV-MX-494', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33751, 42, 'Vacio', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33752, 43, 'Vacio', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33753, 44, 'Vacio', 'GARBURG SUP VACIO', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33754, 52, 'Vacio', 'GARBURG ME19', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33755, 53, 'Vacio', 'GARBURG CELULA I', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33756, 54, 'Vacio', 'GARBURG CELULA B', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33757, 55, 'Vacio', 'GARBURG ME18 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33758, 56, 'Vacio', 'GARBURG ME14 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33759, 57, 'Vacio', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33760, 58, 'Vacio', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33761, 59, 'Mezzanine', 'GARBURG ME12', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33762, 60, 'Suaje', 'GARBURG ME71', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33763, 61, 'Carbón', 'Terminal MPDV-MX-481', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33764, 62, 'Carbón', 'Legic Card de Terminal MPDV-MX-481 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33765, 63, 'Carbón', 'Scanner de Terminal MPDV-MX-481 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33766, 64, 'Carbón', 'Terminal MPDV-MX-490', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33767, 65, 'Carbón', 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33768, 66, 'Carbón', 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33769, 67, 'Carbón', 'Terminal MPDV-MX-492', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33770, 68, 'Carbón', 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33771, 69, 'Carbón', 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33772, 70, 'Carbón', 'Terminal MPDV-MX-493', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33773, 71, 'Carbón', 'Legic Card de Terminal MPDV-MX-493', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33774, 72, 'Carbón', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33775, 73, 'Carbón', 'Terminal MPDV-MX-495', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33776, 74, 'Carbón', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33777, 75, 'Carbón', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33778, 76, 'Carbón', 'GARBURG ATORNILLADORA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33779, 77, 'Carbón', 'GARBURG ME17 MATERIALISTA CORTINA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33780, 78, 'Carbón', 'GARBURG ZEBRA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33781, 79, 'Carbón', 'GARBURG ME13', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33782, 80, 'Carbón', 'GARBURG ME09', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33783, 84, 'Carbón', 'GARBURG FORD LINEA 2 VARIO III', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33784, 85, 'Carbón', 'GARBURG LINEA 2 VITA II', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33785, 86, 'Carbón', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33786, 87, 'Soplado', 'Terminal MPDV-MX-309 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33787, 88, 'Soplado', 'Legic Card de Terminal MPDV-MX-309 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33788, 89, 'Soplado', 'Scanner de Terminal MPDV-MX-309 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33789, 90, 'Soplado', 'Terminal MPDV-MX-312', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33790, 91, 'Soplado', 'Legic Card de Terminal MPDV-MX-312', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33791, 92, 'Soplado', 'Scanner de Terminal MPDV-MX-312', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33792, 93, 'Soplado', 'GARBURG ME06', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33793, 94, 'Soplado', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33794, 95, 'Conectores', 'Terminal MPDV-MX-323', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33795, 96, 'Conectores', 'Legic Card  de Terminal MPDV-MX-323', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33796, 97, 'Conectores', 'Scanner de Terminal MPDV-MX-323', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33797, 98, 'Conectores', 'Terminal MPDV-MX-325', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33798, 99, 'Conectores', 'Legic Card de Terminal MPDV-MX-325', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33799, 100, 'Conectores', 'Scanner de Terminal MPDV-MX-325', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33800, 101, 'Conectores', 'Terminal MPDV-MX-487', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33801, 102, 'Conectores', 'Legic Card de Terminal MPDV-MX-487', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33802, 103, 'Conectores', 'Scanner de Terminal MPDV-MX-487', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33803, 104, 'Conectores', 'GARBURG ME20', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33804, 105, 'Conectores', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33805, 106, 'Inyección', 'Terminal MPDV-MX-316', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33806, 107, 'Inyección', 'Legic Card de Terminal MPDV-MX-316', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33807, 108, 'Inyección', 'Scanner de Terminal MPDV-MX-316', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33808, 109, 'Inyección', 'Terminal MPDV-MX-322', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33809, 110, 'Inyección', 'Legic Card de Terminal MPDV-MX-322', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33810, 111, 'Inyección', 'Scanner de Terminal MPDV-MX-322', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33811, 112, 'Inyección', 'Terminal MPDV-MX-480 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33812, 113, 'Inyección', 'Legic Card de Terminal MPDV-MX-480 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33813, 114, 'Inyección', 'Scanner de Terminal MPDV-MX-480 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33814, 115, 'Inyección', 'Terminal MPDV-MX-484', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33815, 116, 'Inyección', 'Legic Card de Terminal MPDV-MX-484', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33816, 117, 'Inyección', 'Scanner de Terminal MPDV-MX-484', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33817, 118, 'Inyección', 'Terminal MPDV-MX-491', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33818, 119, 'Inyección', 'Legic Card de Terminal MPDV-MX-491', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33819, 124, 'Inyección', 'Scanner de Terminal MPDV-MX-491', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33820, 125, 'Inyección', 'Terminal MPDV-MX-496', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33821, 126, 'Inyección', 'Legic Scanner de Terminal MPDV-MX-496', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33822, 127, 'Inyección', 'Scanner de Terminal MPDV-MX-496', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33823, 128, 'Inyección', 'GARBURG ME02', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33824, 129, 'Inyección', 'GARBURG ME16', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33825, 130, 'Inyección', 'GARBURG ME03', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33826, 131, 'Inyección', 'GARBURG INYECTORA 14', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33827, 132, 'Inyección', 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33828, 133, 'Inyección', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33829, 134, 'GP12', 'Terminal MPDV-MX-302', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33830, 135, 'GP12', 'Legic Card de Terminal MPDV-MX-302 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33831, 136, 'GP12', 'Scanner de Terminal MPDV-MX-302', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33832, 137, 'Bodega', 'Terminal MPDV-MX-499', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33833, 138, 'Bodega', 'Legic Card de Terminal MPDV-MX-499', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33834, 139, 'Bodega', 'Scanner de Terminal MPDV-MX-499', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33835, 140, 'Bodega ', 'Terminal MPDV-MX-500', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33836, 141, 'Bodega', 'Legic Card Terminal MPDV-MX-500', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33837, 142, 'Bodega ', 'Scanner de Terminal MPDV-MX-500', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33838, 143, 'Bodega', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33839, 144, 'Moldes de Flexión', 'Terminal MPDV-MX-498', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-08-19', 34, NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica'),
(33840, 145, 'Moldes de Flexión', 'Legic Card de Terminal MPDV-MX-498', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33841, 146, 'Moldes de Flexión', 'Scanner de Terminal MPDV-MX-498', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33842, 147, 'Embarques PT', 'GARBURG ME41', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', '2024-08-19', 34, NULL, 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste'),
(33843, 148, 'Embarques PT', 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-08-19', 34, NULL, 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica'),
(33844, 149, 'Embarques PT', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', '2024-08-19', 34, NULL, 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica');

-- --------------------------------------------------------

--
-- Table structure for table `check_fallas`
--

CREATE TABLE `check_fallas` (
  `id` int(11) NOT NULL,
  `falla_id` int(11) DEFAULT NULL,
  `fallaname` varchar(255) DEFAULT NULL,
  `identificador_caract` varchar(255) DEFAULT NULL,
  `identificador_elemento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `check_fallas`
--

INSERT INTO `check_fallas` (`id`, `falla_id`, `fallaname`, `identificador_caract`, `identificador_elemento`) VALUES
(1, 1, 'No funciona el touch ', 'C1A', 'TNRA'),
(2, 2, 'Se encuentra apagada ', 'C2A', 'TNRA'),
(3, 2, 'Terminal pasmada ', 'C2A', 'TNRA'),
(4, 3, 'Aplicación cerrada ', 'C3A', 'TNRA'),
(5, 4, 'Error al leer la orden ', 'C4A', 'TNRA'),
(6, 4, 'No registra la orden ', 'C4A', 'TNRA'),
(7, 5, 'Tiene rayón ', 'C5A', 'TNRA'),
(9, 5, 'Esta pintada con plumón ', 'C5A', 'TNRA'),
(10, 5, 'Tiene etiquetas que no corresponden ', 'C5A', 'TNRA'),
(11, 7, 'Aplicación esta en rojo', 'C6A ', 'TNRA'),
(12, 7, 'La terminal no tiene red ', 'C6A ', 'TNRA'),
(13, 9, 'Material colocado frente de la terminal ', 'C7A', 'TNRA'),
(14, 9, 'No se puede acceder a la terminal ', 'C7A', 'TNRA'),
(15, 47, 'No funciona el Touch ', 'C1M', 'TNRM'),
(16, 47, 'Se encuentra apagada ', 'C1M', 'TNRM'),
(17, 47, 'Aplicación cerrada ', 'C1M', 'TNRM'),
(18, 47, 'Terminal pasmada', 'C1M', 'TNRM'),
(19, 48, 'Maquina en rojo ', 'C2M', 'TNRM'),
(20, 49, 'Ninguna cambia de estatus ', 'C3M ', 'TNRM'),
(21, 49, 'No cambia a producción ', 'C3M ', 'TNRM'),
(22, 50, 'Tiene rayón ', 'C4M ', 'TNRM'),
(23, 50, 'Esta pintada con plumón ', 'C4M ', 'TNRM'),
(24, 50, 'Tiene etiquetas que no corresponden', 'C4M', 'TNRM'),
(25, 51, 'Error al leer la orden ', 'C5M', 'TNRM'),
(26, 51, 'No registra la orden ', 'C5M', 'TNRM'),
(27, 52, 'La aplicación esta en rojo ', 'C6M', 'TNRM'),
(28, 52, 'La terminal no tiene red ', 'C6M', 'TNRM'),
(29, 53, 'Material colocado frente de la terminal', 'C7M', 'TNRM'),
(30, 53, 'No se puede acceder a la terminal ', 'C7M', 'TNRM'),
(31, 19, 'Scanner apagado, no prende.', 'C1S ', 'SC'),
(32, 22, 'No lee las ordenes ', 'C2S ', 'SC'),
(33, 10, 'No se encunetra en su lugar ', 'C3S ', 'SC'),
(34, 11, 'La terminal no detecta el Scanner ', 'C4S ', 'SC'),
(35, 11, 'Scanner pasmado ', 'C4S', 'SC'),
(36, 40, 'No Scannea ', 'C1SK', 'SCK'),
(37, 44, 'Sin conexión a red ', 'C2SK', 'SCK'),
(38, 41, 'Scanner no prende ', 'C3SK ', 'SCK'),
(39, 14, 'No funciona el legic ', 'C1L', 'LG'),
(40, 15, 'No lee tarjetas ', 'C2L', 'LG'),
(41, 17, 'No lo detecta la terminal ', 'C3L', 'LG'),
(42, 17, 'Apagado (no prende el foquito) ', 'C3L', 'LG'),
(43, 21, 'No salen etiquetas ', 'C1G ', 'GR'),
(44, 21, 'Etiqueta atorada ', 'C1G ', 'GR'),
(45, 21, 'Salen líneas en las etiquetas ', 'C1G ', 'GR'),
(46, 21, 'No imprime nada ', 'C1G ', 'GR'),
(47, 25, 'no funciona el cortador', 'C2G', 'GR'),
(48, 25, 'no corta correctamente', 'C2G', 'GR'),
(49, 26, 'pantalla rota', 'C3G', 'GR'),
(50, 26, 'esta pintada', 'C3G', 'GR'),
(51, 26, 'no tiene la etiqueta de identificacion', 'C3G', 'GR'),
(52, 26, 'faltan tornillos', 'C3G', 'GR'),
(53, 26, 'no tiene la palanquita roja', 'C3G', 'GR'),
(54, 26, 'puertos dañados', 'C3G', 'GR'),
(55, 27, 'No tiene red ', 'C4G', 'GR'),
(56, 28, 'Área con obstrucción de paso ', 'C5G', 'GR'),
(57, 37, 'No Tara OK', 'C1B', 'BS'),
(58, 38, 'No abre SAP ', 'C2B', 'BS'),
(59, 39, 'Sin conexión a Red ', 'C3B', 'BS'),
(60, 36, 'Sin conexión al servidor MTOPC ', 'C4B', 'BS'),
(61, 35, 'Área con obstrucción de paso ', 'C5B', 'BS'),
(62, 6, 'Derrame de liquidos', 'C8A', 'TNRA'),
(63, 54, 'Derrame de liquidos', 'C8M', 'TNRM');

-- --------------------------------------------------------

--
-- Table structure for table `elementos`
--

CREATE TABLE `elementos` (
  `id` int(11) NOT NULL,
  `NameElemento` varchar(255) DEFAULT NULL,
  `Falla1` int(11) DEFAULT NULL,
  `Falla2` int(11) DEFAULT NULL,
  `Falla3` int(11) DEFAULT NULL,
  `Falla4` int(11) DEFAULT NULL,
  `Falla5` int(11) DEFAULT NULL,
  `Falla6` int(11) DEFAULT NULL,
  `Falla7` int(11) DEFAULT NULL,
  `Falla8` int(11) DEFAULT NULL,
  `Falla9` int(11) DEFAULT NULL,
  `Falla10` int(11) DEFAULT NULL,
  `Falla11` int(11) DEFAULT NULL,
  `Falla12` int(11) DEFAULT NULL,
  `areas` varchar(255) DEFAULT NULL,
  `identificador_elemento` varchar(11) DEFAULT NULL,
  `name_identificador` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `identificador_caract` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `elementos`
--

INSERT INTO `elementos` (`id`, `NameElemento`, `Falla1`, `Falla2`, `Falla3`, `Falla4`, `Falla5`, `Falla6`, `Falla7`, `Falla8`, `Falla9`, `Falla10`, `Falla11`, `Falla12`, `areas`, `identificador_elemento`, `name_identificador`, `user`, `codigo`, `identificador_caract`) VALUES
(1, 'Terminal MPDV-MX-317', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Recepción', 'TNRA', 'Terminal ADE', NULL, 317, NULL),
(2, 'Legic Card de Terminal MPDV-MX-317', 14, 15, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Recepción', 'LG', 'Legic Card ', NULL, 317, NULL),
(3, 'Terminal MPDV-MX-497', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Hornos de Flexión', 'TNRM', 'Terminal MDE', NULL, 497, NULL),
(4, 'Legic Card de Terminal MPDV-MX-497', 14, 15, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hornos de Flexión', 'LG', 'Legic Card ', NULL, 497, NULL),
(5, 'Scanner de Terminal MPDV-MX-497', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hornos de Flexión', 'SC', 'Scanner', NULL, 497, NULL),
(6, 'GARBURG ME73', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hornos de Flexión', 'GR', 'Impresora Garburg ', NULL, NULL, NULL),
(7, 'Basculas', 37, 38, 39, 36, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hornos de Flexión', 'BS', 'Basculas', NULL, NULL, NULL),
(8, 'Scanner Keyence-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Hornos de Flexión', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(18, 'Terminal MPDV-MX-315', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'TNRM', 'Terminal MDE', NULL, 315, NULL),
(19, 'Legic Card de Terminal 315', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'LG', 'Legic Card', NULL, 315, NULL),
(20, 'Scanner de Terminal 315', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'SC', 'Scanner', NULL, 315, NULL),
(21, 'Terminal MPDV-MX-486', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'TNRA', 'Terminal ADE', NULL, 486, NULL),
(22, 'Legic Card de Terminal 486', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'LG', 'Legic Card', NULL, 486, NULL),
(23, 'Scanner de Terminal 486', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'SC', 'Scanner', NULL, 486, NULL),
(24, 'Terminal MPDV-MX-488 ', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'TNRA', 'Terminal ADE', NULL, 488, NULL),
(25, 'Legic Card de Terminal 488 ', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'LG', 'Legic Card', NULL, 488, NULL),
(26, 'GARBURG ME15', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(27, 'GARBURG MAQUINA 4010', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(28, 'GARBURG VARIO III junto a terminales', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(29, 'GARBURG MAQUINA 4006', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(30, 'GARBURG MAQUINA 4005', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(31, 'GARBURG ME75', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(32, 'Basculas', 37, 38, 39, 36, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'BS', 'Basculas', NULL, NULL, NULL),
(33, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stepp', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(34, 'Terminal MPDV-MX-489', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Extrucción', 'TNRM', 'Terminal MDE', NULL, 497, NULL),
(35, 'Legic Card de Terminal MPDV-MX-497 ', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Extrucción', 'LG', 'Legic Card', NULL, 497, NULL),
(36, 'Scanner de Terminal MPDV-MX-497 ', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Extrucción', 'SC', 'Scanner', NULL, 497, NULL),
(37, 'GARBURG ME53', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Extrucción', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(38, 'Terminal MPDV-MX-307', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'TNRA', 'Terminal ADE', NULL, 307, NULL),
(39, 'Legic Card de Terminal MPDV-MX-307', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'LG', 'Legic Card', NULL, 307, NULL),
(40, 'Scanner de Terminal MPDV-MX-307', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'SC', 'Scanner', NULL, 307, NULL),
(41, 'Terminal MPDV-MX-494', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'TNRA', 'Terminal ADE', NULL, 494, NULL),
(42, 'Legic Card de Terminal MPDV-MX-494', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'LG', 'Legic Card', NULL, 494, NULL),
(43, 'Scanner de Terminal MPDV-MX-494', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'SC', 'Scanner', NULL, 494, NULL),
(44, 'GARBURG SUP VACIO', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(52, 'GARBURG ME19', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(53, 'GARBURG CELULA I', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(54, 'GARBURG CELULA B', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(55, 'GARBURG ME18 MATERIALES', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(56, 'GARBURG ME14 MATERIALES', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(57, 'Basculas', 37, 38, 39, 36, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'BS', 'Basculas', NULL, NULL, NULL),
(58, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vacio', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(59, 'GARBURG ME12', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mezzanine', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(60, 'GARBURG ME71', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suaje', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(61, 'Terminal MPDV-MX-481', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'TNRM', 'Terminal MDE', NULL, 481, NULL),
(62, 'Legic Card de Terminal MPDV-MX-481', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'LG', 'Legic Card', NULL, 481, NULL),
(63, 'Scanner de Terminal MPDV-MX-481', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'SC', 'Scanner', NULL, 481, NULL),
(64, 'Terminal MPDV-MX-490', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'TNRM', 'Terminal MDE', NULL, 490, NULL),
(65, 'Legic Card de Terminal MPDV-MX-490', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'LG', 'Legic Card', NULL, 490, NULL),
(66, 'Scanner de Terminal MPDV-MX-490', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'SC', 'Scanner', NULL, 490, NULL),
(67, 'Terminal MPDV-MX-492', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'TNRM', 'Terminal MDE', NULL, 492, NULL),
(68, 'Legic Card de Terminal MPDV-MX-492', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'LG', 'Legic Card', NULL, 492, NULL),
(69, 'Scanner de Terminal MPDV-MX-492', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'SC', 'Scanner', NULL, 492, NULL),
(70, 'Terminal MPDV-MX-493', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'TNRA', 'Terminal ADE', NULL, 493, NULL),
(71, 'Legic Card de Terminal MPDV-MX-493', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'LG', 'Legic Card', NULL, 493, NULL),
(72, 'Scanner de Terminal MPDV-MX-493', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'SC', 'Scanner', NULL, 493, NULL),
(73, 'Terminal MPDV-MX-495', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'TNRA', 'Terminal ADE', NULL, 495, NULL),
(74, 'Legic Card de Terminal MPDV-MX-495', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'LG', 'Legic Card', NULL, 495, NULL),
(75, 'Scanner de Terminal MPDV-MX-495', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'SC', 'Scanner', NULL, 495, NULL),
(76, 'GARBURG ATORNILLADORA', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(77, 'GARBURG ME17 MATERIALISTA CORTINA', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(78, 'GARBURG ZEBRA', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(79, 'GARBURG ME13', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(80, 'GARBURG ME09', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(84, 'GARBURG FORD LINEA 2 VARIO III', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(85, 'GARBURG LINEA 2 VITA II', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(86, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Carbón', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(87, 'Terminal MPDV-MX-309 ', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'TNRA', 'Terminal ADE', NULL, 309, NULL),
(88, 'Legic Card de Terminal MPDV-MX-309', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'LG', 'Legic Card', NULL, 309, NULL),
(89, 'Scanner de Terminal MPDV-MX-309', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'SC', 'Scanner', NULL, 309, NULL),
(90, 'Terminal MPDV-MX-312', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'TNRM', 'Terminal MDE', NULL, 312, NULL),
(91, 'Legic Card de Terminal MPDV-MX-312', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'LG', 'Legic Card', NULL, 312, NULL),
(92, 'Scanner de Terminal MPDV-MX-312 ', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'SC', 'Scanner', NULL, 312, NULL),
(93, 'GARBURG ME06', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(94, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Soplado', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(95, 'Terminal MPDV-MX-323', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'TNRM', 'Terminal MDE', NULL, 323, NULL),
(96, 'Legic Card  de Terminal MPDV-MX-323', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'LG', 'Legic Card', NULL, 323, NULL),
(97, 'Scanner de Terminal MPDV-MX-323', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'SC', 'Scanner', NULL, 323, NULL),
(98, 'Terminal MPDV-MX-325', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'TNRA', 'Terminal ADE', NULL, 325, NULL),
(99, 'Legic Card de Terminal MPDV-MX-325', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'LG', 'Legic Card', NULL, 325, NULL),
(100, 'Scanner de Terminal MPDV-MX-325', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'SC', 'Scanner', NULL, 325, NULL),
(101, 'Terminal MPDV-MX-487', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'TNRM', 'Terminal MDE', NULL, 487, NULL),
(102, 'Legic Card de Terminal MPDV-MX-487', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'LG', 'Legic Card', NULL, 487, NULL),
(103, 'Scanner de Terminal MPDV-MX-487', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'SC', 'Scanner', NULL, NULL, NULL),
(104, 'GARBURG ME20', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(105, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Conectores', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(106, 'Terminal MPDV-MX-316', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'TNRA', 'Terminal ADE', NULL, 316, NULL),
(107, 'Legic Card de Terminal MPDV-MX-316', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'LG', 'Legic Card', NULL, 316, NULL),
(108, 'Scanner de Terminal MPDV-MX-316', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SC', 'Scanner', NULL, 316, NULL),
(109, 'Terminal MPDV-MX-322', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'TNRM', 'Terminal MDE', NULL, 322, NULL),
(110, 'Legic Card de Terminal MPDV-MX-322', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'LG', 'Legic Card', NULL, 322, NULL),
(111, 'Scanner de Terminal MPDV-MX-322', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SC', 'Scanner', NULL, 322, NULL),
(112, 'Terminal MPDV-MX-480 ', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'TNRM', 'Terminal MDE', NULL, 480, NULL),
(113, 'Legic Card de Terminal MPDV-MX-480', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'LG', 'Legic Card', NULL, 480, NULL),
(114, 'Scanner de Terminal MPDV-MX-480', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SC', 'Scanner', NULL, 480, NULL),
(115, 'Terminal MPDV-MX-484', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'TNRA', 'Terminal ADE', NULL, 484, NULL),
(116, 'Legic Card de Terminal MPDV-MX-484', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'LG', 'Legic Card', NULL, 484, NULL),
(117, 'Scanner de Terminal MPDV-MX-484 ', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SC', 'Scanner', NULL, 484, NULL),
(118, 'Terminal MPDV-MX-491', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'TNRA', 'Terminal ADE', NULL, 491, NULL),
(119, 'Legic Card de Terminal MPDV-MX-491', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'LG', 'Legic Card', NULL, 491, NULL),
(124, 'Scanner de Terminal MPDV-MX-491', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SC', 'Scanner', NULL, 491, NULL),
(125, 'Terminal MPDV-MX-496', 47, 48, 49, 50, 51, 52, 53, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'TNRM', 'Terminal MDE', NULL, 491, NULL),
(126, 'Legic Scanner de Terminal MPDV-MX-496', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'LG', 'Legic Card', NULL, 496, NULL),
(127, 'Scanner de Terminal MPDV-MX-496', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SC', 'Scanner', NULL, 496, NULL),
(128, 'GARBURG ME02', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(129, 'GARBURG ME16', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(130, 'GARBURG ME03', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(131, 'GARBURG INYECTORA 14', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'GR', 'Impresora Garburg', NULL, NULL, NULL),
(132, 'Basculas ', 37, 38, 39, 36, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'BS', 'Basculas', NULL, NULL, NULL),
(133, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inyección', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(134, 'Terminal MPDV-MX-302', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'GP12', 'TNRA', 'Terminal ADE', NULL, 302, NULL),
(135, 'Legic Card de Terminal MPDV-MX-302 ', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GP12', 'LG', 'Legic Card', NULL, 302, NULL),
(136, 'Scanner de Terminal MPDV-MX-302', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GP12', 'SC', 'Scanner', NULL, 302, NULL),
(137, 'Terminal MPDV-MX-499', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Bodega ', 'TNRA', 'Terminal ADE', NULL, 499, NULL),
(138, 'Legic Card de Terminal MPDV-MX-499', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bodega', 'LG', 'Legic Card', NULL, 499, NULL),
(139, 'Scanner de Terminal MPDV-MX-499', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bodega', 'SC', 'Scanner', NULL, 499, NULL),
(140, 'Terminal MPDV-MX-500', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Bodega', 'TNRA', 'Terminal ADE', NULL, 500, NULL),
(141, 'Legic Card Terminal MPDV-MX-500', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bodega', 'LG', 'Legic Card', NULL, 500, NULL),
(142, 'Scanner de Terminal MPDV-MX-500', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bodega', 'SC', 'Scanner', NULL, NULL, NULL),
(143, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bodega', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL),
(144, 'Terminal MPDV-MX-498', 1, 2, 3, 4, 5, 7, 9, NULL, NULL, NULL, NULL, NULL, 'Moldes de Flexión', 'TNRA', 'Terminal ADE', NULL, 498, NULL),
(145, 'Legic Card de Terminal MPDV-MX-498', 14, 15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Moldes de Flexión', 'LG', 'Legic Card', NULL, 498, NULL),
(146, 'Scanner de Terminal MPDV-MX-498', 19, 22, 10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Moldes de Flexión', 'SC', 'Scanner', NULL, 498, NULL),
(147, 'GARBURG ME41', 21, 25, 26, 27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Embarques PT', 'GR', 'Impresora garburg ', NULL, NULL, NULL),
(148, 'Basculas', 37, 38, 39, 36, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Embarques PT', 'BS', 'Basculas', NULL, NULL, NULL),
(149, 'Scanner Keyebce-Skorpion', 40, 44, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Embarques PT', 'SCK', 'Scanner Keyebce-skorpion', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fallas`
--

CREATE TABLE `fallas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `identificador_elemento` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `desc_falla` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `identificador_caract` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fallas`
--

INSERT INTO `fallas` (`id`, `descripcion`, `identificador_elemento`, `desc_falla`, `identificador_caract`) VALUES
(1, 'Touch Funciona', 'TNRA', NULL, 'C1A'),
(2, 'Terminal en funcionamiento ', 'TNRA', NULL, 'C2A'),
(3, 'Aplicación hydra en funcionamiento', 'TNRA', NULL, 'C2A'),
(4, 'Sin problemas con ordenes', 'TNRA', NULL, 'C4A'),
(5, 'sin problemas esteticos', 'TNRA', NULL, 'C5A'),
(6, 'Derrame de liquido ', 'TNRA', '', 'C8A'),
(7, 'Conexión a Red', 'TNRA', NULL, 'C6A'),
(8, 'Derrame de liquido', '', NULL, ''),
(9, ' Área Libre ', 'TNRA', NULL, 'C7A'),
(10, 'Scanner en su lugar ', 'SC', NULL, NULL),
(11, 'Scanner  detectado correctamente por el equipo', 'SC', NULL, NULL),
(12, 'Legic en posición correcta', 'LG', NULL, NULL),
(14, 'Legic en funcionamiento', 'LG', NULL, 'C1L'),
(15, 'Lectura de tarjetas correcta', 'LG', NULL, 'C2L'),
(16, 'Legic en posición correcta', 'LG', NULL, NULL),
(17, 'Legic detectado correctamente por el equipo ', 'LG', NULL, 'C3L'),
(18, 'Área Libre', 'LG', NULL, NULL),
(19, 'Scanner prendido', 'SC', NULL, NULL),
(20, 'Área libre ', 'SCK', NULL, NULL),
(21, 'Impresión de etiquetas correcta ', 'GR', NULL, 'C1G'),
(22, 'Scannea correctamente ', 'SC', NULL, NULL),
(23, 'Conexión a Red', 'SC', NULL, NULL),
(24, 'Lee correctamente la orden de producción', 'SC', NULL, NULL),
(25, 'Sin fallas en el cortador ', 'GR', NULL, 'C2G'),
(26, 'Sin problemas esteticos ', 'GR', NULL, 'C3G'),
(27, 'Conexión a Red', 'GR', NULL, 'C4G'),
(28, 'Área Libre', 'GR', NULL, 'C5G'),
(29, 'Scanner pasmado', 'SC', NULL, NULL),
(30, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, NULL),
(33, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, NULL),
(35, 'Área Libre', 'BS', NULL, 'C5B'),
(36, 'Conexión al servidor MTOPC ', 'BS', NULL, 'C4B'),
(37, 'Tara ok', 'BS', NULL, 'C1B'),
(38, 'Abre SAP', 'BS', NULL, 'C2B'),
(39, 'Conexión a Red', 'BS', NULL, 'C3B'),
(40, 'Scanea correctamente', 'SCK', NULL, 'C1SK'),
(41, 'Scanner prendido ', 'SCK', NULL, 'C3SK'),
(42, 'Scanner  detectado correctamente por el equipo ', 'SCK', NULL, NULL),
(43, 'Scanner en su lugar ', 'SCK', NULL, NULL),
(44, 'Conexión a Red ', 'SCK', NULL, 'C2SK'),
(45, 'Lee correctamente la orden de producción', 'SC', NULL, NULL),
(46, 'Área Libre ', 'SC', NULL, NULL),
(47, 'Terminal en funcionamiento correcto ', 'TNRM', NULL, 'C1M'),
(48, 'Aplicación hydra en funcionamiento', 'TNRM', NULL, 'C2M'),
(49, 'No cambia de status ', 'TNRM', NULL, 'C3M'),
(50, 'sin problemas estéticos', 'TNRM', '', 'C4M'),
(51, 'Sin problemas con ordenes ', 'TNRM', '', 'C5M'),
(52, 'conexión a red ', 'TNRM', '', 'C6M'),
(53, 'Área libre', 'TNRM', '', 'C7M'),
(54, 'sin derrame de liquidos', 'TNRM', NULL, 'C8M');

-- --------------------------------------------------------

--
-- Table structure for table `fallas2`
--

CREATE TABLE `fallas2` (
  `id` int(11) NOT NULL,
  `descripcion` text,
  `identificador_elemento` varchar(50) DEFAULT NULL,
  `id_caracteristica` int(11) DEFAULT NULL,
  `descripcion_caracteristica` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fallas2`
--

INSERT INTO `fallas2` (`id`, `descripcion`, `identificador_elemento`, `id_caracteristica`, `descripcion_caracteristica`) VALUES
(0, 'No imprime ', 'GR', 25, 'Imprime correctamente'),
(1, 'No escanea', 'SC', 22, 'Scannea correctamente'),
(2, 'Scanner no enciende(o se encuentra apagado)', 'SC', 19, 'Scanner prendido'),
(3, 'No reconoce el Scanner', 'SC', 11, 'Scanner  detectado correctamente por el equipo'),
(4, 'No se encuentra el Scanner en su lugar', 'SC', 10, 'Scanner en su lugar '),
(5, 'No tiene conexión a red ', 'SC', 23, 'Conexión a Red'),
(6, 'No lee la orden de producción', 'SC', 45, 'Lee correctamente la orden de producción'),
(7, 'Área con obstrucción de paso', 'SC', 46, 'Área Libre '),
(8, 'Terminal se encuentra apagada ', 'TNRA', 1, 'Cambia de estatus correctamente '),
(9, 'Aplicación cerrada ', 'TNRA', 2, 'Terminal prendida'),
(10, 'Terminal Pasmada ', 'TNRA', 3, 'Terminal en funcionamiento'),
(11, 'No funciona el touch ', 'TNRA', 4, 'Touch en funcionamiento'),
(12, 'La terminal tiene un rayón  (Lapicero o Plumón)', 'TNRA', 5, 'Sin golpes ni rayones'),
(13, 'Error al leer la orden ', 'TNRA', 6, 'ingreso de ordenes correctas'),
(14, 'No tiene conexión a red ', 'TNRA', 7, 'Conexión a Red'),
(15, 'No registra la orden ', 'TNRA', 8, 'Tiene etiquetas correspondientes '),
(16, 'Material colocado  enfrente de la terminal', 'TNRA', 9, ' Área Libre '),
(17, 'No escanea ', 'SCK', 40, 'Scanea correctamente'),
(18, 'Scanner no enciende', 'SCK', 41, 'Scanner prendido'),
(19, 'No reconoce el Scanner ', 'SCK', 42, 'Scanner  detectado correctamente por el equipo '),
(20, 'No tiene conexión a red ', 'SCK', 44, 'Conexión a Red '),
(21, 'Área con obstrucción de paso', 'SCK', 20, 'Área Libre'),
(22, 'No se encuentra el Scanner en su lugar', 'SCK', 43, 'Scanner en su lugar '),
(23, 'Legic Pasmado ', 'LG', 14, ' Legic en funcionamiento'),
(24, 'No lee la tarjeta ', 'LG', 15, 'Lectura de tarjetas correcta'),
(25, 'No reconoce el lector ', 'LG', 17, 'Legic detectado correctamente por el equipo '),
(26, 'Legic despegado', 'LG', 12, 'Legic en posición correcta'),
(27, 'Área con obstrucción de paso', 'LG', 18, 'Área Libre'),
(28, 'No conecta con el servidor MTOPC', 'BS', 36, 'Conexión al servidor MTOPC '),
(29, 'Tara no OK ', 'BS', 37, 'Tara ok'),
(30, 'No abre SAP', 'BS', 38, 'Abre SAP'),
(31, 'No tiene conexión a Red ', 'BS', 39, 'Conexión a Red '),
(32, 'Área con obstrucción de paso', 'BS', 35, 'Área Libre'),
(33, 'No imprime ', 'GR', 25, 'Imprime correctamente'),
(34, 'No salen etiquetas ', 'GR', 21, 'Salen etiquetas correctamente '),
(35, 'Salen lineas en las etiquetas', 'GR', 26, 'Salen etiquetas sin lineas '),
(36, 'Atasco de etiquetas ', 'GR', 29, 'Sin atasco de etiquetas '),
(37, 'Impresiones borrosas', 'GR', 30, 'Impresiones legibles '),
(38, 'No tiene conexión a red', 'GR', 27, 'Conexión a Red'),
(39, 'Puertos dañados ', 'GR', 31, 'Puertos en buenas condiciones '),
(40, 'Pantalla principal con daño', 'GR', 32, 'Pantalla principal en buen estado'),
(41, 'No funciona los botones', 'GR', 33, 'Botones en buen estado'),
(42, 'Falta palanca de ajuste', 'GR', 34, 'Con palanca de ajuste '),
(43, 'Área con obstrucción de paso', 'GR', 28, 'Área Libre'),
(44, 'La aplicación esta en rojo', 'TNRA', 7, NULL),
(45, 'No se puede acceder a la terminal ', 'TNRA', 9, NULL),
(46, 'se encuentra apagada', 'TNRM ', 47, NULL),
(47, 'Terminal pasmada', 'TNRM', 47, NULL),
(48, 'maquina en rojo', 'TNRM ', 48, NULL),
(49, 'ninguna cambia de estatus', 'TNRM', 48, NULL),
(50, 'no cambia a produccion', 'TNRM', 48, NULL),
(51, 'La terminal tiene un rayón  (Lapicero o Plumón)', 'TNRM', 5, NULL),
(52, 'No tiene conexión a red ', 'TNRM', 7, NULL),
(53, 'Material colocado  enfrente de la terminal', 'TNRM', 9, NULL),
(54, 'Terminal pasmada', 'TNRM', 47, NULL),
(55, 'Derrame de liquido ', 'TNRA', 6, 'Derrame de liquido '),
(56, 'Derrame de liquido ', 'TNRM', 54, 'Derrame de liquido ');

-- --------------------------------------------------------

--
-- Table structure for table `fallas3`
--

CREATE TABLE `fallas3` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `identificador_elemento` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fallas3`
--

INSERT INTO `fallas3` (`id`, `descripcion`, `identificador_elemento`) VALUES
(1, 'La terminal tiene un golpe o rayón  (Lapicero o Plumón)', 'TNR'),
(2, 'Terminal pasmada ', 'TNR '),
(3, 'Tiene pegado etiquetas que no corresponden', 'TNR'),
(4, 'Área con obstrucción de paso', 'TNR '),
(5, 'Error al introducir la orden ', 'TNR'),
(6, 'La terminal no esta cambiando de status ', 'TNR '),
(7, 'La terminal no esta prendida', 'TNR'),
(8, 'No funciona el touch ', 'TNR '),
(9, 'Scanner no enciende', 'SC'),
(10, 'No se encuentra el Scanner en su lugar', 'SC'),
(11, 'No lee la orden de producción el Scanner ', 'SC'),
(12, 'Área con obstrucción de paso', 'SC'),
(13, 'No escanea ', 'SCK'),
(14, 'Scanner no enciende', 'SCK'),
(15, 'No se encuentra el Scanner en su lugar', 'SCK'),
(16, 'Área con obstrucción de paso', 'SCK'),
(17, 'Legic Pasmado', 'LG'),
(18, 'No reconoce el lector ', 'LG'),
(19, 'Legic despegado', 'LG'),
(20, 'Área con obstrucción de paso', 'LG'),
(21, 'Tara no OK ', 'BS'),
(22, 'No tiene Red', 'BS'),
(23, 'Área con obstrucción de paso', 'BS'),
(24, 'Salen lineas en las etiquetas', 'GR'),
(25, 'Atasco de etiquetas ', 'GR'),
(26, 'Impresiones borrosas ', 'GR'),
(27, 'Puertos dañados', 'GR'),
(28, 'Pantalla principal con daño', 'GR'),
(29, 'No funciona los botones ', 'GR'),
(30, 'Falta palanca de ajuste', 'GR'),
(31, 'Área con obstrucción de paso', 'GR');

-- --------------------------------------------------------

--
-- Table structure for table `guardar_check`
--

CREATE TABLE `guardar_check` (
  `id` int(11) NOT NULL,
  `elemento_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `NameElemento` varchar(255) DEFAULT NULL,
  `caracteristica1` varchar(255) DEFAULT NULL,
  `caracteristica2` varchar(255) DEFAULT NULL,
  `caracteristica3` varchar(255) DEFAULT NULL,
  `caracteristica4` varchar(255) DEFAULT NULL,
  `caracteristica5` varchar(255) DEFAULT NULL,
  `caracteristica6` varchar(255) DEFAULT NULL,
  `caracteristica7` varchar(255) DEFAULT NULL,
  `caracteristica8` varchar(255) DEFAULT NULL,
  `caracteristica9` varchar(255) DEFAULT NULL,
  `caracteristica10` varchar(255) DEFAULT NULL,
  `caracteristica11` varchar(255) DEFAULT NULL,
  `identificador_elemento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guardar_check`
--

INSERT INTO `guardar_check` (`id`, `elemento_id`, `area`, `NameElemento`, `caracteristica1`, `caracteristica2`, `caracteristica3`, `caracteristica4`, `caracteristica5`, `caracteristica6`, `caracteristica7`, `caracteristica8`, `caracteristica9`, `caracteristica10`, `caracteristica11`, `identificador_elemento`) VALUES
(2327, 1, 'Recepción', 'Terminal MPDV-MX-317', '2024-08-22', 'La terminal no esta prendida', 'Terminal pasmada', '2024-09-03', 'No funciona el Touch de la terminal', '2024-09-05', '2024-09-30', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2328, 2, 'Recepción', 'Legic Card de Terminal MPDV-MX-317', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2329, 3, 'Hornos de Flexión', 'Terminal MPDV-MX-497', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', '2024-09-05', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2330, 4, 'Hornos de Flexión', 'Legic Card  de Terminal MPDV-MX-497', 'Legic Pasmado', 'No lee la tarjeta ', '2024-09-05', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2331, 5, 'Hornos de Flexión', 'Scanner de Terminal MPDV-MX-497', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', '2024-08-20', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2332, 6, 'Hornos de Flexión', 'GARBURG ME73', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2333, 7, 'Hornos de Flexión', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', '2024-09-05', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2334, 8, 'Hornos de Flexión', 'Scanner Keyence-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2335, 18, 'Stepp', 'Terminal MPDV-MX-315', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2336, 19, 'Stepp', 'Legic Card de Terminal MPDV-MX-315', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2337, 20, 'Stepp', 'Scanner de Terminal MPDV-MX-315', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2338, 21, 'Stepp', 'Terminal MPDV-MX-486', 'La terminal no esta cambiando de status', '2024-10-09', NULL, 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2339, 22, 'Stepp', 'Legic Card de Terminal MPDV-MX-486', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2340, 23, 'Stepp', 'Scanner de Terminal MPDV-MX-486', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2341, 24, 'Stepp', 'Terminal MPDV-MX-488 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2342, 25, 'Stepp', 'Legic Card de Terminal MPDV-MX-488 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2343, 26, 'Stepp', 'GARBURG ME15', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2344, 27, 'Stepp', 'GARBURG MAQUINA 4010', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2345, 28, 'Stepp', 'GARBURG VARIO III JUNTO A TERMINALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2346, 29, 'Stepp', 'GARBURG MAQUINA 4006', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2347, 30, 'Stepp', 'GARBURG MAQUINA 4005', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2348, 31, 'Stepp', 'GARBURG ME75', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2349, 32, 'Stepp', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2350, 33, 'Stepp', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2351, 34, 'Extrucción', 'Terminal MPDV-MX-497 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', '2024-09-10', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2352, 35, 'Extrucción', 'Legic Card de Terminal MPDV-MX-497 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2353, 36, 'Extrucción', 'Scanner de Terminal MPDV-MX-497 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2354, 37, 'Extrucción', 'GARBURG ME53', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2355, 38, 'Vacio', 'Terminal MPDV-MX-307', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', '2024-10-09', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2356, 39, 'Vacio', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2357, 40, 'Vacio', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2358, 41, 'Vacio', 'Terminal MPDV-MX-494', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', NULL, 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2359, 42, 'Vacio', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2360, 43, 'Vacio', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2361, 44, 'Vacio', 'GARBURG SUP VACIO', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2362, 52, 'Vacio', 'GARBURG ME19', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2363, 53, 'Vacio', 'GARBURG CELULA I', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2364, 54, 'Vacio', 'GARBURG CELULA B', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2365, 55, 'Vacio', 'GARBURG ME18 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2366, 56, 'Vacio', 'GARBURG ME14 MATERIALES', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2367, 57, 'Vacio', 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2368, 58, 'Vacio', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2369, 59, 'Mezzanine', 'GARBURG ME12', 'No imprime ', 'Salen lineas en las etiquetas', NULL, 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2370, 60, 'Suaje', 'GARBURG ME71', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2371, 61, 'Carbón', 'Terminal MPDV-MX-481', '2024-10-07', '2024-10-02', 'Terminal pasmada', '2024-09-26', '2024-09-26', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2372, 62, 'Carbón', 'Legic Card de Terminal MPDV-MX-481 ', NULL, '2024-10-07', '2024-10-07', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2373, 63, 'Carbón', 'Scanner de Terminal MPDV-MX-481 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2374, 64, 'Carbón', 'Terminal MPDV-MX-490', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2375, 65, 'Carbón', 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2376, 66, 'Carbón', 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2377, 67, 'Carbón', 'Terminal MPDV-MX-492', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2378, 68, 'Carbón', 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2379, 69, 'Carbón', 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2380, 70, 'Carbón', 'Terminal MPDV-MX-493', 'La terminal no esta cambiando de status', '2024-10-16', NULL, '2024-09-26', '2024-09-26', 'Error al introducir la orden', '2024-10-09', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2381, 71, 'Carbón', 'Legic Card de Terminal MPDV-MX-493', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2382, 72, 'Carbón', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2383, 73, 'Carbón', 'Terminal MPDV-MX-495', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2384, 74, 'Carbón', 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2385, 75, 'Carbón', 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2386, 76, 'Carbón', 'GARBURG ATORNILLADORA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2387, 77, 'Carbón', 'GARBURG ME17 MATERIALISTA CORTINA', 'No imprime ', NULL, 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2388, 78, 'Carbón', 'GARBURG ZEBRA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2389, 79, 'Carbón', 'GARBURG ME13', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2390, 80, 'Carbón', 'GARBURG ME09', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2391, 84, 'Carbón', 'GARBURG FORD LINEA 2 VARIO III', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2392, 85, 'Carbón', 'GARBURG LINEA 2 VITA II', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2393, 86, 'Carbón', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2394, 87, 'Soplado', 'Terminal MPDV-MX-309 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2395, 88, 'Soplado', 'Legic Card de Terminal MPDV-MX-309 ', 'Legic Pasmado', NULL, 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2396, 89, 'Soplado', 'Scanner de Terminal MPDV-MX-309 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2397, 90, 'Soplado', 'Terminal MPDV-MX-312', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2398, 91, 'Soplado', 'Legic Card de Terminal MPDV-MX-312', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2399, 92, 'Soplado', 'Scanner de Terminal MPDV-MX-312', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2400, 93, 'Soplado', 'GARBURG ME06', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2401, 94, 'Soplado', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2402, 95, 'Conectores', 'Terminal MPDV-MX-323', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2403, 96, 'Conectores', 'Legic Card  de Terminal MPDV-MX-323', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2404, 97, 'Conectores', 'Scanner de Terminal MPDV-MX-323', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2405, 98, 'Conectores', 'Terminal MPDV-MX-325', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', NULL, 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2406, 99, 'Conectores', 'Legic Card de Terminal MPDV-MX-325', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2407, 100, 'Conectores', 'Scanner de Terminal MPDV-MX-325', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2408, 101, 'Conectores', 'Terminal MPDV-MX-487', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2409, 102, 'Conectores', 'Legic Card de Terminal MPDV-MX-487', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2410, 103, 'Conectores', 'Scanner de Terminal MPDV-MX-487', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2411, 104, 'Conectores', 'GARBURG ME20', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2412, 105, 'Conectores', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2413, 106, 'Inyección', 'Terminal MPDV-MX-316', 'La terminal no esta cambiando de status', '2024-10-07', 'Terminal pasmada', NULL, 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2414, 107, 'Inyección', 'Legic Card de Terminal MPDV-MX-316', 'Legic Pasmado', NULL, 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2415, 108, 'Inyección', 'Scanner de Terminal MPDV-MX-316', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2416, 109, 'Inyección', 'Terminal MPDV-MX-322', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2417, 110, 'Inyección', 'Legic Card de Terminal MPDV-MX-322', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2418, 111, 'Inyección', 'Scanner de Terminal MPDV-MX-322', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2419, 112, 'Inyección', 'Terminal MPDV-MX-480 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2420, 113, 'Inyección', 'Legic Card de Terminal MPDV-MX-480 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2421, 114, 'Inyección', 'Scanner de Terminal MPDV-MX-480 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2422, 115, 'Inyección', 'Terminal MPDV-MX-484', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', '2024-09-26', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', NULL, 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2423, 116, 'Inyección', 'Legic Card de Terminal MPDV-MX-484', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2424, 117, 'Inyección', 'Scanner de Terminal MPDV-MX-484', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2425, 118, 'Inyección', 'Terminal MPDV-MX-491', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', NULL, 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2426, 119, 'Inyección', 'Legic Card de Terminal MPDV-MX-491', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2427, 124, 'Inyección', 'Scanner de Terminal MPDV-MX-491', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2428, 125, 'Inyección', 'Terminal MPDV-MX-496', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2429, 126, 'Inyección', 'Legic Scanner de Terminal MPDV-MX-496', '2024-10-07', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2430, 127, 'Inyección', 'Scanner de Terminal MPDV-MX-496', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', '2024-09-26', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2431, 128, 'Inyección', 'GARBURG ME02', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2432, 129, 'Inyección', 'GARBURG ME16', NULL, 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2433, 130, 'Inyección', 'GARBURG ME03', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2434, 131, 'Inyección', 'GARBURG INYECTORA 14', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2435, 132, 'Inyección', 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', '2024-09-26', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2436, 133, 'Inyección', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2437, 134, 'GP12', 'Terminal MPDV-MX-302', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2438, 135, 'GP12', 'Legic Card de Terminal MPDV-MX-302 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2439, 136, 'GP12', 'Scanner de Terminal MPDV-MX-302', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2440, 137, 'Bodega', 'Terminal MPDV-MX-499', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', '2024-10-07', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2441, 138, 'Bodega', 'Legic Card de Terminal MPDV-MX-499', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2442, 139, 'Bodega', 'Scanner de Terminal MPDV-MX-499', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2443, 140, 'Bodega ', 'Terminal MPDV-MX-500', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2444, 141, 'Bodega', 'Legic Card Terminal MPDV-MX-500', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2445, 142, 'Bodega ', 'Scanner de Terminal MPDV-MX-500', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2446, 143, 'Bodega', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2447, 144, 'Moldes de Flexión', 'Terminal MPDV-MX-498', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', NULL),
(2448, 145, 'Moldes de Flexión', 'Legic Card de Terminal MPDV-MX-498', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2449, 146, 'Moldes de Flexión', 'Scanner de Terminal MPDV-MX-498', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2450, 147, 'Embarques PT', 'GARBURG ME41', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', NULL),
(2451, 148, 'Embarques PT', 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL),
(2452, 149, 'Embarques PT', 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guardar_dato`
--

CREATE TABLE `guardar_dato` (
  `id` int(11) NOT NULL,
  `elemento_id` int(11) DEFAULT NULL,
  `NameElemento` varchar(255) DEFAULT NULL,
  `caracteristica1` varchar(255) DEFAULT NULL,
  `caracteristica2` varchar(255) DEFAULT NULL,
  `caracteristica3` varchar(255) DEFAULT NULL,
  `caracteristica4` varchar(255) DEFAULT NULL,
  `caracteristica5` varchar(255) DEFAULT NULL,
  `caracteristica6` varchar(255) DEFAULT NULL,
  `caracteristica7` varchar(255) DEFAULT NULL,
  `caracteristica8` varchar(255) DEFAULT NULL,
  `caracteristica9` varchar(255) DEFAULT NULL,
  `caracteristica10` varchar(255) DEFAULT NULL,
  `caracteristica11` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guardar_dato`
--

INSERT INTO `guardar_dato` (`id`, `elemento_id`, `NameElemento`, `caracteristica1`, `caracteristica2`, `caracteristica3`, `caracteristica4`, `caracteristica5`, `caracteristica6`, `caracteristica7`, `caracteristica8`, `caracteristica9`, `caracteristica10`, `caracteristica11`, `area`) VALUES
(1, 1, 'Terminal MPDV-MX-317', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Recepción'),
(2, 2, 'Legic Card de Terminal MPDV-MX-317', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Recepción'),
(3, 3, 'Terminal MPDV-MX-497', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Hornos de Flexión'),
(4, 4, 'Legic Card  de Terminal MPDV-MX-497', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Hornos de Flexión'),
(5, 5, 'Scanner de Terminal MPDV-MX-497', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Hornos de Flexión'),
(6, 6, 'GARBURG ME73', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Hornos de Flexión'),
(7, 7, 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Hornos de Flexión'),
(8, 8, 'Scanner Keyence-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Hornos de Flexión'),
(9, 18, 'Terminal MPDV-MX-315', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Stepp'),
(10, 19, 'Legic Card de Terminal MPDV-MX-315', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(11, 20, 'Scanner de Terminal MPDV-MX-315', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(12, 21, 'Terminal MPDV-MX-486', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Stepp'),
(13, 22, 'Legic Card de Terminal MPDV-MX-486', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(14, 23, 'Scanner de Terminal MPDV-MX-486', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(15, 24, 'Terminal MPDV-MX-488 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Stepp'),
(16, 25, 'Legic Card de Terminal MPDV-MX-488 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(17, 26, 'GARBURG ME15', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Stepp'),
(18, 27, 'GARBURG MAQUINA 4010', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Stepp'),
(19, 28, 'GARBURG VARIO III JUNTO A TERMINALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Stepp'),
(20, 29, 'GARBURG MAQUINA 4006', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Stepp'),
(21, 30, 'GARBURG MAQUINA 4005', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Stepp'),
(22, 31, 'GARBURG ME75', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Stepp'),
(23, 32, 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(24, 33, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Stepp'),
(25, 34, 'Terminal MPDV-MX-497 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Extrucción'),
(26, 35, 'Legic Card de Terminal MPDV-MX-497 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Extrucción'),
(27, 36, 'Scanner de Terminal MPDV-MX-497 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Extrucción'),
(28, 37, 'GARBURG ME53', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Extrucción'),
(29, 38, 'Terminal MPDV-MX-307', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Vacio'),
(30, 39, 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Vacio'),
(31, 40, 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Vacio'),
(32, 41, 'Terminal MPDV-MX-494', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Vacio'),
(33, 42, 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Vacio'),
(34, 43, 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Vacio'),
(35, 44, 'GARBURG SUP VACIO', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Vacio'),
(36, 52, 'GARBURG ME19', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Vacio'),
(37, 53, 'GARBURG CELULA I', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Vacio'),
(38, 54, 'GARBURG CELULA B', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Vacio'),
(39, 55, 'GARBURG ME18 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Vacio'),
(40, 56, 'GARBURG ME14 MATERIALES', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Vacio'),
(41, 57, 'Basculas', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Vacio'),
(42, 58, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Vacio'),
(43, 59, 'GARBURG ME12', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Mezzanine'),
(44, 60, 'GARBURG ME71', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Suaje'),
(45, 61, 'Terminal MPDV-MX-481', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Carbón'),
(46, 62, 'Legic Card de Terminal MPDV-MX-481 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(47, 63, 'Scanner de Terminal MPDV-MX-481 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(48, 64, 'Terminal MPDV-MX-490', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Carbón'),
(49, 65, 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(50, 66, 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(51, 67, 'Terminal MPDV-MX-492', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Carbón'),
(52, 68, 'Legic Card de Terminal MPDV-MX-490', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(53, 69, 'Scanner de Terminal MPDV-MX-490', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(54, 70, 'Terminal MPDV-MX-493', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Carbón'),
(55, 71, 'Legic Card de Terminal MPDV-MX-493', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(56, 72, 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(57, 73, 'Terminal MPDV-MX-495', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Carbón'),
(58, 74, 'Legic Card', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(59, 75, 'Scanner', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(60, 76, 'GARBURG ATORNILLADORA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(61, 77, 'GARBURG ME17 MATERIALISTA CORTINA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(62, 78, 'GARBURG ZEBRA', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(63, 79, 'GARBURG ME13', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(64, 80, 'GARBURG ME09', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(65, 84, 'GARBURG FORD LINEA 2 VARIO III', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(66, 85, 'GARBURG LINEA 2 VITA II', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Carbón'),
(67, 86, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Carbón'),
(68, 87, 'Terminal MPDV-MX-309 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Soplado'),
(69, 88, 'Legic Card de Terminal MPDV-MX-309 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Soplado'),
(70, 89, 'Scanner de Terminal MPDV-MX-309 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Soplado'),
(71, 90, 'Terminal MPDV-MX-312', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Soplado'),
(72, 91, 'Legic Card de Terminal MPDV-MX-312', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Soplado'),
(73, 92, 'Scanner de Terminal MPDV-MX-312', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Soplado'),
(74, 93, 'GARBURG ME06', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Soplado'),
(75, 94, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Soplado'),
(76, 95, 'Terminal MPDV-MX-323', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Conectores'),
(77, 96, 'Legic Card  de Terminal MPDV-MX-323', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(78, 97, 'Scanner de Terminal MPDV-MX-323', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(79, 98, 'Terminal MPDV-MX-325', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Conectores'),
(80, 99, 'Legic Card de Terminal MPDV-MX-325', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(81, 100, 'Scanner de Terminal MPDV-MX-325', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(82, 101, 'Terminal MPDV-MX-487', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Conectores'),
(83, 102, 'Legic Card de Terminal MPDV-MX-487', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(84, 103, 'Scanner de Terminal MPDV-MX-487', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(85, 104, 'GARBURG ME20', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Conectores'),
(86, 105, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Conectores'),
(87, 106, 'Terminal MPDV-MX-316', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Inyección'),
(88, 107, 'Legic Card de Terminal MPDV-MX-316', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(89, 108, 'Scanner de Terminal MPDV-MX-316', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(90, 109, 'Terminal MPDV-MX-322', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Inyección'),
(91, 110, 'Legic Card de Terminal MPDV-MX-322', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(92, 111, 'Scanner de Terminal MPDV-MX-322', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(93, 112, 'Terminal MPDV-MX-480 ', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Inyección'),
(94, 113, 'Legic Card de Terminal MPDV-MX-480 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(95, 114, 'Scanner de Terminal MPDV-MX-480 ', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(96, 115, 'Terminal MPDV-MX-484', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Inyección'),
(97, 116, 'Legic Card de Terminal MPDV-MX-484', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(98, 117, 'Scanner de Terminal MPDV-MX-484', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(99, 118, 'Terminal MPDV-MX-491', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Inyección'),
(100, 119, 'Legic Card de Terminal MPDV-MX-491', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(101, 124, 'Scanner de Terminal MPDV-MX-491', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(102, 125, 'Terminal MPDV-MX-496', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Inyección'),
(103, 126, 'Legic Scanner de Terminal MPDV-MX-496', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(104, 127, 'Scanner de Terminal MPDV-MX-496', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(105, 128, 'GARBURG ME02', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Inyección'),
(106, 129, 'GARBURG ME16', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Inyección'),
(107, 130, 'GARBURG ME03', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Inyección'),
(108, 131, 'GARBURG INYECTORA 14', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Inyección'),
(109, 132, 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(110, 133, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Inyección'),
(111, 134, 'Terminal MPDV-MX-302', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'GP12'),
(112, 135, 'Legic Card de Terminal MPDV-MX-302 ', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'GP12'),
(113, 136, 'Scanner de Terminal MPDV-MX-302', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'GP12'),
(114, 137, 'Terminal MPDV-MX-499', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Bodega'),
(115, 138, 'Legic Card de Terminal MPDV-MX-499', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Bodega'),
(116, 139, 'Scanner de Terminal MPDV-MX-499', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Bodega'),
(117, 140, 'Terminal MPDV-MX-500', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Bodega '),
(118, 141, 'Legic Card Terminal MPDV-MX-500', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Bodega'),
(119, 142, 'Scanner de Terminal MPDV-MX-500', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Bodega '),
(120, 143, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Bodega'),
(121, 144, 'Terminal MPDV-MX-498', 'La terminal no esta cambiando de status', 'La terminal no esta prendida', 'Terminal pasmada', 'No funciona el Touch de la terminal', 'No funciona el Touch de la terminal', 'Error al introducir la orden', 'No tiene conexión a red', 'Tiene pegado etiquetas que no corresponden', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'Moldes de Flexión'),
(122, 145, 'Legic Card de Terminal MPDV-MX-498', 'Legic Pasmado', 'No lee la tarjeta ', 'Legic despegado', 'No reconoce el lector ', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Moldes de Flexión'),
(123, 146, 'Scanner de Terminal MPDV-MX-498', 'Scanner no enciende ', 'No escanea ', 'No tiene red ', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'No lee la orden de producción', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Moldes de Flexión'),
(124, 147, 'GARBURG ME41', 'No imprime ', 'Salen lineas en las etiquetas', 'No tiene red ', 'Área con obstrucción de paso ', 'Atasco de etiquetas ', 'Impresiones borrosas ', 'Puertos dañados ', 'Pantalla principal con daño', 'No salen etiquetas ', 'No funciona los botones ', 'Falta palanca de ajuste', 'Embarques PT'),
(125, 148, 'Basculas ', 'Tara no OK ', 'No abre SAP', 'No tiene Red ', 'No conecta con el servidor MTOPC', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Embarques PT'),
(126, 149, 'Scanner Keyebce-Skorpion', 'No escanea', 'No tiene red ', 'Scanner no enciende', 'No se reconoce el Scanner en el equipo', 'No se encuentra el Scanner en su lugar', 'Área con obstrucción de paso', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'no aplica', 'Embarques PT');

-- --------------------------------------------------------

--
-- Table structure for table `historial_escaneos`
--

CREATE TABLE `historial_escaneos` (
  `id` int(11) NOT NULL,
  `elemento_id` int(11) NOT NULL,
  `fecha_escaneo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion_falla` varchar(255) DEFAULT NULL,
  `NameElemento` varchar(255) NOT NULL,
  `areas` varchar(255) NOT NULL,
  `identificador_elemento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `historial_escaneos`
--

INSERT INTO `historial_escaneos` (`id`, `elemento_id`, `fecha_escaneo`, `descripcion_falla`, `NameElemento`, `areas`, `identificador_elemento`) VALUES
(45, 3, '2024-08-13 15:49:57', 'Terminal en funcionamiento ', 'Terminal MPDV-MX-497', 'Hornos de Flexión', 'TNR'),
(46, 3, '2024-08-13 15:49:57', 'Touch en funcionamiento ', 'Terminal MPDV-MX-497', 'Hornos de Flexión', 'TNR'),
(55, 4, '2024-08-13 15:49:57', 'Legic en posición correcta', 'Legic Card de Terminal MPDV-MX-497', 'Hornos de Flexión', 'LG'),
(56, 4, '2024-08-13 15:49:57', 'Área Libre', 'Legic Card de Terminal MPDV-MX-497', 'Hornos de Flexión', 'LG'),
(62, 5, '2024-08-13 15:49:57', 'Lee correctamente la orden de producción', 'Scanner de Terminal MPDV-MX-497', 'Hornos de Flexión', 'SC'),
(63, 5, '2024-08-13 15:49:57', 'Área Libre ', 'Scanner de Terminal MPDV-MX-497', 'Hornos de Flexión', 'SC'),
(76, 2, '2024-08-13 15:50:07', 'Legic en posición correcta', 'Legic Card de Terminal MPDV-MX-317', 'Recepción', 'LG'),
(77, 2, '2024-08-13 15:50:07', 'Área Libre', 'Legic Card de Terminal MPDV-MX-317', 'Recepción', 'LG');

-- --------------------------------------------------------

--
-- Table structure for table `identificadorareas`
--

CREATE TABLE `identificadorareas` (
  `id` varchar(10) NOT NULL,
  `NameArea` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `identificadorareas`
--

INSERT INTO `identificadorareas` (`id`, `NameArea`) VALUES
('Ac', 'Almacenistas Carbón'),
('Ad', 'Aduana Logística'),
('Bo', 'Bodega'),
('Ca', 'Carbón'),
('Co', 'Conectores'),
('Ep', 'Embarques PT'),
('Ex', 'Extrucción'),
('Fl', 'Flexión'),
('Gp', 'Gp12'),
('In', 'Inyección'),
('Me', 'Mezzanine'),
('Mf', 'Moldes Flexión'),
('Re', 'Recepción'),
('So', 'Soplado'),
('Srv', 'Servidor'),
('St', 'Stepp'),
('Va', 'Vacio');

-- --------------------------------------------------------

--
-- Table structure for table `meses`
--

CREATE TABLE `meses` (
  `id` int(10) NOT NULL,
  `nombre_mes` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meses`
--

INSERT INTO `meses` (`id`, `nombre_mes`) VALUES
(1, 'Enero'),
(2, 'Febrero'),
(3, 'Marzo'),
(4, 'Abril'),
(5, 'Mayo'),
(6, 'Junio'),
(7, 'Julio'),
(8, 'Agosto'),
(9, 'Septiembre'),
(10, 'Octubre'),
(11, 'Noviembre'),
(12, 'Diciembre');

-- --------------------------------------------------------

--
-- Table structure for table `reportes`
--

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL,
  `comentarios` text,
  `foto_nombre` varchar(255) DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `fecha_reporte` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_alerta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportes`
--

INSERT INTO `reportes` (`id`, `comentarios`, `foto_nombre`, `foto_url`, `fecha_reporte`, `id_alerta`) VALUES
(27, 'No hay red en los servidores sin conexion a internet en toda el area de finanzas ', 'backgroundvector.jpg', 'C:/xampp/htdocs/terminalesproject/imgReportes/backgroundvector.jpg', '2024-05-17 06:00:00', NULL),
(28, 'se encuentran fallas mecánicas y se reportaron las nuevas alertas de las siguientes alertas', 'WIN_20240509_16_28_22_Pro.jpg', 'C:/xampp/htdocs/terminalesproject/imgReportes/WIN_20240509_16_28_22_Pro.jpg', '2024-05-17 06:00:00', NULL),
(30, 'se encuentran fallas mecánicas y se reportaron las nuevas alertas de las siguientes alertas', 'WIN_20240520_09_09_01_Pro.jpg', 'C:/xampp/htdocs/terminalesproject/imgReportes/WIN_20240520_09_09_01_Pro.jpg', '2024-05-21 06:00:00', NULL),
(33, 'bascula no funciona el touch', NULL, NULL, '2024-05-29 06:00:00', NULL),
(37, 'terminal307,315 tiene plumón,490 derrame de liquido,493 tiene rayon de lapicero', NULL, NULL, '2024-06-04 06:00:00', NULL),
(56, '', NULL, NULL, '2024-06-06 06:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reportes2`
--

CREATE TABLE `reportes2` (
  `id` int(11) NOT NULL,
  `elemento_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `name_foto` varchar(255) DEFAULT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `falla` mediumtext,
  `elemento` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'En espera...',
  `user_report` varchar(255) DEFAULT NULL,
  `hora_acept` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportes2`
--

INSERT INTO `reportes2` (`id`, `elemento_id`, `area`, `fecha`, `name_foto`, `url_foto`, `falla`, `elemento`, `status`, `user_report`, `hora_acept`) VALUES
(2, 1, 'Recepción', '2024-09-03', 'alert_r.png', 'C:\\xampp\\tmp\\phpED07.tmp', 'Aplicación cerrada ', 'Terminal MPDV-MX-317', 'Aceptada', 'mx-azarate', '2024-09-03'),
(11, 1, 'Recepción', '2024-09-03', 'fondorosa.png', 'C:\\xampp\\tmp\\phpFCCB.tmp', 'Aplicación cerrada ', 'Terminal MPDV-MX-317', 'Pendiente', NULL, NULL),
(12, 1, 'Recepción', '2024-09-03', 'Picture1.png', 'C:\\xampp\\tmp\\phpEBBB.tmp', 'Se encuentra apagada ', 'Terminal MPDV-MX-317', 'Pendiente', NULL, NULL),
(13, 1, 'Recepción', '2024-09-03', 'fondorosa.png', 'C:\\xampp\\tmp\\phpE1CD.tmp', 'Error al leer la orden ', 'Terminal MPDV-MX-317', 'Aceptada', 'mx-azarate', '2024-09-03'),
(14, 1, 'Recepción', '2024-09-03', 'Picture1.png', 'C:\\xampp\\tmp\\phpB599.tmp', 'Error al leer la orden ', 'Terminal MPDV-MX-317', 'Pendiente', NULL, NULL),
(15, 1, 'Recepción', '2024-09-03', 'kayser_icon22.ico', 'C:\\xampp\\tmp\\phpFBBF.tmp', 'Error al leer la orden ', 'Terminal MPDV-MX-317', 'En espera...', NULL, NULL),
(16, 1, 'Recepción', '2024-09-03', 'check.png', 'C:\\xampp\\tmp\\php11D0.tmp', 'Error al leer la orden ', 'Terminal MPDV-MX-317', 'En espera...', NULL, NULL),
(17, 1, 'Recepción', '2024-09-03', 'stock.png', 'C:\\xampp\\tmp\\php5C91.tmp', 'Error al leer la orden ', 'Terminal MPDV-MX-317', 'En espera...', NULL, NULL),
(18, 34, 'Extrucción', '2024-09-03', 'Picture4.png', 'C:\\xampp\\tmp\\phpB18E.tmp', 'Maquina en rojo ', 'Terminal MPDV-MX-489', 'En espera...', NULL, NULL),
(19, 1, 'Recepción', '2024-09-05', 'fondorosa - Copy.png', 'C:\\xampp\\tmp\\php7BF8.tmp', 'Error al leer la orden ', 'Terminal MPDV-MX-317', 'Aceptada', 'mx-azarate', '2024-09-05'),
(20, 34, 'Extrucción', '2024-09-06', 'WIN_20240906_08_22_28_Pro.jpg', 'C:\\xampp7\\tmp\\php1BD3.tmp', 'No cambia a producción ', 'Terminal MPDV-MX-489', 'En espera...', NULL, NULL),
(21, 127, 'Inyección', '2024-09-06', 'WIN_20240906_08_34_06_Pro.jpg', 'C:\\xampp7\\tmp\\phpB402.tmp', 'La terminal no detecta el Scanner ', 'Scanner de Terminal MPDV-MX-496', 'En espera...', NULL, NULL),
(22, 115, 'Inyección', '2024-09-11', 'WIN_20240911_08_27_16_Pro.jpg', 'C:\\xampp7\\tmp\\php35F7.tmp', 'Aplicación cerrada ', 'Terminal MPDV-MX-484', 'En espera...', NULL, NULL),
(23, 70, 'Carbón', '2024-09-11', 'WIN_20240911_08_34_14_Pro.jpg', 'C:\\xampp7\\tmp\\phpB898.tmp', 'No funciona el touch ', 'Terminal MPDV-MX-493', 'En espera...', NULL, NULL),
(24, 88, 'Soplado', '2024-09-12', 'WIN_20240912_08_49_22_Pro.jpg', 'C:\\xampp7\\tmp\\phpC905.tmp', 'No lee tarjetas ', 'Legic Card de Terminal MPDV-MX-309', 'En espera...', NULL, NULL),
(25, 126, 'Inyección', '2024-09-13', 'WIN_20240913_08_32_25_Pro.jpg', 'C:\\xampp7\\tmp\\phpACF1.tmp', 'No lee tarjetas ', 'Legic Scanner de Terminal MPDV-MX-496', 'En espera...', NULL, NULL),
(26, 38, 'Vacio', '2024-09-23', 'WIN_20240923_08_06_19_Pro.jpg', 'C:\\xampp7\\tmp\\php4CF5.tmp', 'Aplicación cerrada ', 'Terminal MPDV-MX-307', 'En espera...', NULL, NULL),
(27, 115, 'Inyección', '2024-09-27', 'WIN_20240927_08_16_58_Pro.jpg', 'C:\\xampp7\\tmp\\phpDCA3.tmp', 'Material colocado frente de la terminal ', 'Terminal MPDV-MX-484', 'En espera...', NULL, NULL),
(28, 70, 'Carbón', '2024-09-27', 'WIN_20240927_08_23_14_Pro.jpg', 'C:\\xampp7\\tmp\\php497F.tmp', 'Material colocado frente de la terminal ', 'Terminal MPDV-MX-493', 'En espera...', NULL, NULL),
(29, 118, 'Inyección', '2024-10-02', 'WIN_20241002_08_27_53_Pro.jpg', 'C:\\xampp7\\tmp\\php4576.tmp', 'La terminal no tiene red ', 'Terminal MPDV-MX-491', 'En espera...', NULL, NULL),
(30, 118, 'Inyección', '2024-10-02', 'WIN_20241002_08_27_53_Pro.jpg', 'C:\\xampp7\\tmp\\php593D.tmp', 'La terminal no tiene red ', 'Terminal MPDV-MX-491', 'En espera...', NULL, NULL),
(31, 61, 'Carbón', '2024-10-02', 'WIN_20241002_08_30_43_Pro.jpg', 'C:\\xampp7\\tmp\\phpE663.tmp', 'Aplicación cerrada ', 'Terminal MPDV-MX-481', 'En espera...', NULL, NULL),
(32, 61, 'Carbón', '2024-10-02', 'WIN_20241002_08_30_43_Pro.jpg', 'C:\\xampp7\\tmp\\phpDC5F.tmp', 'Aplicación cerrada ', 'Terminal MPDV-MX-481', 'En espera...', NULL, NULL),
(33, 56, 'Vacio', '2024-10-04', 'WIN_20241004_08_01_40_Pro.jpg', 'C:\\xampp7\\tmp\\php431E.tmp', 'No imprime nada ', 'GARBURG ME14 MATERIALES', 'En espera...', NULL, NULL),
(34, 137, 'Bodega ', '2024-10-04', 'WIN_20241004_08_27_14_Pro.jpg', 'C:\\xampp7\\tmp\\phpC592.tmp', 'Terminal pasmada ', 'Terminal MPDV-MX-499', 'En espera...', NULL, NULL),
(35, 107, 'Inyección', '2024-10-07', 'WIN_20241007_08_24_55_Pro.jpg', 'C:\\xampp7\\tmp\\php5682.tmp', 'No lee tarjetas ', 'Legic Card de Terminal MPDV-MX-316', 'En espera...', NULL, NULL),
(36, 62, 'Carbón', '2024-10-07', 'WIN_20241007_08_29_09_Pro.jpg', 'C:\\xampp7\\tmp\\php3DA9.tmp', 'No funciona el legic ', 'Legic Card de Terminal MPDV-MX-481', 'En espera...', NULL, NULL),
(37, 21, 'Stepp', '2024-10-09', 'WIN_20241009_08_18_46_Pro.jpg', 'C:\\xampp7\\tmp\\phpD35.tmp', 'Se encuentra apagada ', 'Terminal MPDV-MX-486', 'En espera...', NULL, NULL),
(38, 60, 'Suaje', '2024-10-14', 'WIN_20241014_08_23_25_Pro.jpg', 'C:\\xampp7\\tmp\\php7B7D.tmp', 'Salen líneas en las etiquetas ', 'GARBURG ME71', 'En espera...', NULL, NULL),
(39, 115, 'Inyección', '2024-10-14', 'WIN_20241014_08_30_19_Pro.jpg', 'C:\\xampp7\\tmp\\php1B21.tmp', 'Material colocado frente de la terminal ', 'Terminal MPDV-MX-484', 'En espera...', NULL, NULL),
(40, 115, 'Inyección', '2024-10-14', 'WIN_20241014_08_30_19_Pro.jpg', 'C:\\xampp7\\tmp\\phpBD8C.tmp', 'Material colocado frente de la terminal ', 'Terminal MPDV-MX-484', 'En espera...', NULL, NULL),
(41, 115, 'Inyección', '2024-10-15', 'WIN_20241015_08_24_21_Pro.jpg', 'C:\\xampp7\\tmp\\phpE617.tmp', 'Material colocado frente de la terminal ', 'Terminal MPDV-MX-484', 'En espera...', NULL, NULL),
(42, 41, 'Vacio', '2024-10-16', 'WIN_20241016_08_10_42_Pro.jpg', 'C:\\xampp7\\tmp\\phpFE81.tmp', 'Tiene rayón ', 'Terminal MPDV-MX-494', 'En espera...', NULL, NULL),
(43, 70, 'Carbón', '2024-10-16', 'WIN_20241016_08_33_23_Pro.jpg', 'C:\\xampp7\\tmp\\php4FCE.tmp', 'Se encuentra apagada ', 'Terminal MPDV-MX-493', 'En espera...', NULL, NULL),
(44, 98, 'Conectores', '2024-10-17', 'WIN_20241017_08_44_20_Pro.jpg', 'C:\\xampp7\\tmp\\phpCFF0.tmp', 'Se encuentra apagada ', 'Terminal MPDV-MX-325', 'En espera...', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `servidores`
--

CREATE TABLE `servidores` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `elemento` varchar(255) NOT NULL,
  `descripcion` text,
  `lunes` date DEFAULT NULL,
  `martes` date DEFAULT NULL,
  `miercoles` date DEFAULT NULL,
  `jueves` date DEFAULT NULL,
  `viernes` date DEFAULT NULL,
  `reporte` text,
  `disabled` tinyint(1) DEFAULT '0',
  `semana_actual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `servidores`
--

INSERT INTO `servidores` (`id`, `fecha`, `area`, `elemento`, `descripcion`, `lunes`, `martes`, `miercoles`, `jueves`, `viernes`, `reporte`, `disabled`, `semana_actual`) VALUES
(1, '2024-03-25', 'N/A', 'Server MX-FS01', 'Acceso correcto a carpetas compartida y unidad de red', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19),
(2, '2024-03-25', 'N/A', 'Server KYS-MX1-EMP01', 'Servicios de Instalacion automaticos y Personal Backup', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19),
(3, '2024-03-25', 'N/A', 'Servidor MX-PLANT', 'Access Manager, Trace Control, Attendance Management, Envio de Nomina, Credencializacion, Tickets de Comedor', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19),
(4, '2024-03-25', 'N/A', 'Servidor KYS-MX1-FTRADE', 'Acceso a aplicaciones de IT', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19),
(5, '2024-03-25', 'N/A', 'Servidor KYS-MX1-PRN01', 'Acceso a Printers', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19),
(6, '2024-03-25', 'N/A', 'Servidor MX1-HYDMS03', 'Acesso a terminales', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19),
(7, '2024-03-25', 'N/A', 'Servidor MX1-MTOPC', 'Funcionamiento Basculas', NULL, NULL, NULL, NULL, NULL, NULL, 0, 19);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `rol`) VALUES
(1, 'mx-ogonzalez', 'Kayser2024', 'oe.gonzalez@kayser-automotive.com', 'Administrador'),
(2, 'mx-asanchez', 'Kayser2024', 'a.sanchez@kayser-automotive.com', 'Usuario'),
(3, 'mx-azarate', 'Kayser2024*', 'a.zarate@kayser-automotive.com', 'Administrador'),
(4, 'mx-fgonzalez', 'Kayser2024', 'f.gonzalez@kayser-automotive.com', 'Usuario'),
(6, 'mx-rpablo', 'Kayser2024', 'j.rosasquiroz@kayser-automotive.com', 'Usuario'),
(7, 'mx-fsanchez', 'Kayser2024', 'p.it@kayser-automotive.com', 'Usuario');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerta`
--
ALTER TABLE `alerta`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_identificador` (`Identificador`);

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_fallas`
--
ALTER TABLE `check_fallas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `falla_id` (`falla_id`);

--
-- Indexes for table `elementos`
--
ALTER TABLE `elementos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Falla1` (`Falla1`),
  ADD KEY `fk_Falla2` (`Falla2`),
  ADD KEY `fk_Falla3` (`Falla3`),
  ADD KEY `fk_Falla4` (`Falla4`),
  ADD KEY `fk_Falla5` (`Falla5`),
  ADD KEY `fk_Falla6` (`Falla6`),
  ADD KEY `fk_Falla7` (`Falla7`),
  ADD KEY `fk_Falla8` (`Falla8`),
  ADD KEY `fk_Falla9` (`Falla9`),
  ADD KEY `fk_Falla10` (`Falla10`),
  ADD KEY `fk_Falla11` (`Falla11`),
  ADD KEY `fk_Falla12` (`Falla12`);

--
-- Indexes for table `fallas`
--
ALTER TABLE `fallas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fallas2`
--
ALTER TABLE `fallas2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_caracteristica` (`id_caracteristica`);

--
-- Indexes for table `fallas3`
--
ALTER TABLE `fallas3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardar_check`
--
ALTER TABLE `guardar_check`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elemento_id` (`elemento_id`);

--
-- Indexes for table `guardar_dato`
--
ALTER TABLE `guardar_dato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `historial_escaneos`
--
ALTER TABLE `historial_escaneos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elemento_id` (`elemento_id`);

--
-- Indexes for table `identificadorareas`
--
ALTER TABLE `identificadorareas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meses`
--
ALTER TABLE `meses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alerta` (`id_alerta`);

--
-- Indexes for table `reportes2`
--
ALTER TABLE `reportes2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servidores`
--
ALTER TABLE `servidores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerta`
--
ALTER TABLE `alerta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33845;

--
-- AUTO_INCREMENT for table `check_fallas`
--
ALTER TABLE `check_fallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `elementos`
--
ALTER TABLE `elementos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `fallas`
--
ALTER TABLE `fallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `fallas3`
--
ALTER TABLE `fallas3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `guardar_check`
--
ALTER TABLE `guardar_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2453;

--
-- AUTO_INCREMENT for table `guardar_dato`
--
ALTER TABLE `guardar_dato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `historial_escaneos`
--
ALTER TABLE `historial_escaneos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `meses`
--
ALTER TABLE `meses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `reportes2`
--
ALTER TABLE `reportes2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `servidores`
--
ALTER TABLE `servidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `check_fallas`
--
ALTER TABLE `check_fallas`
  ADD CONSTRAINT `check_fallas_ibfk_1` FOREIGN KEY (`falla_id`) REFERENCES `fallas` (`id`);

--
-- Constraints for table `elementos`
--
ALTER TABLE `elementos`
  ADD CONSTRAINT `fk_Falla1` FOREIGN KEY (`Falla1`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla10` FOREIGN KEY (`Falla10`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla11` FOREIGN KEY (`Falla11`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla12` FOREIGN KEY (`Falla12`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla2` FOREIGN KEY (`Falla2`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla3` FOREIGN KEY (`Falla3`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla4` FOREIGN KEY (`Falla4`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla5` FOREIGN KEY (`Falla5`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla6` FOREIGN KEY (`Falla6`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla7` FOREIGN KEY (`Falla7`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla8` FOREIGN KEY (`Falla8`) REFERENCES `fallas` (`id`),
  ADD CONSTRAINT `fk_Falla9` FOREIGN KEY (`Falla9`) REFERENCES `fallas` (`id`);

--
-- Constraints for table `fallas2`
--
ALTER TABLE `fallas2`
  ADD CONSTRAINT `fallas2_ibfk_1` FOREIGN KEY (`id_caracteristica`) REFERENCES `fallas` (`id`);

--
-- Constraints for table `guardar_check`
--
ALTER TABLE `guardar_check`
  ADD CONSTRAINT `guardar_check_ibfk_1` FOREIGN KEY (`elemento_id`) REFERENCES `elementos` (`id`);

--
-- Constraints for table `historial_escaneos`
--
ALTER TABLE `historial_escaneos`
  ADD CONSTRAINT `historial_escaneos_ibfk_1` FOREIGN KEY (`elemento_id`) REFERENCES `elementos` (`id`);

--
-- Constraints for table `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`id_alerta`) REFERENCES `alerta` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `copiar_tabla_diaria` ON SCHEDULE EVERY 1 DAY STARTS '2024-08-08 17:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    CALL copiar_datos();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
