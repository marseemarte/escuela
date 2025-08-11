-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2025 a las 14:01:14
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
-- Base de datos: `tablas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_visto`
--

CREATE TABLE `archivos_visto` (
  `id` int(11) NOT NULL,
  `id_archivo` int(11) NOT NULL,
  `id_asignacionesalumnos` int(11) NOT NULL,
  `visto` tinyint(4) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistenciasalumnos`
--

CREATE TABLE `inasistenciasalumnos` (
  `id` int(11) NOT NULL,
  `id_asignacionesalumnos` int(11) NOT NULL,
  `cupof` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `turno` varchar(1) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `justificado` varchar(1) NOT NULL,
  `dni_personal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `tamanio` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `fecha_subida` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `id_revista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_alumnos`
--

CREATE TABLE `tareas_alumnos` (
  `id` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_asignacionesalumnos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nombre_archivo` varchar(150) NOT NULL,
  `borrado_fisico` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_notas`
--

CREATE TABLE `tareas_notas` (
  `id` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_asignacionesalumnos` int(11) NOT NULL,
  `nota` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_visto`
--
ALTER TABLE `archivos_visto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id archivo` (`id_archivo`),
  ADD KEY `id asig` (`id_asignacionesalumnos`);

--
-- Indices de la tabla `inasistenciasalumnos`
--
ALTER TABLE `inasistenciasalumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_asignacionesalumnos` (`id_asignacionesalumnos`),
  ADD KEY `id_asignacionesalumnos_2` (`id_asignacionesalumnos`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id revista` (`id_revista`);

--
-- Indices de la tabla `tareas_alumnos`
--
ALTER TABLE `tareas_alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id tarea` (`id_tarea`),
  ADD KEY `id asig` (`id_asignacionesalumnos`);

--
-- Indices de la tabla `tareas_notas`
--
ALTER TABLE `tareas_notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tarea` (`id_tarea`),
  ADD KEY `id_asignacionesalumnos` (`id_asignacionesalumnos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos_visto`
--
ALTER TABLE `archivos_visto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inasistenciasalumnos`
--
ALTER TABLE `inasistenciasalumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas_alumnos`
--
ALTER TABLE `tareas_alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas_notas`
--
ALTER TABLE `tareas_notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
