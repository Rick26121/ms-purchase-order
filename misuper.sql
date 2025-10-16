-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-10-2025 a las 00:08:33
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `misuper`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_bancarias`
--

CREATE TABLE `cuentas_bancarias` (
  `id_cuenta` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `tipo_cuenta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `numero_cuenta` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `correo_asociado` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `titular` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cedula` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `banco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compras`
--

CREATE TABLE `ordenes_compras` (
  `id` int NOT NULL,
  `sucursal` int NOT NULL DEFAULT '1',
  `producto` int NOT NULL,
  `proveedores` int NOT NULL,
  `cantidad` int NOT NULL,
  `unidad` int NOT NULL,
  `totalGeneral` decimal(10,2) NOT NULL,
  `tasa_dia` decimal(10,2) NOT NULL,
  `moneda` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `iva` tinyint(1) NOT NULL,
  `totalbs` decimal(10,2) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `fecha_orden` date NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ordenes_compras`
--

INSERT INTO `ordenes_compras` (`id`, `sucursal`, `producto`, `proveedores`, `cantidad`, `unidad`, `totalGeneral`, `tasa_dia`, `moneda`, `iva`, `totalbs`, `created_at`, `updated_at`, `fecha_orden`, `estatus`, `visible`) VALUES
(1, 1, 3, 21, 22, 1, 22.00, 193.30, 'usd', 0, 4252.60, '2025-10-10', '2025-10-10', '2025-10-10', 1, 1),
(2, 1, 3, 21, 22, 1, 22.00, 193.30, 'usd', 0, 4252.60, '2025-10-10', '2025-10-10', '2025-10-10', 0, 1),
(3, 1, 4, 22, 1, 1, 5.00, 193.30, 'usd', 1, 1121.14, '2025-10-10', '2025-10-10', '2025-10-10', 0, 1),
(4, 1, 5, 20, 1, 1, 500.00, 195.25, 'usd', 80, 113245.00, '2025-10-11', '2025-10-11', '2025-10-11', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_moviles`
--

CREATE TABLE `pagos_moviles` (
  `id_pago_movil` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `banco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `rif_asociado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `updated_at`, `created_at`) VALUES
(3, 'aguita', 1.00, '2025-10-10', '2025-10-10'),
(4, 'dasd', 5.00, '2025-10-10', '2025-10-10'),
(5, 'balanza', 500.00, '2025-10-11', '2025-10-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `rif` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `correo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci,
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `rif`, `correo`, `telefono`, `direccion`, `fecha_registro`) VALUES
(19, '2PI C.A', 'J-502199128', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(20, 'A.V. PESAJES BALANZAS, C.A.', 'J-403001383', 'nan', 'nan', 'Av. Las ciencias con calle Codazzi, Qta. Coromoto-caracas', '2025-10-08 14:53:23'),
(21, 'ACEROS LAMINADOS C.A.', 'V-24.159.383', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(22, 'ACRILICOS VIRGUEZ', 'J-07521779-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(23, 'AIR VENCA', 'J-40031173-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(24, 'ALFARERIA GRES', 'J-08504433-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(25, 'ALQUI EQUIPOS', 'J-29454695-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(26, 'AMAZON', 'J-30069347-3', 'nan', 'nan', 'ZONA INDUSTRIAL I', '2025-10-08 14:53:23'),
(27, 'ASERRADERO INDUSTRIAL VENEZUELA', 'J-08517025-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(28, 'COMERCIAL LA COLMENA', 'J-31488981-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(29, 'COPIKAG GLOBAL ', 'J-41089216-1 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(30, 'DISTRIBUIDORA DEL FRIO, C.A.', 'J-50535419-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(31, 'FERRETERIA EPA C.A.', 'J-00271144-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(32, 'HGM', 'J-40931811-7', 'nan', '4123555688', 'AV PEDRO LEON TORRES CON CALLE 48', '2025-10-08 14:53:23'),
(33, 'HIERRO EXPRESS', 'J-5011564-9', 'nan', '4247087112', 'CALLE 23 ENTRE 24 Y AV VENEZUELA', '2025-10-08 14:53:23'),
(34, 'IMPORTADORA ARTIKIN ', 'J-407379038', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(35, 'INVERSIONES NAZAR', 'J-50097121-4', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(36, 'ITALMADERAS LARA 22, C.A', 'J-40213367-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(37, 'LA CASA DEL ACUEDUCTO C.A. ', 'J-30791197-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(38, 'LUBRICANTES SULBARAN', 'J-31088494-3', 'nan', '0424-5797330', 'AV ROMULO GALLEGOS ENTRE CARRERAS 30 Y 31', '2025-10-08 14:53:23'),
(39, 'M Y D LOGISTICA', 'J-40602410-4', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(40, 'MADETOR', 'J-07540970-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(41, 'MANGOCENTER, C.A.', 'J-29968295-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(42, 'MATERIALES Y DECORACIONES MG, C.A', 'J-31113278-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(43, 'PINTURAS BENAVIDES S.A. (CABUDARE)', 'J-29599191-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(44, 'REFRIGERACION EL NECTAR', 'J-50222202-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(45, 'REPARACIONES MENDOZA', 'V-19697585', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(46, 'ROLIAUTO LARA C.A.', 'J-30714396-7', 'nan', '4125220819', 'AV ROMULO GALLEGOS ENTRE VENEZUELA Y CARRERA 27', '2025-10-08 14:53:23'),
(47, 'SARVEN C.A.', 'J-408142490', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(48, 'SERVICIO TECNICO BJM ', 'J-31373001-7 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(49, 'TODOTUBO DEL CENTRO C.A. ', 'J-31613114-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(50, 'TOTAL TOOLS', 'J-502091807', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(51, 'VAL-PLAST', 'J-50086639-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(52, 'VICTOR MANUEL LOUREIRO PEREIRA', 'V-7420084', 'nan', '4245197702', 'nan', '2025-10-08 14:53:23'),
(53, 'MULTIMAX STORE, C.A.', 'J-50226790-5', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(54, 'FERRETAZO, C.A.', 'J-50242530-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(55, 'INNOVALED C.A.', 'J-406112658', 'INNOVALED@HOTMAIL.COM', '0251-4155415', 'CARRERA 1 ENTRE CALLES 2 Y3 NUEVA SEGOVIA', '2025-10-08 14:53:23'),
(56, 'INVERSIONES BURBUJAS 21 CA', 'J-317317661', 'nan', '1422018218', 'AV LARA CON CARRERA 1', '2025-10-08 14:53:23'),
(57, 'GRUPO ASIA CENTER ', 'J-40547456-4', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(58, 'PORTUMANIA ', 'J-40037478-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(59, 'INVERSIONES MAXI 2005,C.A', 'J-31173993-9 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(60, 'GUAROVISION', 'J-31658603-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(61, 'FERRETERIA PORTUGUESA', 'J-08500659-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(62, 'TELEPILA CENTER C.A', 'J-31558886-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(63, 'FERRETERIA RELAMPAGO C.A.', 'J-309488767 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(64, 'FIDEMA ', 'J-40208515-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(65, 'SEIPCA', 'J-504557218', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(66, 'DIANA FREITAS MERCADO LIBRE', 'V-30782748', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(67, 'INVERSORA SAN LORENZO', 'V-01124110-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(68, 'REFRI SERVICIOS D GONZALEZ II', 'J-50654606-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(69, 'SUMINISTROS ELECTRICOS G&L', 'J-40512807-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(70, 'MZ INGENIERIA ', 'J-29827511-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(71, 'MATERIALES ELECTRICOS Y CONSTRUCCIONES VENELCO CA', 'J-50083771-2 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(72, 'SERVICIOS PACIFICO, C.A.', 'J-31109672-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(73, 'DISTRIBUIDORA KATINAPO S.R.L.', 'J-30220709-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(74, 'CORPORACION GOLAR DE VENEZUELA', 'J-29821261-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(75, 'COMERCIAL FERREMUNDO ', 'J-295436203', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(76, 'FEDEVEN C.A.', 'J-29895043-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(77, 'CORPORACION DCM. C.A', 'J-40444575-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(78, 'ISIRACDP, C.A', 'J-29696704-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(79, 'FERREMORAN C.A.', 'J-40255590-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(80, 'ECODIGITAL C.A.', 'J-30672652-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(81, 'ANDRES MENDEZ', 'V-9613965', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(82, 'VPSOLUCIONES', 'V-25293519', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(83, 'RR INTEC', 'V-17194164', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(84, 'CANGURO', 'J-500455577', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(85, 'TORNI RODA BARQUISIMETO', 'J-50025738-4', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(86, 'TORNILLOS LARA', 'J-08501144-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(87, 'REDCURSOS C.A.', 'J-29725765-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(88, 'SERVICIOS Y SOLUCIONS TECNOLOGICAS C.A.', 'J-29788645-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(89, 'PINTURAS Y SUMINISTROS ZG ', 'J-50064170-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(90, 'CARJUED SERVICIOS GENERALES', 'J-40527713-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(91, 'FILTROS J.J.S. LARA', 'J-40979788-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(92, 'CARPITAP ', 'J-08520384-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(93, 'WILKER ANTONIO CASTILLO JUAREZ', 'V-29604455', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(94, 'JOSE ROJAS', 'V-10854956', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(95, 'PIOVESAN C.A', 'J-311059393 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(96, 'MAYRA DURAN CISTERNA ', 'V-9620913 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(97, 'FIBRA DE MADERA DE LARA C.A.', 'J-30543164-7 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(98, 'MECICA ', 'J-40654772-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(99, 'MULTISERVICIOS YEPEZ CA', 'J-31589425-4', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(100, 'MUNDO CARPINTERO ', 'J-0356628-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(101, 'METROTELAS CA', 'J402396791', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(102, 'MATERIALES DE ABREU', ' J-29503690-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(103, 'ROBERTO COSENTINO', 'V-4386344 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(104, 'HOME READY DEL ESTE ', 'J-412763725-5', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(105, 'INVERSIONES SOSA 19,11, CA', 'J-403992231', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(106, 'ELECTRONICA NUEVA SION C.A.', 'J-50383913-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(107, 'THELMO PEREZ VIELMA', 'V-9882722', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(108, 'RUEDAS Y MAS RUEDAS, C.A.', 'J-302984831', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(109, 'PINTURAS BENAVIDES S.A. (CENTRO)', 'J-31105939-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(110, 'EL PUNTO DEL HIERRO', 'J-501287759 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(111, 'FUTURE WATER C.A.', 'J-50101229-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(112, 'IMPORTADORA OCCIDENTAL DE VENEZUELA, CA', 'J-31210923-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(113, 'MULTISERVICIOS ARW ', 'J-40744878-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(114, 'FERRETANQUES H2O', 'J-41096157-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(115, 'EXPO FRIO C.A. ', 'J-29362839-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(116, 'SONIMAX MOVIL', 'V33165177', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(117, 'BALDOLARA C.A', 'J-30426773-8 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(118, '3113 REPRESENTACIONES', 'J-29450944-4 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(119, 'VICTOR JOSE RODRIGUEZ C.A.', 'J-08505667-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(120, 'COMERCIALIZADORA 1368 C.A', 'J-29850272-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(121, 'P.P.F, C.A (P.P.F, C.A)\r\n', 'J501106746', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(122, 'COMERCIAL SAFA MUNDO', 'J-405626607', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(123, 'CENTRO CONSTRURAMA, C. A,', ' J-40637490-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(124, 'FERREELECTRICA DEL ESTE, C.A.', 'J295931930', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(125, 'GRUPO HIERROCA LARA C.A.', 'J501156549', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(126, 'MARCO ALVAREZ', 'V-17.860.613', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(127, 'SONIA FERNANDEZ FERNANDEZ', 'V-13435096', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(128, 'LUIS PEREZ', 'V-7433003-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(129, 'AIRES VENEZUELA (AIRVENCA)', 'J-31003960-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(130, 'ARCOSAN BARQUISIMETO', 'J-085185330', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(131, 'DJM SISTEMAS DE SEGURIDAD', 'V20351420', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(132, 'ALFREDO ANTONIO PARADA COLMENAREZ', 'V-11792933', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(133, 'LUBRI REPUESTOS LA 17 CA', 'J411202711', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(134, 'INVERSIONES FERREMETAL', 'J503142189', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(135, 'GILBERTO FLORES', 'V25838554', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(136, 'TODO RUEDAS', 'J-50680407-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(137, 'PLASTIC PLANET', 'J-40209043-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(138, 'MULTISERVICIOS RUSO FRIO ', 'V-24397601-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(139, 'CONTROLES LARA', 'J301168712', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(140, 'RODDY PERAZA', 'V17572546', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(141, 'MAPLOCA C.A ', 'J-000244995', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(142, 'CARMEN VILLEGAS', 'V-15319136', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(143, 'ERICK RIVAS', 'V-22783060', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(144, 'CASTEL LARA', 'J-50261973-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(145, 'DISTRIBUIDORA DUNCAN C.A.', 'J085007636', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(146, 'VIDEO Y SONIDO CENTER C.A.', 'J-29700068-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(147, 'FERREMAX BQTO, CA', 'J-50036520-9 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(148, 'TECH SOLUTION STORE CA', 'V-15.491.963', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(149, 'JONATHAN JOSE VILLEGAS HERNANDEZ', 'V-20350140', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(150, 'JOHANNA ANDREA PAREDES GIMENEZ', 'V-18421047', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(151, 'VirtualPC Electronic', 'V-18356666', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(152, 'GIUSEPPE VERDE', 'V-7418030', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(153, 'SOLO LED', 'J-40978166-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(154, ' NILSON JAVIER HERNANDEZ', 'V14482711', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(155, 'JEALIROS CARUCI GIL', '\r\nV-14879574', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(156, 'RELEVEN, C.A.', 'J-41094282-7', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(157, 'OSYDAR DISTRIBUIDORA, C.A ', 'J-300254569', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(158, 'HIDROIN, C.A', 'J-30660707-2', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(159, 'TORNILLERIA LA VIEJA ', 'J-50082134-4', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(160, 'GRUPO ITAPVEN, C.A.', 'J-50030712-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(161, 'FERRE NEWLINK', 'V-12565647', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(162, 'INVERSIONES WTS C.A', 'V-13786098', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(163, 'Technology Store', 'V-27346695', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(164, 'MARIELENA CAROLINA MUJICA GOMEZ\r\n', 'V-24925680', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(165, 'ZONA TECNO C.A', 'V-13905167', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(166, 'SYM REPRESENTACIONES', 'J-40612434-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(167, 'MUESCA EVENTOS C.A', 'J-40074511-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(168, 'JORGE HERNANDEZ', 'V15729866', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(169, 'HIDROTUBERIA DH', 'J-50416571-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(170, 'TOTAL TOOLS CENTRO', 'J-50350319-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(171, 'CORP. ESPERANZA DE ELECTRODOMESTICOS ', 'J-30975798-9', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(172, 'KAMAL SERVICE', 'J-505007211', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(173, 'JOSE LEONARDO RODRIGUEZ', 'V-19165991', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(174, 'MERCANTIL FABULOSO', 'E-82239242', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(175, 'WU JIN JUN', 'V17618710', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(176, 'FUEGOTEXT SISTEMAS C.A.', 'J-40772342-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(177, 'FERRE PINTURAS LA 50, C.A', 'J-504301485', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(178, 'FABIOLA ANDREINA PASTRAN REINOSO', 'V-20186834', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(179, 'COMERCIAL CASTILLO', 'J-08532046-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(180, 'OFFICENET SUMINISTROS Y TECNOLOGIA C.A', 'J-40345070-6', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(181, 'FARMACIA LA 55 DE BQTO, C.A. ', 'J-500278152', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(182, 'LANDYS ANTONIO PINEDA CARUCI', 'V-15003857-6 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(183, 'FERRE TECH 2024 C.A.', 'J-50737791-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(184, 'LA CASA DEL ASFALTO', 'J-31378616-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(185, ' MATERIALES PINTAPEG, C.A', 'J- 412724576', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(186, 'CARLOS OROPEZA', 'V-14376622', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(187, 'OCEAN´S ', 'J-500999828', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(188, 'OFICINAS TECNICAS PEREZ ARAUJO', 'J-178730114', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(189, 'INVERSIONES ELECTRONIC JNC 2016 CA (MERCADO LIBRE)', 'J-41242479-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(190, 'GRUPO FRAGA C.A.', 'J-40229463-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(191, 'FERRETERIA LA CONCORDIA CA', 'J-31114922-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(192, 'ELECTRO INDUSTRIAL BIONDI, C.A.', 'J-30566676-8', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(193, 'CORPORACION GRUPO SIGMA, C.A. ', 'J-40707875-5', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(194, 'H.S. CRISTALES 2030, C.A', 'J-50301164-5', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(195, 'IMPORTADORA EL TIO AMMI II, C.A', 'J-500374461', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(196, 'CONSTRUHOGAR FERRETERIA C.A ', 'J-504544116', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(197, 'CASPERSU SEGURIDAD INDUSTRIAL C.A ', 'V-16260862', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(198, 'INVERSIONES CP 2017, C.A.', 'J-41176825-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(199, 'FERREBOMBAS ', 'J-407587757', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(200, 'FERROMETAL, C.A.', 'J-31692366-5', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(201, 'EVER BIANEY BRICEÑO MARIN', 'V-20187406', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(202, 'PINTURAS BARRETO, C.A.', 'J-50100626-1', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(203, 'OTROS ', 'E84397276', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(204, 'SEGURINET C.A', 'V-19883773 ', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(205, 'OTROSS', 'V-19727259', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(206, 'SIANDRE DECOR EL ROSAL, C.A', 'J-296121915', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(207, 'LUIS PEREZ ARENA ', 'V-7433003', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(208, 'REFRIGERACION DAIR ', 'V-22322517', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(209, 'CESAR PEREIRA ', 'V-21126771', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(210, 'CESAR ENRIQUE VELIZ BRAVO', 'V-26540929', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(211, 'TECHOLAND MIRANDA LP, C.A.', 'J-294850707', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(212, 'JOSE ANTONIO BRICEÑO ', 'V-11900541', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(213, 'GRUPO CHERRY 2015, C.A.', 'J-40567389-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(214, 'INVERSIONES ZAMZIBAR', 'J-40846089-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(215, 'COLCHONES BARQUISIMETO', 'J-500278705', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(216, 'EDGAR ENRIQUE FARIAS RIVAS ', 'V9626050', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(217, 'BRUTS STORE', 'V-10380316', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(218, 'FERREGRANITO ', 'J-30979025-0', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(219, 'INFIVENITY', '\r\nV-16242507', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(220, 'ORANGEL MECANICO', 'V 9266573', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(221, 'GIGABYTE STORE, C.A', 'J507488394', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(222, 'JOSE DAVID DE ANDRADE', 'V-18862639', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(223, 'ESPACIO ELECTRONIC', 'V-18628957', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(224, 'FERREMATE', 'J-29840192-3', 'nan', 'nan', 'nan', '2025-10-08 14:53:23'),
(225, 'EQUIP OFFICE ', 'J-306148973', 'nan', 'nan', 'nan', '2025-10-08 14:53:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int NOT NULL,
  `rif` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `rif`, `nombre`, `telefono`, `direccion`) VALUES
(1, NULL, 'HOTEL RITZ', NULL, NULL),
(2, NULL, 'MI SUPER 55 CON 15', NULL, NULL),
(3, NULL, 'MI SUPER 48 CON 18', NULL, NULL),
(4, NULL, 'MI SUPER COSMOS', NULL, NULL),
(5, NULL, 'MI SUPER 21 CON 11', NULL, NULL),
(6, NULL, 'MI SUPER AV LARA', NULL, NULL),
(7, NULL, 'MI SUPER MADEIRA', NULL, NULL),
(8, NULL, 'MI SUPER AV MADRID', NULL, NULL),
(9, NULL, 'MI SUPER TRINITARIAS', NULL, NULL),
(10, NULL, 'MI SUPER LICORES', NULL, NULL),
(11, NULL, 'APARTAMENTO - HOTEL', NULL, NULL),
(12, NULL, 'GRILL HOUSE', NULL, NULL),
(13, NULL, 'ESTACIONAMIENTO CC COSMOS', NULL, NULL),
(14, NULL, 'GASTO PERSONAL', NULL, NULL),
(15, NULL, 'CASA SR MARTIN Y SRA TERESA', NULL, NULL),
(16, NULL, 'RESTAURANT AV MADRID', NULL, NULL),
(17, NULL, 'CENTRO DE DISTRIBUCION - ACOPIO', NULL, NULL),
(18, NULL, 'PARQUE DEL ESTE', NULL, NULL),
(19, NULL, 'LOCALES CC COSMOS', NULL, NULL),
(20, NULL, 'GASTOS EXTRA', NULL, NULL),
(21, NULL, 'PIZZERIA', NULL, NULL),
(22, NULL, 'CASAS COLINAS DEL VALLE', NULL, NULL),
(23, NULL, 'ZONA II', NULL, NULL),
(24, NULL, 'GRUPO MI SUPER', NULL, NULL),
(25, NULL, 'OTROS', NULL, NULL),
(26, NULL, 'OFICINA', NULL, NULL),
(27, NULL, 'GRUPO TRATTORIA  (FORNO D ORO - GRILL HOUSE)', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_unidad` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `abreviatura` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_unidad`, `nombre`, `abreviatura`, `tipo`) VALUES
(1, 'Litro', 'L', 'volumen'),
(2, 'Mililitro', 'mL', 'volumen'),
(3, 'Galón', 'gal', 'volumen'),
(4, 'Metro cúbico', 'm³', 'volumen'),
(5, 'Centímetro cúbico', 'cm³', 'volumen'),
(6, 'Kilogramo', 'kg', 'peso'),
(7, 'Gramo', 'g', 'peso'),
(8, 'Miligramo', 'mg', 'peso'),
(9, 'Tonelada', 't', 'peso'),
(10, 'Libra', 'lb', 'peso'),
(11, 'Onza', 'oz', 'peso'),
(12, 'Metro', 'm', 'longitud'),
(13, 'Centímetro', 'cm', 'longitud'),
(14, 'Milímetro', 'mm', 'longitud'),
(15, 'Kilómetro', 'km', 'longitud'),
(16, 'Pulgada', 'in', 'longitud'),
(17, 'Pie', 'ft', 'longitud'),
(18, 'Unidad', 'u', 'cantidad'),
(19, 'Par', 'par', 'cantidad'),
(20, 'Docena', 'dz', 'cantidad'),
(21, 'Ciento', 'c', 'cantidad'),
(22, 'Segundo', 's', 'tiempo'),
(23, 'Minuto', 'min', 'tiempo'),
(24, 'Hora', 'h', 'tiempo'),
(25, 'Día', 'd', 'tiempo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  ADD PRIMARY KEY (`id_cuenta`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sucursal` (`sucursal`),
  ADD KEY `unidad-unidades` (`unidad`),
  ADD KEY `producto` (`producto`),
  ADD KEY `proveedores` (`proveedores`);

--
-- Indices de la tabla `pagos_moviles`
--
ALTER TABLE `pagos_moviles`
  ADD PRIMARY KEY (`id_pago_movil`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `rif` (`rif`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  MODIFY `id_cuenta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos_moviles`
--
ALTER TABLE `pagos_moviles`
  MODIFY `id_pago_movil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id_unidad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  ADD CONSTRAINT `cuentas_bancarias_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD CONSTRAINT `producto-ordens` FOREIGN KEY (`producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proveedores` FOREIGN KEY (`proveedores`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sucursales` FOREIGN KEY (`sucursal`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unidad-unidades` FOREIGN KEY (`unidad`) REFERENCES `unidades` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos_moviles`
--
ALTER TABLE `pagos_moviles`
  ADD CONSTRAINT `pagos_moviles_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
