-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 28 Février 2016 à 13:20
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
-- Structure de la table `portofolio_dashboard_guest`
--

CREATE TABLE IF NOT EXISTS `portofolio_dashboard_guest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(32) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(20) DEFAULT NULL,
  `strategy` char(20) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `accountid` (`accountid`,`instrument`,`strategy`),
  UNIQUE KEY `accountid_2` (`accountid`,`instrument`,`strategy`),
  KEY `timeinsert` (`timeinsert`),
  KEY `instrument` (`instrument`,`strategy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `portofolio_dashboard_guest`
--

INSERT INTO `portofolio_dashboard_guest` (`id`, `accountid`, `accountpwd`, `instrument`, `strategy`, `lot`, `comment`, `timeinsert`, `live`) VALUES
(1, 'd498243b50070da073e11f8003205cde', 'd498243b50070da', 'EURSEK', 'shortmove', 0.02, '', 1456660802, 0),
(3, 'd498243b50070da073e11f8003205cde', 'd498243b50070da', 'EURGBP', 'shortmove', 0.02, '', 1456660811, 0),
(5, 'd498243b50070da073e11f8003205cde', 'd498243b50070da', 'EURGBP', 'x112', 0.01, '', 1456660840, 0),
(6, 'd498243b50070da073e11f8003205cde', 'd498243b50070da', 'USDNOK', 'sphynx', 0.01, '', 1456660920, 0),
(7, 'd498243b50070da073e11f8003205cde', 'd498243b50070da', 'AUDCAD', 'x112', 0.01, '', 1456660923, 0),
(8, '57d12f097de0b7811449aa631984d102', '57d12f097de0b78', 'EURSEK', 'shortmove', 0.01, '', 1456660969, 0),
(9, '57d12f097de0b7811449aa631984d102', '57d12f097de0b78', 'EURGBP', 'shortmove', 0.01, '', 1456660971, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
