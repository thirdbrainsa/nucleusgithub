-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mer 13 Janvier 2016 à 11:19
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
-- Structure de la table `accountmirror`
--

CREATE TABLE IF NOT EXISTS `accountmirror` (
  `account` int(11) DEFAULT NULL,
  `winsertdata` date NOT NULL,
  `mt4` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `accountnucleus`
--

CREATE TABLE IF NOT EXISTS `accountnucleus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` char(16) DEFAULT NULL,
  `email` char(33) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  `timeactivation` int(11) NOT NULL,
  `account` char(8) NOT NULL,
  `passwd` char(12) NOT NULL,
  `code` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`),
  KEY `email` (`email`),
  KEY `code` (`code`),
  KEY `phone_2` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `account_running`
--

CREATE TABLE IF NOT EXISTS `account_running` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) DEFAULT NULL,
  `runningposition` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `account_2` (`account`),
  KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `authuser`
--

CREATE TABLE IF NOT EXISTS `authuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  `lastcheck` int(11) NOT NULL,
  `live` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `lastcheck` (`lastcheck`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `authuser_bacchus`
--

CREATE TABLE IF NOT EXISTS `authuser_bacchus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  `lastcheck` int(11) NOT NULL,
  `live` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `lastcheck` (`lastcheck`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Structure de la table `closed_positions`
--

CREATE TABLE IF NOT EXISTS `closed_positions` (
  `ticket` varchar(25) NOT NULL,
  `currency` varchar(25) NOT NULL,
  `open_price` varchar(25) NOT NULL,
  `close_price` varchar(25) NOT NULL,
  `Profit` float NOT NULL,
  `timeclose` varchar(10) NOT NULL,
  UNIQUE KEY `ticket` (`ticket`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `expiration`
--

CREATE TABLE IF NOT EXISTS `expiration` (
  `account` int(11) DEFAULT NULL,
  `expire` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `id_ticket`
--

CREATE TABLE IF NOT EXISTS `id_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primaryid` int(11) DEFAULT NULL,
  `mt4ticket` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `id_ticket_close`
--

CREATE TABLE IF NOT EXISTS `id_ticket_close` (
  `id` int(11) NOT NULL,
  `ticket` varchar(25) NOT NULL,
  `mt4ticket` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `instrument_profit`
--

CREATE TABLE IF NOT EXISTS `instrument_profit` (
  `entry_id` int(11) NOT NULL,
  `profit_date` varchar(25) NOT NULL,
  `instrument` varchar(25) NOT NULL,
  `profit` float NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `taken` smallint(2) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `journalsms`
--

CREATE TABLE IF NOT EXISTS `journalsms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `taken` smallint(2) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` smallint(2) NOT NULL,
  `phone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `journal_bacchus`
--

CREATE TABLE IF NOT EXISTS `journal_bacchus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `taken` smallint(2) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `listoftrade`
--

CREATE TABLE IF NOT EXISTS `listoftrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `idprimary` varchar(25) DEFAULT NULL,
  `ticket` varchar(25) DEFAULT NULL,
  `strategy` char(20) DEFAULT NULL,
  `lot` double DEFAULT NULL,
  `comment` varchar(25) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idprimary` (`idprimary`),
  KEY `ticket` (`ticket`,`strategy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `liveaccount`
--

CREATE TABLE IF NOT EXISTS `liveaccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(8) DEFAULT NULL,
  `email` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `accountid` (`accountid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personnaldata`
--

CREATE TABLE IF NOT EXISTS `personnaldata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `phone` char(50) DEFAULT NULL,
  `comment` char(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phone`
--

CREATE TABLE IF NOT EXISTS `phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(15) DEFAULT NULL,
  `phonenumber` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `portofolio`
--

CREATE TABLE IF NOT EXISTS `portofolio` (
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
  KEY `timeinsert` (`timeinsert`),
  KEY `instrument` (`instrument`,`strategy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `userwealth`
--

CREATE TABLE IF NOT EXISTS `userwealth` (
  `account` int(11) NOT NULL DEFAULT '0',
  `checklogin` int(11) DEFAULT NULL,
  `lastresult` char(11) DEFAULT NULL,
  `live` tinyint(2) NOT NULL,
  PRIMARY KEY (`account`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
