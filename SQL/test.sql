-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 14 Novembre 2017 à 19:20
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test2`
--

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE `test` (
  `data_date` date NOT NULL,
  `data_heure` time NOT NULL,
  `data_temperature` varchar(30) NOT NULL,
  `data_id` int(11) NOT NULL,
  `date` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `test`
--

INSERT INTO `test` (`data_date`, `data_heure`, `data_temperature`, `data_id`, `date`) VALUES
('2017-11-05', '10:00:00', '13', 1, '2017-11-05'),
('2017-11-05', '11:00:00', '15', 2, '2017-11-05'),
('2017-11-05', '12:00:00', '16', 3, '2017-11-05'),
('2017-11-05', '13:00:00', '18', 4, '2017-11-05'),
('2017-11-05', '14:00:00', '18', 5, NULL),
('2017-11-05', '15:00:00', '19', 6, NULL),
('2017-11-05', '16:00:00', '22', 7, NULL),
('2017-11-05', '17:00:00', '20', 8, NULL),
('2017-11-06', '10:00:00', '14', 9, NULL),
('2017-11-06', '11:00:00', '14', 10, NULL),
('2017-11-06', '12:00:00', '16', 11, NULL),
('2017-11-06', '13:00:00', '17', 12, NULL),
('2017-11-06', '14:00:00', '18', 13, NULL),
('2017-11-06', '15:00:00', '19', 14, NULL),
('2017-11-06', '16:00:00', '20', 15, NULL),
('2017-11-06', '17:00:00', '17', 16, NULL),
('2017-11-05', '18:00:00', '17', 17, NULL),
('2017-11-05', '19:00:00', '16', 18, NULL),
('2017-11-05', '20:00:00', '16', 19, NULL),
('2017-11-05', '21:00:00', '13', 20, NULL),
('2017-11-05', '22:00:00', '12', 21, NULL),
('2017-11-05', '23:00:00', '10', 22, NULL),
('2017-11-06', '18:00:00', '16', 24, NULL),
('2017-11-06', '19:00:00', '15', 25, NULL),
('2017-11-06', '20:00:00', '14', 26, NULL),
('2017-11-06', '21:00:00', '13', 27, NULL),
('2017-11-06', '22:00:00', '11', 28, NULL),
('2017-11-06', '23:00:00', '10', 29, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`data_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `test`
--
ALTER TABLE `test`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
