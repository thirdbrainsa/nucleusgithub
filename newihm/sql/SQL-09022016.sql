-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mar 09 Février 2016 à 11:35
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
-- Structure de la table `automated`
--

CREATE TABLE IF NOT EXISTS `automated` (
  `account` int(11) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `automated` double DEFAULT '0.01',
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `blockportfolio`
--

CREATE TABLE IF NOT EXISTS `blockportfolio` (
  `account` int(11) NOT NULL DEFAULT '0',
  `block` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historydb`
--

CREATE TABLE IF NOT EXISTS `historydb` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `command` smallint(1) DEFAULT NULL,
  `price` double NOT NULL,
  `digit` int(11) DEFAULT NULL,
  `sl` double DEFAULT NULL,
  `tp` double DEFAULT NULL,
  `swap` double NOT NULL,
  `profit` double NOT NULL,
  `spread` double NOT NULL,
  `strategy` char(20) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `whenopen` datetime NOT NULL,
  `whenclose` datetime NOT NULL,
  `signature` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `signature` (`signature`),
  KEY `timeinsert` (`timeinsert`),
  KEY `strategy` (`strategy`),
  KEY `instrument` (`instrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=549 ;

-- --------------------------------------------------------

--
-- Structure de la table `id_ticket`
--

CREATE TABLE IF NOT EXISTS `id_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primaryid` int(11) DEFAULT NULL,
  `mt4ticket` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `journal_php`
--

CREATE TABLE IF NOT EXISTS `journal_php` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `price` double NOT NULL,
  `digit` int(11) DEFAULT NULL,
  `sl` int(11) DEFAULT NULL,
  `tp` int(11) DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `taken` smallint(2) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `portofolio_dashboard`
--

CREATE TABLE IF NOT EXISTS `portofolio_dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Structure de la table `ranking`
--

CREATE TABLE IF NOT EXISTS `ranking` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `strategy` char(20) NOT NULL,
  `whenopen` datetime NOT NULL,
  `profit` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `dayprofit` int(11) DEFAULT NULL,
  `drawdown` int(11) DEFAULT NULL,
  `winningperc` int(3) DEFAULT NULL,
  `awt` int(5) DEFAULT NULL,
  `alt` int(5) DEFAULT NULL,
  `tbx_score` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instrument` (`instrument`),
  KEY `strategy` (`strategy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Structure de la table `ranking_month`
--

CREATE TABLE IF NOT EXISTS `ranking_month` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `strategy` char(20) NOT NULL,
  `whenopen` datetime NOT NULL,
  `profit` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `dayprofit` int(11) DEFAULT NULL,
  `drawdown` int(11) DEFAULT NULL,
  `winningperc` int(3) DEFAULT NULL,
  `awt` int(5) DEFAULT NULL,
  `alt` int(5) DEFAULT NULL,
  `tbx_score` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instrument` (`instrument`),
  KEY `strategy` (`strategy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ranking_week`
--

CREATE TABLE IF NOT EXISTS `ranking_week` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `strategy` char(20) NOT NULL,
  `whenopen` datetime NOT NULL,
  `profit` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `dayprofit` int(11) DEFAULT NULL,
  `drawdown` int(11) DEFAULT NULL,
  `winningperc` int(3) DEFAULT NULL,
  `awt` int(5) DEFAULT NULL,
  `alt` int(5) DEFAULT NULL,
  `tbx_score` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instrument` (`instrument`),
  KEY `strategy` (`strategy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `temp_login`
--

CREATE TABLE IF NOT EXISTS `temp_login` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `token` char(32) DEFAULT NULL,
  `login` char(15) DEFAULT NULL,
  `password` char(80) DEFAULT NULL,
  `lotsize` double NOT NULL DEFAULT '0.01',
  `ip` char(32) NOT NULL,
  `whenregister` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `login` (`login`),
  KEY `password` (`password`),
  KEY `token` (`token`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Structure de la table `tradedb`
--

CREATE TABLE IF NOT EXISTS `tradedb` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `command` smallint(1) DEFAULT NULL,
  `price` double NOT NULL,
  `digit` int(11) DEFAULT NULL,
  `sl` double DEFAULT NULL,
  `tp` double DEFAULT NULL,
  `swap` double NOT NULL,
  `profit` double NOT NULL,
  `spread` double NOT NULL,
  `strategy` char(20) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `whenopen` datetime NOT NULL,
  `signature` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `signature` (`signature`),
  KEY `timeinsert` (`timeinsert`),
  KEY `strategy` (`strategy`),
  KEY `instrument` (`instrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `trade_taken`
--

CREATE TABLE IF NOT EXISTS `trade_taken` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `price` double NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
