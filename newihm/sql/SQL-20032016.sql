-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 20 Mars 2016 à 08:47
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
-- Structure de la table `advancedstats`
--

CREATE TABLE IF NOT EXISTS `advancedstats` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `strategy` char(20) NOT NULL,
  `instrument2` char(255) NOT NULL,
  `strategy2` char(255) NOT NULL,
  `nb` int(11) NOT NULL,
  `slope` double DEFAULT NULL,
  `intercept` double DEFAULT NULL,
  `correlation` double DEFAULT NULL,
  `coeffofreg` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instrument` (`instrument`),
  KEY `strategy` (`strategy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
