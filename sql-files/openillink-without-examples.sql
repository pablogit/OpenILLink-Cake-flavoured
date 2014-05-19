-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 16 Mai 2014 à 09:38
-- Version du serveur: 5.5.34
-- Version de PHP: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `openillink_test_migration`
--

-- --------------------------------------------------------

--
-- Structure de la table `configurations`
--

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `library_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `library_street` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `library_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `library_city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `library_country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `library_tel` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `library_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `library_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `manager_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `manager_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `manager_tel` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `journals_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `crossref_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `crossref_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `crossref_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `directory1_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `directory1_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `directory2_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `directory2_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `browser_language_detection` tinyint(1) NOT NULL,
  `openurl_sid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_shibboleth_active` tinyint(1) NOT NULL,
  `shibboleth_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shibboleth_entity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shibboleth_return` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_ldap_active` tinyint(1) NOT NULL,
  `mail_auth_info` tinyint(1) NOT NULL,
  `invoice_fields_visibility` tinyint(1) NOT NULL,
  `budget_visibility` tinyint(1) NOT NULL,
  `ldap_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ldap_port` int(11) NOT NULL,
  `ldap_rdn` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ldap_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ldap_base_dn` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_proxy_active` tinyint(1) NOT NULL,
  `proxy_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proxy_port` int(11) NOT NULL,
  `proxy_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proxy_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_info` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `configurations`
--

INSERT INTO `configurations` (`id`, `library_name`, `library_street`, `library_zip`, `library_city`, `library_country`, `library_tel`, `library_email`, `library_url`, `manager_name`, `manager_email`, `manager_tel`, `journals_url`, `delivery_email`, `admin_email`, `crossref_username`, `crossref_password`, `crossref_email`, `directory1_name`, `directory1_url`, `directory2_name`, `directory2_url`, `browser_language_detection`, `openurl_sid`, `is_shibboleth_active`, `shibboleth_url`, `shibboleth_entity`, `shibboleth_return`, `is_ldap_active`, `mail_auth_info`, `invoice_fields_visibility`, `budget_visibility`, `ldap_url`, `ldap_port`, `ldap_rdn`, `ldap_password`, `ldap_base_dn`, `is_proxy_active`, `proxy_url`, `proxy_port`, `proxy_username`, `proxy_password`, `order_info`) VALUES (1, 'Library XYZ', 'Street ABC', '1234', 'DEF Island', '', '', 'library@xyz.com', '', '', '', '', '', 'library@xyz.com', '', '', '', '', '', '', '', '', 1, 'xyz:openillink', 0, 'https://wayf-test.switch.ch/SWITCHaai/WAYF', 'https://aai-demo.switch.ch/shibboleth', 'https://aai-demo.switch.ch/Shibboleth.sso/DS?SAMLDS=1', 0, 1, 1, 1, 'ldap.xyz.com', 389, 'CN=myusername,OU=myou,DC=xyz,DC=com', 'mypassword', 'OU=users,OU=secondou,DC=xyz,DC=com', 0, 'proxy.nxyz.com', 8080, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `ip_ranges`
--

CREATE TABLE IF NOT EXISTS `ip_ranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mask` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ip_ranges`
--

INSERT INTO `ip_ranges` (`id`, `name`, `mask`) VALUES
(1, 'Everybody', '0.0.0.0/0');

-- --------------------------------------------------------

--
-- Structure de la table `ip_ranges_services`
--

CREATE TABLE IF NOT EXISTS `ip_ranges_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `ip_range_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `SERVICE_IPRANGE_UNIQUE` (`service_id`,`ip_range_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `libraries`
--

CREATE TABLE IF NOT EXISTS `libraries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default` tinyint(1) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `libraries`
--

INSERT INTO `libraries` (`id`, `default`, `name`) VALUES
(1, 1, 'Bibliothèque centrale');

-- --------------------------------------------------------

--
-- Structure de la table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `is_search_issn` tinyint(1) NOT NULL,
  `is_search_isbn` tinyint(1) NOT NULL,
  `is_search_ptitle` tinyint(1) NOT NULL,
  `is_search_btitle` tinyint(1) NOT NULL,
  `is_search_atitle` tinyint(1) NOT NULL,
  `is_search_pmid` tinyint(1) NOT NULL,
  `is_order_ext` tinyint(1) NOT NULL,
  `is_order_form` tinyint(1) NOT NULL,
  `is_openurl` tinyint(1) NOT NULL,
  `library_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `sid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order_at` datetime NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `invoice_at` datetime DEFAULT NULL,
  `renew_at` datetime DEFAULT NULL,
  `price` decimal(10,0) DEFAULT '0',
  `is_prepaid` tinyint(1) NOT NULL DEFAULT '0',
  `external_ref` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `request_by` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `service_id` int(11) NOT NULL,
  `cgra` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cgrb` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `doc_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `deliver_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `journal_title` text COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volume` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `issue` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `supplement` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pages` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `article_title` text COLLATE utf8_unicode_ci NOT NULL,
  `authors` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edition` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `isxn` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `eissn` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `doi` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `user_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `history` text COLLATE utf8_unicode_ci NOT NULL,
  `filled_out_by` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `library_id` int(11) NOT NULL,
  `internal_ref` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pmid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `referer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bibliotheque` (`library_id`),
  KEY `stade` (`status_id`),
  KEY `localisation` (`origin_id`),
  KEY `date` (`order_at`),
  KEY `cgra` (`cgra`),
  KEY `nom` (`surname`,`firstname`),
  KEY `mail` (`mail`),
  KEY `service` (`service_id`),
  KEY `annee` (`year`),
  KEY `volume` (`volume`),
  KEY `pages` (`pages`),
  KEY `ref` (`external_ref`),
  KEY `sid` (`sid`,`pid`),
  KEY `isbn` (`isxn`),
  KEY `issn` (`eissn`),
  KEY `ui` (`uid`,`doi`,`pmid`),
  KEY `renouveler` (`renew_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Structure de la table `origins`
--

CREATE TABLE IF NOT EXISTS `origins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `library_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `origins`
--

INSERT INTO `origins` (`id`, `library_id`, `name`) VALUES
(1, 0, 'Fond propre');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `faculty` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `library_id` int(11) NOT NULL,
  `need_validation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department` (`department`),
  KEY `name1` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `statistics`
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `help` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `special` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `is_visible_in_box` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `special` (`special`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`id`, `title`, `help`, `color`, `special`, `is_visible_in_box`) VALUES
(1, 'Nouvelle commande', 'Nouvelle commande non traitée', 'green', 'new', 'in'),
(2, 'Commandée', 'Commande traitée et envoyée à une autre bibliothèque ou fournisseur externe et pas encore reçue', 'black', '', 'out'),
(3, 'Reçue et envoyée au client', 'Reçue et envoyée au client à l''origine de la commande', 'gray', 'sent', ''),
(4, 'Soldée', 'Commande reçue, envoyée et payée par le client', 'gray', 'paid', ''),
(5, 'Abandonnée', 'Commande abandonnée par le client à cause du prix ou du delai', 'purple', '', 'trash'),
(6, 'Validée', 'Commande validée par la bibliothèque ou la personne responsable de l''unité', 'green', '', 'in'),
(7, 'Rejetée', 'Commande rejetée par la bibliothèque qui devait la fournir ou par la personne responsable de la validation', 'red', 'reject', 'out'),
(8, 'En transit', 'Commande envoyée par la bibliothèque prêteuse et pas encore reçue par celle qui commande', 'orange', '', 'out'),
(9, 'En traitement', 'Commande en cours de traitement (scan en cours, recherche dans les archives, etc.)', 'orange', '', 'in'),
(10, 'A renouveler', 'Commande mise en attente pour une durée déterminée (document en cours de publication et pas encore reçu, etc.)', 'orange', 'renew', ''),
(11, 'A valider', 'Commande à valider par la bibliothèque ou la personne responsable de l''unité', 'orange', 'tobevalidated', 'in'),
(12, 'Supprimée', 'Commande supprimée (erreur de saisie, spam, etc.)', 'red', '', 'trash'),
(13, 'PEB chez demandeur', 'Document actuellement chez l''emprunteur. Permet d''avoir un rappel à la date demandée', 'orange', 'peb', 'out');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `library_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `admin_level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login`, `password`, `library_id`, `is_active`, `admin_level`) VALUES
(1, 'Super administrateur', 'sadmin@unixyz.com', 'sadmin', '25d5080a3d547a8732da5a4ac849f8f4546065bd', 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
