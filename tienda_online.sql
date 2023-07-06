-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2023 a las 02:52:00
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas_`
--

CREATE TABLE `caracteristicas_` (
  `id` int(11) NOT NULL,
  `caracteristica` varchar(30) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caracteristicas_`
--

INSERT INTO `caracteristicas_` (`id`, `caracteristica`, `activo`) VALUES
(1, 'talle', 0),
(2, 'color', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `dni`, `estatus`, `fecha_alta`, `fecha_modifica`, `fecha_baja`) VALUES
(1, 'david', 'García', 'garciad980@gmail.com', '02604604309', '45654654', 1, '2023-05-23 23:29:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `medio_pago` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_transaccion`, `fecha`, `status`, `medio_pago`, `email`, `id_cliente`, `total`) VALUES
(1, '27A946968X782981G', '2023-05-23 01:56:13', 'COMPLETED', NULL, 'sb-jdz9u25493243@personal.example.com', 'NZGAKN79LFZLC', 4480.00),
(2, '74M90131R03269154', '2023-05-23 02:07:39', 'COMPLETED', NULL, 'sb-jdz9u25493243@personal.example.com', 'NZGAKN79LFZLC', 1600.00),
(3, '6CP13252DM575623B', '2023-05-23 02:14:50', 'COMPLETED', NULL, 'sb-jdz9u25493243@personal.example.com', 'NZGAKN79LFZLC', 2880.00),
(4, '8F876690J44952404', '2023-05-23 02:17:12', 'COMPLETED', NULL, 'sb-jdz9u25493243@personal.example.com', 'NZGAKN79LFZLC', 2880.00),
(5, '84B07764LD834731D', '2023-05-23 02:19:36', 'COMPLETED', NULL, 'sb-jdz9u25493243@personal.example.com', 'NZGAKN79LFZLC', 4480.00),
(6, '8ES77369BH950363W', '2023-05-23 14:36:27', 'COMPLETED', NULL, 'sb-jdz9u25493243@personal.example.com', 'NZGAKN79LFZLC', 4480.00),
(7, '2R235145T8420600C', '2023-05-23 14:53:38', 'COMPLETED', NULL, 'garciad980@gmail.com', 'NZGAKN79LFZLC', 6080.00),
(8, '5AE76945P7794615A', '2023-05-23 14:55:26', 'COMPLETED', NULL, 'garciad980@gmail.com', 'NZGAKN79LFZLC', 6400.00),
(9, '1YR66456442371126', '2023-05-23 14:56:53', 'COMPLETED', NULL, 'garciad980@gmail.com', '1', 8640.00),
(10, '2AP08893J5717782W', '2023-05-23 15:21:16', 'COMPLETED', NULL, 'garciad980@gmail.com', '1', 3200.00),
(26, '1313073694', '2023-05-23 19:26:14', 'COMPLETED', 'Mercado Pago', 'garciad980@gmail.com', '1', 0.00),
(27, '1313073832', '2023-05-23 19:36:02', 'COMPLETED', 'Mercado Pago', 'garciad980@gmail.com', '1', 0.00),
(28, '1315168297', '2023-05-23 21:31:06', 'COMPLETED', 'Mercado Pago', 'garciad980@gmail.com', '1', 0.00),
(29, '1315168405', '2023-05-23 21:37:13', 'COMPLETED', 'Mercado Pago', 'garciad980@gmail.com', '1', 0.00),
(30, '1315168627', '2023-05-23 21:54:36', 'COMPLETED', 'Mercado Pago', 'garciad980@gmail.com', '1', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `nombre`, `precio`, `cantidad`) VALUES
(1, 1, 2, 'Sudadera Deportiva', 1600.00, 1),
(2, 1, 1, 'Remera StoneWash', 2880.00, 1),
(3, 2, 1, 'Remera StoneWash', 2880.00, 2),
(4, 2, 2, 'Sudadera Deportiva', 1600.00, 1),
(5, 3, 2, 'Sudadera Deportiva', 1600.00, 1),
(6, 4, 2, 'Sudadera Deportiva', 1600.00, 1),
(7, 1, 2, 'Sudadera Deportiva', 1600.00, 1),
(8, 1, 1, 'Remera StoneWash', 2880.00, 1),
(9, 2, 2, 'Sudadera Deportiva', 1600.00, 1),
(10, 3, 1, 'Remera StoneWash', 2880.00, 1),
(11, 4, 1, 'Remera StoneWash', 2880.00, 1),
(12, 5, 2, 'Sudadera Deportiva', 1600.00, 1),
(13, 5, 1, 'Remera StoneWash', 2880.00, 1),
(14, 6, 2, 'Sudadera Deportiva', 1600.00, 1),
(15, 6, 1, 'Remera StoneWash', 2880.00, 1),
(16, 7, 2, 'Sudadera Deportiva', 1600.00, 2),
(17, 7, 1, 'Remera StoneWash', 2880.00, 1),
(18, 8, 2, 'Sudadera Deportiva', 1600.00, 4),
(19, 9, 1, 'Remera StoneWash', 2880.00, 3),
(20, 10, 2, 'Sudadera Deportiva', 1600.00, 2),
(21, 18, 2, 'Sudadera Deportiva', 1600.00, 2),
(22, 19, 2, 'Sudadera Deportiva', 1600.00, 2),
(23, 20, 2, 'Sudadera Deportiva', 1600.00, 2),
(24, 21, 2, 'Sudadera Deportiva', 1600.00, 3),
(25, 22, 2, 'Sudadera Deportiva', 1600.00, 5),
(26, 23, 2, 'Sudadera Deportiva', 1600.00, 10),
(27, 24, 2, 'Sudadera Deportiva', 1600.00, 7),
(28, 25, 2, 'Sudadera Deportiva', 1600.00, 7),
(29, 26, 2, 'Sudadera Deportiva', 1600.00, 7),
(30, 26, 1, 'Remera StoneWash', 2880.00, 1),
(31, 27, 2, 'Sudadera Deportiva', 1600.00, 7),
(32, 27, 1, 'Remera StoneWash', 2880.00, 1),
(33, 28, 2, 'Sudadera Deportiva', 1600.00, 7),
(34, 28, 1, 'Remera StoneWash', 2880.00, 1),
(35, 29, 2, 'Sudadera Deportiva', 1600.00, 7),
(36, 29, 1, 'Remera StoneWash', 2880.00, 1),
(37, 30, 2, 'Sudadera Deportiva', 1600.00, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_prod_caracter`
--

CREATE TABLE `det_prod_caracter` (
  `id` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_caracteristica` int(11) NOT NULL,
  `valor` varchar(30) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `det_prod_caracter`
--

INSERT INTO `det_prod_caracter` (`id`, `id_prod`, `id_caracteristica`, `valor`, `stock`) VALUES
(1, 1, 1, 'L', 3),
(2, 1, 1, 'XL', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `id_categoria`, `activo`) VALUES
(1, 'Remera StoneWash', 'Remera Stonewash\n100% Algodón\nTécnica: Serigrafía Tintas Al Agua.\nEstampado Blanco', 3200, 10, 1, 1),
(2, 'Sudadera Deportiva', 'Sudadera Deportiva\r\nSet Deportivo 100% Poliester\r\n', 1600, 0, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_password` int(11) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `activacion`, `token`, `token_password`, `password_request`, `id_cliente`) VALUES
(1, 'gfa32', '$2y$10$cSR/bsRtJg5RVRRFYrY5eu6.XdbNs1LE.gCZqVyfownV18gdSReYa', 1, '388acaf5967d33ce67fa9e02c9bd3036', 0, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caracteristicas_`
--
ALTER TABLE `caracteristicas_`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `det_prod_caracter`
--
ALTER TABLE `det_prod_caracter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_det_prod` (`id_prod`),
  ADD KEY `fk_det_caracter` (`id_caracteristica`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caracteristicas_`
--
ALTER TABLE `caracteristicas_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `det_prod_caracter`
--
ALTER TABLE `det_prod_caracter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `det_prod_caracter`
--
ALTER TABLE `det_prod_caracter`
  ADD CONSTRAINT `fk_det_caracter` FOREIGN KEY (`id_caracteristica`) REFERENCES `caracteristicas_` (`id`),
  ADD CONSTRAINT `fk_det_prod` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
