-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Lun 29 Février 2016 à 12:04
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
-- Structure de la table `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `account` int(11) DEFAULT NULL,
  `balance` double(11,2) DEFAULT NULL,
  `winsertdata` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `history_client`
--

CREATE TABLE IF NOT EXISTS `history_client` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `price` double NOT NULL,
  `profit` double NOT NULL,
  `swap` double NOT NULL,
  `digit` int(11) DEFAULT NULL,
  `sl` int(11) DEFAULT NULL,
  `tp` int(11) DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `taken` smallint(2) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` datetime DEFAULT NULL,
  `signature` char(32) NOT NULL,
  `token` char(32) NOT NULL,
  `live` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`),
  KEY `instrument` (`instrument`),
  KEY `signature` (`signature`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `trade_running`
--

CREATE TABLE IF NOT EXISTS `trade_running` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `price` double NOT NULL,
  `profit` double NOT NULL,
  `swap` double NOT NULL,
  `digit` int(11) DEFAULT NULL,
  `sl` int(11) DEFAULT NULL,
  `tp` int(11) DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `taken` smallint(2) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` datetime DEFAULT NULL,
  `signature` char(32) NOT NULL,
  `token` char(32) NOT NULL,
  `live` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`),
  KEY `instrument` (`instrument`),
  KEY `signature` (`signature`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
