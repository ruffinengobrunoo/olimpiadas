-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2024 a las 02:49:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerse`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `contraseña`) VALUES
(1, 'thiagoadmin', 'contra'),
(2, 'blitadmin', 'administrar1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_articulo` int(10) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` text COLLATE utf8_bin DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `nombre`, `precio`, `descripcion`, `stock`, `imagen`) VALUES
(1, 'Camiseta Uruguay', '130000.00', 'jaja son de provincia', 3, 'https://http2.mlstatic.com/D_NQ_NP_824129-MLA78196358951_082024-O.webp'),
(11, 'Camiseta Argentina ', '180000.00', 'BICAMPEONES DE AMERICA', 1, 'https://afaar.vtexassets.com/arquivos/ids/156640/IP8403_FC_eCom.jpg?v=638459548133600000'),
(12, 'Camiseta Venezuela', '110000.00', 'la seleccion vino tinto', 1, 'https://www.thunderinternacional.com/cdn/shop/files/8KItbBMzz5SonLt.jpg?v=1712151715');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `id_tipUs` int(10) NOT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `direction` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `direction`) VALUES
(1, 'ThagoPrueba', '$2y$10$ik09b0e3ktPPermHrAp8LOAqnscPQ3Runu0Je5QU4gJTRfn4p/b8u', 'Espora 645'),
(10, 'FilasAdmin', '$2y$10$AzTfsFgtlS4N1lsRvup17.pkdzsJKg5DTHLJTzRmTMi1z1YrwaUNS', 'siempre viva'),
(11, 'santino', '$2y$10$hfBHqkVamecFWlImXanm3.FTvrE//I1lH7lBwfEpXKrzZigWMFOC.', 'siempre viva123'),
(12, 'tomas', '$2y$10$8SBRMlabMSrfn7e5OYv0EOvRO1Ib6kCEV/lehKB6Qy4RrOe1e36/S', 'Mitre 3000'),
(13, 'fabian', '$2y$10$PwFwcgOJJ0Wka8z6poIJHutSCxkb0sU5JzHD6OncUyBE5D9Kw7fxa', 'mitre 3000'),
(14, 'aaa', '$2y$10$ujBWVQ8p6QVmtqeloOv7Suy511bC1X5s/ka5wVSxzCA4OU/CQeCMq', 'aaa'),
(15, 'ThagoUnico', '$2y$10$3reqCTTKdd3xTMMNN0REvO0yZzj3NMiAQ0.FHDYFzY38xMBTgbl9e', 'micasabuena123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`id_tipUs`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_articulo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
