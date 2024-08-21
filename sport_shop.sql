-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 19-08-2024 a las 07:01:38
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
-- Base de datos: `sport_shop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `email_cliente` varchar(100) DEFAULT NULL,
  `direccion_cliente` text DEFAULT NULL,
  `telefono_cliente` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `numero_tarjeta` varchar(16) DEFAULT NULL,
  `fecha_vencimiento` varchar(5) DEFAULT NULL,
  `cvv` varchar(3) DEFAULT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `nombre_cliente`, `email_cliente`, `direccion_cliente`, `telefono_cliente`, `total`, `numero_tarjeta`, `fecha_vencimiento`, `cvv`, `fecha_compra`) VALUES
(1, 'Cliente Ejemplo', 'cliente@ejemplo.com', '123 Calle Ejemplo', '123456789', 80.00, '1214125136346425', '01/02', '123', '2024-08-17 06:39:25'),
(2, 'jorge', 'thiagobustosvalenzuela01@gmail.com', '1231414', '123456789', 90.00, '1242145125423523', '01/02', '123', '2024-08-17 07:37:19'),
(4, 'Test', 'thiagobustosvalenzuela01@gmail.com', 'Test123', '123456789', 10.00, '1231421413554215', '01/02', '123', '2024-08-17 19:34:36'),
(5, 'test', 'test', 'test', '123456789', 10.00, '1234134314513452', '01/02', '123', '2024-08-17 19:38:25'),
(6, '', '', '', '123456789', 20.00, '', '', '', '2024-08-17 19:39:04'),
(7, 'test', 'test@gmail.com', '12312', '123456789', 10.00, '1234567891011123', '01/02', '123', '2024-08-17 19:51:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `nombre_producto` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `nombre_producto`, `precio`, `cantidad`) VALUES
(1, 1, 'Pelota de Tenis', 10.00, 2),
(2, 1, 'Gafas de Natación', 20.00, 1),
(3, 1, 'Traje de Baño', 40.00, 1),
(4, 2, 'Raqueta de Tenis', 50.00, 1),
(5, 2, 'Gafas de Natación', 20.00, 2),
(6, 4, 'Pelota de Tenis', 10.00, 1),
(7, 5, 'Pelota de Tenis', 10.00, 1),
(8, 6, 'Gafas de Natación', 20.00, 1),
(9, 7, 'Pelota de Tenis', 10.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `client_name`, `client_email`, `client_address`, `created_at`) VALUES
(1, 'test', 'asda@gmail.com', '1', '2024-08-18 02:52:07'),
(2, 'test', 'asda@gmail.com', '1', '2024-08-18 02:54:11'),
(3, 'test', 'asda@gmail.com', '1', '2024-08-18 02:55:16'),
(4, 'test', 'asda@gmail.com', '1', '2024-08-18 05:59:27'),
(5, 'test', 'asda@gmail.com', '1', '2024-08-18 06:02:34'),
(6, 'asd', 'asda@gmail.com', '1', '2024-08-18 17:31:52'),
(7, 'test', 'asda@gmail.com', '1', '2024-08-19 01:25:55'),
(8, 'test', 'asda@gmail.com', '1', '2024-08-19 01:35:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 4, 'Camiseta de Fútbol', 1, 75.00),
(2, 5, 'Camiseta de Fútbol', 2, 75.00),
(3, 5, 'Balón de Fútbol', 1, 25.00),
(4, 6, 'Guantes de Boxeo', 1, 60.00),
(5, 6, 'Balón de Baloncesto', 1, 30.00),
(6, 7, 'Raqueta de Tenis', 3, 50.00),
(7, 8, 'Raqueta de Tenis', 3, 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `categoria`, `imagen`) VALUES
(1, 'Balón de Fútbol', 25.00, 'futbol', 'https://th.bing.com/th/id/OIP.gsP0lCclklXwtovliu8x2gHaHR?rs=1&pid=ImgDetMain'),
(2, 'Camiseta de Fútbol', 75.00, 'futbol', 'https://www.kandiny.cl/images/webp/Europe/EUBH001_1.webp'),
(3, 'Raqueta de Tenis', 50.00, 'tenis', 'https://th.bing.com/th/id/OIP.4wvNrT1EEi3dE6jjrCwNggAAAA?rs=1&pid=ImgDetMain'),
(4, 'Pelota de Tenis', 10.00, 'tenis', 'https://contents.mediadecathlon.com/p152665/k$0f4b43adaff6a83bae78b7459746fe3c/jumbo-tennis-ball-yellow.jpg?&f=800x800'),
(5, 'Gafas de Natación', 20.00, 'natacion', 'https://s.libertaddigital.com/2022/06/23/gafas-de-natacion-aqtivaqua-dx.jpg'),
(6, 'Traje de Baño', 40.00, 'natacion', 'https://contents.mediadecathlon.com/p1789834/k$a366848c8ef5dc27186f38838b90b9f0/sq/Traje+Nataci+n+Mar+Abierto+OWS+Hombre+Neopreno+2+2+mm.jpg'),
(7, 'Guantes de Boxeo', 60.00, 'boxeo', 'https://th.bing.com/th/id/R.9b9cacaced09077a3c1096ec760e1992?rik=Bzja5v5yMt9pXQ&pid=ImgRaw&r=0'),
(8, 'Saco de Boxeo', 120.00, 'boxeo', 'https://carulla.vtexassets.com/arquivos/ids/298603/saco-de-boxeo-everlast-sh4006wb-60-lbs-13-pulg-x34-pulg-negro.jpg?v=637104367250570000'),
(9, 'Balón de Baloncesto', 30.00, 'baloncesto', 'https://contents.mediadecathlon.com/p298557/k$74a7f525136224fac43390162df7b775/sq/Bal+n+de+baloncesto+SPALDING+NBA+ALL+STAR+talla+7.jpg'),
(10, 'Zapatillas de Baloncesto', 85.00, 'baloncesto', 'https://th.bing.com/th/id/OIP.-v922-ELvugjYEGlR-5tygAAAA?rs=1&pid=ImgDetMain'),
(11, 'Guantes de Softball', 35.00, 'softball', 'https://th.bing.com/th/id/OIP.L8GWjnxXxesKUxMRYH2hswHaHa?rs=1&pid=ImgDetMain'),
(12, 'Bate de Softball', 70.00, 'softball', 'https://images-na.ssl-images-amazon.com/images/I/71JdkYHLY3L._AC_SL1500_.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contrasena`) VALUES
(15, 'Test', '$2y$10$WXDTGtjUWS6bdDdsKgf34OVL8nU5/zjQLeaSb/rn8YNnzs1X58TNW'),
(16, 'Test123', '$2y$10$KZbxtRK3/YP/Tz0aDXNMC..uEBHZT8XUDnI//N4tP.v69QU83Kkt6'),
(17, 'registrotest', '$2y$10$r3.pC2HWPToB1R.nMIAcuupHliKH26Vih/AP1VcmHvZ/B.fygtq/e'),
(19, 'registrotest123', '$2y$10$d0qAerysz8.XMVsdT/MMsuJKe1SJXj2WwYV61Lkvkur6IuPDzB8NS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

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
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`);

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
