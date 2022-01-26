-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 23, 2022 at 09:44 PM
-- Server version: 8.0.22-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naujienos`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorijos`
--

CREATE TABLE `kategorijos` (
  `id` int NOT NULL,
  `kategorija` varchar(10) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `kategorijos`
--

INSERT INTO `kategorijos` (`id`, `kategorija`) VALUES
(1, 'verslas'),
(3, 'sportas'),
(4, 'orai'),
(7, 'projektai'),
(8, 'kita');

-- --------------------------------------------------------

--
-- Table structure for table `komentarai`
--

CREATE TABLE `komentarai` (
  `id` int NOT NULL,
  `nid` int NOT NULL,
  `elpastas` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `komentaras` varchar(2000) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `komentarai`
--

INSERT INTO `komentarai` (`id`, `nid`, `elpastas`, `komentaras`) VALUES
(1, 1, 'vincas@labas.com', 'Geras straipsnins'),
(2, 1, 'petras@labas.com', 'Blogas straipsnins'),
(3, 3, 'vpb@gov.lt', 'Neteisingai pateikta'),
(4, 3, 'lsd@gov.lt', 'Per daug informacijos'),
(5, 1, 'matas@vpb.lt', 'šiuo metu svarbesnis klausimas – darbuotojų trūkumas'),
(6, 3, 'info@.lsd.lt', 'Rašykite komentarą...');

-- --------------------------------------------------------

--
-- Table structure for table `naujienos`
--

CREATE TABLE `naujienos` (
  `id` int NOT NULL,
  `pavadinimas` varchar(500) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `turinys` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `naujienos`
--

INSERT INTO `naujienos` (`id`, `pavadinimas`, `turinys`, `data`) VALUES
(1, 'Investuok Lietuvoje', 'žsienio investicijos Lietuvoje pernai pasiekė rekordinį lygį. Ekspertai sako, kad pasiekėme vieną geriausių rezultatų centrinėje ir Rytų Europoje. Pernai pritraukėme mažiau naujų žaidėjų pramonės srityje, tačiau „Investuok Lietuvoje“ tikisi geresnių rezultatų šiemet. Jiems įtakos turės ir konfliktas su Kinija, tačiau, anot Elijaus Čivilio, šiuo metu svarbesnis klausimas – darbuotojų trūkumas.\r\n\r\n2021-aisiais tiesioginių užsienio investicijų (TUI) skaičiai pasiekė rekordinį lygį. „Investuok Lietuvoje“ pernai patvirtino 49 TUI projektus. Tai – 4 projektais daugiau nei iki tol geriausias buvęs rezultatas 2019 m.\r\n\r\nLietuvoje kursis 27 naujos įmonės, dar 22 Lietuvoje jau veikiančios įmonės patvirtino plėtros projektus. Iš viso Lietuvoje per ateinančius trejus metus planuojama sukurti 5 435 naujas darbo vietas (iš jų – trečdalis už Vilniaus ribų) ir investuoti beveik 205 mln. Eur į ilgalaikį turtą.\r\n', '2022-01-23'),
(3, 'Kauniečiai  šventė', 'Veiksmo netrūko ir Vienybės aikštėje, kur vyko muzikiniai pasirodymai, o šildė ugnies instaliacijos. Einančius V.Putvinskio gatve prie funikulieriaus pasitiko snaudžiantis, tačiau nuo miesto šurmulio vis pabundantis žvėris, o laiptai tapo milžiniško žvėries kūnu. Miestą patirti pasiryžusiems šventės dalyviams kelrode žvaigžde tapo Kauno Kristaus prisikėlimo bazilika – šviesos spindulys buvo matomas iš tolimiausių vietų.\r\n', '2022-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `naujienu_kategorijos`
--

CREATE TABLE `naujienu_kategorijos` (
  `id` int NOT NULL,
  `naujID` int NOT NULL,
  `katID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `naujienu_kategorijos`
--

INSERT INTO `naujienu_kategorijos` (`id`, `naujID`, `katID`) VALUES
(1, 1, 4),
(2, 1, 7),
(5, 3, 1),
(6, 3, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorijos`
--
ALTER TABLE `kategorijos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentarai`
--
ALTER TABLE `komentarai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `naujienos`
--
ALTER TABLE `naujienos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `naujienu_kategorijos`
--
ALTER TABLE `naujienu_kategorijos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorijos`
--
ALTER TABLE `kategorijos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komentarai`
--
ALTER TABLE `komentarai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `naujienos`
--
ALTER TABLE `naujienos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `naujienu_kategorijos`
--
ALTER TABLE `naujienu_kategorijos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
