-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2019 at 10:49 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psi_bolnica`
--

-- --------------------------------------------------------

--
-- Table structure for table `bolest`
--

CREATE TABLE `bolest` (
  `id` int(11) NOT NULL,
  `ime_bolest` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifra_bolest` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bolest`
--

INSERT INTO `bolest` (`id`, `ime_bolest`, `sifra_bolest`) VALUES
(1, 'bolest1', 'bol1'),
(2, 'bolest2', 'bol2');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecenje`
--

CREATE TABLE `lecenje` (
  `id` int(11) NOT NULL,
  `id_pacijent` int(11) NOT NULL,
  `id_lekar` bigint(20) UNSIGNED NOT NULL,
  `datum` date NOT NULL,
  `prva_poseta` tinyint(1) NOT NULL,
  `dijagnoza` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bolest` int(11) NOT NULL,
  `terapija` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_lek` int(11) NOT NULL,
  `lek_prepisana_kol` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecenje`
--

INSERT INTO `lecenje` (`id`, `id_pacijent`, `id_lekar`, `datum`, `prva_poseta`, `dijagnoza`, `id_bolest`, `terapija`, `id_lek`, `lek_prepisana_kol`) VALUES
(1, 1, 3, '2019-12-07', 1, 'Prva dijagnoza.', 1, 'nesto', 1, 1),
(2, 1, 3, '2019-12-07', 1, 'Prva dijagnoza.', 2, 'nesto', 2, 2),
(6, 1, 3, '2019-12-06', 1, 'hehehehe', 1, 'wwqwqw', 1, 3),
(7, 1, 3, '2019-12-06', 1, 'hehehehe', 1, 'wwqwqw', 2, 2),
(10, 1, 3, '2019-12-08', 1, 'novi dan', 2, 'ertee', 1, 2),
(12, 1, 3, '2019-12-08', 0, 'test', 1, 'test', 1, 1),
(13, 1, 3, '2019-12-08', 0, 'test', 1, 'test', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lek`
--

CREATE TABLE `lek` (
  `id` int(11) NOT NULL,
  `ime_lek` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifra_lek` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolicina_lek` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lek`
--

INSERT INTO `lek` (`id`, `ime_lek`, `sifra_lek`, `kolicina_lek`) VALUES
(1, 'lek1', 'l1', 1002),
(2, 'lek2', 'l2', 991);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pacijent`
--

CREATE TABLE `pacijent` (
  `id` int(11) NOT NULL,
  `ime` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezime` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dat_rodjenja` date NOT NULL,
  `pol` enum('muski','zenski','neopredeljen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `grad` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ulica` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `broj` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jmbg` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lekar` bigint(20) UNSIGNED NOT NULL,
  `istorija_bolesti` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alergija_lek` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pacijent`
--

INSERT INTO `pacijent` (`id`, `ime`, `prezime`, `dat_rodjenja`, `pol`, `grad`, `ulica`, `broj`, `jmbg`, `lekar`, `istorija_bolesti`, `alergija_lek`) VALUES
(1, 'Prvi', 'Pacijent', '1989-12-25', 'muski', 'Beograd', 'Neka', '12', '1206989123456', 3, 'Depresija Magnifuc', 'Supercilin'),
(2, 'Drugi', 'Pacijent', '1989-12-25', 'muski', 'Beograd', 'Neka', '12', '1206989123456', 4, 'nema', 'nema');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 'pew', 'dz_shop@gmail.com', NULL, '$2y$10$Jt8q931/eIs1o47zmV.d4u.M.fBkgRSlrCCa/Ev/XTqp6RzV8amr.', NULL, '2019-12-05 13:02:27', '2019-12-06 22:18:18'),
(2, 3, 'Aleksandar', 'Alekp111@gmail.com', NULL, '$2y$10$Fc9A.vPkMiYVjVU9CPwaouHQUU4k9L8qJSb8u8cenTvE0UfTn8XrC', 'vuYwfx2rMTN4WkhUBv4izxIqUHtcK17FGEzKm34vzngw8XbmEOQVUSajBUbf', '2019-12-06 21:28:24', '2019-12-06 21:28:24'),
(3, 2, 'Dr Prvic', 'Prvic@Gmail.com', NULL, '$2y$10$d0j26.ZpkzVpP6Y.kNr.GerkntjCGbbD3Iaf/nKurKAekqAifKDd2', NULL, '2019-12-07 05:34:55', '2019-12-08 08:39:31'),
(4, 2, 'Dr_Drugic', 'Drugic@Gmail.com', NULL, '$2y$10$d0j26.ZpkzVpP6Y.kNr.GerkntjCGbbD3Iaf/nKurKAekqAifKDd2', NULL, '2019-12-07 05:34:55', '2019-12-07 05:57:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bolest`
--
ALTER TABLE `bolest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecenje`
--
ALTER TABLE `lecenje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_pacijent` (`id_pacijent`),
  ADD KEY `ID_lekar` (`id_lekar`),
  ADD KEY `ID_bolest` (`id_bolest`),
  ADD KEY `ID_lek` (`id_lek`);

--
-- Indexes for table `lek`
--
ALTER TABLE `lek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacijent`
--
ALTER TABLE `pacijent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lekar` (`lekar`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bolest`
--
ALTER TABLE `bolest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecenje`
--
ALTER TABLE `lecenje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lek`
--
ALTER TABLE `lek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pacijent`
--
ALTER TABLE `pacijent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lecenje`
--
ALTER TABLE `lecenje`
  ADD CONSTRAINT `lecenje_ibfk_2` FOREIGN KEY (`id_pacijent`) REFERENCES `pacijent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lecenje_ibfk_3` FOREIGN KEY (`id_bolest`) REFERENCES `bolest` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lecenje_ibfk_4` FOREIGN KEY (`id_lek`) REFERENCES `lek` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lecenje_ibfk_5` FOREIGN KEY (`id_lekar`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pacijent`
--
ALTER TABLE `pacijent`
  ADD CONSTRAINT `pacijent_ibfk_1` FOREIGN KEY (`lekar`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
