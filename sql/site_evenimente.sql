-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2025 at 02:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `site_evenimente`
--

-- --------------------------------------------------------

--
-- Table structure for table `bilet`
--

CREATE TABLE `bilet` (
  `id_bilet` int(11) NOT NULL,
  `denumire` varchar(255) NOT NULL,
  `pret` float NOT NULL,
  `loc_eveniment` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bilet`
--

INSERT INTO `bilet` (`id_bilet`, `denumire`, `pret`, `loc_eveniment`, `description`, `id_event`) VALUES
(1, 'DID YOU ATTEND BP 2024? YOU HAVE THE BEST PRICE! General Access — 5 Days Pass ⚡️ 120 EUR', 599, 'Costinești', 'Bilet standard cu acces 5 zile, redus daca ai fost la BP 2024.', 2),
(2, 'EARLYBIRD: General Access — 5 Days Pass ⚡️ 130 EUR', 649, 'Costinești', 'Bilet standard cu acces 5 zile.', 2),
(3, 'EARLYBIRD: General Access Plus — 5 Days Pass ⚡️ 160 EUR', 799, 'Costinești', 'Bilet standard cu acces rapid 5 zile.', 2),
(4, 'EARLYBIRD: GOLDEN CIRCLE — 5 Days Pass ⚡️ 175 EUR', 874, 'Costinești', 'Bilet standard cu acces 5 zile cu loc garantat în fața scenei.', 2),
(5, 'EARLYBIRD: VIP — 5 Days Pass ⚡️ 300 EUR', 1499, 'Costinești', 'Bilet VIP cu acces 5 zile.', 2),
(6, 'EARLYBIRD: ULTRA VIP + GOLDEN CIRCLE — 5 Days Pass ⚡️ 400 EUR', 1999, 'Costinești', 'Bilet ULTRA-VIP + GOLDEN CIRCLE cu acces 5 zile.', 2),
(7, 'UPGRADE: General Access → Golden Circle ⚡ 45 EUR', 225, 'Costinești', 'Upgrade de la bilet General Access la Golden Circle', 2),
(8, 'UPGRADE: General Access —> ULTRA VIP + Golden Circle (5 Days Pass) ⚡️ 270 EUR', 1350, 'Costinești', 'Upgrade de la bilet General Access la ULTRA VIP + Golden Circle', 2),
(9, 'DID YOU ATTEND BP 2025? YOU HAVE THE BEST PRICE! General Access — 5 Days Pass ⚡️ 120 EUR', 599, 'Costinești', 'Bilet standard cu acces 5 zile, redus daca ai fost la BP 2025.', 1),
(10, 'EARLYBIRD: General Access — 5 Days Pass ⚡️ 130 EUR', 649, 'Costinești', 'Bilet standard cu acces 5 zile.', 1),
(11, 'EARLYBIRD: General Access Plus — 5 Days Pass ⚡️ 160 EUR', 799, 'Costinești', 'Bilet standard cu acces rapid 5 zile.', 1),
(12, 'EARLYBIRD: GOLDEN CIRCLE — 5 Days Pass ⚡️ 175 EUR', 874, 'Costinești', 'Bilet standard cu acces 5 zile cu loc garantat în fața scenei.', 1),
(13, 'EARLYBIRD: VIP — 5 Days Pass ⚡️ 300 EUR', 1499, 'Costinești', 'Bilet VIP cu acces 5 zile.', 1),
(14, 'EARLYBIRD: ULTRA VIP + GOLDEN CIRCLE — 5 Days Pass ⚡️ 400 EUR', 1999, 'Costinești', 'Bilet ULTRA-VIP + GOLDEN CIRCLE cu acces 5 zile.', 1),
(15, 'UPGRADE: General Access → Golden Circle ⚡ 45 EUR', 225, 'Costinești', 'Upgrade de la bilet General Access la Golden Circle', 1),
(16, 'UPGRADE: General Access —> ULTRA VIP + Golden Circle (5 Days Pass) ⚡️ 270 EUR', 1350, 'Costinești', 'Upgrade de la bilet General Access la ULTRA VIP + Golden Circle', 1),
(17, 'SUMMER SALE ⚡️⚡️ Acces General - Abonament 3 zile (11-13 Septembrie)⚡️', 519, 'Piața Constituției, București', '3 Day pass: acces la toate cele 3 zile ale festivalului.<br /><br />Acces în picioare, situat în spatele zonei Categoria 1.', 4),
(18, 'SUMMER SALE ⚡️⚡️ Categoria 1 - Abonament 3 zile (11-13 Septembrie)⚡️', 879, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Loc pe scaun, poziționat în spatele zonei VIP, oferind vizibilitate bună către scenă.', 4),
(19, 'SUMMER SALE ⚡️⚡️ Categoria 2 - Abonament 3 zile (11-13 Septembrie)⚡️', 799, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Loc pe scaun, situată în spatele zonei Categoria 1, oferind un unghi excelent pentru vizionare.', 4),
(20, 'SUMMER SALE ⚡️⚡️ Categoria 3 - Abonament 3 zile (11-13 Septembrie)⚡️', 679, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Loc pe scaun, situat în lateralele zonei Categoria 1, cu o perspectivă amplă asupra scenei.', 4),
(21, 'SUMMER SALE ⚡️⚡️ Categoria 4 - Abonament 3 zile (11-13 Septembrie)⚡️', 639, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Loc pe scaun, în spatele zonei Categoria 3, pentru o experiență de neuitat.', 4),
(22, 'SUMMER SALE ⚡️⚡️ VIP 1 - Abonament 3 zile (11-13 Septembrie)⚡️', 1359, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Loc pe scaun, poziționat în fața scenei, aproape de artiști, pentru o experiență exclusivistă.<br /><br />Oferă acces Ultra-Fast Lane (cel mai rapid culoar de acces din festival).', 4),
(23, 'SUMMER SALE ⚡️⚡️ VIP 2 - Abonament 3 zile (11-13 Septembrie)⚡️', 1199, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Loc pe scaun, în fața scenei, în laterala zonei VIP 1, oferind un unghi premium asupra spectacolului.<br /><br />Oferă acces Ultra-Fast Lane (cel mai rapid culoar de acces din festival).', 4),
(24, 'SUMMER SALE ⚡️⚡️ Ultra VIP Gold - Abonament 3 zile (11-13 Septembrie)⚡️', 2559, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Acces pe platforma Lounge-ul-ui Ultra VIP cu cea mai bună vedere către scenă.<br /><br />Acces la baruri private si toalete VIP dedicate.<br /><br />Ofera acces ultra-fast lane (cel mai rapid culoar de acces din festival).', 4),
(25, 'SUMMER SALE ⚡️⚡️ Ultra VIP – Diamond - Abonament 3 zile – (11-13 Septembrie)⚡️', 3999, 'Piața Constituției, București', '3-Day Pass: acces la toate cele 3 zile ale festivalului.<br /><br />Lojă dedicată cu canapele și mese pentru grupuri de 6 persoane, pe platforma elevată a Lounge-ului Ultra VIP, în zona lojelor dedicate pentru cea mai bună vedere către scenă și cea mai exclusivistă experiență din festival.<br /><br />Servire la masă, acces la baruri private și toalete VIP dedicate.<br /><br />Oferă acces Ultra-Fast Lane (cel mai rapid culoar de acces din festival).', 4),
(26, 'Film Online', 15, 'Online', 'Disponibil 72h de la prima accesare', 3),
(27, 'VIP', 787.77, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet VIP cu vizibilitate ridicată și acces prioritar.', 5),
(28, 'Categoria 1', 659, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet standard cu vizibilitate foarte bună.', 5),
(29, 'CATEGORIA 1 - copii', 603.44, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet pentru copii între 2-12 ani în zona Categoria 1.', 5),
(30, 'Categoria 2', 529, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet cu loc bun în zona Categoria 2.', 5),
(31, 'Categoria 2 - GRUP ≥ 11', 477, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet de grup (minim 11 persoane) în zona Categoria 2.', 5),
(32, 'CATEGORIA 2 - copii', 473.44, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet pentru copii între 2-12 ani în zona Categoria 2.', 5),
(33, 'Categoria 3', 429, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet cu vedere bună în zona Categoria 3.', 5),
(34, 'Categoria 3 - GRUP ≥ 11', 387, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet de grup (minim 11 persoane) în zona Categoria 3.', 5),
(35, 'CATEGORIA 3 - copii', 373.44, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet pentru copii între 2-12 ani în zona Categoria 3.', 5),
(36, 'Categoria 4', 329, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet economic în zona Categoria 4.', 5),
(37, 'Categoria 4 - GRUP ≥ 11', 297, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet de grup (minim 11 persoane) în zona Categoria 4.', 5),
(38, 'CATEGORIA 4 - copii', 273.45, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet pentru copii între 2-12 ani în zona Categoria 4.', 5),
(39, 'Categoria 5', 229, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet accesibil în zona Categoria 5.', 5),
(40, 'Categoria 5 - GRUP ≥ 11', 207, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet de grup (minim 11 persoane) în zona Categoria 5.', 5),
(41, 'CATEGORIA 5 - copii', 173.45, 'Sala Polivalenta BTarena, Cluj-Napoca - Strada Uzinei Electrice, Cluj-Napoca', 'Bilet pentru copii între 2-12 ani în zona Categoria 5.', 5),
(42, 'General Access - Presale', 429.1, 'Pădurea VERDE, Timișoara - Avram Imbroane nr. 90', 'Abonamentul General Access oferă 3 zile de acces în perimetrul festivalului, de vineri (29 august) până duminică (31 august) inclusiv.', 6),
(43, 'Under 25 - Presale', 304.14, 'Pădurea VERDE, Timișoara - Avram Imbroane nr. 90', 'Abonament redus pentru persoanele sub 25 de ani, valabil 3 zile (29–31 august).', 6),
(44, 'Premium', 372.19, 'Arenele Romane, București - Str. Cutitul de Argint, Parcul Carol I', 'Cu loc în sectoarele K și E. Asigură acces și în categoria Teren, early entry și afiș cadou. Locurile se ocupă pe măsură ce sosiți la locație.', 7),
(45, 'Teren', 269.81, 'Arenele Romane, București - Str. Cutitul de Argint, Parcul Carol I', 'Fără loc, în fața scenei.', 7),
(46, 'Acces General', 218.03, 'Arenele Romane, București - Str. Cutitul de Argint, Parcul Carol I', 'Cu loc în Arenă (mai puțin sectoarele K și E) sau fără loc în spatele zonei Teren. Locurile se ocupă pe măsură ce sosiți la locație. Mai sunt doar 36 bilete disponibile.', 7),
(47, 'Teren', 250.81, 'Arenele Romane, București - Str. Cutitul de Argint, Parcul Carol I', 'Fără loc, în fața scenei. Cea mai bună vizibilitate.', 8),
(48, 'Abonament', 345.71, 'Vama Veche, România', '', 9),
(49, 'Bilet Ziua 1 - Joi, 14 August', 157.14, 'Vama Veche, România', 'Lineup: Trooper, Bucovina, Anton, Revolver', 9),
(50, 'Bilet Ziua 2 - Vineri, 15 August', 157.14, 'Vama Veche, România', 'Lineup: Dirty Shirt, Sukar Nation, The Groovy Bastards, The Strizzers', 9),
(51, 'Bilet Ziua 3 - Sambata, 16 August', 157.14, 'Vama Veche, România', 'Lineup: Alternosfera, Hvnds, June Turns Black, Hollow Flag', 9),
(52, 'Abonament ARTmania Festival 2025 - KIDS', 0, 'Piata Mare - Sibiu, Sibiu', 'Disponibil pentru copii cu varsta pana in 12 ani. Acces gratuit, însoțiți de un adult cu bilet. Accesul va fi permis in baza biletului si a declaratiei pentru minori. (declaratia poate fi accesata din cadrul link-ului Termenii si Conditiile organizatorului din pasii de comanda)', 10),
(53, 'Abonament ARTmania Festival 2025 – School of Rock', 157.14, 'Piata Mare - Sibiu, Sibiu', 'Abonament dedicat tinerilor între 12–18 ani și celor până în 25 de ani, dacă sunt studenți sau masteranzi.', 10),
(54, 'Abonamente Presale 1', 576.18, 'Piata Mare - Sibiu, Sibiu', '', 10),
(55, 'Acces vineri 25 iulie', 471.42, 'Piata Mare - Sibiu, Sibiu', '', 10),
(56, 'Acces sambata 26 iulie', 366.66, 'Piata Mare - Sibiu, Sibiu', '', 10),
(57, 'General Acces', 495, 'Piața Constituției, București', '', 11),
(58, 'Golden Circle', 825, 'Piața Constituției, București', '', 11),
(59, 'Diamond Circle', 1045, 'Piața Constituției, București', '', 11),
(60, 'VIP', 1100, 'Piața Constituției, București', '', 11),
(61, 'Greet & Photo', 0, 'Piața Constituției, București', 'Sold out', 11),
(62, 'Vineri 29 august - Classical Strings - 18:30', 210.84, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', '', 13),
(63, 'Vineri 29 august - Modern Strings - 20:00', 210.84, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', '', 13),
(64, 'Full Access Vineri 29 august', 369.77, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', 'Full night experience with both concerts. Asigura accesul la ambele concerte de Vineri. Mai sunt doar 16 bilete disponibile', 13),
(65, 'Sambata 30 august - Classical Strings - 18:30', 263.82, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', '', 13),
(66, 'Sambata 30 august - Modern Strings - 20:00', 263.82, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', '', 13),
(67, 'Full Access Sambata 30 august', 475.72, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', 'Full night experience with both concerts. Asigura accesul la ambele concerte de Sambata. Mai sunt doar 20 bilete disponibile', 13),
(68, 'Duminica 31 august - Classical Strings - 18:30', 210.84, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', '', 13),
(69, 'Duminica 31 august - Modern Strings - 20:00', 210.84, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', '', 13),
(70, 'Full Access Duminica 31 august', 369.77, 'Palais Ghica Victoria, București Nicolae Iorga nr. 1', 'Full night experience with both concerts. Asigura accesul la ambele concerte de Duminica. Mai sunt doar 18 bilete disponibile', 13),
(71, 'General Acces', 330, 'Romexpo, București Bulevardul Mărăști 65-67', 'In spatele Golden Circle', 14),
(72, 'Golden Circle', 440, 'Romexpo, București Bulevardul Mărăști 65-67', 'In spatele Front of Stage. Mai sunt doar 59 bilete disponibile', 14),
(73, 'Front of Stage', 550, 'Romexpo, București Bulevardul Mărăști 65-67', 'In fața scenei. Mai sunt doar 59 bilete disponibile', 14),
(74, 'Acces General', 100, 'Sala Polivalenta a Sporturilor, Focșani Bulevardul Unirii, Focșani 620172', '', 15),
(75, 'Full Pass - General Access', 399, 'Bulevardul Victoriei, Sibiu, România', '', 16),
(76, 'Full Pass - General Access - Couple Pack 2', 339.15, 'Bulevardul Victoriei, Sibiu, România', 'Pui 2 bilete în coș și beneficiezi de discount 15%', 16),
(77, 'Full Pass - General Access - Group Pack 3', 327.18, 'Bulevardul Victoriei, Sibiu, România', 'Pui 3 bilete în coș și beneficiezi de discount 18%', 16),
(78, 'Full Pass - General Access - Group Pack 5', 319.02, 'Bulevardul Victoriei, Sibiu, România', 'Pui 5 bilete în coș și beneficiezi de discount 20%', 16),
(79, 'U21 Pass - General Access', 249, 'Bulevardul Victoriei, Sibiu, România', 'Bilet valabil doar pentru persoanele care au maxim 21 ani împliniți la data evenimentului.', 16),
(80, 'Abonament / Pass for all six days', 635.7, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '6 days pass and 3 day pass', 17),
(81, 'Abonament marți, miercuri, joi', 423.8, '', '', 17),
(82, 'Abonament weekend (vineri, sâmbătă, duminică)', 529.75, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(83, 'Bilet Marți', 158.93, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(84, 'Bilet Miercuri', 158.93, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(85, 'Bilet Joi', 211.9, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(86, 'Bilet Vineri', 211.9, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(87, 'Bilet Sâmbătă', 370.83, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(88, 'Bilet Duminică', 211.9, 'Summer Camp Brezoi, Brezoi (Vâlcea)', '', 17),
(89, 'Camping cort STADION', 63.57, 'Summer Camp Brezoi, Brezoi (Vâlcea)', 'Prețul este per persoană și acoperă întreaga perioadă a festivalului.', 17),
(90, 'Camping cort', 63.57, 'Summer Camp Brezoi, Brezoi (Vâlcea)', 'Prețul este de persoană pentru întreaga perioadă a festivalului.', 17),
(91, 'Camping rulote', 63.57, 'Summer Camp Brezoi, Brezoi (Vâlcea)', 'Prețul este de persoană pentru întreaga perioadă a festivalului.', 17),
(92, 'Categoria I Presale (27.09)', 442, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 18),
(93, 'Categoria II Presale (27.09)', 338, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', 'Mai sunt doar 2 bilete disponibile', 18),
(94, 'Categoria III Presale (27.09)', 234, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 18),
(95, 'Categoria I Presale (28.09)', 442, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 18),
(96, 'Categoria II Presale (28.09)', 338, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 18),
(97, 'Categoria III Presale (28.09)', 234, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 18),
(98, 'Categoria IV Presale (28.09)', 130, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', 'Sold out', 18),
(99, 'Categoria D - Tarif de vara', 169.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 19),
(100, 'Categoria C - Tarif de vara', 199.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 19),
(101, 'Categoria B - Tarif de vara', 219.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 19),
(102, 'Categoria A - Tarif de vara', 259.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 19),
(103, 'VIP', 369.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', 'Mai sunt doar 14 bilete disponibile', 19),
(104, 'VIP - Earlybird', 319.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', 'Sold out', 19),
(105, 'Bilete persoane cu dizabilitati', 0, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', 'Biletele pentru persoanele cu handicap se pot achizitiona gratuit in limita stocului disponibil si se adreseaza doar persoanelor cu handicap grav sau accentuat plus un însoțitor al acestora. Accesul la spectacol va fi permis doar in urma prezentarii documentelor justificative.\nStoc epuizat', 19),
(106, 'Categoria I - Pitești', 132.44, 'Filarmonica Pitești, Pitești\nCalea București 2, Pitești', '', 20),
(107, 'Categoria II - Pitești', 105.95, 'Filarmonica Pitești, Pitești\nCalea București 2, Pitești', 'Mai sunt doar 27 bilete disponibile', 20),
(108, 'Categoria III - Pitești', 84.76, 'Filarmonica Pitești, Pitești\nCalea București 2, Pitești', 'Mai sunt doar 29 bilete disponibile', 20),
(109, 'Acces General - Brașov', 158.93, 'Filarmonica Brașov - Sala Patria, Brasov\nStrada 15 Noiembrie 50A', '', 20),
(110, 'Categoria I - Sibiu', 158.93, 'Filarmonica de Stat Sibiu - Sala Thalia, Sibiu\nStr. Cetatii, nr. 3-5', '', 20),
(111, 'Categoria II - Sibiu', 127.14, 'Filarmonica de Stat Sibiu - Sala Thalia, Sibiu\nStr. Cetatii, nr. 3-5', '', 20),
(112, 'Categoria I - Cluj-Napoca', 158.93, 'Casa de Cultura a Studentilor, Cluj-Napoca\nPiata Lucian Blaga, nr. 1-3', '', 20),
(113, 'Categoria II - Cluj-Napoca', 127.14, 'Casa de Cultura a Studentilor, Cluj-Napoca\nPiata Lucian Blaga, nr. 1-3', '', 20),
(114, 'Categoria III - Cluj-Napoca', 95.36, 'Casa de Cultura a Studentilor, Cluj-Napoca\nPiata Lucian Blaga, nr. 1-3', '', 20),
(115, 'Categoria 1 - Bistrița', 127.14, 'Palatul Culturii Bistrita, Bistrița\nstr. Albert Berger, nr. 10', '', 20),
(116, 'Categoria 2 - Bistrița', 95.36, 'Palatul Culturii Bistrita, Bistrița\nstr. Albert Berger, nr. 10', 'Mai sunt doar 13 bilete disponibile', 20),
(117, 'Categoria I - Baia Mare', 132.44, 'ATP Tech Center, Baia Mare\nBulevardul Regele Mihai I 67, Baia Mare 430012', '', 20),
(118, 'Categoria II - Baia Mare', 95.36, 'ATP Tech Center, Baia Mare\nBulevardul Regele Mihai I 67, Baia Mare 430012', '', 20),
(119, 'Categoria 1 - Oradea', 127.14, 'Casa Tineretului, Oradea\nCalea Alexandru Cazaban 49, Oradea 410282', '', 20),
(120, 'Categoria 2 - Oradea', 95.36, 'Casa Tineretului, Oradea\nCalea Alexandru Cazaban 49, Oradea 410282', 'Mai sunt doar 15 bilete disponibile', 20),
(121, 'Categoria 1 - Timișoara', 132.44, 'Filarmonica Banatul Timisoara - Sala Capitol, Timisoara\nBd. Constantin Diaconovici Loga, 2', '', 20),
(122, 'Categoria 2 - Timișoara', 105.95, 'Filarmonica Banatul Timisoara - Sala Capitol, Timisoara\nBd. Constantin Diaconovici Loga, 2', '', 20),
(123, 'Categoria 3 - Timișoara', 84.76, 'Filarmonica Banatul Timisoara - Sala Capitol, Timisoara\nBd. Constantin Diaconovici Loga, 2', '', 20),
(129, 'Standing', 203.23, 'Sala Polivalenta BTarena, Cluj-Napoca\r\nStrada Uzinei Electrice, Cluj-Napoca', '', 21),
(130, 'PREMIUM', 246.24, 'Sala Polivalenta BTarena, Cluj-Napoca\r\nStrada Uzinei Electrice, Cluj-Napoca', '', 21),
(131, 'ROSU', 203.23, 'Sala Polivalenta BTarena, Cluj-Napoca\r\nStrada Uzinei Electrice, Cluj-Napoca', '', 21),
(132, 'GALBEN', 160.22, 'Sala Polivalenta BTarena, Cluj-Napoca\r\nStrada Uzinei Electrice, Cluj-Napoca', '', 21),
(133, 'VIOLET', 138.71, 'Sala Polivalenta BTarena, Cluj-Napoca\r\nStrada Uzinei Electrice, Cluj-Napoca', '', 21),
(134, 'Acces online', 26.49, 'Romania, Romania', 'Biletele virtuale reprezintă donații pentru Asociația Liga Legendelor.', 22),
(135, 'VIP - Earlybird', 226.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 23),
(136, 'Categoria A - Earlybird', 182.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 23),
(137, 'Categoria B - Earlybird', 147.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 23),
(138, 'Categoria C - Earlybird', 120.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 23),
(139, 'Categoria D - Earlybird', 94.14, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', '', 23),
(140, 'Bilete persoane cu dizabilitati', 0, 'Sala Palatului, București\nStrada Ion Câmpineanu, nr. 28', 'Sold out', 23),
(141, 'General Admission', 0, 'Online', 'Bilet gratuit general', 24),
(142, 'General Admission', 0, 'Online', 'Bilet gratuit general', 26),
(143, 'Member Ticket', 540, 'Online', 'Bilet pentru membri', 27),
(144, 'Non-member Ticket', 630, 'Online', 'Bilet pentru non-membri', 27),
(145, 'General Admission', 202.5, 'Online', 'Bilet general', 28);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_cat` int(11) NOT NULL,
  `denumire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_cat`, `denumire`) VALUES
(1, 'Concert'),
(2, 'Festival'),
(3, 'Teatru'),
(4, 'Stand-up'),
(5, 'Operă'),
(6, 'Balet'),
(7, 'Jazz'),
(8, 'Rock'),
(9, 'Pop'),
(10, 'Clasic'),
(11, 'Hip-hop'),
(12, 'Electronic'),
(13, 'Indie'),
(14, 'Folk'),
(15, 'Blues'),
(16, 'Rap'),
(17, 'Metal'),
(18, 'Muzică religioasă'),
(19, 'Muzică instrumentală'),
(20, 'Muzică tradițională'),
(21, 'Film'),
(22, 'Proiecție specială'),
(23, 'Lansare de album'),
(24, 'Conferință'),
(25, 'Workshop'),
(26, 'Seminar'),
(27, 'Expoziție'),
(28, 'Artă vizuală'),
(29, 'Sculptură'),
(30, 'Pictură'),
(31, 'Fotografie'),
(32, 'Lansare de carte'),
(33, 'Târg'),
(34, 'Comedie'),
(35, 'Cultură urbană'),
(36, 'Cultură populară'),
(37, 'Modă'),
(38, 'Gastronomie'),
(39, 'Sport'),
(40, 'Fitness'),
(41, 'E-sports'),
(42, 'Tehnologie'),
(43, 'Gaming'),
(44, 'Business'),
(45, 'Educație'),
(46, 'Spiritualitate'),
(47, 'Meditație'),
(48, 'Familie'),
(49, 'Copii'),
(50, 'Caritabil'),
(51, 'Beach'),
(52, 'Party');

-- --------------------------------------------------------

--
-- Table structure for table `cos`
--

CREATE TABLE `cos` (
  `id_cos` int(11) NOT NULL,
  `isBought` tinyint(1) NOT NULL,
  `cantitate` int(11) NOT NULL,
  `pret` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cos`
--

INSERT INTO `cos` (`id_cos`, `isBought`, `cantitate`, `pret`, `id_user`) VALUES
(91, 1, 2, 30, 23),
(92, 1, 3, 2472, 23),
(93, 1, 2, 30, 23),
(94, 0, 0, 0, 0),
(95, 0, 0, 0, 0),
(96, 0, 0, 0, 0),
(97, 0, 0, 0, 0),
(98, 0, 0, 0, 0),
(99, 1, 4, 6371, 27),
(100, 1, 1, 15, 27),
(101, 1, 1, 15, 27),
(102, 1, 2, 30, 27),
(116, 1, 1, 15, 27),
(117, 1, 1, 15, 27),
(118, 1, 1, 15, 27),
(119, 1, 1, 15, 27),
(120, 1, 2, 40, 27);

-- --------------------------------------------------------

--
-- Table structure for table `cos_bilet`
--

CREATE TABLE `cos_bilet` (
  `id_cos_bilet` int(11) NOT NULL,
  `id_cos` int(11) NOT NULL,
  `id_bilet` int(11) NOT NULL,
  `cantitate` int(11) NOT NULL,
  `pret` int(11) NOT NULL,
  `pret_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cos_bilet`
--

INSERT INTO `cos_bilet` (`id_cos_bilet`, `id_cos`, `id_bilet`, `cantitate`, `pret`, `pret_total`) VALUES
(13, 92, 11, 2, 799, 1748),
(14, 92, 12, 1, 874, 874),
(15, 93, 26, 2, 15, 30),
(16, 99, 12, 1, 874, 1999),
(17, 99, 13, 1, 1499, 1999),
(18, 99, 14, 2, 1999, 3998),
(19, 100, 26, 1, 15, 15),
(20, 101, 26, 1, 15, 15),
(21, 102, 26, 2, 15, 30),
(22, 103, 26, 1, 15, 15),
(23, 104, 26, 1, 15, 15),
(24, 105, 26, 1, 15, 15),
(25, 106, 26, 1, 15, 15),
(26, 107, 145, 2, 202, 404),
(27, 108, 26, 1, 15, 15),
(28, 109, 26, 1, 15, 15),
(29, 110, 26, 2, 15, 30),
(30, 111, 26, 2, 15, 30),
(31, 112, 26, 3, 15, 45),
(32, 113, 26, 2, 15, 30),
(33, 114, 26, 1, 15, 15),
(34, 115, 26, 1, 15, 15),
(35, 116, 26, 1, 15, 15),
(36, 117, 26, 1, 15, 15),
(37, 118, 26, 1, 15, 15),
(38, 119, 26, 1, 15, 15),
(39, 120, 147, 2, 20, 40);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `organiser` varchar(255) NOT NULL,
  `imgpath` varchar(255) NOT NULL,
  `description` varchar(3700) NOT NULL,
  `city` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `name`, `location`, `date`, `organiser`, `imgpath`, `description`, `city`, `type`) VALUES
(1, 'BEACH, PLEASE! Festival 2026', 'Costinești', '2026-07-08', 'by Selly', 'beach_please2026.png', 'ATENTIE! Varsta minima pentru a participa la BEACH, PLEASE! 2026 este 14 ani. Minorii intre 14 si 15 ani trebuie sa fie obligatoriu insotiti de un parinte sau tutore legal. Parintele/tutorele legal trebuie sa aiba, de asemenea, bilet valabil pentru a intra in festival.\r\n<br /><br />\r\nToate biletele sunt NOMINALE si NETRANSMISIBILE. In momentul in care se achizitioneaza biletul, trebuie completat numele complet al participantului. In cazul in care participantul nu mai poate ajunge la eveniment, biletul este nul, nu se poate schimba numele de pe bilet ulterior.\r\n<br /><br />\r\n<b>Biletele NU SE RETURNEAZA.</b>\r\n<br /><br />\r\nPrin achizitia biletului, ati citit si sunteti de acord cu <a href=\"https://beach-please.ro/regulament-bp26/\"> Regulamentul Oficial al Beach, Please 2026</a>.', 'Costinești', 'fizic'),
(2, 'BEACH, PLEASE! Festival 2025', 'Plaja Obelisc, Costinești', '2025-07-09', 'by Selly', 'beach_please2025.png', 'ATENTIE! Varsta minima pentru a participa la BEACH, PLEASE! 2025 este 14 ani. Minorii intre 14 si 15 ani trebuie sa fie obligatoriu insotiti de un parinte sau tutore legal. Parintele/tutorele legal trebuie sa aiba, de asemenea, bilet valabil pentru a intra in festival.\r\n<br /><br />\r\nToate biletele sunt NOMINALE si NETRANSMISIBILE. In momentul in care se achizitioneaza biletul, trebuie completat numele complet al participantului. In cazul in care participantul nu mai poate ajunge la eveniment, biletul este nul, nu se poate schimba numele de pe bilet ulterior.\r\n<br /><br />\r\n<b>Biletele NU SE RETURNEAZA.</b>\r\n<br /><br />\r\nPrin achizitia biletului, ati citit si sunteti de acord cu <a href=\"https://beach-please.ro/regulament-bp25/\"> Regulamentul Oficial al Beach, Please 2025<a/>.', 'Costinești', 'fizic'),
(3, 'ULTIMA NOAPTE / L\'ULTIMA NOTTE DI AMORE\r\n', 'Film Online', '2025-06-23', 'by SMART HOUSE films from Bad Unicorn', 'ultima_noapte.jpg', 'Franco Amore își pregătește discursul de pensionare. Este ultima lui noapte din cei 35 de ani în slujba poliției. În lunga sa carieră nu a tras nici măcar o dată pentru a ucide și întotdeauna s-a străduit să rămână onest. Ce nu știe el este că are în față cea mai lungă și dificilă noapte din viață și că pericolul amenință tot ceea ce contează pentru el: cariera sa, dragostea pentru soția sa, prietenia cu partenerii de echipă, chiar și propria-i viață.\r\n<br /><br />\r\nÎn „Ultima noapte” a lui Amore, Milano este scena unor evenimente care se vor succeda cu repeziciune, în timp ce lumina dimineții pare tot mai departe.\r\n<br /><br />\r\n<b>Premii: Selecție Berlinale Special Gala 2022\r\n<br /><br />\r\nImportant! Filmul nu poate fi redat prin dispozitivele de tip Chromecast</b>', '-', 'virtual'),
(4, 'Unforgettable Festival 2025', 'Piața Constituției', '2025-09-11', 'Dream Events', 'unforgettable_2025.png', 'Artiști confirmați: Andrea Bocelli, Nikos Vertis, Gheorghe Zamfir, José Carreras, Katherine Jenkins, Loreen, Arash, David Gimenez, Andra, Subcarpati Simfonic și mulți alții.<br /><br />\r\n\r\nEdiția 2025 a Unforgettable Festival aduce în Piața Constituției din București, pe parcursul a trei zile, spectacole pline de emoție, arta și muzica. ANDREA BOCELLI, celebrul tenor italian, cu vocea sa emblematică, vine la București pentru un concert care promite emoție pură și momente de neuitat. Iubit în întreaga lume pentru sensibilitatea și rafinamentul interpretării sale, Andrea Bocelli aduce la Unforgettable Festival o experiență sonoră care va rămâne în sufletul tău pentru totdeauna.<br /><br />\r\n\r\nGHEORGHE ZAMFIR, maestrul naiului, revine pe scena festivalului cu un moment dedicat – \"Celebrating Zamfir\". Această reprezentație unică va aduce în prim-plan geniul muzical al marelui Gheorghe Zamfir, alături de invitații săi speciali și interpretări care îmbină muzica clasică, folclorul românesc cu influențele moderne.<b', 'București', 'fizic'),
(5, 'Cluj-Napoca: OVO by Cirque du Soleil', 'BTarena', '2026-04-23', 'Cirque du Soleil', 'ovo_cirque.jpg', 'Biletele vor fi puse în vânzare pentru publicul general începând cu 11 iulie, iar membrii Cirque Club, Emagic, iaBilet și Ticketa au acces prioritar începând cu 8 iulie.<br /><br />\r\n\r\nPregătiți-vă să aflați despre ce este tot acest zumzet! Creat în 2009, celebrul spectacol OVO („ou” în portugheză) al Cirque du Soleil va face o oprire în oraș cu o versiune reînnoită! După câteva luni de muncă, echipa OVO va prezenta noua iterație a spectacolului. Cu un decor regândit, noi numere acrobatice, personaje originale, costume adăugate și muzică reimaginată, OVO încântă mai mult ca niciodată cu fascinanta sa colonie de insecte, reunind 53 de acrobați și muzicieni într-un spectacol care încântă atât adulții, cât și copiii!<br /><br />\r\n\r\nDupă ce a captivat publicul în 40 de țări și a fermecat mulțimile din întreaga lume, OVO vine la BT ARENA din Cluj-Napoca, în perioada 23–26 aprilie 2026.<br /><br />\r\n\r\n<strong>PROGRAM SPECTACOLE:</strong><br /><br />\r\nOVO va susține spectacole în Cluj-Napoca, la BT Arena, în datele:\r\n<br /><br />\r\nJoi, 23 aprilie, ora 19:00\r\n<br />\r\nVineri, 24 aprilie, ora 19:00\r\n<br />\r\nSâmbătă, 25 aprilie, ora 15:00 (primul spectacol) si ora 19:00 (al doilea spectacol)\r\n<br />\r\nDuminică, 26 aprilie, ora 17:00 \r\n<br /><br />\r\n\r\nDESPRE OVO \r\n<br /><br />\r\nDe la greierii energici care sar voioși pe trambuline, până la păianjenul hipnotizant ce se mișcă grațios în propria pânză, OVO oferă un spectacol captivant care îți pune imaginația în mișcare. Plin de umor și momente haotice, dar și adorabil și fermecător, OVO reușește să trezească copilul din fiecare dintre noi cu bucuria și energia sa molipsitoare. O trupă de 100 de persoane din 25 de țări diferite, inclusiv 53 de artiști, OVO („ou” în portugheză) aduce pe scenă numere acrobatice de înalt nivel, redefinind limitele corpului uman. De la premiera sa în Montreal, în 2009, OVO a încântat peste 7 milioane de spectatori în 40 de țări diferite.\r\n<br /><br />\r\nCIRQUE DU SOLEIL ENTERTAINMENT GROUP\r\n<br /><br />\r\nCirque du Soleil Entertainment Group este un nume de referință la nivel mondial în domeniul divertismentului live. Cu o experiență de peste 40 de ani în depășirea limitelor imaginației, compania aduce un suflu creativ în numeroase forme de entertainment, de la producții multimedia și experiențe imersive, până la evenimente speciale de anvergură. Anul trecut, Cirque du Soleil a celebrat patru decenii în care a redefinit arta spectacolului, a sfidat convențiile și a inspirat publicul din întreaga lume. De la înființarea sa în 1984, peste 400 de milioane de oameni din 86 de țări și 6 continente au fost fermecați de creațiile sale. În prezent, compania canadiană numără peste 4000 de angajați, inclusiv 1200 de artiști provenind din 80 de naționalități diferite. Pentru mai multe detalii despre Cirque du Soleil Entertainment Group, vă invităm să vizitați cirquedusoleil.com.\r\n<br /><br />\r\nUn eveniment Emagic și Live Nation.', 'Cluj-Napoca', 'fizic'),
(6, 'CODRU Festival 2025', 'Pădurea Verde', '2025-08-29', 'Codru Events', 'codru_2025.jpg', 'CODRU Festival 2025!<br /><br />\r\n29-31 august, Pădurea VERDE Timișoara De 5 ani, CODRU este locul unde muzica, arta și comunitatea se întâlnesc.<br /><br />\r\nÎncă de la prima ediție, a fost mai mult decât scene și lumini. Ne-am dorit un loc al întâlnirilor, al zâmbetelor de copii și al copacilor care cresc, datorită vouă și a fiecărui bilet cumpărat.<br /><br />\r\nLa CODRU5 vor urca pe scenele festivalului artiști care ne ating sufletul și ne inspiră. Artiști care ne fac să dansăm, să ne emoționăm, să ne îmbrățișăm și să zâmbim.<br /><br />\r\nPe scenele CODRU din această vară vor urca:<br /><br />\r\nAkua Naru, Trio Mandili, Goran Bregovic & Wedding and Funeral Band, Subcarpați, Irina Rimes, Deliric x Silent Strike, Vița de Vie, COMA, Dirty Shirt, Phoenix, Tania Turtureanu, Implant pentru Refuz, Mircea Baniciu, Paraziții, Oscar, Rava, Erika Isac, Azteca, Sami G, IDK, Albert NBN, Calinacho, NOUA UNSPE, E-an-na, Florin Chilian, Emeric Imre, Radu Guran, Țapinarii, Eligraf... și mulți alții pe care îi vom dezvălui în curând.\r\n<br /><br />\r\nCODRU Festival aduce muzica aproape de natură, zone speciale de relaxare, zone dedicate copiilor, mâncare locală, artă, comunitatea împreună și, poate, câteva lacrimi de fericire.\r\n<br /><br />\r\nCODRU înseamnă mai mult decât un festival.\r\n<br /><br />\r\nEste despre oameni. Despre grija față de natură. Despre artă. Despre comunitate și sprijin reciproc.\r\n<br /><br />\r\nIar după cinci ani împreună, povestea noastră abia începe.', 'Timișoara', 'fizic'),
(7, 'Skunk Anansie la Arenele Romane', 'Arenele Romane', '2025-07-27', 'Live Nation', 'skunk_anansie.jpg', 'SKUNK ANANSIE cântă pe 27 iulie la Arenele Romane din București.<br /><br />\r\n#concert #bucuresti #skunkanansie #areneleromane<br /><br />\r\nSkunk Anansie vin din Londra, Anglia, iar activitatea și-au început-o în 1994. Chiar dacă din 2001 au avut o perioadă de pauză, începând cu 2008, formația a revenit în atenția publicului. Până în prezent au lansat șase materiale de studio care le-au adus 10 Discuri de Platină și 14 Discuri de Aur, vânzând peste 5 milioane de albume.<br /><br />\r\nAbordează un stil muzical din care regăsim influențe din alternative, hard rock sau grunge.<br /><br />\r\nPrintre artiștii care i-au influențat se numără Sex Pistols sau Blondie, aceștia declarând însă că și muzica reggae, hip-hop sau dub și-a pus amprenta asupra lor. Lineup-ul formației este neschimbat din 1995, când toboșarul Robbie France a fost înlocuit de Mark Richardson.<br /><br />\r\nDe-a lungul timpului au susținut turnee alături de formații precum U2, Aerosmith, Rammstein, Muse, Staind sau Soulfly și au fost headlineri la festivaluri precum Glastonbury sau Sziget.<br /><br />\r\nBiletele se pun în vânzare la următoarele prețuri:<br /><br />\r\n\r\nPremium (cu loc în sectoarele K și E) - 289 lei în earlybird, 309 lei în presale și 350 la intrare<br />\r\n\r\nTeren (fără loc, în fața scenei) - 209 lei în earlybird, 229 în presale și 250 la intrare<br />\r\n\r\nAcces General (cu loc în Arena) - 149 lei în earlybird, 169 lei în presale și 200 lei la intrare<br /><br />\r\nCopiii sub 10 ani au acces gratuit doar în zona Teren (nu și pe scaune) și însoțiți de un adult posesor de bilet valabil.<br /><br />\r\nSe consideră biletul validat momentul în care ați intrat la concert, atunci când acesta a fost scanat / rupt. Din acel moment biletul nu mai este valid și a început spectacolul / concertul / festivalul iar biletul (contravaloarea acestuia) nu mai poate fi returnat(ă) în nicio circumstanță. În caz de vreme nefavorabilă sau în caz de urgență organizatorii vă pot cere să evacuați locația și să reveniți când este sigur pentru dumneavoastră să participați la eveniment. Vă rugăm să urmăriți cu atenție mereu instrucțiunile organizatorilor, ale firmei de pază și mai ales ale autorităților pe toată perioada când sunteți în locația unde are loc evenimentul.<br /><br />\r\nLocurile se ocupă pe măsură ce sosiți în locație.<br /><br />\r\nRecomandăm fanilor care vin cu copii sub 10 ani să le protejeze acestora urechile cu căști speciale. La concert volumul va fi puternic și acesta poate afecta auzul copiilor.<br /><br />\r\nOrganizatorii vor organiza suficiente puncte de vânzare a băuturilor pentru a evita cozile, Arenele Romane fiind o locație propice pentru evenimentele de gen. Recomandăm totuși să veniți la concert din timp și nu fix înainte de concert. Este normal ca la orele de vârf, fix înainte de intrarea pe scenă a trupei, când se atinge capacitatea maximă a locației, barurile să se aglomereze. Organizatorii vor oferi un program detaliat cu câteva săptămâni înainte de concert.<br /><br />\r\nAccesul cu umbrele este interzis.\r\n<br /><br />\r\nBiletele se gasesc in format electronic pe www.iabilet.ro si in magazinele Flanco din toata tara,  Magazinul Muzica din Bucuresti si pe terminalele Selfpay. Online puteti plati cu cardul, prin Revolut Pay, prin Paypal, folosind carduri de tichete culturale Sodexo, Up si Edenred, pe factura la Vodafone sau Orange sau in rate cu carduri de credit acceptate. La pretul tuturor biletelor comandate se adauga comisioanele agentiei de ticketing.\r\n<br /><br', 'București', 'fizic'),
(8, 'Joe Satriani & Steve Vai & SatchVai Band', 'Arenele Romane', '2025-07-23', 'Live Nation', 'satriani_vai.jpg', 'Celebrii chitariști Joe Satriani și Steve Vai cântă pe 23 iulie la Arenele Romane din București alături de trupa SatchVai Band în cadrul turneului Surfing with the Hydra 2025 Tour. Muzicienii din SatchVai Band sunt un all star team compus din toboșarul Kenny Aronoff, basistul Marco Mendoza și chitaristul Pete Thorn.<br /><br />\r\n#concert #bucuresti #stevevai #joesatriani #satchvaiband #areneleromane<br /><br />\r\nPentru prima dată, celebrii chitariști vor susține un turneu împreună! În cei aproape 50 de ani de carieră, Joe Satriani și Steve Vai s-au decis să pună bazele SATCHVAI BAND urmând să pornească într-un turneu european ce se anunță electrizant! În afara celebrului G3, Satriani și Vai au avut primul turneu împreună în primăvara lui 2024, când au cântat în mai multe orașe din Statele Unite, iar acum s-au decis să formeze o trupă în adevăratul sens al cuvântului și să își înceapă concertele pe bătrânul continent.<br /><br />\r\nÎn Martie 2024 au lansat \'The Sea of Emotion, Part 1\', prima colaborare muzicală dintre cei doi, urmând ca în scurt timp să fie lansată și o a doua astfel de colaborare. Istoria dintre cei doi artiști începe încă de pe vremea când Satriani era profesorul de chitară a lui Vai iar relația dintre cei doi a evoluat continuu. De-a lungul timpului cei doi au făcut echipă în repetate rânduri cu câte un alt chitarist în cadrul celebrului turneu G3.<br /><br />\r\nConcertul celor doi mari chitariști se anunță a fi un adevărat festin muzical ce nu trebuie ratat.<br /><br />\r\nBiletele se pun în vânzare la următoarele prețuri:<br /><br />\r\n\r\nPremium (cu loc în sectoarele K și E) - 329 lei în earlybird, 349 lei în presale și 380 la intrare<br />\r\n\r\nTeren (fără loc, în fața scenei) - 239 lei în earlybird, 259 în presale și 290 la intrare<br />\r\n\r\nAcces General (cu loc în Arena) - 169 lei în earlybird, 189 lei în presale și 220 lei la intrare<br /><br />\r\nCopiii sub 10 ani au acces gratuit doar în zona Teren (nu și pe scaune) și însoțiți de un adult posesor de bilet valabil.<br /><br />\r\nSe consideră biletul validat momentul în care ați intrat la concert, atunci când acesta a fost scanat / rupt. Din acel moment biletul nu mai este valid și a început spectacolul / concertul / festivalul iar biletul (contravaloarea acestuia) nu mai poate fi returnat(ă) în nicio circumstanță. În caz de vreme nefavorabilă sau în caz de urgență organizatorii vă pot cere să evacuați locația și să reveniți când este sigur pentru dumneavoastră să participați la eveniment. Vă rugăm să urmăriți cu atenție mereu instrucțiunile organizatorilor, ale firmei de pază și mai ales ale autorităților pe toată perioada când sunteți în locația unde are loc evenimentul.<br /><br />\r\nLocurile se ocupă pe măsură ce sosiți în locație.<br /><br />\r\nRecomandăm fanilor care vin cu copii sub 10 ani să le protejeze acestora urechile cu căști speciale. La concert volumul va fi puternic și acesta poate afecta auzul copiilor.<br /><br />\r\nOrganizatorii vor organiza suficiente puncte de vanzare a bauturilor pentru a evita cozile, Arenele Romane fiind o locatie propice pentru evenimentele de gen. Recomandam totusi sa veniti la concert din timp si nu fix inainte de concert. Este normal ca la orele de varf, fix inainte de intrarea pe scena a trupei cand se atinge capacitatea maxima a locatiei, barurile sa se aglomereze. Organizatorii vor oferi un program detaliat cu cateva saptamani inainte de concert.\r\n<br /><br />\r\nAccesul cu umbrele este interzis.\r\n<br /><br />\r\nBiletele se gase', 'București', 'fizic'),
(9, 'BACK IN VAMA – Manifestul unei întoarceri', 'Vama Veche', '2025-08-14', 'Vama Events', 'back_in_vama.jpg', 'Vama Veche își vrea spiritul înapoi. Și pe cei care au creat legenda.<br /><br />\r\nBack in Vama nu e doar un festival – e o chemare. O întoarcere la esență, la libertatea născută din acorduri de chitară, nopți fără sfârșit și comunitatea care a făcut din Vamă un simbol.<br /><br />\r\nNe întoarcem cu muzica care a creat locul, cu atitudine rock, cu legenda și cu dorul de ceea ce a fost, cu adevărat, aici.<br /><br />\r\nEste un omagiu adus celor care i-au dat viață. Și o rechemare pentru toți cei care au simțit vreodată că acolo era casa lor.<br /><br />\r\nA venit vremea să ne revendicăm locul – în Vama pe care tot noi, și cei ca noi, au creat-o.<br /><br />\r\nPentru că ceea ce s-a născut din noi... ne cheamă înapoi.<br /><br />\r\nProgram festival<br /><br />\r\nJoi, 14 August 2025:<br />\r\nTrooper<br />\r\nBucovina<br />\r\nAnton<br />\r\nRevolter<br /><br />\r\nVineri, 15 August:<br />\r\nDirty Shirt<br />\r\nSuklar Nation<br />\r\nThe Groovy Bastards<br />\r\nThe Strizzers<br /><br />\r\nSâmbătă, 16 August:<br />\r\nAlternosfera<br />\r\nHvnds<br />\r\nJune Turns Black<br />\r\nHollow Flag<br /><br />\r\nÎn fiecare seară, după concertul headliner-ului, Aftershow rock party cu “Emo Reunion”<br />\r\nPrezentatorul festivalului: Claudiu Cîrțină\r\n', 'Vama Veche', 'fizic'),
(10, 'ARTmania Festival Sibiu 2025', 'Piața Mare', '2025-07-25', 'ARTmania Org.', 'artmania_2025.jpg', 'București, 9 mai 2025<br />\r\nVotează. Nu-i lăsa pe alții să-ți seteze playlist-ul.<br /><br />\r\nDe Ziua Europei, pe 9 mai – ziua în care celebrăm pacea, libertatea și unitatea europeană – ARTmania Festival lansează platforma dedicată noii generații:<br /><br />\r\nRock Talk – School of Rock<br /><br />\r\nLa 20 de ani de la fondare și în pragul ediției cu numărul 18, după ce pe scena ARTmania au urcat unele dintre cele mai emblematice nume din rockul internațional – Korn, Nightwish, Serj Tankian, Die Toten Hosen, Porcupine Tree, Meshuggah, Wardruna, Helloween, HIM, Opeth – ne uităm înapoi cu mândrie la ce am construit împreună: O comunitate. O cultură. O tradiție.<br /><br />\r\nEram tineri, proaspăt absolvenți sau încă studenți, când am pornit pe acest drum. Și astăzi, după aproape două decenii, păstrăm flacăra vie.<br /><br />\r\nMai presus de orice headliner, mândria noastră este comunitatea ARTmania – o comunitate vibrantă de oameni care au o pasiune pentru artă, pentru muzică, pentru frumos.<br /><br />\r\nDe la seniori respectabili la copii curioși, de la adolescenți cu chitara în spate la bebeluși care fac primii pași spre scenă – împreună formăm o familie.<br /><br />\r\nAceastă comunitate e legată nu doar de sunetul tobelor sau al riff-urilor electrizante, ci de valori: Respect. Toleranță. Compasiune. Incluziune. Corectitudine. Libertate.<br /><br />\r\nÎntr-un context social fragil, în care dialogul public e degradat și tinerii devin tot mai puțin implicați civic, ARTmania reacționează:<br /><br />\r\nRock Talk – School of Rock<br /><br />\r\nO platformă de educație, cultură și conștientizare democratică parte din festivalul ARTmania<br /><br />\r\nCE NE PROPUNEM<br /><br />\r\nSă aducem muzica complexă mai aproape de noile generații<br />\r\nSă cultivăm gândirea critică, dialogul și curiozitatea culturală<br />\r\nSă încurajăm participarea civică, responsabilitatea socială și votul<br />\r\nSă oferim un spațiu de întâlnire între artiști și tineri, între experiență și prospețime<br /><br />\r\nCE OFERIM<br /><br />\r\nARTmania Festival 2025 - School of Rock Pass<br />\r\n→ 150 lei + taxe, valabil pentru: adolescenți între 12–18 ani elevi de liceu, studenți și masteranzi până în 25 de ani<br />\r\n→ Număr limitat de 500 abonamente<br /><br />\r\nCopiii sub 12 ani<br />\r\n→ Acces gratuit, însoțiți de un adult cu bilet<br />\r\nPersoanele cu dizabilități<br />\r\n→ Acces gratuit, fără bariere<br /><br />\r\nCE URMEAZĂ, dincolo de abonamentele disponibile imediat:<br /><br />\r\nInterviuri cu trupele, voluntarii și echipele din ultimele 18 ediții<br />\r\nArhivă digitală cu povești, clipuri și materiale educative<br />\r\nMini-serii video și TikTok Shorts pentru tineri<br />\r\nAteliere de chitară, întâlniri informale cu artiști, acțiuni live în Piața Mare<br /><br />\r\nDE CE ACUM?<br /><br />\r\nPentru că fără tineri activi și conectați, România riscă să piardă nu doar direcția democratică, ci și festivalurile.<br />\r\nFără cultură, educație și libertatea de a simți și gândi liber, scena devine tăcută.\r\n<br /><br />\r\nMESAJUL NOSTRU E CLAR:\r\n<br /><br />\r\nMuzică. Educație. Voce civică. Tineri care schimbă România.<br />\r\nVotează. Nu-i lăsa pe alții să-ți seteze playlist-ul. \r\n<br /><br />\r\nDESPRE ARTmania\r\n<br /><br />\r\nARTmania Festival este primul eveniment din România care a unit muzica rock cu artele vizuale și literatura, devenind un reper în cultura contemporană.<br />\r\nFestivalul oferă mai mult decât concerte: vernisaje, proiecții, lansări și momente de reflecție în inima Sibiulu', 'Sibiu', 'fizic'),
(11, 'Concert Jennifer Lopez (JLo)', 'Piața Constituției', '2025-07-27', 'MLD Events', 'jlo_bucharest.jpg', 'Jennifer Lopez (J Lo) în concert la București pe 27 iulie în Piața Constituției. Summer in the City aduce “UP ALL NIGHT LIVE” – cel mai exploziv show al verii!<br /><br />\r\n\r\nDiva absolută a showbiz-ului mondial aduce la București un show fulminant: Up All Night.<br /><br />\r\n\r\nJennifer Lopez va electriza publicul la cea de-a treia ediție Summer in the City! Superstarul internațional care a cucerit planeta prin energia sa debordantă, vocea și mișcările inconfundabile de dans, carismă și un stil mereu inspirațional a inclus Bucureștiul în cadrul noului său turneu mondial “Up All Night Live” – un eveniment unic, de neratat care va rescrie standardele spectacolelor live în România!<br /><br />\r\n\r\nConcertul de la București va fi un show incendiar, plin de emoție, energie și magie pură, adus de renumitul promotor de eveniment Marcel Avram, în parteneriat cu D&D East Entertainment. Biletele ale căror prețuri pleacă de la 400 lei (Early Bird) plus taxe s-au pus în vânzare iar noutatea absolută este că fanii vor putea achiziționa Greet & Foto Tickets care le vor permite să interacționeze și să se fotografieze cu celebra Jennifer Lopez. În plus, vor avea acces la o platformă VIP, dar și la Diamond Circle (categoria care aduce spectatorii cel mai aproape de artistă), de unde vor putea trăi intensitatea concertului la cote maxime.<br /><br />\r\n\r\nBiletele pentru concertul Jennifer Lopez se pun în vânzare la următoarele prețuri:<br /><br />\r\n\r\nAcces General Earlybird: 400 lei + comision ticketing<br />\r\nAcces General Presale: 450 lei + comision ticketing<br /><br />\r\n\r\nGolden Circle Earlybird: 650 lei + comision ticketing<br />\r\nGolden Circle Presale: 750 lei + comision ticketing<br /><br />\r\n\r\nDiamond Circle: 950 lei + comision ticketing<br /><br />\r\n\r\nTribuna VIP (informații în curând): 1000 lei + comision ticketing<br /><br />\r\n\r\nSupliment Greet & Photo: 5000 lei + comision ticketing<br /><br />\r\n\r\nGreet & Photo este un Pass care permite cumpărătorului să se întâlnească cu artistul și să facă o fotografie alături de acesta. Accesul este permis unei singure persoane. Greet & Photo nu oferă acces la eveniment, iar participarea la eveniment se face în baza unui bilet valabil, din categoriile disponibile, achiziționat separat.<br /><br />\r\n\r\nÎn cadrul Summer in the City, Jennifer Lopez va oferi publicului român o experiență totală: hituri care au făcut înconjurul lumii, coregrafii electrizante, ținute inspiraționale și o poveste personală transpusă pe scenă ca niciodată până acum într-un spectacol live.<br /><br />\r\n\r\nEste momentul, pe care fanii din România și întreaga lume l-au așteptat ani de zile și care își va pune amprenta pe vara anului 2025. Evenimentul în sine marchează o nouă perioadă în epopeea personală a artistei care revine după o carieră de o viață în lumina reflectoarelor cu o reinterpretare personală și o forță creativă nemaiîntâlnită.<br /><br />\r\n\r\n„Pentru toți fanii mei internaționali JLovers: voi susține câteva spectacole selecte în vara aceasta”, a postat artista pe Instagram. „Abia aștept să mă întorc pe scenă și să vă văd pe toți. A trecut prea mult timp! Va fi o vară incredibilă. Rămâneți pe fază pentru mai multe informații și vizitați contul @onthejlo pentru informații despre biletele disponibile în această săptămână.” Hashtag-ul oficial al turneului este #JLoLivein2025\r\n<br /><br />\r\nJennifer Lopez este o forță a naturii. Dominând multiple industrii ca actriță, producătoare, cântăreață și mogul de afaceri. Ea a realizat per', 'București', 'fizic'),
(13, 'Art, Drinks and Classical Strings', 'Palais Ghica Victoriei', '2025-08-29', 'Classical Events', 'classical_strings.jpg', '<br /><br />\r\nAria Pulse returns this August - but this time, with two unique concerts each evening.\r\n<br /><br />\r\nFirst Concert - Classical Strings\r\n18:30 – 19:30\r\n<br /><br />\r\nEine Kleine Nacht Musik – W. A. Mozart <br />\r\nAnotimpurile – A. Vivaldi <br />\r\nRondo Alla Turca – W. A. Mozart <br /><br />\r\n\r\nDans ungar nr. 1 – J. Brahms <br />\r\nDans ungar nr. 5 – J. Brahms <br /><br />\r\n\r\nPolka Pizzicato – J. Strauss <br />\r\nTrisch Trasch Polka – J. Strauss <br /><br />\r\n\r\nSleeping Beauty Waltz – P. I. Ceaikovski <br />\r\nMarș (Spărgătorul de nuci) – P. I. Ceaikovski <br />\r\nTrepak (Spărgătorul de nuci) – P. I. Ceaikovski <br /><br />\r\n\r\nSpecial Act - Bitter Sweet Symphony – The Verve\r\n<br /><br />\r\nA refined selection of classical string masterpieces – from Vivaldi to Mozart and others.\r\n<br /><br />\r\nTickets for 18:30 grand access in the palace for the interval 18:00–20:00.\r\n<br /><br />\r\nSecond Concert - Modern Strings\r\n20:00 – 21:00\r\n<br /><br />\r\nViva La Vida – Coldplay <br />\r\nParadise – Coldplay <br />\r\nA Sky Full of Stars – Coldplay <br />\r\nAdventure of a Lifetime – Coldplay <br /><br />\r\n\r\nThe Pirates of the Caribbean <br />\r\nLove Theme from The Godfather <br />\r\nSkyfall <br />\r\nMamma Mia <br /><br />\r\n\r\nBittersweet Symphony – The Verve <br /><br />\r\n\r\nRadioactive – Imagine Dragons <br />\r\nNatural – Imagine Dragons <br />\r\nBeliever – Imagine Dragons <br /><br />\r\n\r\nBohemian Rhapsody – Queen <br />\r\nShow Must Go On – Queen <br /><br />\r\n\r\nSpecial Act: Eine Kleine Nacht Musik – W. A. Mozart\r\n<br /><br />\r\nA vibrant twist with modern string arrangements – from Coldplay and Imagine Dragons to cinematic scores.\r\n<br /><br />\r\nTickets for 20:00 grand access in the palace for the interval 20:00–22:00.\r\n<br /><br />\r\nStay for one, or experience both.\r\n<br /><br />\r\nBetween and after the concerts, enjoy drinks, food, and unexpected moments in the elegant courtyard of Palatul Ghica Victoriei.\r\n<br /><br />\r\nLimited seats, intimate atmosphere, same Aria elegance.', 'București', 'fizic'),
(14, 'Concert Scorpions la Romexpo', 'Romexpo', '2025-09-11', 'Scorpions Tour', 'scorpions_romexpo.jpg', '<br /><br />\r\nScorpions revine în România cu un concert aniversar spectaculos: „Coming Home” pe 11 septembrie 2025, la Romexpo!\r\n<br /><br />\r\nLegendara trupă germană Scorpions revine în România într-un concert de neratat, parte din turneul internațional aniversar „Coming Home”, dedicat celor 60 de ani de activitate muzicală.\r\n<br /><br />\r\nScorpions este una dintre cele mai influente și longevive trupe de hard rock și heavy metal din istorie, cu peste 100 de milioane de albume vândute în întreaga lume. Trupa a fost fondată în 1965 la Hanovra, Germania, de chitaristul Rudolf Schenker, iar alături de el, Klaus Meine (voce) a devenit vocea inconfundabilă a formației. Printre hiturile ce au cucerit generații se numără: Rock You Like a Hurricane, Wind of Change, Still Loving You, Send Me an Angel, No One Like You.\r\n<br /><br />\r\nConcertul din București, organizat de Marcel Avram (East European Production) și DD East Entertainment, face parte dintr-o serie de evenimente aniversare ce au inclus și un eveniment special în Las Vegas, intitulat „Coming Home to Las Vegas 60th Anniversary Residency” la Planet Hollywood Resort & Casino, un show unic în orașul natal Hanovra, Germania, alături de Judas Priest – iar în curând și în România!\r\n<br /><br />\r\nAu fost lansate bilete Early Bird, într-un număr limitat, iar prețurile sunt:\r\n<br /><br />\r\nAcces General Earlybird – 302.5 lei <br />\r\nAcces General Presale – 330 lei <br />\r\nGolden Circle Earlybird – 385 lei <br />\r\nGolden Circle Presale – 440 lei <br />\r\nFront of Stage – 550 lei\r\n<br /><br />\r\nO moștenire de 60 de ani în hard rock și influență globală\r\n<br /><br />\r\nFormată în 1965 la Hanovra, Germania, de chitaristul Rudolf Schenker, trupa Scorpions a evoluat de la influențe Merseybeat la una dintre cele mai emblematice formații de hard rock și heavy metal din lume. Alăturarea lui Klaus Meine ca solist vocal și a fratelui mai mic al lui Rudolf, Michael Schenker, la chitară solo, în 1970, a definit identitatea timpurie a trupei. Albumul de debut, Lonesome Crow (1972), a marcat începutul unei cariere legendare.\r\n<br /><br />\r\nDupă plecarea lui Michael Schenker către trupa UFO, Scorpions a fuzionat cu membrii trupei Dawn Road, inclusiv chitaristul Uli Jon Roth și basistul Francis Buchholz. Deși majoritatea membrilor proveneau din Dawn Road, formația a păstrat numele Scorpions datorită notorietății. Această formulă a lansat Fly to the Rainbow (1974), urmat de In Trance (1975), începutul colaborării cu producătorul Dieter Dierks și dezvoltarea unui sunet mai puternic și distinct.\r\n<br /><br />\r\nSfârșitul anilor ’70 a adus albume notabile precum Virgin Killer (1976) și Taken by Force (1977), care au sporit popularitatea trupei, deși au generat și controverse din cauza copertelor îndrăznețe. După plecarea lui Roth, Matthias Jabs s-a alăturat trupei, iar Lovedrive (1979) a consolidat formula de succes Scorpions – piese hard rock energice combinate cu balade melodice.\r\n<br /><br />\r\nAnii ’80 au reprezentat apogeul comercial al formației. Albume precum Animal Magnetism (1980), Blackout (1982) și Love at First Sting (1984) – cu hituri ca “Rock You Like a Hurricane” și “Still Loving You” – au propulsat Scorpions în topurile internaționale. Albumul live World Wide Live (1985) a capturat energia spectacolelor lor live. Trupa a devenit și un simbol cultural, susținând concerte emblematice, inclusiv la Moscow Music Peace Festival în 1989, câștigând numeroși fani dincolo de Cortina de Fier.\r\n<br /><br />\r\nÎn 199', 'București', 'fizic'),
(15, 'Focșani: Rock for Hope', 'Sala Polivalenta', '2025-09-26', 'Hope Foundation', 'rock_for_hope.jpg', 'Concert caritabil în sprijinul copiilor cu autism<br /><br />\r\nAsociația Sfântul Stelian, Ocrotitorul Copiilor te invită la Rock for Hope, un eveniment caritabil unde muzica și solidaritatea se împletesc într-o seară de neuitat, cu scopul de a construi Centrul Terapeutic pentru Autism „Sf. Stelian” – un spațiu dedicat sprijinului copiilor care au nevoie de terapie specializată.<br /><br />\r\nLine-up de excepție:<br />\r\nCOMPACT<br />\r\nBERE GRATIS<br />\r\nSCARLET AURA<br /><br />\r\nÎți promitem o atmosferă vibrantă, energie rock și o cauză nobilă care merită fiecare aplauz. Pe lângă concert, vei putea participa la tombole cu premii și vei descoperi standuri dedicate unde poți susține cauza prin achiziții sau donații.<br /><br />\r\nFiecare bilet cumpărat înseamnă un pas mai aproape de realizarea centrului pentru copiii cu autism.<br /><br />\r\nFii parte din schimbare!<br />\r\nHai să arătăm împreună că muzica poate construi nu doar emoții, ci și speranță reală.', 'Focșani', 'fizic'),
(16, 'Focus in The Park 2025', 'Parcul Sub Arini', '2025-08-28', 'Focus Events', 'focus_in_the_park.jpg', 'Va avea loc în perioada 28–31 august, în Parcul Sub Arini din Sibiu, și este cel mai mare festival outdoor de muzică alternativă din oraș.<br /><br />\r\nAnunțăm cu entuziasm că John Newman va fi capul de afiș al ediției din acest an! Artistul britanic, cunoscut pentru hituri precum Love Me Again și Come and Get It, promite un show plin de energie și emoție, aducând pe scenă mixul său inconfundabil de soul, pop și dance.<br /><br />\r\nOkean Elzy, una dintre cele mai iubite trupe rock din Ucraina, va fi co-headliner anul acesta. Cunoscuți pentru energia lor explozivă pe scenă și pentru piesele încărcate de emoție, Okean Elzy aduc un amestec unic de rock alternativ și lirism profund, captivând publicul din întreaga lume.<br /><br />\r\nLine-up-ul este completat de: Akua Naru (US), Dub Pistols (UK), Carla’s Dreams, Fanfara Ciocărlia, Stanton Warriors (UK), Vița de Vie, Lupii lui Calancea (MD), Coma, Byron & Muse Quartet, Om la lună, Argatu, Erika Isac & M.G.L., Grimus, Dimitri’s Bats, DJ Antenna, Vlad Dobrescu, Soceron, Funkydrop, Lowelt, Cipi Hampu, STF, Disconnected, Kosta, Dr4goș, Iustee, SYL, Laztech, Tuți, Tanima.<br /><br />\r\nBiletele de o zi vor fi puse în vânzare în luna iunie.<br /><br />\r\nCopiii cu vârsta de până la 14 ani (inclusiv) beneficiază de intrare gratuită, cu condiția să fie însoțiți de un părinte care deține abonament.', 'Sibiu', 'fizic'),
(17, 'Open Air Blues Festival Brezoi 2025', 'Summer Camp Brezoi', '2025-07-22', 'Brezoi Blues Org.', 'blues_brezoi.jpg', 'Va avea loc între 22 și 27 iulie, cu trei scene și peste 40 de trupe, oferind 6 zile și 6 nopți de momente de neuitat și muzică blues uimitoare.<br /><br />\r\nFestivalul se desfășoară în inima munților, de-a lungul văii râului Lotru, într-un cadru natural idilic, promițând o experiență imersivă plină de muzică blues captivantă.<br /><br />\r\nLine-up-ul zilnic este foarte variat, cu artiști din toată lumea, jam session-uri noaptea și multă atmosferă autentică de blues.<br /><br />\r\nAccesul copiilor sub 14 ani este gratuit dacă sunt însoțiți de un părinte sau tutore cu bilet valid.<br /><br />\r\nPersoanele cu dizabilități au acces gratuit pe baza certificatului.<br /><br />\r\nCampingul este separat și necesită achiziționarea unui bilet special.<br /><br />\r\nFestivalul este cashless, cu plata prin carduri speciale „FESTIVAL” încărcabile la fața locului.<br /><br />\r\nRegulile privind ce se poate aduce, ce e interzis și cum funcționează campingul sunt detaliate și menite să asigure o experiență plăcută și sigură pentru toți participanții.<br /><br />\r\nTransportul este bine organizat, iar zona Brezoi oferă și opțiuni de cazare alternative.<br /><br />\r\nFestivalul nu este doar muzică, ci și o comunitate, o celebrare a naturii și a pasiunii pentru blues.', 'Brezoi', 'fizic'),
(18, 'Dan Balan - Soundstalgic', 'Sala Palatului', '2025-10-30', 'Dan Balan Org.', 'dan_balan.jpg', 'Celebrul artist Dan Bălan aduce “Soundstalgic” la București!<br /><br />\r\nSe pregătește un concert grandios la Sala Palatului, pe 27 septembrie 2025.<br /><br />\r\nPentru prima dată în România, un concert solo de anvergură semnat Dan Bălan.<br /><br />\r\nDupă o carieră spectaculoasă pe marile scene ale lumii, Dan Bălan ajunge în sfârșit, pentru prima dată, cu un recital solo complet în fața publicului român. Nu este un simplu concert. Este un eveniment rar, încărcat de emoție, în care artistul își deschide universul muzical într-un show memorabil — “Soundstalgic”.<br /><br />\r\nO experiență care atinge toate simțurile.<br /><br />\r\nTermen inventat chiar de Dan Bălan, “Soundstalgic” este o fuziune între „sound” și „nostalgie”, transformată într-o experiență care îți atinge toate simțurile.<br /><br />\r\nVei simți cum sunetul te poartă înapoi în timp, spre momentele în care ai fost fericit pe „Dragostea din tei”, ai dansat cu inima plină pe „Despre tine” sau ai simțit adrenalina pură cu „Chica Bomb”. Și desigur, vei retrăi primii fiori ai dragostei cu „Oriunde ai fi”.<br /><br />\r\nUn decor de poveste pentru un muzical adevărat.<br /><br />\r\nConcertul este conceput ca o poveste scenică, o adevărată piesă de teatru muzical, unde proiecțiile, luminile și decorul creează o lume aparte — o lume în care muzica devine portal spre copilărie, adolescență sau anii nebuni ai studenției.<br /><br />\r\nDan Bălan explorează nostalgia mai profund decât ți-ai imagina, iar în această călătorie nu aduce doar piesele sale, ci și reinterpretări speciale ale unor melodii emblematice ale altor artiști care au marcat acea epocă.<br /><br />\r\n\"Sunt nerăbdător să mă întâlnesc cu publicul meu din România, de la București. Am gândit “Soundstalgic” ca o explozie muzicală pentru revederea cu fanii mei. Oriunde ați fi vă invit să cântăm împreună cele mai frumoase piese și să scriem istorie la București! O să fie magic și intens!\", își asigură Dan Bălan fanii din țară.<br /><br />\r\nCu o carieră de peste 27 de ani, Dan Bălan este singurul artist moldovean nominalizat la Premiul Grammy și unul dintre puținii artiști din Europa de Est care au cucerit topurile internaționale. Hiturile sale au răsunat în toată lumea, de la Tokyo până la Los Angeles, și acum... răsună la Sala Palatului.<br /><br />\r\nNu rata această premieră istorică.<br /><br />\r\nO singură lume. O singură stare: “Soundstalgie”.', 'București', 'fizic'),
(19, 'SMILEY @ SALA PALATULUI – “ARMONIE”', 'Sala Palatului', '2025-10-30', 'Smiley Music', 'smiley_armonie.jpg', 'Concertul ARMONIE aduce o fuziune emoționantă dintre muzica pop și rafinamentul orchestral, transformând cele mai îndrăgite piese ale artistului în capodopere simfonice. Cu o orchestră de peste 45 de muzicieni și invitați surpriză, acest eveniment îți oferă o experiență muzicală desăvârșită.<br /><br />\r\nÎmpreună cu SMILEY vom călători spre esență, spre emoție, spre sunet, totul în deplină ARMONIE.<br /><br />\r\nRegulament de participare:<br />\r\nToti participantii la spectacol cu varsta peste 2 ani trebuie sa detina un bilet de acces. Copiii cu varsta sub 2 ani care beneficiaza de gratuitate nu trebuie sa ocupe un loc (scaun) in sala.<br /><br />\r\nDupa inceperea spectacolului locurile afisate pe bilet nu mai pot fi garantate. Va rugam sa veniti din timp la spectacol pentru a nu ii deranja pe ceilalti spectatori.<br /><br />\r\nDin motive independente de vointa noastra, anumite detalii legate de eveniment pot suferi modificari (ora, locatia). Va vom anunta de fiecare data cand acest lucru se intampla si va multumim pentru intelegere.', 'București', 'fizic'),
(20, 'Turneu: Alifantis & Zan 30 de ani', 'Sala Palatului', '2025-10-01', 'Alifantis & Zan Org.', 'alifantis_zan.jpg', 'Pentru a sărbători 30 de ani de activitate alături de Zan, Nicu Alifantis anunță cu entuziasm un turneu special, care va aduce împreună publicul din România și Republica Moldova.<br /><br />\r\nNicu Alifantis, în vârstă de 70 de ani, este unul dintre cei mai apreciați artiști de muzică folk. Actor, poet, cântăreţ şi compozitor de muzică folk şi de teatru. Iubit de public, în fiecare dintre ipostaze.<br /><br />\r\nDe oraşul Brăila se leagă perioada sa de ucenicie. De acolo începe povestea celui care se poate lăuda cu peste o jumătate de secol de activitate artistică.<br /><br />\r\nÎn cadrul acestui turneu, Alifantis reflectează asupra acestei perioade extraordinare:<br />\r\n„În 1995, sfătuit de prietenul Doru Căplescu, i-am invitat pe Virgil Popescu, Răzvan Mirică, Sorin Voinea și Relu Bițulescu să mi se alăture pentru a înregistra albumul „Voiaj”. Nu mi-a trecut prin minte la acea dată, că alături de acești oameni aveam să-mi petrec următorii 30 de ani, concertând prin țară, străinătăți, înregistrând albume, legând prietenii, văzând cum ni se nasc sau cresc copiii, nepoții… Se pare că titlul primului album, „Voiaj”, avea să ne fie predestinat. O perpetuă călătorie cu oameni, printre oameni, pentru oameni… Și toate acestea 30 de ani în aceeași componență. Povestea merge mai departe!”<br /><br />\r\nAlăturați-vă turneului “Alifantis & Zan 30 de ani” pentru o serie de spectacole unice, în care muzica și amintirile se împletesc într-un show dedicat tuturor celor care au fost aproape și au susținut acest proiect de-a lungul decadelor.<br /><br />\r\nRegulament de participare:<br />\r\n\r\nFilmatul și fotografierea pe durata spectacolului sunt strict interzise.<br />\r\n\r\nVă rugăm să puneți telefoanele pe modul silențios pentru a respecta atmosfera evenimentului.<br />\r\n\r\nDupă începerea spectacolului, locurile afișate pe bilet nu mai pot fi garantate, așa că vă rugăm să ajungeți la timp.<br /><br />\r\nOrganizatorii își rezervă dreptul de a modifica ora sau locația evenimentului din motive independente de voința lor. Orice schimbări vor fi comunicate în timp util.<br /><br />\r\nPrețul biletelor poate fi ajustat până la epuizarea acestora sau până la ora evenimentului.<br /><br />\r\nPartener Media: Magic FM<br /><br />\r\nUn Turneu Organizat de Kompas Events în colaborare cu Alifantismusic.<br /><br />\r\nO parte din încasări se vor direcționa către Club Rotary Pipera pentru proiectul “Salvează o inimă”.<br /><br />\r\nVă așteptăm cu drag să fiți alături de Alifantis & Zan în această aniversare muzicală de neuitat!\r\n<br /><br />\r\n<strong>Perioadă evenimente:</strong>\r\n<br /><br />\r\n-Filarmonica Pitești, Pitești Calea București 2, Pitești - vineri, 31 octombrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-Filarmonica Brașov - Sala Patria, Brasov\r\nStrada 15 Noiembrie 50A- sâmbătă, 1 noiembrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-Filarmonica de Stat Sibiu - Sala Thalia, Sibiu Str. Cetatii, nr. 3-5- duminică, 2 noiembrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-Casa de Cultura a Studentilor, Cluj-Napoca\r\nPiata Lucian Blaga, nr. 1-3 - marți, 4 noiembrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-Palatul Culturii Bistrita, Bistrița\r\nstr. Albert Berger, nr. 10 - joi, 6 noiembrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-ATP Tech Center, Baia Mare Bulevardul Regele Mihai I 67, Baia Mare 430012 - vineri, 7 noiembrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-Casa Tineretului, Oradea Calea Alexandru Cazaban 49, Oradea 410282 - sâmbătă, 8 noiembrie, ora 20:00 acces de la 19:30\r\n<br /><br />\r\n-Filarmonica Banatul Timisoara - Sala Capitol, Timisoara Bd. Constantin Diaconovici Loga, 2 - marți, 11 noiembrie, ora 20:00 acces de la 19:30', 'București', 'fizic'),
(21, 'B.U.G. Mafia în concert la BTarena', 'BTarena', '2025-12-13', 'B.U.G. Mafia Org.', 'bug_mafia.jpg', 'Sâmbătă, 13 decembrie 2025, B.U.G. Mafia va susține un show în Sala Polivalentă BT Arena Cluj-Napoca. Primele bilete au preț promoțional, earlybird.<br /><br />\r\n\r\nFanii înscriși în newsletter-ul B.U.G. Mafia, precum și anumiți clienți Emagic/iaBilet.ro vor primi pe mail un cod cu care vor putea să-și achiziționeze biletele în pre-sale. Biletele se vor pune în vânzare către publicul general vineri, 20 iunie, ora 10:00.<br /><br />\r\n\r\n<b>Acces nerecomandat persoanelor sub 15 ani.</b> Evenimentul poate include elemente verbale sau vizuale ce pot fi considerate nepotrivite pentru minori. Recomandăm ca persoanele sub 18 ani să fie însoțite de un adult.<br /><br />', 'Cluj-Napoca', 'fizic'),
(22, 'Tombola \"Fotbalul Face Bine\"', 'Arena Națională', '2025-11-20', 'Charity Events', 'tombola_fotbal.jpg', 'Cu „Fotbalul Face Bine”, fiecare bilet virtual e o șansă dublă: faci bine și poți câștiga un premiu care să îți schimbe viața!<br /><br />\r\n\r\nIa-ți bilet la meci în <b>TRIBUNA VIRTUALĂ</b> și intri în joc pentru premii fabuloase!<br /><br />\r\n\r\n<b>Marele Premiu:</b> 1 APARTAMENT<br />\r\n\r\n<b>Premiu Diamond:</b> 10 x 10.000 euro<br />\r\n\r\n<b>Premiu Platinum:</b> 10 x 5.000 euro<br />\r\n\r\n<b>Premiu Gold:</b> 100 x 1.000 euro<br />\r\n\r\n<b>Premiu Silver:</b> 100 x 500 euro<br /><br />\r\n\r\nBilete pot fi achiziționate până la data de 29 august 2025, ora 23:59!<br /><br />\r\n\r\nPot fi cumpărate un număr nelimitat de bilete, din cele 200.000 disponibile!<br /><br />\r\n\r\nMeciul poate fi urmărit live pe aplicația: <b>romania.sociosmanager.com</b><br /><br />\r\n\r\n“Bătrânii lupi ai balonului rotund se întorc… dar de data asta, o dau la poartă cu administrația locală!”<br /><br />\r\n\r\nDe o parte a terenului: foști campioni, titani ai gazonului, cei care au făcut stadionul să vibreze și care știu exact unde dorm mingile noaptea.<br /><br />\r\n\r\nDe cealaltă parte: primarii-fotbaliști – care știu să dribleze atât în teren, cât și prin birocrație, care semnează proiecte cu stângul și dau goluri cu dreptul!<br /><br />\r\n\r\nMeciul e pe bune. Orgoliile sunt reale. Glumele… inevitabile.<br /><br />\r\n\r\nLegendele vin să-și apere onoarea, iar primarii vor să arate că nu doar vorbesc frumos, ci și pasează cu stil.<br /><br />\r\n\r\nNu e doar un meci. E un duel între generații, profesii și… picioare grele de la atâtea trofee sau atâtea ședințe de consiliu.<br /><br />\r\n\r\nHai și tu să vezi dacă experiența bate administrația… sau dacă asfaltările anulează driblingurile!<br /><br />\r\n\r\n<b>Cine sunt ambasadorii campaniei?</b><br />\r\nCampania este susținută de:<br />\r\n\r\nFlorin Gardoș, fost fotbalist<br />\r\n\r\nRobert Tudor, magician și animator<br />\r\n\r\niaBilet.ro<br /><br />\r\n\r\n<b>Când și unde are loc meciul?</b><br />\r\nMeciul demonstrativ va avea loc pe 29.08.2025, la Pomârla, jud. Botoșani. Va fi transmis live în aplicația romania.sociosmanager.com, începând cu ora 17:00.<br /><br />\r\n\r\n<b>Câștigătorii</b> vor fi anunțați pe site-ul oficial al campaniei, prin e-mail și telefon (dacă sunt extrași), dar și în cadrul transmisiunii live a tragerii la sorți, de la finalul campaniei.<br /><br />\r\n\r\n<b>Este campania sigură și transparentă?</b><br />\r\nDa. Campania are regulament oficial public și colaborează cu influenceri și fotbaliști cunoscuți. Tragerea la sorți este realizată transparent, cu martori și înregistrată video.<br /><br />\r\n\r\n<b>Pot participa și din afara țării?</b><br />\r\nDa! Dacă ai o adresă de e-mail validă și achiziționezi un bilet virtual, poți participa, indiferent unde te afli. Campania se adresează tuturor persoanelor fizice, cetățeni români sau străini, rezidenți sau cu domiciliul/reședința, chiar și temporară, în România, care au împlinit vârsta de 14 ani la data începerii campaniei, posesoare de bilet-donație virtual în TRIBUNA VIRTUALĂ (fără prezență fizică).<br /><br />\r\nPot achiziționa mai multe bilete?\r\n<br /><br />\r\nDa. Cu cât achiziționezi mai multe bilete, cu atât ai mai multe șanse să câștigi. Fiecare bilet reprezintă o șansă în plus la premii.', 'București', 'fizic'),
(23, 'Stand-up comedy cu Teo, Vio & Costel', 'Sala Palatului', '2025-09-25', 'Comedy Stars', 'standup_teo_vio_costel.jpg', 'Cel mai longeviv trio de stand-up comedy din România revine pe cea mai mare scenă a țării pe 28 Octombrie 2025!<br /><br />\r\n\r\n..Cum cine?! Teo, Vio și Costel!<br /><br />\r\n\r\n..Cum unde?! La Sala Palatului - așa cum este tradiția, pentru al optulea an consecutiv.<br /><br />\r\n\r\nÎi știi din Cafe Deko? Atunci chiar nu ai nicio scuză să lipsești!<br />\r\n“Comedianți pe drumuri”, “Somncast”, “CineȘtieCe”, “RSS Reloaded” sau \"Între Show-uri” – îți țin companie constant? Vino să-i vezi live!<br />\r\nClub 99 e ca a doua casă pentru tine și prietenii tăi? Atunci sunteți deja parte din familie!<br /><br />\r\n\r\nAi râs cu ei la TV, la Stand Up Revolution, iUmor și multe altele. Iar mai nou îi regăsești și pe ComedyBox.ro.<br /><br />\r\n\r\nȘtii deja că distracția e garantată și că glumele bune sunt și ele o tradiție!<br /><br />\r\n\r\nAșadar.. ce faci pe 28 Octombrie?<br />\r\nAdună toată gașca și hai la Teo, Vio și Costel la Sala Palatului!<br /><br />', 'București', 'fizic'),
(24, 'Rhyme and Reason, a talk by Florida Educator John Louis Meeks, Jr.', 'Online (Zoom)', '2025-07-21', 'John Louis Meeks, Jr.', 'rhyme_and_reason.png', 'WHAT: Rhyme and Reason\r\n<br /><br />\r\nWHO: John Louis Meeks, Jr.\r\n<br /><br />\r\nWHEN: Monday, July 21, 2025 from 6:30 to 8:00 p.m. Eastern Time. You can join the meeting starting at 6:15.\r\n<br /><br />\r\nWHERE: This is a virtual event.\r\n<br /><br />\r\nMEETING DESCRIPTION: John L. Meeks, Jr., a local unionist and educator, shares his insights on teaching in Florida and building community through mutual aid and solidarity.\r\n<br /><br />\r\nMEET THE SPEAKER: John Louis Meeks, Jr. is an Air Force veteran and educator. A graduate of Orange Park High School and the University of North Florida, Meeks studied journalism and political science. \"Change in this world depends on what we can do on the community level with our neighbors who are much closer to us than Tallahassee or Washington.\"\r\n<br /><br />\r\nThis is an online Zoom event from 6:30 pm until 8:00 pm ET. Zoom room opens at 6:15pm.\r\n<br /><br />\r\nZoom Room Info:\r\n<br />\r\nMeeting ID: 896 7554 8568\r\n<br />\r\nPasscode: 041272', '', 'virtual');
INSERT INTO `event` (`id_event`, `name`, `location`, `date`, `organiser`, `imgpath`, `description`, `city`, `type`) VALUES
(25, 'Teatro Grattacielo Announces 2025 Season', 'New York City (Various Theaters)', '2025-06-28', 'Teatro Grattacielo', 'teatro_grattacielo.png', 'Teatro Grattacielo is proud to unveil its 31st Season, marking a significant expansion with the addition of a third production and an enhanced \"Creative Tableaux\" educational and community outreach program.\r\n<br /><br />\r\nEvents include:<br /><br />\r\n- The Tin Angel (June 28-29, Ellen Stewart Theater)<br />\r\n- Tribute to Naples (July 15, Columbus Citizens Foundation)<br />\r\n- Generación Perdida (July 18, Downstairs Theater)<br />\r\n- L’Amico Fritz (July 19-20, Downstairs Theater)<br />\r\n- Le Nozze di Figaro (July 25-27, Downstairs Theater)<br />\r\n<br /><br />\r\nMore details and full descriptions at: www.grattacielo.org\r\n<br /><br />\r\nThis season explores social themes, Italian and Latin American heritage, and classical masterpieces through bold productions and immersive outreach.', 'New York', 'virtual'),
(26, 'Take Back Your Power', 'Online (Webinar)', '2025-07-22', 'Women Can Inspire Foundation', 'survive_heal.png', 'Survive. Heal. Thrive.\r\n<br /><br />\r\nYou don’t have to stay stuck in survival mode. It’s your time to break free, heal what hurt you, and step boldly into the life you deserve.\r\n<br /><br />\r\nJoin the Women Can Inspire Foundation for a transformative virtual workshop:\r\n<br /><br />\r\n\"Take Back Your Power\" – a safe space for healing, self-discovery, and reclaiming your voice.\r\n<br /><br />\r\nWhat to Expect:<br /><br />\r\n- Real stories from powerful women<br />\r\n- Tools to begin your healing journey<br />\r\n- Permission to grow, glow, and go after more<br />\r\n<br />\r\nWill be available on YouTube after the live webinar, but you must register. We hope to see you there.', '', 'virtual'),
(27, 'Art Class 101: Drawing from the Masters – Toned Paper with Stephanie Goldman', 'Online via Zoom', '2025-07-23', 'Athenaeum Music & Arts Library | School of the Arts', 'art_class101.png', 'In this class, we will draw from classical and modern art masters who worked on toned paper. You will learn how to use the tone of the paper plus white to create dynamic and expressive drawings.\r\n<br /><br />\r\nThis course will sharpen your skills in rendering form, value, and texture. Basic composition, anatomy, and perspective will also be taught.\r\n<br /><br />\r\nMaterials: Choose only what you prefer working with. Includes pan pastel, charcoal pencils, white charcoal, blending stumps, toned paper, brushes, and more.', '', 'virtual'),
(28, 'Blood Sugar Hacks: Natural Strategies for Stable Energy & Health', 'Online', '2025-07-24', 'Health Educators Team', 'blood_sugar_hacks.png', 'Feeling the ups and downs of energy throughout your day? Struggling with cravings, fatigue, or brain fog? Your blood sugar might be the culprit.\r\n<br /><br />\r\nIn this empowering class, we’ll dive into practical, evidence-informed herbal and lifestyle “hacks” to help you regulate your blood sugar naturally.\r\n<br /><br />\r\n- Discover blood-sugar-friendly foods<br />\r\n- Learn powerful herbs that support glucose metabolism<br />\r\n- Integrate daily habits for sustained energy and better health<br />\r\n<br />\r\nDate: July 24th, 6:00 – 8:30pm PST\r\nOnline event.', '', 'virtual'),
(36, 'Test Eveniment 1', 'Teatrul Dramatic', '2025-07-27', 'Firma SRL', '1753357405_647883785192202b3520939696d8ca34.jpg', '<b>What is Lorem?</b>\r\n<br />\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n<br /><br />\r\n<b>Why do we use it?</b>\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n<br /><br />\r\n<b>Where does it come from?</b>\r\n<br />\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n<br /><br />\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.\r\n<br /><br />\r\n<b>Where can I get some?</b>\r\n<br />\r\nThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Galati Test', 'fizic'),
(37, 'Test Eveniment 2', 'Cinematograf Prof. Ioan Manole', '2025-07-24', 'Firma SRL', '1753359142_stock-photo-147866627.jpg', 'Descriere Test Eveniment 2', 'Galati', 'virtual');

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `id_event_categories` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_categories`
--

INSERT INTO `event_categories` (`id_event_categories`, `id_event`, `id_cat`) VALUES
(1, 1, 2),
(2, 1, 9),
(3, 1, 11),
(4, 1, 12),
(5, 1, 51),
(6, 1, 52),
(7, 2, 2),
(8, 2, 9),
(9, 2, 11),
(13, 3, 1),
(14, 3, 5),
(15, 3, 10),
(16, 4, 2),
(17, 4, 12),
(18, 4, 9),
(19, 5, 3),
(20, 5, 6),
(21, 5, 5),
(22, 6, 2),
(23, 6, 12),
(24, 6, 13),
(25, 6, 9),
(26, 7, 1),
(27, 7, 8),
(28, 7, 17),
(29, 8, 1),
(30, 8, 19),
(31, 8, 8),
(32, 9, 2),
(33, 9, 13),
(34, 9, 14),
(35, 10, 2),
(36, 10, 17),
(37, 10, 8),
(38, 11, 1),
(39, 11, 9),
(40, 11, 11),
(41, 13, 10),
(42, 13, 1),
(43, 13, 19),
(44, 14, 1),
(45, 14, 8),
(46, 14, 17),
(47, 15, 1),
(48, 15, 8),
(49, 15, 9),
(50, 16, 2),
(51, 16, 13),
(52, 16, 2),
(53, 17, 2),
(54, 17, 15),
(55, 17, 1),
(56, 18, 1),
(57, 18, 9),
(58, 18, 11),
(59, 19, 1),
(60, 19, 9),
(61, 19, 11),
(62, 20, 1),
(63, 20, 14),
(64, 20, 13),
(65, 21, 1),
(66, 21, 11),
(67, 21, 16),
(68, 22, 24),
(69, 23, 4),
(70, 24, 5),
(71, 24, 3),
(72, 25, 27),
(73, 25, 28),
(74, 25, 31),
(75, 26, 24),
(76, 26, 25),
(77, 26, 42),
(78, 26, 45),
(79, 26, 44),
(80, 27, 24),
(81, 27, 45),
(82, 28, 46),
(83, 28, 47),
(84, 28, 40),
(85, 3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `bday` date NOT NULL,
  `role` varchar(255) NOT NULL,
  `company` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `fname`, `lname`, `email`, `password`, `phone`, `bday`, `role`, `company`) VALUES
(1, 'Andrei', 'Popescu', 'andrei.popescu@example.com', 'hashedpass1', '0712345678', '1990-05-20', 'admin', '-'),
(2, 'Maria', 'Ionescu', 'maria.ionescu@example.com', 'hashedpass2', '0723456789', '1992-08-15', 'manager', 'Manager SRL'),
(3, 'Ion', 'Georgescu', 'ion.georgescu@example.com', 'hashedpass3', '0734567890', '1985-12-03', 'user', '-'),
(4, 'Elena', 'Dumitru', 'elena.dumitru@example.com', 'hashedpass4', '0745678901', '1995-03-22', 'user', '-'),
(5, 'Cristian', 'Marin', 'cristian.marin@example.com', 'hashedpass5', '0756789012', '1988-11-11', 'user', '-'),
(23, 'test', 'test', 'test@test.com', '123', '4213123', '2025-07-01', 'user', '-'),
(24, 'user', 'user', 'user@example.com', '12', '124123241', '2025-07-03', 'user', '-'),
(25, 'manager', 'manager', 'manager@example.com', '123', '421123123', '2025-07-02', 'manager', 'Manager SRL'),
(26, 'test', 'test', 'test2@test.com', '123', '412412312', '2025-07-03', 'user', '-'),
(27, 'Alex', 'Stoian', 'stoianalex23@firma.com', '123', '124124123', '2025-07-01', 'manager', 'Firma SRL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bilet`
--
ALTER TABLE `bilet`
  ADD PRIMARY KEY (`id_bilet`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indexes for table `cos`
--
ALTER TABLE `cos`
  ADD PRIMARY KEY (`id_cos`);

--
-- Indexes for table `cos_bilet`
--
ALTER TABLE `cos_bilet`
  ADD PRIMARY KEY (`id_cos_bilet`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id_event_categories`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilet`
--
ALTER TABLE `bilet`
  MODIFY `id_bilet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `cos`
--
ALTER TABLE `cos`
  MODIFY `id_cos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `cos_bilet`
--
ALTER TABLE `cos_bilet`
  MODIFY `id_cos_bilet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id_event_categories` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
