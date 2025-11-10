-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2025 a las 02:30:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbsalon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `idCita` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idEstilista` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `duracion` float DEFAULT NULL,
  `idPromocion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`idCita`, `idCliente`, `idEstilista`, `fecha`, `hora`, `estado`, `duracion`, `idPromocion`) VALUES
(1, 1, 1, '2025-11-15', '10:00:00', 'COMPLETADA', 45, NULL),
(2, 2, 2, '2025-11-18', '14:00:00', 'CONFIRMADA', 30, 2),
(3, 3, 1, '2025-11-20', '16:00:00', 'PENDIENTE', 60, NULL),
(4, 1, 1, '2025-11-12', '11:00:00', 'COMPLETADA', 120, 1),
(5, 2, 2, '2025-11-22', '09:00:00', 'CONFIRMADA', 40, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citaservicio`
--

CREATE TABLE `citaservicio` (
  `idCita` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citaservicio`
--

INSERT INTO `citaservicio` (`idCita`, `idServicio`) VALUES
(1, 1),
(2, 2),
(3, 8),
(4, 3),
(5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_detalles`
--

CREATE TABLE `cita_detalles` (
  `idCitaDetalle` int(11) NOT NULL,
  `idCita` int(11) NOT NULL,
  `largo_cabello` varchar(20) DEFAULT NULL COMMENT 'corto, medio, largo',
  `tinturado_previo` tinyint(1) DEFAULT 0,
  `retiro_esmalte` tinyint(1) DEFAULT 0,
  `con_estilizado` tinyint(1) DEFAULT 0,
  `tiempo_adicional_total` int(11) DEFAULT 0 COMMENT 'Minutos adicionales calculados'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita_detalles`
--

INSERT INTO `cita_detalles` (`idCitaDetalle`, `idCita`, `largo_cabello`, `tinturado_previo`, `retiro_esmalte`, `con_estilizado`, `tiempo_adicional_total`) VALUES
(1, 1, 'medio', 0, 0, 0, 0),
(2, 4, 'largo', 1, 0, 0, 50),
(3, 5, NULL, 0, 1, 0, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correoElectronico` varchar(100) DEFAULT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` enum('CLIENTE','ESTILISTA','ADMIN') DEFAULT 'CLIENTE',
  `fechaNacimiento` date DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `comoConocio` varchar(50) DEFAULT NULL,
  `suscripcionNewsletter` tinyint(1) DEFAULT 1,
  `fechaRegistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombre`, `apellido`, `telefono`, `correoElectronico`, `clave`, `rol`, `fechaNacimiento`, `genero`, `comoConocio`, `suscripcionNewsletter`, `fechaRegistro`) VALUES
(1, 'Sofía', 'Ramírez', '7567-8901', 'sofia.ramirez@gmail.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'CLIENTE', '1995-03-15', 'femenino', 'redes_sociales', 1, '2024-09-15 10:30:00'),
(2, 'Diego', 'López', '7678-9012', 'diego.lopez@gmail.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'CLIENTE', '1990-07-22', 'masculino', 'recomendacion', 1, '2024-10-02 14:20:00'),
(3, 'Valeria', 'Torres', '7789-0123', 'valeria.torres@gmail.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'CLIENTE', '1998-11-08', 'femenino', 'publicidad', 0, '2024-11-01 09:15:00'),
(4, 'Andrea', 'Olmedo', '7155-3954', 'andrea.olmedo@gmail.com', '$2y$12$PbU4bQegcAD63hvSnFWp3O4Kvsms4wm7f/xKofLVvR4Kj/SBntZb2', 'CLIENTE', '2002-06-04', 'femenino', NULL, 0, '2025-11-09 19:26:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combo`
--

CREATE TABLE `combo` (
  `idCombo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precioCombo` decimal(10,2) NOT NULL,
  `precioRegular` decimal(10,2) NOT NULL,
  `ahorro` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `combo`
--

INSERT INTO `combo` (`idCombo`, `nombre`, `descripcion`, `precioCombo`, `precioRegular`, `ahorro`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Combo Belleza Total', 'Corte + Manicure + Pedicure', 38.00, 43.00, 5.00, 1, '2025-11-09 23:43:11', '2025-11-10 01:24:05'),
(2, 'Combo Renovación', 'Tinte + Corte + Limpieza Facial', 80.00, 90.00, 10.00, 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(3, 'Combo Express Hombre', 'Corte Hombre + Depilación Cejas + Masaje', 37.00, 42.00, 5.00, 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combo_servicio`
--

CREATE TABLE `combo_servicio` (
  `idComboServicio` int(11) NOT NULL,
  `idCombo` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `combo_servicio`
--

INSERT INTO `combo_servicio` (`idComboServicio`, `idCombo`, `idServicio`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(2, 1, 5, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(3, 1, 6, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(4, 2, 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(5, 2, 3, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(6, 2, 8, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(7, 3, 2, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(8, 3, 12, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(9, 3, 15, '2025-11-09 23:43:11', '2025-11-09 23:43:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correoElectronico` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `idRol` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idEmpleado`, `nombre`, `apellido`, `telefono`, `correoElectronico`, `clave`, `direccion`, `idRol`, `activo`) VALUES
(1, 'Andrea', 'Martínez', '7123-4567', 'andrea.martinez@beautysalon.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'Col. Escalón, San Salvador', 1, 1),
(2, 'Carlos', 'Hernández', '7234-5678', 'carlos.hernandez@beautysalon.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'Col. San Benito, San Salvador', 1, 1),
(3, 'María', 'González', '7345-6789', 'maria.gonzalez@beautysalon.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'Col. Maquilishuat, Santa Tecla', 2, 1),
(4, 'Roberto', 'Flores', '7456-7890', 'roberto.flores@beautysalon.com', '$2y$12$LQv3c1yDwmHFqB5f5hKJeOKd.BXMJHqYZ0WqI.YnJzLqS8tYvNxCi', 'Col. San Francisco, San Salvador', 3, 0),
(5, 'Francisco', 'Dubon', '7777-7777', 'francisco@gmail.com', '$2y$12$VqK9d3KHJUFF65IEba6tbutJ8awGveJBnUksHFZqrz1HUSOuNgdDa', 'sonsonate', 3, 1),
(6, 'Adriana', 'Fuentes', '71623954', 'estefanyfuentes010@gmail.com', '$2y$12$/RrCjuFqHpV7WDh7TGNNc.SKGWUVPHM9WXlg42vzFkdggkIODgFjG', 'Calle la ceiba, urbanización el sauce, sonzacate, sonsonate', 2, 1),
(7, 'Michelle', 'Zelada', '7425-6387', 'michelle.zelada@gmail.com', '$2y$12$6YIGB2Z8ZyVxt3Tf1aLyB.IPc2LLEwhh.JCjtSMjjjgPD99PXB/fa', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilista`
--

CREATE TABLE `estilista` (
  `idEstilista` int(11) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `passwordreset`
--

CREATE TABLE `passwordreset` (
  `idReset` int(11) NOT NULL,
  `tipoUsuario` enum('Empleado','Cliente') NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fechaExpiracion` datetime NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfilcliente`
--

CREATE TABLE `perfilcliente` (
  `idCliente` int(11) NOT NULL,
  `largoCabello` varchar(50) DEFAULT NULL,
  `tinturado` tinyint(1) DEFAULT 0,
  `esmaltePrevio` tinyint(1) DEFAULT 0,
  `tipoEsmaltado` varchar(50) DEFAULT NULL,
  `otrosTratamientos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion`
--

CREATE TABLE `promocion` (
  `idPromocion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `tipoDescuento` enum('porcentaje','fijo') NOT NULL,
  `valorDescuento` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `codigoPromocional` varchar(50) NOT NULL,
  `usosMaximos` int(11) DEFAULT NULL,
  `usosActuales` int(11) DEFAULT 0,
  `usosPorCliente` int(11) DEFAULT 1,
  `diasAplicables` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`diasAplicables`)),
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promocion`
--

INSERT INTO `promocion` (`idPromocion`, `nombre`, `descripcion`, `tipoDescuento`, `valorDescuento`, `descuento`, `fechaInicio`, `fechaFin`, `codigoPromocional`, `usosMaximos`, `usosActuales`, `usosPorCliente`, `diasAplicables`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Black Friday 2025', 'Descuento especial fin de año', 'porcentaje', 20.00, NULL, '2025-11-20', '2025-11-30', 'BLACK25', 50, 5, 1, '[\"lunes\",\"martes\",\"miercoles\",\"jueves\",\"viernes\",\"sabado\",\"domingo\"]', 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(2, 'Lunes Feliz', 'Descuento fijo todos los lunes', 'fijo', 5.00, NULL, '2025-11-01', '2025-12-31', 'LUNES5', 100, 12, 2, '[\"lunes\"]', 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(3, 'Primera Visita', 'Descuento para clientes nuevos', 'porcentaje', 15.00, NULL, '2025-01-01', '2025-12-31', 'BIENVENIDA', 200, 8, 1, '[\"lunes\",\"martes\",\"miercoles\",\"jueves\",\"viernes\",\"sabado\",\"domingo\"]', 1, '2025-11-09 23:43:11', '2025-11-09 23:43:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocioncombo`
--

CREATE TABLE `promocioncombo` (
  `idPromocion` int(11) NOT NULL,
  `idCombo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocionservicio`
--

CREATE TABLE `promocionservicio` (
  `idPromocion` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `idReporte` int(11) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `fechaGeneracion` date NOT NULL,
  `idEmpleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombre`, `descripcion`) VALUES
(1, 'estilista', 'Profesional que realiza servicios de belleza'),
(2, 'recepcionista', 'Encargado de atención al cliente y agenda'),
(3, 'admin', 'Administrador del sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precioBase` float NOT NULL,
  `duracionBase` float NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `ajustes_especiales` text DEFAULT NULL,
  `permite_promociones` tinyint(1) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `requiere_largo_cabello` tinyint(1) DEFAULT 0,
  `requiere_tinturado_previo` tinyint(1) DEFAULT 0,
  `requiere_retiro_esmalte` tinyint(1) DEFAULT 0,
  `requiere_estilizado` tinyint(1) DEFAULT 0,
  `tiempo_adicional_largo` int(11) DEFAULT 0 COMMENT 'Minutos adicionales por cabello largo',
  `tiempo_adicional_tinturado` int(11) DEFAULT 0 COMMENT 'Minutos adicionales por tinturado previo',
  `tiempo_adicional_esmalte` int(11) DEFAULT 0 COMMENT 'Minutos adicionales por retiro de esmalte',
  `tiempo_adicional_estilizado` int(11) DEFAULT 0 COMMENT 'Minutos adicionales por estilizado',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`idServicio`, `nombre`, `descripcion`, `precioBase`, `duracionBase`, `categoria`, `ajustes_especiales`, `permite_promociones`, `activo`, `requiere_largo_cabello`, `requiere_tinturado_previo`, `requiere_retiro_esmalte`, `requiere_estilizado`, `tiempo_adicional_largo`, `tiempo_adicional_tinturado`, `tiempo_adicional_esmalte`, `tiempo_adicional_estilizado`, `created_at`, `updated_at`) VALUES
(1, 'Corte de Cabello Mujer', 'Corte profesional con lavado y secado incluido', 15, 45, 'cabello', NULL, 1, 1, 1, 0, 0, 1, 15, 0, 0, 20, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(2, 'Corte de Cabello Hombre', 'Corte moderno con degradado', 12, 30, 'cabello', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(3, 'Tinte Completo', 'Aplicación de tinte con hidratación', 45, 120, 'cabello', NULL, 1, 1, 1, 1, 0, 0, 30, 20, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(4, 'Mechas Californianas', 'Técnica de mechas naturales', 55, 150, 'cabello', NULL, 1, 1, 1, 1, 0, 0, 30, 20, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(5, 'Manicure Tradicional', 'Limpieza, limado y esmaltado', 10, 40, 'unas', NULL, 1, 1, 0, 0, 1, 0, 0, 0, 10, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(6, 'Pedicure Spa', 'Pedicure con exfoliación e hidratación', 18, 60, 'unas', NULL, 1, 1, 0, 0, 1, 0, 0, 0, 15, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(7, 'Uñas Acrílicas', 'Aplicación de uñas acrílicas', 25, 90, 'unas', NULL, 1, 1, 0, 0, 1, 0, 0, 0, 15, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(8, 'Limpieza Facial Profunda', 'Limpieza con vapor y extracción', 30, 60, 'facial', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(9, 'Tratamiento Anti-edad', 'Tratamiento rejuvenecedor facial', 45, 75, 'facial', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(10, 'Maquillaje Social', 'Maquillaje para eventos especiales', 35, 45, 'maquillaje', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(11, 'Maquillaje de Novia', 'Maquillaje profesional para novias', 65, 90, 'maquillaje', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(12, 'Depilación de Cejas', 'Perfilado y depilación de cejas', 5, 15, 'depilacion', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(13, 'Depilación Facial Completa', 'Depilación de rostro completo', 12, 30, 'depilacion', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(14, 'Depilación de Piernas', 'Depilación completa de piernas con cera', 20, 45, 'depilacion', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(15, 'Masaje Relajante', 'Masaje de cuello, hombros y espalda', 25, 30, 'corporal', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11'),
(16, 'Exfoliación Corporal', 'Exfoliación completa del cuerpo', 35, 60, 'corporal', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2025-11-09 23:43:11', '2025-11-09 23:43:11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `cita_ibfk_2` (`idEstilista`),
  ADD KEY `fk_cita_promocion` (`idPromocion`);

--
-- Indices de la tabla `citaservicio`
--
ALTER TABLE `citaservicio`
  ADD PRIMARY KEY (`idCita`,`idServicio`),
  ADD KEY `idServicio` (`idServicio`);

--
-- Indices de la tabla `cita_detalles`
--
ALTER TABLE `cita_detalles`
  ADD PRIMARY KEY (`idCitaDetalle`),
  ADD KEY `idCita` (`idCita`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD UNIQUE KEY `correoElectronico` (`correoElectronico`);

--
-- Indices de la tabla `combo`
--
ALTER TABLE `combo`
  ADD PRIMARY KEY (`idCombo`);

--
-- Indices de la tabla `combo_servicio`
--
ALTER TABLE `combo_servicio`
  ADD PRIMARY KEY (`idComboServicio`),
  ADD KEY `fk_combo_servicio_combo` (`idCombo`),
  ADD KEY `fk_combo_servicio_servicio` (`idServicio`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD UNIQUE KEY `correoElectronico` (`correoElectronico`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `estilista`
--
ALTER TABLE `estilista`
  ADD PRIMARY KEY (`idEstilista`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `passwordreset`
--
ALTER TABLE `passwordreset`
  ADD PRIMARY KEY (`idReset`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `perfilcliente`
--
ALTER TABLE `perfilcliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `promocion`
--
ALTER TABLE `promocion`
  ADD PRIMARY KEY (`idPromocion`),
  ADD UNIQUE KEY `codigoPromocional` (`codigoPromocional`);

--
-- Indices de la tabla `promocioncombo`
--
ALTER TABLE `promocioncombo`
  ADD PRIMARY KEY (`idPromocion`,`idCombo`),
  ADD KEY `idCombo` (`idCombo`);

--
-- Indices de la tabla `promocionservicio`
--
ALTER TABLE `promocionservicio`
  ADD PRIMARY KEY (`idPromocion`,`idServicio`),
  ADD KEY `idServicio` (`idServicio`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`idReporte`),
  ADD KEY `idEmpleado` (`idEmpleado`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`idServicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cita_detalles`
--
ALTER TABLE `cita_detalles`
  MODIFY `idCitaDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `combo`
--
ALTER TABLE `combo`
  MODIFY `idCombo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `combo_servicio`
--
ALTER TABLE `combo_servicio`
  MODIFY `idComboServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `passwordreset`
--
ALTER TABLE `passwordreset`
  MODIFY `idReset` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `promocion`
--
ALTER TABLE `promocion`
  MODIFY `idPromocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`idEstilista`) REFERENCES `empleado` (`idEmpleado`),
  ADD CONSTRAINT `fk_cita_promocion` FOREIGN KEY (`idPromocion`) REFERENCES `promocion` (`idPromocion`) ON DELETE SET NULL;

--
-- Filtros para la tabla `citaservicio`
--
ALTER TABLE `citaservicio`
  ADD CONSTRAINT `citaservicio_ibfk_1` FOREIGN KEY (`idCita`) REFERENCES `cita` (`idCita`),
  ADD CONSTRAINT `citaservicio_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`);

--
-- Filtros para la tabla `cita_detalles`
--
ALTER TABLE `cita_detalles`
  ADD CONSTRAINT `cita_detalles_ibfk_1` FOREIGN KEY (`idCita`) REFERENCES `cita` (`idCita`) ON DELETE CASCADE;

--
-- Filtros para la tabla `combo_servicio`
--
ALTER TABLE `combo_servicio`
  ADD CONSTRAINT `fk_combo_servicio_combo` FOREIGN KEY (`idCombo`) REFERENCES `combo` (`idCombo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_combo_servicio_servicio` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`);

--
-- Filtros para la tabla `estilista`
--
ALTER TABLE `estilista`
  ADD CONSTRAINT `estilista_ibfk_1` FOREIGN KEY (`idEstilista`) REFERENCES `empleado` (`idEmpleado`);

--
-- Filtros para la tabla `perfilcliente`
--
ALTER TABLE `perfilcliente`
  ADD CONSTRAINT `perfilcliente_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Filtros para la tabla `promocioncombo`
--
ALTER TABLE `promocioncombo`
  ADD CONSTRAINT `promocioncombo_ibfk_1` FOREIGN KEY (`idPromocion`) REFERENCES `promocion` (`idPromocion`),
  ADD CONSTRAINT `promocioncombo_ibfk_2` FOREIGN KEY (`idCombo`) REFERENCES `combo` (`idCombo`);

--
-- Filtros para la tabla `promocionservicio`
--
ALTER TABLE `promocionservicio`
  ADD CONSTRAINT `promocionservicio_ibfk_1` FOREIGN KEY (`idPromocion`) REFERENCES `promocion` (`idPromocion`),
  ADD CONSTRAINT `promocionservicio_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`);

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
