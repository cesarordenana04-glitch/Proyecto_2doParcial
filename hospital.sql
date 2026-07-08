-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2026 a las 00:15:35
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
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE `citas_medicas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text NOT NULL,
  `registrado_por` int(11) DEFAULT NULL,
  `estado` enum('Pendiente','Confirmada','Atendida','Cancelada') DEFAULT 'Pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas_medicas`
--

INSERT INTO `citas_medicas` (`id`, `paciente_id`, `medico_id`, `fecha`, `hora`, `motivo`, `registrado_por`, `estado`, `created_at`) VALUES
(3, 3, 10, '2026-07-22', '17:08:00', 'Fractura en la clavicula', 1, 'Cancelada', '2026-07-08 19:08:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_factura`
--

CREATE TABLE `detalles_factura` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `servicio_id` int(11) DEFAULT NULL,
  `descripcion_personalizada` varchar(255) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_factura`
--

INSERT INTO `detalles_factura` (`id`, `factura_id`, `servicio_id`, `descripcion_personalizada`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 'sasd', 1, 30.00),
(2, 1, 1, 'sfsdfsd', 1, 30.00),
(3, 2, 3, 'Descripcion', 1, 15.00),
(4, 3, 3, 'Descripcion', 1, 15.00),
(5, 3, 2, 'Descripcion', 1, 50.00),
(6, 4, 2, 'Descripcion', 1, 50.00),
(7, 4, 2, 'Descripcion', 1, 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Cardiología', 'Estudio, diagnóstico y tratamiento de las enfermedades del corazón y del sistema circulatorio.'),
(2, 'Pediatría', 'Rama de la medicina que involucra la atención médica de bebés, niños y adolescentes.'),
(3, 'Dermatología', 'Especialidad encargada del estudio de la estructura y función de la piel, así como de sus enfermedades.'),
(4, 'Traumatología', 'Estudio de las lesiones del aparato locomotor y sus tratamientos.'),
(5, 'Gastroenterología', 'Especialidad médica que se ocupa de las enfermedades del aparato digestivo y órganos asociados.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `numero_comprobante` varchar(50) NOT NULL,
  `fecha_emision` date NOT NULL,
  `forma_pago` enum('Efectivo','Tarjeta de Débito','Tarjeta de Crédito','Transferencia') DEFAULT 'Efectivo',
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Pagada','Pendiente','Anulada') DEFAULT 'Pagada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `paciente_id`, `numero_comprobante`, `fecha_emision`, `forma_pago`, `subtotal`, `iva`, `total`, `estado`, `created_at`) VALUES
(1, 5, 'COMP-001', '2026-07-08', 'Efectivo', 60.00, 9.00, 69.00, 'Anulada', '2026-07-08 21:32:43'),
(2, 4, 'COMP-002', '2026-07-08', 'Tarjeta de Débito', 15.00, 2.25, 17.25, 'Anulada', '2026-07-08 21:34:01'),
(3, 4, 'COMP-003', '2026-07-08', 'Tarjeta de Débito', 65.00, 9.75, 74.75, 'Anulada', '2026-07-08 21:45:01'),
(4, 4, 'COMP-004', '2026-07-08', 'Tarjeta de Crédito', 100.00, 15.00, 115.00, 'Anulada', '2026-07-08 22:02:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historiales_clinicos`
--

CREATE TABLE `historiales_clinicos` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `cita_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `antecedentes_personales` text DEFAULT NULL,
  `motivo_consulta` text NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento_receta` text NOT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historiales_clinicos`
--

INSERT INTO `historiales_clinicos` (`id`, `paciente_id`, `medico_id`, `cita_id`, `fecha`, `antecedentes_personales`, `motivo_consulta`, `diagnostico`, `tratamiento_receta`, `observaciones`, `created_at`) VALUES
(2, 1, 10, NULL, '2026-07-28', 'tibia fracturada por accidente de transito', 'Hincón en la tibia ', 'No ha realizado las terapias de recuperación', 'Hacer terapia y paracetamol', 'Descansar bien', '2026-07-08 19:49:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id`, `nombre`, `apellido`, `especialidad`, `telefono`) VALUES
(6, 'Juan', 'Pérez', 'Cardiología', '0991234567'),
(7, 'María', 'García', 'Pediatría', '0998765432'),
(8, 'Luis', 'Mora', 'Medicina General', '0995556667'),
(9, 'Ana', 'Martínez', 'Ginecología', '0994443332'),
(10, 'Carlos', 'Cevallos', 'Traumatología', '0998881112');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `cedula_identidad` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `cedula_identidad`, `nombre`, `apellido`, `fecha_nacimiento`, `telefono`, `correo`, `created_at`) VALUES
(1, '0931787535', 'Gabriel', 'Urgiles', '2004-09-25', '0998873972', 'Admin@gmail.com', '2026-07-08 08:44:07'),
(3, '0941011546', 'Rania', 'Ostaiza', '2004-10-01', '0994462104', 'raniaOstaiza@gmail.com', '2026-07-08 09:07:55'),
(4, '0991032466', 'Cesar', 'Ordeñana', '2004-07-04', '0995731528', 'CesarOr@gmail.com', '2026-07-08 09:37:09'),
(5, '0910932466', 'Alejandra', 'Rueda', '2003-07-12', '0998942555', 'Alepro@gmail.com', '2026-07-08 09:57:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo` enum('Consulta','Examen','Procedimiento','Otro') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `tipo`, `precio`, `activo`) VALUES
(1, 'Consulta Médica General', 'Consulta', 30.00, 1),
(2, 'Consulta con Especialista', 'Consulta', 50.00, 1),
(3, 'Biometría Hemática Completa', 'Examen', 15.00, 1),
(4, 'Electrocardiograma', 'Examen', 25.00, 1),
(5, 'Radiografía de Tórax', 'Examen', 20.00, 1),
(6, 'Ecografía Abdominal', 'Examen', 35.00, 1),
(7, 'Curación de Herida Menor', 'Procedimiento', 10.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `signos_vitales`
--

CREATE TABLE `signos_vitales` (
  `id` int(11) NOT NULL,
  `historial_id` int(11) NOT NULL,
  `presion_arterial` varchar(20) DEFAULT NULL,
  `frecuencia_cardiaca` varchar(20) DEFAULT NULL,
  `temperatura` varchar(10) DEFAULT NULL,
  `saturacion_o2` varchar(10) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
  `talla` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `signos_vitales`
--

INSERT INTO `signos_vitales` (`id`, `historial_id`, `presion_arterial`, `frecuencia_cardiaca`, `temperatura`, `saturacion_o2`, `peso`, `talla`) VALUES
(2, 2, '120mmHg', '89bpm', '32.2 C', '85 %', '80 kg', '181 cm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) DEFAULT 'Administrativo',
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `activo`, `created_at`) VALUES
(1, 'Admin', 'Admin@gmail.com', 'Admin1234', 'Administrador', 1, '2026-07-08 02:14:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`),
  ADD KEY `registrado_por` (`registrado_por`);

--
-- Indices de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_comprobante` (`numero_comprobante`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `historiales_clinicos`
--
ALTER TABLE `historiales_clinicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cita_id` (`cita_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula_identidad` (`cedula_identidad`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `signos_vitales`
--
ALTER TABLE `signos_vitales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_id` (`historial_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historiales_clinicos`
--
ALTER TABLE `historiales_clinicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `signos_vitales`
--
ALTER TABLE `signos_vitales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD CONSTRAINT `citas_medicas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_medicas_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_medicas_ibfk_3` FOREIGN KEY (`registrado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD CONSTRAINT `detalles_factura_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_factura_ibfk_2` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historiales_clinicos`
--
ALTER TABLE `historiales_clinicos`
  ADD CONSTRAINT `historiales_clinicos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historiales_clinicos_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historiales_clinicos_ibfk_3` FOREIGN KEY (`cita_id`) REFERENCES `citas_medicas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `signos_vitales`
--
ALTER TABLE `signos_vitales`
  ADD CONSTRAINT `signos_vitales_ibfk_1` FOREIGN KEY (`historial_id`) REFERENCES `historiales_clinicos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
