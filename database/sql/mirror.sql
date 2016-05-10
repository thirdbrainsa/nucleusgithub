-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mar 10 Mai 2016 à 09:44
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
-- Structure de la table `abook`
--

CREATE TABLE IF NOT EXISTS `abook` (
  `account` int(11) DEFAULT NULL,
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `account` int(11) DEFAULT NULL,
  `runningposition` int(11) DEFAULT NULL,
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  KEY `strategy` (`strategy`),
  KEY `instrument2` (`instrument2`),
  KEY `strategy2` (`strategy2`),
  KEY `instrument` (`instrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `alertemail`
--

CREATE TABLE IF NOT EXISTS `alertemail` (
  `account` int(11) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `automated` double DEFAULT '0.01',
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `alertsms`
--

CREATE TABLE IF NOT EXISTS `alertsms` (
  `account` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `attempte_db`
--

CREATE TABLE IF NOT EXISTS `attempte_db` (
  `account` int(11) DEFAULT NULL,
  `idjournal` int(11) NOT NULL,
  `whentime` datetime DEFAULT NULL
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
-- Structure de la table `balance`
--

CREATE TABLE IF NOT EXISTS `balance` (
  `account` int(11) DEFAULT NULL,
  `balance` double(11,2) DEFAULT NULL,
  `winsertdata` date NOT NULL,
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
-- Structure de la table `bonus`
--

CREATE TABLE IF NOT EXISTS `bonus` (
  `account` int(11) DEFAULT NULL,
  `balance` double(11,2) DEFAULT NULL,
  `winsertdata` date NOT NULL,
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorystats`
--

CREATE TABLE IF NOT EXISTS `categorystats` (
  `category` char(30) DEFAULT NULL,
  `subcategory` char(30) DEFAULT NULL,
  `pourc` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `clientasset`
--

CREATE TABLE IF NOT EXISTS `clientasset` (
  `iduser` int(11) NOT NULL,
  `forex` tinyint(1) DEFAULT NULL,
  `equities` tinyint(1) DEFAULT NULL,
  `etfs` tinyint(1) NOT NULL,
  `indices` tinyint(1) NOT NULL,
  `commodities` tinyint(1) NOT NULL,
  UNIQUE KEY `iduser_2` (`iduser`,`forex`,`equities`),
  KEY `iduser` (`iduser`),
  KEY `category` (`forex`),
  KEY `subcategory` (`equities`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `clientdata`
--

CREATE TABLE IF NOT EXISTS `clientdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `accountid` char(15) DEFAULT NULL,
  `accountpwd` char(32) DEFAULT NULL,
  `active` int(2) DEFAULT NULL,
  `email` char(255) NOT NULL,
  `phone` char(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
-- Structure de la table `commission`
--

CREATE TABLE IF NOT EXISTS `commission` (
  `idhistory` int(11) NOT NULL,
  `commission` double(11,2) DEFAULT NULL,
  UNIQUE KEY `idhistory` (`idhistory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `datastats`
--

CREATE TABLE IF NOT EXISTS `datastats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instrument` char(10) DEFAULT NULL,
  `strategy` char(20) NOT NULL,
  `month` int(3) NOT NULL,
  `year` int(4) NOT NULL,
  `pips` int(11) NOT NULL,
  `drawdown` int(11) NOT NULL,
  `swap` double NOT NULL,
  `trades_win` int(11) NOT NULL,
  `trades_loose` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `instrument_2` (`instrument`,`strategy`,`month`,`year`),
  KEY `month` (`month`),
  KEY `year` (`year`),
  KEY `instrument` (`instrument`),
  KEY `strategy` (`strategy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
-- Structure de la table `historicbalance`
--

CREATE TABLE IF NOT EXISTS `historicbalance` (
  `account` int(11) DEFAULT NULL,
  `balance` double(11,2) DEFAULT NULL,
  `equity` double NOT NULL,
  `margin` double NOT NULL,
  `margin_free` double NOT NULL,
  `winsertdata` date NOT NULL,
  `timeinsert` int(11) DEFAULT NULL
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
  KEY `signature_2` (`signature`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historylogin`
--

CREATE TABLE IF NOT EXISTS `historylogin` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `token` char(32) DEFAULT NULL,
  `login` char(15) DEFAULT NULL,
  `password` char(80) DEFAULT NULL,
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
  KEY `signature_2` (`signature`)
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
-- Structure de la table `instrumentcluster`
--

CREATE TABLE IF NOT EXISTS `instrumentcluster` (
  `idinstrument` int(11) NOT NULL DEFAULT '0',
  `idcluster` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `instrumentdb`
--

CREATE TABLE IF NOT EXISTS `instrumentdb` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `category` char(32) DEFAULT NULL,
  `subcategory` char(32) DEFAULT NULL,
  `symbol` char(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ask` double NOT NULL,
  `bid` double NOT NULL,
  `longonly` tinyint(1) DEFAULT NULL,
  `shortselling` tinyint(1) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `tickvalue` double NOT NULL,
  `lotmin` double NOT NULL,
  `lotstep` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `symbol` (`symbol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `instrumentdbhistory`
--

CREATE TABLE IF NOT EXISTS `instrumentdbhistory` (
  `id` int(11) NOT NULL,
  `ask` double NOT NULL,
  `bid` double NOT NULL,
  `whendata` datetime DEFAULT NULL,
  `timeinsert` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `instrumenttrend`
--

CREATE TABLE IF NOT EXISTS `instrumenttrend` (
  `id` int(11) NOT NULL DEFAULT '0',
  `trend` char(6) NOT NULL,
  `pourc` double NOT NULL,
  `category` char(32) NOT NULL,
  `subcategory` char(32) NOT NULL,
  `lastpourc` double NOT NULL
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
  `signature` char(32) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  `live` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timeinsert` (`timeinsert`),
  KEY `signature` (`signature`)
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `accountid` char(15) DEFAULT NULL,
  `msg` text,
  `wheninsert` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accountid` (`accountid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message_log`
--

CREATE TABLE IF NOT EXISTS `message_log` (
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
  `message` text NOT NULL,
  `signature` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `signature` (`signature`),
  KEY `instrument` (`instrument`),
  KEY `strategy` (`strategy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mt4bridge`
--

CREATE TABLE IF NOT EXISTS `mt4bridge` (
  `account` int(11) NOT NULL DEFAULT '0',
  `keyprivate` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `account` (`account`),
  KEY `keyprivate` (`keyprivate`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mt4_distribued`
--

CREATE TABLE IF NOT EXISTS `mt4_distribued` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `idjournal` int(11) DEFAULT NULL,
  `account` char(6) DEFAULT NULL,
  `datedistrib` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idjournal_2` (`idjournal`,`account`),
  KEY `account` (`account`),
  KEY `idjournal` (`idjournal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL,
  `body` text,
  `whencreated` varchar(32) DEFAULT NULL,
  `wheninserted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `nucleus`
--

CREATE TABLE IF NOT EXISTS `nucleus` (
  `account` int(11) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `automated` double DEFAULT '0.01',
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `nucleusrun`
--

CREATE TABLE IF NOT EXISTS `nucleusrun` (
  `account` int(11) DEFAULT NULL,
  `goal` double(11,2) DEFAULT NULL,
  `winsertdata` date NOT NULL,
  `whenstop` date NOT NULL,
  `moderisk` smallint(2) NOT NULL,
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `portofolio_nucleus`
--

CREATE TABLE IF NOT EXISTS `portofolio_nucleus` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rates`
--

CREATE TABLE IF NOT EXISTS `rates` (
  `timestamp` int(11) DEFAULT NULL,
  `instrument` char(12) DEFAULT NULL,
  `ask` double DEFAULT NULL,
  `bid` double DEFAULT NULL,
  KEY `instrument` (`instrument`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `resultrun`
--

CREATE TABLE IF NOT EXISTS `resultrun` (
  `account` int(11) DEFAULT NULL,
  `goal` double(11,2) DEFAULT NULL,
  `winsertdata` date NOT NULL,
  `whenstop` date NOT NULL,
  `moderisk` smallint(2) NOT NULL,
  `result` double(11,2) NOT NULL,
  `code` smallint(2) NOT NULL,
  `timeinsert` int(11) NOT NULL,
  KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t`
--

CREATE TABLE IF NOT EXISTS `t` (
  `id` int(11) DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Structure de la table `tradecomment`
--

CREATE TABLE IF NOT EXISTS `tradecomment` (
  `idtrade` bigint(22) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Structure de la table `tradency`
--

CREATE TABLE IF NOT EXISTS `tradency` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `strategy` char(32) DEFAULT NULL,
  `signature` char(32) DEFAULT NULL,
  `instrument` char(10) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `price` double NOT NULL,
  `pos` int(11) DEFAULT NULL,
  `timewhen` datetime DEFAULT NULL,
  `idtradency` char(32) DEFAULT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `strategy` (`strategy`),
  KEY `signature` (`signature`),
  KEY `instrument` (`instrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `trade_bridged`
--

CREATE TABLE IF NOT EXISTS `trade_bridged` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `trade_cfd`
--

CREATE TABLE IF NOT EXISTS `trade_cfd` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `idinstrument` int(11) NOT NULL,
  `instrument` char(30) DEFAULT NULL,
  `command` char(10) DEFAULT NULL,
  `openprice` double NOT NULL,
  `closeprice` double NOT NULL,
  `timeinsert` datetime DEFAULT NULL,
  `signature` char(32) NOT NULL,
  `slot` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `instrument` (`instrument`),
  KEY `slot` (`slot`),
  KEY `signature` (`signature`),
  KEY `idinstrument` (`idinstrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
