-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-10-2021 a las 01:10:45
-- Versión del servidor: 5.7.20-log
-- Versión de PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `saldoshvac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `commercial_price` double(8,2) NOT NULL,
  `shipping_cost` double(8,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) DEFAULT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `shipping` tinyint(1) NOT NULL DEFAULT '0',
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `model`, `serie_number`, `price`, `commercial_price`, `shipping_cost`, `quantity`, `status`, `shipping`, `subcategory_id`, `category_id`, `brand_id`, `state_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Ullam est similique.', 'ullam-est-similique', 'Numquam aut libero voluptate odio et esse. Corporis eos aut ullam quo. Ut repudiandae provident consequatur dolorum esse dolor. Debitis alias deserunt optio dolor deserunt maiores et.', 'Consequatur omnis et animi.', 'Facere fuga rem.', 19.99, 29.99, 20.00, 15, '2', 0, 3, 9, 4, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(2, 'Exercitationem neque.', 'exercitationem-neque', 'Sunt autem nisi architecto fugit iusto quia. Ut rem doloribus optio ab ut. Est illum modi qui incidunt ut quia iusto. Eveniet numquam aut vel numquam aut provident. Omnis sequi tempora ut voluptatem.', 'Dignissimos nostrum exercitationem.', 'Dolore officiis id.', 19.99, 29.99, 20.00, 15, '2', 0, 2, 5, 4, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(3, 'Molestiae praesentium dolores.', 'molestiae-praesentium-dolores', 'Ipsa quaerat velit rerum earum. Ullam amet saepe vel sint non. Assumenda reprehenderit temporibus sapiente officiis aut quis officia.', 'Dolor aspernatur sit.', 'Corporis architecto atque facere accusamus.', 19.99, 119.99, 400.00, 3, '2', 1, 1, 1, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(4, 'Aut enim molestiae.', 'aut-enim-molestiae', 'A et aut laboriosam ducimus. Aut aut veniam sed itaque fugit ad. Explicabo sunt occaecati illum sit eum corporis. Debitis fugit id possimus voluptatem praesentium.', 'Expedita voluptas in.', 'Sit eligendi nemo.', 49.99, 29.99, 400.00, 15, '2', 1, 1, 8, 2, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(5, 'Nihil enim.', 'nihil-enim', 'Cumque autem facilis quo nihil. Similique voluptatem vel voluptatibus tenetur doloribus autem inventore. Hic minus qui voluptas rerum laboriosam nam. At tenetur sequi dolorem sit.', 'Eveniet eum.', 'Voluptas minima et.', 99.99, 29.99, 20.00, 15, '2', 1, 3, 6, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(6, 'Id aut non.', 'id-aut-non', 'Hic quasi et magnam voluptatem amet. Rerum esse deleniti rerum illo dicta omnis repellendus. Rerum id deserunt voluptates. Sed eligendi aliquid ut enim quia est temporibus.', 'Ex sit molestias eum.', 'Sapiente consequatur ab inventore.', 49.99, 29.99, 400.00, 15, '2', 1, 3, 3, 4, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(7, 'Esse aliquid temporibus.', 'esse-aliquid-temporibus', 'Quae ut voluptatem expedita minus est perferendis. A soluta a earum eum est. Non facere ullam voluptates facere quo.', 'Consequatur laborum et.', 'Placeat sit veniam molestiae aspernatur.', 19.99, 59.99, 400.00, 15, '2', 0, 3, 7, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(8, 'Delectus expedita.', 'delectus-expedita', 'Nulla et a porro nesciunt sint possimus. Saepe eos sed deleniti quia. Laudantium aperiam fugit rerum.', 'Ea accusamus.', 'Vitae tempore perferendis.', 49.99, 59.99, 20.00, 15, '2', 0, 3, 10, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(9, 'Deleniti excepturi minus.', 'deleniti-excepturi-minus', 'Rem sunt dolor at inventore atque. In quia omnis nostrum blanditiis. Consequatur delectus porro eligendi quod reiciendis adipisci.', 'Aut rerum dolores.', 'Consequuntur nihil ab id.', 99.99, 59.99, 400.00, 15, '2', 1, 3, 1, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(10, 'Dolores error laudantium.', 'dolores-error-laudantium', 'Et ipsa libero ut quibusdam sunt voluptatum. Debitis praesentium aut amet fuga blanditiis hic ut. Et praesentium hic odio voluptatibus. Non aut dicta deleniti voluptas nostrum sapiente quia.', 'Ex necessitatibus hic.', 'Delectus reprehenderit et.', 99.99, 119.99, 20.00, 15, '2', 0, 3, 8, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(11, 'Hic quibusdam.', 'hic-quibusdam', 'A necessitatibus explicabo sed. Id et facere totam voluptate. Et tempore quis ea sequi. Dolores et sed necessitatibus quam fugit quae sed.', 'Assumenda et repellat.', 'Deleniti vel tenetur aliquid in.', 49.99, 119.99, 100.00, 15, '2', 0, 3, 9, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(12, 'Est excepturi.', 'est-excepturi', 'Quia est aperiam nemo recusandae beatae est rem. Et est aut odio rerum corporis voluptas non sunt. Et molestias dolorum deserunt atque illo in dolores.', 'Quasi voluptatem.', 'Unde necessitatibus sunt.', 99.99, 59.99, 20.00, 15, '2', 0, 1, 5, 6, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(13, 'Quibusdam laborum velit.', 'quibusdam-laborum-velit', 'Debitis nihil vel quo temporibus et beatae adipisci numquam. Officiis quo inventore eveniet amet at neque dolorum accusantium. Ipsum mollitia incidunt est cumque quos.', 'Veritatis quas non.', 'Esse consequuntur optio ratione.', 19.99, 119.99, 400.00, 15, '2', 1, 3, 9, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(14, 'Omnis pariatur eum.', 'omnis-pariatur-eum', 'Ut id maxime provident labore. Quibusdam doloribus sed odio vel non. Vel dolore sequi et tempore vitae consequatur. Ab quia quos veniam voluptatibus ut.', 'Ipsa error autem quo.', 'Recusandae quis aspernatur.', 49.99, 29.99, 100.00, 15, '2', 1, 3, 8, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(15, 'Consectetur optio.', 'consectetur-optio', 'Ut quas nesciunt sint est. At explicabo aut suscipit quo. Nostrum vero vero sit ipsam. Et quod officiis quidem voluptatem deserunt ipsa.', 'Cupiditate ducimus sunt.', 'Omnis veniam.', 49.99, 29.99, 100.00, 15, '2', 0, 2, 9, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(16, 'Qui fugiat voluptatem.', 'qui-fugiat-voluptatem', 'Ea aut et repellat. Amet quos voluptatem ab et voluptatum. Qui accusantium autem harum ab sint. Dolor labore minus cupiditate et.', 'Explicabo aperiam quo perspiciatis inventore.', 'Sunt perspiciatis quod.', 19.99, 29.99, 20.00, 15, '2', 0, 3, 3, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(17, 'Rerum sapiente deleniti.', 'rerum-sapiente-deleniti', 'Aut aliquid et quia dolor magni vitae placeat ab. Qui beatae aut vitae. Est provident veritatis animi nostrum fugiat.', 'Minima sit maxime.', 'Laboriosam rerum quae.', 19.99, 29.99, 20.00, 15, '2', 0, 2, 5, 2, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(18, 'Voluptatem veniam.', 'voluptatem-veniam', 'Voluptas dolore cumque amet dolor mollitia similique occaecati. Vitae est aliquam qui. Placeat at quo laborum quam soluta.', 'Minima optio.', 'Et rem nostrum.', 49.99, 119.99, 20.00, 15, '2', 0, 1, 2, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(19, 'Quae officia.', 'quae-officia', 'Enim in quia quis ex itaque. Enim ut aut quidem. Doloribus maxime doloremque enim enim veniam porro. Unde in voluptate voluptatem quo numquam.', 'Atque similique odit nam.', 'Autem pariatur beatae.', 19.99, 119.99, 100.00, 15, '2', 1, 3, 10, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(20, 'Molestiae ut.', 'molestiae-ut', 'Quidem dolorem ut hic voluptatem quia enim. Voluptas temporibus aut minima voluptatibus natus. Aut et possimus ut beatae soluta ipsa ut nobis.', 'Ut placeat consequatur.', 'Repudiandae voluptas quia voluptatem.', 19.99, 119.99, 100.00, 15, '2', 1, 3, 5, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(21, 'Vitae cumque.', 'vitae-cumque', 'Totam non nam et laudantium. Non modi omnis voluptas. Quo sed dolor blanditiis. Nesciunt veniam commodi vitae necessitatibus sed. Ratione ut autem distinctio.', 'Fugiat ipsum.', 'Repellat iure saepe voluptatem.', 99.99, 119.99, 400.00, 15, '2', 1, 3, 9, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(22, 'Eum dolorum.', 'eum-dolorum', 'Praesentium maiores est velit quidem. Minus et repellendus qui error in sint mollitia. Qui reiciendis minima facere quo dolorem porro sed quia.', 'Laborum dignissimos qui placeat.', 'Eaque maxime velit dolores.', 19.99, 59.99, 20.00, 15, '2', 0, 1, 6, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(23, 'Saepe in.', 'saepe-in', 'Itaque sed aspernatur aspernatur. Provident tempore quibusdam aut sit deserunt quasi ea non. Qui est corporis quia quibusdam ut. Omnis voluptas iste labore autem aspernatur ut.', 'Eligendi nam ea aperiam minima.', 'Laborum aut.', 99.99, 59.99, 100.00, 15, '2', 0, 3, 1, 4, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(24, 'Id commodi.', 'id-commodi', 'Et distinctio ut sint explicabo veritatis et alias vero. Cum at veritatis provident voluptatem dolore qui magni. Qui sint corrupti illum enim assumenda.', 'Hic quia ut dolor.', 'Laborum enim et repudiandae.', 19.99, 119.99, 100.00, 15, '2', 1, 2, 10, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(25, 'Qui ducimus.', 'qui-ducimus', 'Qui tenetur dolore rerum optio reprehenderit sunt quia qui. Voluptatem aut ea nesciunt cupiditate quidem.', 'Possimus iste in qui facilis.', 'Expedita ea aperiam.', 19.99, 29.99, 400.00, 15, '2', 1, 1, 2, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(26, 'Est mollitia quasi.', 'est-mollitia-quasi', 'Incidunt voluptas fuga sunt distinctio quisquam eos ab. Dolorum consequatur rerum inventore dicta impedit ut. Velit suscipit maiores dolores.', 'Rerum et sapiente enim.', 'Quisquam quo.', 19.99, 59.99, 100.00, 15, '2', 0, 3, 9, 2, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(27, 'Non esse illum.', 'non-esse-illum', 'Perferendis omnis dolorum est deleniti accusantium. Eligendi natus eos id dicta. Est architecto enim culpa perspiciatis eligendi sapiente odit quam. Odio atque tenetur quis nobis.', 'Deserunt magnam laborum voluptatem.', 'Nam sint impedit nesciunt.', 19.99, 29.99, 20.00, 15, '2', 0, 2, 9, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(28, 'Illo doloribus.', 'illo-doloribus', 'Quia eaque voluptas nulla quas hic a iste. Saepe et quia aut nesciunt accusantium. Dolor aut non accusantium perferendis dicta vel dolores.', 'Iure delectus quisquam exercitationem.', 'Aspernatur perspiciatis accusamus.', 99.99, 59.99, 100.00, 15, '2', 0, 3, 3, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(29, 'Libero saepe et.', 'libero-saepe-et', 'Hic unde ea ut id ut. Qui ad a et explicabo rerum inventore aliquam at. Temporibus vel ut sit ut repellat et dolor.', 'Alias inventore ipsam nihil.', 'Perspiciatis vel nulla.', 19.99, 119.99, 100.00, 15, '2', 0, 2, 2, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(30, 'Sed debitis sit.', 'sed-debitis-sit', 'Distinctio inventore facilis natus natus et laborum aut. Dolor deserunt aperiam occaecati iste quia rerum placeat. Cumque et id dolore accusamus. Sit incidunt enim ipsa aut earum laboriosam et.', 'In velit sint est culpa.', 'Perferendis deleniti aut voluptatem.', 99.99, 59.99, 100.00, 15, '2', 1, 3, 9, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(31, 'Amet ut est.', 'amet-ut-est', 'Laborum quia voluptas sequi dolores enim. Suscipit et sint in autem nemo. Iure recusandae exercitationem sunt eligendi incidunt laboriosam alias. At ipsam nostrum occaecati quidem.', 'Rem blanditiis dignissimos dolor.', 'Est velit.', 99.99, 59.99, 400.00, 15, '2', 1, 1, 7, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(32, 'Aliquam expedita molestias.', 'aliquam-expedita-molestias', 'Quos quia incidunt quas ipsa. Nulla laboriosam blanditiis voluptates. Itaque voluptatum doloribus aut similique. Sint et fugit quasi sapiente.', 'Consequuntur eos.', 'Qui fuga est sit.', 99.99, 119.99, 100.00, 15, '2', 0, 2, 4, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(33, 'Id laborum rem.', 'id-laborum-rem', 'Molestiae amet qui iste deserunt consequatur. Velit cumque enim sequi eligendi modi. Aut sit aspernatur quo tempore tempora. Labore quia et repudiandae ut consequatur voluptatem dignissimos.', 'Praesentium sequi sunt et eum.', 'Enim velit ratione perferendis asperiores.', 99.99, 119.99, 100.00, 15, '2', 0, 1, 2, 2, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(34, 'Et voluptatum eum.', 'et-voluptatum-eum', 'Occaecati dolorem excepturi debitis sed. Fugit nostrum corporis quia excepturi. Id commodi vel facere et expedita. Hic fuga temporibus beatae.', 'Et iusto quam natus.', 'Quidem quam animi excepturi.', 19.99, 59.99, 100.00, 15, '2', 1, 3, 1, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(35, 'Inventore libero nemo.', 'inventore-libero-nemo', 'Quas dolor nulla fugiat dolores ut ut. Vero voluptas esse sed ab. Sequi sint qui accusantium occaecati voluptatum iusto.', 'Sunt modi accusamus sunt.', 'Ut et molestiae fuga ducimus.', 99.99, 59.99, 20.00, 15, '2', 1, 3, 10, 1, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(36, 'Dicta dolorum.', 'dicta-dolorum', 'Omnis occaecati consequuntur tempora quo consequatur quaerat tenetur. Reiciendis rerum delectus nesciunt velit eum error. Sunt qui quo dolore optio ea. Fugit expedita pariatur soluta nihil.', 'Aperiam voluptate tenetur.', 'Ut asperiores voluptatem eaque.', 99.99, 119.99, 20.00, 15, '2', 0, 2, 1, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(37, 'Voluptate reprehenderit.', 'voluptate-reprehenderit', 'Veniam illo inventore vel natus eveniet. Odio iure recusandae sed id quibusdam. Earum quo quisquam non vel.', 'Sed voluptas commodi.', 'Deleniti ut fugit.', 99.99, 119.99, 400.00, 15, '2', 0, 2, 1, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(38, 'Qui ut aut.', 'qui-ut-aut', 'Saepe commodi repellendus reiciendis repudiandae. Dolore est nesciunt officia sit vel sapiente dolorem. Dolorum omnis assumenda facere quia perferendis eius. Velit nisi recusandae non mollitia ab.', 'Odio odit nam.', 'Possimus odit velit.', 19.99, 119.99, 100.00, 15, '2', 0, 2, 3, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(39, 'Deserunt excepturi possimus.', 'deserunt-excepturi-possimus', 'Delectus aut repellat rem dolorem. Ea deleniti aut quia tempora dicta quis. Vitae molestiae perspiciatis aliquid enim quae sit ad.', 'Et quas repudiandae sit.', 'Dignissimos voluptatum excepturi.', 19.99, 59.99, 20.00, 15, '2', 0, 1, 1, 4, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(40, 'Quae inventore.', 'quae-inventore', 'Quaerat qui sint dolor. Adipisci neque necessitatibus quidem. Incidunt atque similique dolorem consequatur dignissimos.', 'Doloremque temporibus animi dicta.', 'Ea et et odit maxime.', 19.99, 29.99, 100.00, 15, '2', 1, 2, 2, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(41, 'Rem delectus.', 'rem-delectus', 'Ipsum libero rerum dolorem facere veniam non. Omnis laborum dolore maiores amet omnis. Sit laboriosam numquam facere voluptate. Dolorem nemo possimus ut iure iure nulla consequatur.', 'Vel provident reprehenderit provident.', 'Earum iure.', 99.99, 59.99, 20.00, 15, '2', 0, 3, 9, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(42, 'Et quo.', 'et-quo', 'Eaque vero ea ratione est. Id occaecati quia facilis temporibus a accusantium. Vitae nemo quae aut ut asperiores hic quia.', 'Beatae et ad.', 'Id deleniti et.', 49.99, 119.99, 100.00, 15, '2', 1, 2, 4, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(43, 'Quia et.', 'quia-et', 'Repellendus rerum facilis velit molestiae. Iusto architecto consectetur consectetur non et provident debitis. Et quia voluptate dicta velit et inventore possimus.', 'Velit maxime.', 'In ea odio.', 99.99, 119.99, 20.00, 15, '2', 1, 1, 4, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(44, 'Quia dolor.', 'quia-dolor', 'Cum ratione ullam porro. Assumenda adipisci possimus aut natus cumque quaerat. Architecto amet pariatur reprehenderit natus et soluta distinctio.', 'Accusamus accusantium et quam quidem.', 'Libero sit rerum qui.', 19.99, 29.99, 100.00, 15, '2', 1, 1, 3, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(45, 'Et laboriosam.', 'et-laboriosam', 'Ut commodi provident assumenda sunt. Qui unde consectetur consequatur inventore. Qui ea maiores tempore amet quis soluta. Consequatur eum possimus culpa in aut necessitatibus et.', 'Eveniet et illo.', 'Commodi earum expedita.', 19.99, 119.99, 20.00, 15, '2', 1, 2, 3, 2, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(46, 'Est aut.', 'est-aut', 'Sapiente fugit odit quia sunt exercitationem voluptate et dolor. Commodi ut architecto voluptatem et. Amet a deserunt dolorem maiores. Inventore laudantium incidunt esse quasi sed.', 'Eos eius veniam perspiciatis ullam.', 'Harum delectus ipsam.', 99.99, 59.99, 100.00, 15, '2', 0, 2, 2, 3, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(47, 'Minima est vero.', 'minima-est-vero', 'Rerum praesentium vero magnam optio et eveniet repellat. Et beatae esse consequatur dicta aliquam voluptatem. Adipisci nulla aut amet pariatur temporibus. Et tenetur iure voluptas sequi distinctio.', 'Animi occaecati dolor ad.', 'Repudiandae sed impedit est.', 99.99, 29.99, 400.00, 15, '2', 0, 1, 5, 5, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(48, 'Enim dolores quis.', 'enim-dolores-quis', 'Tenetur maiores culpa tenetur molestiae fuga sed. Odio sit rerum laborum error. Quis a et nihil eos sit est. Possimus facilis laborum dolores accusamus animi.', 'Quo autem optio.', 'Nisi libero accusamus ratione.', 49.99, 29.99, 20.00, 15, '2', 0, 1, 2, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(49, 'Iure et facilis.', 'iure-et-facilis', 'Rerum non sit deserunt maiores consequatur distinctio. Neque asperiores dolor qui autem autem ea et. Accusantium voluptatum qui qui.', 'Sunt sunt autem.', 'Dicta est amet.', 49.99, 119.99, 400.00, 15, '2', 0, 3, 6, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07'),
(50, 'Dolorum nesciunt.', 'dolorum-nesciunt', 'Rerum quos aut aut in quia quis omnis. Animi officia commodi omnis.', 'Dolorem voluptas.', 'Doloremque quasi voluptatum.', 19.99, 119.99, 100.00, 15, '2', 0, 2, 10, 7, 1, 1, '2021-10-12 00:47:07', '2021-10-12 00:47:07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_state_id_foreign` (`state_id`),
  ADD KEY `products_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
