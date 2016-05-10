-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 20 Mars 2016 à 08:58
-- Version du serveur: 5.5.27
-- Version de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mirror`
--

-- --------------------------------------------------------

--
-- Structure de la table `t`
--

CREATE TABLE IF NOT EXISTS `t` (
  `id` int(11) DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `t`
--

INSERT INTO `t` (`id`, `x`, `y`) VALUES
(1, 100, 1.4),
(2, 78, 0.6),
(3, 89, 50.4),
(4, 89, 49.9),
(5, 48, 50.2),
(6, 73, -160),
(7, 71, -160),
(8, 71, 57.6),
(9, 41, 280),
(10, -100, 280);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
