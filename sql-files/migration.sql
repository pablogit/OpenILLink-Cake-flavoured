-- ***************************************************************************
-- ***************************************************************************
-- ***************************************************************************
-- OpenIllink is a web based library system designed to manage 
-- ILL, document delivery and OpenURL links
-- 
-- Copyright (C) 2014, Cyril Sester
-- 
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
-- 
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
-- 
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.
-- 
-- ***************************************************************************
-- ***************************************************************************
-- ***************************************************************************

--
-- Warning : Only use this file to migrate an Openillink v1 database to an Openillink v2 database.
--

--
-- Table libraries
--
ALTER TABLE libraries DROP name2, DROP name3, DROP name4, DROP name5;
ALTER TABLE libraries CHANGE name1 name VARCHAR(50) NOT NULL;
ALTER TABLE libraries CHANGE `default` `default` tinyint(1) NOT NULL;
ALTER TABLE libraries ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Table links
--
UPDATE links SET library= (SELECT libraries.id FROM libraries WHERE libraries.code=links.library);
ALTER TABLE links CHANGE title title VARCHAR(100) NOT NULL;
ALTER TABLE links CHANGE search_issn is_search_issn tinyint(1) NOT NULL;
ALTER TABLE links CHANGE search_isbn is_search_isbn tinyint(1) NOT NULL;
ALTER TABLE links CHANGE search_ptitle is_search_ptitle tinyint(1) NOT NULL;
ALTER TABLE links CHANGE search_btitle is_search_btitle tinyint(1) NOT NULL;
ALTER TABLE links CHANGE search_atitle is_search_atitle tinyint(1) NOT NULL;
ALTER TABLE links CHANGE order_ext is_order_ext tinyint(1) NOT NULL;
ALTER TABLE links CHANGE order_form is_order_form tinyint(1) NOT NULL;
ALTER TABLE links CHANGE openurl is_openurl tinyint(1) NOT NULL;
ALTER TABLE links CHANGE library library_id INTEGER NOT NULL;
ALTER TABLE links CHANGE active is_active tinyint(1) NOT NULL;
ALTER TABLE links ADD is_search_pmid tinyint(1) NOT NULL AFTER is_search_atitle;
ALTER TABLE links ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Table localizations
--
UPDATE localizations SET library= (SELECT libraries.id FROM libraries WHERE libraries.code=localizations.library);
ALTER TABLE localizations DROP name2, DROP name3, DROP name4, DROP name5;
ALTER TABLE localizations CHANGE name1 name VARCHAR(50) NOT NULL;
ALTER TABLE localizations CHANGE library library_id INTEGER NOT NULL;
ALTER TABLE localizations ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Table status
--
ALTER TABLE status DROP title2, DROP help2, DROP title3, DROP help3, DROP title4, DROP help4, DROP title5, DROP help5;
ALTER TABLE status CHANGE title1 title VARCHAR(50) NOT NULL;
ALTER TABLE status CHANGE help1 help VARCHAR(255) NOT NULL;
ALTER TABLE status CHANGE special special VARCHAR(20) NOT NULL;
ALTER TABLE status CHANGE color color VARCHAR(50) NOT NULL;
ALTER TABLE status ADD is_visible_in_box VARCHAR(20) NOT NULL;
UPDATE status SET is_visible_in_box = CASE WHEN status.in=1 THEN 'in' WHEN status.out=1 THEN 'out' WHEN status.trash=1 THEN 'trash' ELSE '' END;
ALTER TABLE status DROP `in`, DROP `out`, DROP `trash`;
ALTER TABLE status ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Table units
--
ALTER TABLE units DROP name2, DROP name3, DROP name4, DROP name5;
ALTER TABLE units CHANGE name1 name VARCHAR(50) NOT NULL;
UPDATE units SET library= (SELECT libraries.id FROM libraries WHERE libraries.code=units.library);
ALTER TABLE units CHANGE validation need_validation tinyint(1) NOT NULL;
ALTER TABLE units CHANGE library library_id INTEGER NOT NULL;
ALTER TABLE units ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Table users
--
ALTER TABLE users DROP created_ip, DROP created_on;
ALTER TABLE users CHANGE user_id id INTEGER NOT NULL AUTO_INCREMENT;
ALTER TABLE users CHANGE name name VARCHAR(50) NOT NULL;
ALTER TABLE users CHANGE email email VARCHAR(100) NOT NULL;
ALTER TABLE users CHANGE login login VARCHAR(50) NOT NULL;
ALTER TABLE users CHANGE password password VARCHAR(50) NOT NULL;
ALTER TABLE users CHANGE status is_active tinyint(1) NOT NULL;
ALTER TABLE users CHANGE admin admin_level INTEGER NOT NULL;
UPDATE users SET library= (SELECT libraries.id FROM libraries WHERE libraries.code=users.library);
ALTER TABLE users CHANGE library library_id INTEGER NOT NULL;
UPDATE users SET password='355f26371eeeba20a94b7fe5bcfc1cc0e3e522ad' WHERE 1=1;
ALTER TABLE users ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Table orders
--
ALTER TABLE orders CHANGE illinkid id INTEGER NOT NULL AUTO_INCREMENT;
UPDATE orders SET stade= (SELECT status.id FROM status WHERE status.code=orders.stade);
ALTER TABLE orders CHANGE stade status_id INTEGER NOT NULL;
UPDATE orders SET localisation= (SELECT localizations.id FROM localizations WHERE localizations.code=orders.localisation);
ALTER TABLE orders CHANGE localisation origin_id INTEGER NOT NULL;
ALTER TABLE orders CHANGE sid sid VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE pid pid VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE date order_at datetime NOT NULL;
ALTER TABLE orders CHANGE envoye sent_at datetime;
ALTER TABLE orders CHANGE facture invoice_at datetime;
ALTER TABLE orders CHANGE renouveler renew_at datetime;
ALTER TABLE orders CHANGE prix price decimal(10,0) DEFAULT 0;
ALTER TABLE orders CHANGE prepaye is_prepaid tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE orders CHANGE ref external_ref VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE arrivee request_by VARCHAR(20) NOT NULL;
ALTER TABLE orders CHANGE nom surname VARCHAR(100) NOT NULL;
ALTER TABLE orders CHANGE prenom firstname VARCHAR(100) NOT NULL;
UPDATE orders SET service= (SELECT IFNULL((SELECT units.id FROM units WHERE units.code=orders.service LIMIT 1), (SELECT units.id FROM units LIMIT 1)));
ALTER TABLE orders CHANGE service service_id INTEGER NOT NULL;
ALTER TABLE orders CHANGE cgra cgra VARCHAR(10) NOT NULL;
ALTER TABLE orders CHANGE cgrb cgrb VARCHAR(10) NOT NULL;
ALTER TABLE orders CHANGE mail mail VARCHAR(100) NOT NULL;
ALTER TABLE orders CHANGE tel tel VARCHAR(20) NOT NULL;
ALTER TABLE orders CHANGE adresse address VARCHAR(255) NOT NULL;
ALTER TABLE orders CHANGE code_postal zip VARCHAR(10) NOT NULL;
ALTER TABLE orders CHANGE localite locality VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE type_doc doc_type VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE urgent priority INTEGER NOT NULL;
ALTER TABLE orders CHANGE envoi_par deliver_type VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE titre_periodique journal_title text NOT NULL;
ALTER TABLE orders CHANGE annee year VARCHAR(10);
ALTER TABLE orders CHANGE volume volume VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE numero issue VARCHAR(100) NOT NULL;
ALTER TABLE orders CHANGE supplement supplement VARCHAR(100) NOT NULL;
ALTER TABLE orders CHANGE pages pages VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE titre_article article_title text NOT NULL;
ALTER TABLE orders CHANGE auteurs authors VARCHAR(255) NOT NULL;
ALTER TABLE orders CHANGE edition edition VARCHAR(100) NOT NULL;
ALTER TABLE orders CHANGE isbn isxn VARCHAR(50) NOT NULL;
UPDATE orders SET isxn= issn WHERE isxn='';
ALTER TABLE orders DROP issn;
ALTER TABLE orders CHANGE eissn eissn VARCHAR(20) NOT NULL;
ALTER TABLE orders CHANGE doi doi VARCHAR(80) NOT NULL;
ALTER TABLE orders CHANGE uid uid VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE remarques admin_comment text NOT NULL;
ALTER TABLE orders CHANGE remarquespub user_comment text NOT NULL;
ALTER TABLE orders CHANGE historique history text NOT NULL;
ALTER TABLE orders CHANGE saisie_par filled_out_by VARCHAR(50) NOT NULL;
UPDATE orders SET bibliotheque= (SELECT libraries.id FROM libraries WHERE libraries.code=orders.bibliotheque);
ALTER TABLE orders CHANGE bibliotheque library_id INTEGER NOT NULL;
ALTER TABLE orders CHANGE refinterbib internal_ref VARCHAR(50) NOT NULL;
ALTER TABLE orders CHANGE PMID pmid VARCHAR(20) NOT NULL;
ALTER TABLE orders CHANGE ip ip VARCHAR(20) NOT NULL;
ALTER TABLE orders CHANGE referer referer VARCHAR(255) NOT NULL;
DROP INDEX titre_periodique on orders;
ALTER TABLE orders ENGINE = INNODB;

-- ---------------------------------------------------------------------

--
-- Tables renaming
--
RENAME TABLE localizations TO origins;
RENAME TABLE units TO services;

-- ---------------------------------------------------------------------

--
-- Adding new tables
--

--
-- Table configurations structure
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
-- Table `configurations` default values
--

INSERT INTO `configurations` (`id`, `library_name`, `library_street`, `library_zip`, `library_city`, `library_country`, `library_tel`, `library_email`, `library_url`, `manager_name`, `manager_email`, `manager_tel`, `journals_url`, `delivery_email`, `admin_email`, `crossref_username`, `crossref_password`, `crossref_email`, `directory1_name`, `directory1_url`, `directory2_name`, `directory2_url`, `browser_language_detection`, `openurl_sid`, `is_shibboleth_active`, `shibboleth_url`, `shibboleth_entity`, `shibboleth_return`, `is_ldap_active`, `mail_auth_info`, `invoice_fields_visibility`, `budget_visibility`, `ldap_url`, `ldap_port`, `ldap_rdn`, `ldap_password`, `ldap_base_dn`, `is_proxy_active`, `proxy_url`, `proxy_port`, `proxy_username`, `proxy_password`, `order_info`) VALUES (1, '', '', '', '', '', '', 'library@xyz.com', '', '', '', '', '', 'library@xyz.com', '', '', '', '', '', '', '', '', 1, 'xyz:openillink', 0, 'https://wayf-test.switch.ch/SWITCHaai/WAYF', 'https://aai-demo.switch.ch/shibboleth', 'https://aai-demo.switch.ch/Shibboleth.sso/DS?SAMLDS=1', 0, 1, 1, 1, 'ldap.xyz.com', 389, 'CN=myusername,OU=myou,DC=xyz,DC=com', 'mypassword', 'OU=users,OU=secondou,DC=xyz,DC=com', 0, 'proxy.nxyz.com', 8080, '', '', '');

-- ---------------------------------------------------------------------

--
-- Table ip_ranges structure
--

CREATE TABLE IF NOT EXISTS `ip_ranges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mask` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Table ip_ranges default values
--

INSERT INTO `ip_ranges` (`id`, `name`, `mask`) VALUES
(1, 'Everybody', '0.0.0.0/0'),
(2, 'Internal range 1', '192.168.128.0/24'),
(3, 'Internal range 2', '192.168.0.0/24');

-- ---------------------------------------------------------------------

--
-- Table `ip_ranges_services` structure
--

CREATE TABLE IF NOT EXISTS `ip_ranges_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `ip_range_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `SERVICE_IPRANGE_UNIQUE` (`service_id`,`ip_range_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- ---------------------------------------------------------------------

--
-- Table `statistics` structure
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- ---------------------------------------------------------------------

--
-- IP range setup from old model and removing old model
--
INSERT INTO ip_ranges_services (service_id, ip_range_id) SELECT 1, services.id FROM services WHERE services.externalipdisplay=1;
INSERT INTO ip_ranges_services (service_id, ip_range_id) SELECT 2, services.id FROM services WHERE services.internalip1display=1;
INSERT INTO ip_ranges_services (service_id, ip_range_id) SELECT 3, services.id FROM services WHERE services.internalip2display=1;
ALTER TABLE services DROP externalipdisplay, DROP internalip1display, DROP internalip2display;

-- ---------------------------------------------------------------------

--
-- Remove old foreign keys (code)
--
ALTER TABLE libraries DROP code;
ALTER TABLE origins DROP code;
ALTER TABLE services DROP code;
ALTER TABLE status DROP code;

--
-- End of migration
--
