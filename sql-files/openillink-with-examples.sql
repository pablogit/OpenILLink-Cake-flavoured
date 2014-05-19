-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 16 Mai 2014 à 08:17
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ip_ranges`
--

INSERT INTO `ip_ranges` (`id`, `name`, `mask`) VALUES
(1, 'Everybody', '0.0.0.0/0'),
(2, 'Internal range 1', '192.168.128.0/24'),
(3, 'Internal range 2', '192.168.0.0/24');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Contenu de la table `ip_ranges_services`
--

INSERT INTO `ip_ranges_services` (`id`, `service_id`, `ip_range_id`) VALUES
(6, 1, 2),
(7, 1, 3),
(8, 1, 9),
(9, 2, 1),
(10, 2, 4),
(11, 2, 5),
(12, 2, 6),
(13, 2, 9),
(14, 2, 10),
(15, 2, 11),
(16, 3, 7),
(17, 3, 8),
(18, 3, 9);

-- --------------------------------------------------------

--
-- Structure de la table `libraries`
--

CREATE TABLE IF NOT EXISTS `libraries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default` tinyint(1) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `libraries`
--

INSERT INTO `libraries` (`id`, `default`, `name`) VALUES
(1, 1, 'Bibliothèque centrale'),
(2, 0, 'Bibliothèque de l''institut XYZ'),
(3, 0, 'Bibliothèque de l''institut ABC'),
(4, 0, 'Bibliothèque de la faculté JKL'),
(5, 0, 'Bibliothèque de la faculté MNO'),
(6, 0, 'Bibliothèque de la faculté PQR'),
(7, 0, 'Bibliothèque de la faculté STU');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Contenu de la table `links`
--

INSERT INTO `links` (`id`, `title`, `url`, `is_search_issn`, `is_search_isbn`, `is_search_ptitle`, `is_search_btitle`, `is_search_atitle`, `is_search_pmid`, `is_order_ext`, `is_order_form`, `is_openurl`, `library_id`, `is_active`) VALUES
(2, 'PubMed', 'http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?otool=mycode&orig_db=PubMed&db=PubMed&cmd=Search&otool=mycode&term=XTITLEX', 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1),
(3, 'Google', 'http://www.google.ch/search?hl=fr&newwindow=1&q=%22XTITLEX%22', 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1),
(4, 'RERO', 'http://opac.rero.ch/gateway?function=INITREQ&search=SCAN&rootsearch=SCAN&u1=4&t1=XTITLEX', 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1),
(6, 'perUnil', 'http://www2.unil.ch/perunil/search.php?q=XTITLEX&init=&search=simple&field=title&format=all', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(9, 'NLM Locator Plus', 'http://130.14.16.150/cgi-bin/Pwebrecon.cgi?Search_Arg=XTITLEX&Search_Code=JALL&CNT=25&HIST=1', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0),
(10, 'Ge8', 'http://resolver.rero.ch/unige/az?param_lang_save=fre&param_letter_group_save=&param_perform_save=locate&param_letter_group_script_save=&param_chinese_checkbox_save=0&param_services2filter_save=getFullTxt&param_current_view_save=detail&param_jumpToPage_save=1&param_type_save=textSearch&param_textSearchType_save=contains&param_jumpToPage_value=&param_pattern_value=&param_textSearchType_value=contains&param_vendor_active=1&param_locate_category_active=1&param_issn_value=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(11, 'EPFL', 'http://library.epfl.ch/sources/?pg=search&issn=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(12, 'Belle-Idée (HUG)', 'http://biblioglas.hcuge.ch:8080/GLASOPAC/Search/AdvancedSearch.asp?HitCount=1&ShowOptions=false&GoPressed=true&SearchCash=8CF980000%7E0&IsFirstDisplay=false&selectPageSize=10&limitsLocation=&PubYear=&selectField1=8&selectField2=&selectField3=&selectBoolean1=1&selectBoolean2=1&txtSearch1=XISSNX&txtSearch2=&txtSearch3=&select_field1=8&txt_search1=".$enreg[''issn'']."&select_boolean1=1&select_field2=&txt_search2=&select_boolean2=1&select_field3=&txt_search3=&limits_location=&select_labels_medium=&select_labels_type=&select_page_size=10&pub_year=&formAction=&curPage=1&SelectedLinkCodes=&CurBatch=1&BatchChanged=&lblTitlesCount=0+S%E9lectionn%E9%28e%29s+&SortIndex=0', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(13, 'RP/VZ', 'http://libraries.admin.ch/cgi-bin/gw/chameleon?search=KEYWORD&rootsearch=KEYWORD&function=INITREQ&SourceScreen=HOLDINGSCR&skin=rpvz&conf=.%2fchameleon.conf&lng=fr-ch&itemu1=8&scant1=&scanu1=4&pos=1&prevpos=1&beginsrch=1&u1=8&t1=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(14, 'Helveticat', 'http://libraries.admin.ch/cgi-bin/gw/chameleon?search=KEYWORD&function=INITREQ&SourceScreen=HOLDINGSCR&skin=helveticat&lng=fr-ch&inst=consortium&conf=.%2fchameleon.conf&u1=8&op1=0&pos=1&rootsearch=KEYWORD&t1=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(15, 'RERO CC', 'http://opac.rero.ch/get_bib_record.cgi?db=cc&issn=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(16, 'RERO VD', 'http://opac.rero.ch/gateway?skin=vd&function=INITREQ&search=KEYWORD&rootsearch=KEYWORD&u1=8&t1=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(19, 'Ge8', 'http://resolver.rero.ch/unige/az?param_lang_save=fre&param_letter_group_save=&param_perform_save=searchTitle&param_letter_group_script_save=&param_chinese_checkbox_save=0&param_services2filter_save=getFullTxt&param_current_view_save=detail&param_jumpToPage_save=1&param_type_save=textSearch&param_textSearchType_save=contains&param_type_value=textSearch&param_jumpToPage_value=&param_textSearchType_value=contains&param_chinese_checkbox_value=0&param_pattern_value=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(20, 'Ge8', 'http://www.medecine.unige.ch/organisation/bfm/openillink/', 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1),
(21, 'EPFL', 'http://library.epfl.ch/pret-inter/?pg=article&pSerial=XTITLEX&pYear=XDATEX&pVolume=XVOLUMEX&pIssue=XISSUEX&pPage=XPAGESX&pAuthor=XAULASTX&pTitle=XATITLEX&pIsbn=XISSNX&uComment=Ref%20interne%20XPIDX&uName=[my_library_name]&uStatus=other&uNebis=&uEmail=[my_email]&uAddress=[my_address]&uPhone=[my_phone]', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1),
(22, 'IDS (Ba/Be)', 'http://www.zb.unibe.ch/unicd/docdel.php?sl=lib_50&Journal=XTITLEX&Author=XAULASTX&Article=XATITLEX&Volume=XVOLUMEX&Issue=XISSUEX&Year=XDATEX&Pages=XPAGESX&ISSN=XISSNX&meduid=XPMIDX&sid=XSIDX&Publisher=&PubliPlace=&ou=&bennr=[my_ids_username]&passwort=[my_ids_password]&wo_bestellen=schweiz&mitteilung=XNAMEX+%28XPIDX%29', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(23, 'Swiss Serials', 'http://www.ubka.uni-karlsruhe.de/hylib-bin/kvk/nph-kvk2.cgi?maske=chzk&timeout=120&title=Portail+suisse+des+p%E9riodiques+%28PSP%29+:+Liste+des+R%E9sultats&header=http%3A%2F%2Fead.nb.admin.ch%2Fweb%2Fswiss-serials%2Fanzeige_fr.htm&spacer=http%3A%2F%2Fead.nb.admin.ch%2Fweb%2Fswiss-serials%2Fanzeigetop_fr.htm&footer=http%3A%2F%2Fead.nb.admin.ch%2Fweb%2Fswiss-serials%2Fanzeigemail_fr.htm&lang=de&zeiten=nein&kvk-session=08CSUG05&flexpositon_start=1&RERO=&DEUTSCHSCHWEIZ=&WEITERE=&kataloge=CHZK_FRIB&kataloge=CHZK_GENF&kataloge=CHZK_RCBN&kataloge=CHZK_VALAIS&kataloge=CHZK_VAUD&kataloge=CHZK_BASEL&kataloge=CHZK_LUZERN&kataloge=CHZK_STGALLEN&kataloge=ZUERICH&kataloge=CHZK_NEBIS&kataloge=ALEXANDRIA&kataloge=CHZK_BGR&kataloge=HELVETICAT&kataloge=CHZK_SBT&kataloge=CHZK_SGBN&kataloge=LIECHTENSTEIN&kataloge=CHZK_CERN&kataloge=VKCH_KUNSTHAUS&kataloge=CHZK_RPVZ&ALL=&SE=&VORT=&CI=&SS=XISSNX&target=_blank&Timeout=120&inhibit_redirect=1', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(24, 'Doctor-Doc', 'http://www.doctor-doc.com/version1.0/daia.do?issn=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(26, 'Ulrichs', 'http://ulrichsweb.com/ulrichsweb/Search/ViewSearchResults.asp?navPage=1&SortOrder=Asc&SortField=f_display_title&collection=SERIAL&QueryMode=Simple&ScoreThreshold=0&ResultCount=25&ResultTemplate=quickSearchResults.hts&QueryText=sn=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(27, 'perUnil', 'http://www2.unil.ch/perunil/search.php?allfields=&title=&search=advanced&field=title&publisher=&issn=XISSNX&format=all&accessunil=1&accesslibre=1&sujet=&platform=&licence=&statut=&localisation=&cote=', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(28, 'RP/VZ', 'http://links.admin.ch/cgi-bin/gw/chameleon?search=KEYWORD&rootsearch=KEYWORD&function=INITREQ&SourceScreen=HOLDINGSCR&skin=rpvz&conf=.%2fchameleon.conf&lng=fr-ch&itemu1=8&scant1=&scanu1=4&pos=1&prevpos=1&beginsrch=1&u1=4&t1=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(29, 'Helveticat', 'http://links.admin.ch/cgi-bin/gw/chameleon?search=KEYWORD&function=INITREQ&skin=helveticat&lng=fr-ch&inst=consortium&conf=.%2fchameleon.conf&u1=1035&op1=0&t2=p&u2=8701&pos=1&rootsearch=KEYWORD&t1=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(30, 'RERO CC', 'http://opac.rero.ch/gateway?function=INITREQ&search=SCAN&rootsearch=SCAN&u1=2019&t1=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(31, 'RERO VD', 'http://opac.rero.ch/gateway?skin=vd&function=INITREQ&search=SCAN&rootsearch=SCAN&u1=2019&t1=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(33, 'Swiss Serials', 'http://www.ubka.uni-karlsruhe.de/hylib-bin/kvk/nph-kvk2.cgi?maske=chzk&timeout=120&title=Portail+suisse+des+p%E9riodiques+%28PSP%29+%3A+Liste+des+R%E9sultats&header=http%3A%2F%2Fead.nb.admin.ch%2Fweb%2Fswiss-serials%2Fanzeige_fr.htm&spacer=http%3A%2F%2Fead.nb.admin.ch%2Fweb%2Fswiss-serials%2Fanzeigetop_fr.htm&footer=http%3A%2F%2Fead.nb.admin.ch%2Fweb%2Fswiss-serials%2Fanzeigemail_fr.htm&lang=de&zeiten=nein&kvk-session=08CSUG05&flexpositon_start=1&RERO=&DEUTSCHSCHWEIZ=&WEITERE=&kataloge=CHZK_FRIB&kataloge=CHZK_GENF&kataloge=CHZK_RCBN&kataloge=CHZK_VALAIS&kataloge=CHZK_VAUD&kataloge=CHZK_BASEL&kataloge=CHZK_LUZERN&kataloge=CHZK_STGALLEN&kataloge=ZUERICH&kataloge=CHZK_NEBIS&kataloge=ALEXANDRIA&kataloge=CHZK_BGR&kataloge=HELVETICAT&kataloge=CHZK_SBT&kataloge=CHZK_SGBN&kataloge=LIECHTENSTEIN&kataloge=CHZK_CERN&kataloge=VKCH_KUNSTHAUS&kataloge=CHZK_RPVZ&ALL=&SE=XTITLEX&VORT=&CI=&SS=&target=_blank&Timeout=120&inhibit_redirect=1', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(34, 'Doctor-Doc', 'http://www.doctor-doc.com/version1.0/daia.do?jtitle=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(35, 'Ulrichs', 'http://ulrichsweb.com/ulrichsweb/Search/ViewSearchResults.asp?navPage=1&SortOrder=Asc&SortField=f_display_title&collection=SERIAL&QueryMode=Simple&ScoreThreshold=0&ResultCount=25&ResultTemplate=quickSearchResults.hts&QueryText=kt=XTITLEX', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1),
(36, 'NLM', 'http://www.ncbi.nlm.nih.gov/sites/entrez?Db=nlmcatalog&Cmd=DetailsSearch&Term=XTITLEX', 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1),
(37, 'Google', 'http://www.google.ch/search?hl=fr&newwindow=1&q=%22XTITLEX%22', 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1),
(38, 'Amazon', 'http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Dstripbooks&field-keywords=XTITLEX', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1),
(39, 'SAPHIR', 'http://www.saphirdoc.ch/ListRecord.htm?idinlist=0&list=request&NumReq=101912492919&objecttype_03Adresse=on&objecttype_03Annuaire=on&objecttype_03Article=on&objecttype_03Dossier=on&objecttype_03Multim%25E9dia=on&objecttype_03Publication=on&objecttype_03Site%2Bweb=on&oper_1=3&oper_2=20000000&inselect=0&cluster_2=XTITLEX', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1),
(40, 'RERO', 'http://opac.rero.ch/gateway?function=INITREQ&search=SCAN&rootsearch=SCAN&u1=4&t1=XTITLEX', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1),
(42, 'Uni Bern', 'http://www.zb.unibe.ch/unicd/docdel.php?Journal=XTITLEX&Author=XAULASTX&Article=XATITLEX&Volume=XVOLUMEX&Issue=XISSUEX&Year=XDATEX&Pages=XPAGESX&ISSN=XISSNX&meduid=XPMIDX&sid=XSIDX&Publisher=&PubliPlace=&ou=&bennr=[my_bern_ill_code]&passwort=[my_bern_ill_password]&wo_bestellen=schweiz&mitteilung=XNAMEX+%28XPIDX%29', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1),
(45, 'SUBITO', 'http://www.subito-doc.de/order/openurl.php?sid=[my_subito_broker_id]:[my_subito_customer_code]%2F[my_subito_password]', 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1),
(46, 'ILL RERO', 'http://falbala.rero.ch/cgi-bin/WebObjects/ILLForm.woa/wa/LoginFromChameleon/menu?lang=fr-ch&genre=XGENREX&issn=XISSNX&btitle=XTITLEX&jtitle=XTITLEX&volume=XVOLUMEX&issue=XISSUEX&date=XDATEX&spage=XPAGESX&atitle=XATITLEX&aulast=XAULASTX', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1),
(47, 'IDS', 'http://aleph.unibas.ch/F/?func=find-b&CON_LNG=FRE&find_code=022&request=XISSNX', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(48, 'IDS', 'http://aleph.unibas.ch/F/?func=find-b&find_code=WTI&CON_LNG=FRE&request=XTITLEX*', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1);

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

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `status_id`, `origin_id`, `sid`, `pid`, `order_at`, `sent_at`, `invoice_at`, `renew_at`, `price`, `is_prepaid`, `external_ref`, `request_by`, `surname`, `firstname`, `service_id`, `cgra`, `cgrb`, `mail`, `tel`, `address`, `zip`, `locality`, `doc_type`, `priority`, `deliver_type`, `journal_title`, `year`, `volume`, `issue`, `supplement`, `pages`, `article_title`, `authors`, `edition`, `isxn`, `eissn`, `doi`, `uid`, `admin_comment`, `user_comment`, `history`, `filled_out_by`, `library_id`, `internal_ref`, `pmid`, `ip`, `referer`) VALUES
(1, 3, 3, '', '', '2012-01-01 06:00:00', '2012-01-03 09:30:00', NULL, NULL, 0, 0, '', 'publicform', 'Merdwrieva', 'Marie', 1, '', '', 'Marie.Merdwrieva@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'Acta neuropathologica', '1993', '86', '3', '', '215', 'Posterior cortical atrophy in Alzheimer''s disease: analysis of a new case and re-evaluation of a historical report', 'Hof', '', '0001-6322', '', '', '', '', '', 'Commande saisie par 224.654.248.71 le 01/01/2012 15:16:36<br /> Commande modifiée par User XYZ le 02/01/2012 16:15:37 [localisation - stade - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:23:37 [stade - ]', '224.654.248.71', 1, '', '', '224.654.7.44', 'http://sfx.univxyz.com/sfx_local?sid=google&auinit=PR&aulast=Hof&atitle=Posterior+cortical+atrophy+in+Alzheimer%2527s+disease:+analysis+of+a+new+case+and+re-evaluation+of+a+historical+report&titl'),
(2, 3, 14, '', '', '2012-01-01 07:00:00', '2012-01-01 07:10:00', NULL, NULL, 0, 0, '', 'publicform', 'Merdwrieva', 'Marie', 1, '', '', 'Marie.Merdwrieva@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'Anatomy and embryology', '1993', '187', '6', '', '515', 'Layer V pyramidal cells in the adult human cingulate cortex', 'Schlaug', '', '0340-2061', '', '', '', '', '', 'Commande saisie par 224.654.248.71 le 01/01/2012 15:44:19<br /> Commande modifiée par Isabelle de Kaenel le 02/01/2012 16:01:06 [stade - localisation - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 14:58:52 [stade - ]', '224.654.248.71', 1, '', '', '224.654.7.44', 'http://sfx.univxyz.com/sfx_local?sid=google&auinit=G&aulast=Schlaug&atitle=Layer+V+pyramidal+cells+in+the+adult+human+cingulate+cortex&title=Anatomy+and+embryology&volume=187&issue=6&date=1993%'),
(3, 4, 15, '', '', '2012-01-01 08:00:00', '2012-01-10 10:00:00', '2012-01-25 00:00:00', NULL, 0, 0, '', 'publicform', 'Merdwrieva', 'Marie', 1, '', '', 'Marie.Merdwrieva@univxyz.com', '', '', '', '', 'book', 2, 'mail', 'Cingulate neurobiology and disease', '2009', '', '', '', '', '', 'Vogt BA', '', '', '', '', '', '', '', 'Commande saisie par 224.654.248.75 le 01/01/2012 18:21:25<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:49:14 [stade - localisation - ]<br /> Commande modifiée par Gerard Dubois le 10/01/2012 14:59:03 [stade - ]<br /> Commande modifiée par Marc Laurel le 25/01/2012 17:21:33 [stade - ]', '224.654.248.75', 1, '', '', '224.654.7.44', 'http://sfx.univxyz.com/sfx_local?sid=google&auinit=Z&aulast=Li&atitle=Increased+%25E2%2580%259Cdefault+mode%25E2%2580%259D+activity+in+adolescents+prenatally+exposed+to+cocaine&title=Human+brain+mapping&'),
(4, 3, 2, '', '', '2012-01-02 09:00:00', '2012-01-03 11:00:00', NULL, NULL, 0, 0, '', 'publicform', 'Gstzuirer', 'Marc', 5, '', '', 'marc.gstzuirer@univxyz.com', '34674', '', '', '', 'article', 2, 'mail', 'Neurology', '1983', '33', '12', '', '1573-83', 'The anatomic basis of pure alexia.', 'Damasio AR', '', '0028-3878', '', '', 'pmid:6685830', 'pdf fait', '', 'Commande saisie par 224.654.7.44 le 02/01/2012 00:03:31<br /> Commande modifiée par Anissa Djeddou le 02/01/2012 16:13:14 [localisation - stade - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:59:24 [remarques - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 11:22:24 [stade - ]', '224.654.7.44', 1, '', '6685830', '224.654.7.44', ''),
(5, 3, 11, '', '', '2012-01-02 10:00:00', '2012-01-03 14:00:00', NULL, NULL, 0, 0, 'SUBITO:LG12010300351', 'publicform', 'Grossz', 'Sandra', 11, 'URG123', '', 'Sandra.Grossz@univxyz.com', '', 'Victoria Ruffie 77', '2454', 'Lausanne', 'article', 2, 'mail', 'Journal of gerontological nursing', '2004', '30', '6', '', '10-5; quiz 52-3', 'The transition of elderly patients between hospitals and nursing homes. Improving nurse-to-nurse communication.', 'Cortes TA', '', '0098-9134', '', '', 'pmid:15227932 ', '', '', 'Commande saisie par 178.198.138.121 le 02/01/2012 15:08:17<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:29:05 [ref ecrassee par PMID - email - service - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:30:47 [stade - ref fournisseur - localisation - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 12:06:02 [stade - ]', '178.198.138.121', 1, '', '15227932 ', '224.654.7.44', 'http://www.univxyz.com/openillink/neworder.php'),
(6, 3, 12, '', '', '2012-01-02 11:00:00', '2012-01-03 10:00:00', NULL, NULL, 0, 0, '', 'publicform', 'Grossz', 'Sandra', 11, 'URG123', '', 'Sandra.Grossz@univxyz.com', '', 'Victoria Ruffie 77', '2454', 'Lausanne', 'article', 2, 'mail', 'Journal of advanced nursing', '1997', '26', '5', '', '864-71', 'The transition to nursing home life: a comparison of planned and unplanned admissions.', 'Wilson SA', '', '0309-2402', '', '', 'pmid:9372389', '', '', 'Commande saisie par 178.198.138.121 le 02/01/2012 15:25:05<br /> Commande modifiée par Anissa Djeddou le 02/01/2012 16:11:58 [localisation - stade - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:22:19 [stade - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 09:22:54 [email - service - cgra - ]', '178.198.138.121', 1, '', '9372389', '224.654.7.44', 'http://www.univxyz.com/openillink/neworder.php'),
(7, 3, 15, '', '', '2012-01-02 12:00:00', '2012-01-02 16:00:00', NULL, NULL, 0, 0, '', 'publicform', 'Fritzjdue', 'Fernand', 1, '', '', 'fernand.fritzjdue@univxyz.com', '', 'avenue du vin 75', '1124', 'Lausanne', 'article', 2, 'mail', 'The Nursing clinics of North America', '2011', '46', '3', '', '321-33, vi-vii', 'Promoting health literacy: a nursing imperative.', 'Speros', '', '0029-6465', '1558-1357', '', 'pmid:21791267', '', '', 'Commande saisie par 224.654.7.44 le 02/01/2012 16:12:44<br /> Commande modifiée par Anissa Djeddou le 02/01/2012 16:14:18 [email - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 10:35:30 [stade - localisation - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 11:36:48 [stade - ]', '224.654.7.44', 1, '', '21791267', '224.654.7.44', 'http://linksolver.ovid.com/OpenUrl/LinkSolver?sid=Entrez:PubMed&id=pmid:21791267'),
(8, 3, 11, '', '', '2012-01-02 13:00:00', '2012-01-10 12:00:00', NULL, '2012-01-10 00:00:00', 0, 0, 'SUBITO:LG12011000467', 'publicform', 'Fritzjdue', 'Fernand', 1, '', '', 'fernand.fritzjdue@univxyz.com', '', 'avenue du vin 75', '1124', 'Lausanne', 'article', 2, 'mail', 'Holistic nursing practice', '2010', '24', '4', '', '204-12', 'The concept of health literacy within the older adult population.', 'Oldfield SR, Dreher HM.', '', '0887-9311', '', '', 'pmid:20588129', 'écrit le 3.1 à etieurted@wrteint.edu', '', 'Commande saisie par 224.654.7.44 le 02/01/2012 16:19:51<br /> Commande modifiée par Gerard Dubois le 03/01/2012 10:34:45 [stade - renouveler - localisation - ref ecrassee par PMID - remarques - auteurs - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 11:30:34 [remarques - stade - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 11:33:34 [renouveler - ]<br /> Commande modifiée par Gerard Dubois le 10/01/2012 09:35:01 [stade - ref fournisseur - localisation - ]<br /> Commande modifiée par Gerard Dubois le 10/01/2012 15:41:20 [stade - ]', '224.654.7.44', 1, '', '20588129', '224.654.7.44', 'http://linksolver.ovid.com/OpenUrl/LinkSolver?sid=Entrez:PubMed&id=pmid:20588129'),
(9, 3, 3, '', '', '2012-01-03 14:00:00', '2012-01-03 14:05:00', NULL, NULL, 0, 0, '', 'publicform', 'Nielsend', 'Gerald', 6, '', '', 'gerald.nielsend@univxyz.com', '', '', '', '', 'article', 2, 'surplace', 'The Journal of nursing education', '2002', '41', '1', '', '25-31', 'A new perspective on competencies for self-directed learning.', 'Patterson', '', '0148-4834', '', '', '', '', '', 'Commande saisie par 224.654.7.43 le 03/01/2012 00:28:53<br /> Commande modifiée par Gerard Dubois le 03/01/2012 10:31:52 [stade - localisation - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 11:53:19 [stade - ]', '224.654.7.43', 1, '', '', '224.654.7.44', 'http://www.univxyz.com/openillink/openlinker/?tid=pmid&uids=&aulast=Patterson&atitle=A+new+perspective+on+competencies+for+self-directed+learning.&title=The+Journal+of+nursing+education&date=2002%2'),
(10, 3, 25, '', '', '2012-01-03 15:00:00', '2012-01-03 16:22:00', NULL, NULL, 0, 0, 'SUBITO:LE145341233453', '', 'Guerrero', 'Marco', 7, '', '', 'Marco.Guerrero@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'Epigenomics', '2011', '3', '4', '', '503-518', 'Epigenetic diet: impact on the epigenome and cancer', 'Hardy Tabitha M', '', '1750-1911', '', '', 'DOI:10.2217/epi.11.71', 'Facture subito C4534523-234625\r\n', '', 'Commande saisie par Franco Josquin le 03/01/2012 07:30:43<br /> Commande modifiée par Franco Josquin le 03/01/2012 07:33:51 [ref fournisseur - stade - localisation - ]<br /> Commande modifiée par Franco Josquin le 03/01/2012 15:40:08 [stade - ref fournisseur - ]<br /> Commande modifiée par Franco Josquin le 16/02/2012 14:02:11 [remarques - ]', 'Franco Josquin', 0, '', '', '224.654.7.44', 'http://www.univxyz.com/openillink/in.php'),
(11, 5, 6, '', '', '2012-01-03 16:00:00', NULL, NULL, NULL, 0, 0, '', 'publicform', 'Dupont', 'Pierre', 10, '', '', 'pierre.dupont@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'Medical progress through technology', '1994', '20', '3-4', '', '231-42', 'Evaluation of the Omniflow collagen-polymer vascular prosthesis.', 'Werkmeister', '', '0047-6552', '', '', 'pmid:7877568', 'ATTENTION POSSIBLE DOUBLON DE LA COMMANDE 92276 oui, erreur de saisie', '', 'Commande saisie par 224.654.7.44 le 03/01/2012 13:29:25<br /> Commande modifiée par Gerard Dubois le 03/01/2012 13:40:27 [remarques - stade - localisation - ]<br /> Commande modifiée par Gerard Dubois le 03/01/2012 16:25:39 [stade - remarques - ]', '224.654.7.44', 1, '', '7877568', '224.654.7.43', 'http://linksolver.ovid.com/OpenUrl/LinkSolver?sid=Entrez:PubMed&id=pmid:7877568'),
(12, 5, 18, '', '', '2012-01-03 17:00:00', NULL, NULL, NULL, 0, 0, '', '', 'Ansirmet', 'Michel', 8, 'NCP456', '', 'Michel.Ansirmet@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'The Journal of clinical psychiatry', '1989', '50', '11', '', '424-7', 'Chlorprothixene-induced hypouricemia: a biologic indicator of drug compliance.', 'Shalev', '', '0160-6689', '1555-2101,1096-0104', '', 'pmid:2808309', '', '', 'Commande saisie par Vera Bort le 03/01/2012 14:06:43', 'James Abbot', 3, '', '2808309', '224.654.7.43', 'http://linksolver.ovid.com/OpenUrl/LinkSolver?sid=Entrez:PubMed&id=pmid:2808309'),
(13, 5, 18, '', '', '2012-01-03 18:00:00', NULL, NULL, NULL, 0, 0, '', '', 'Ansirmet', 'Michel', 8, 'NCP3457A', '', 'Michel.Ansirmet@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'Acta psychiatrica Scandinavica. Supplementum', '1974', '255', '', '', '71-4', 'Plasma levels of chlorprothixene in alcoholics.', 'Mattsson', '', '0065-1591', '1600-5473', '', 'pmid:4533717', '', '', 'Commande saisie par Vera Bort le 03/01/2012 14:08:45', 'James Abbot', 3, '', '4533717', '224.654.7.43', 'http://linksolver.ovid.com/OpenUrl/LinkSolver?sid=Entrez:PubMed&id=pmid:4533717'),
(14, 10, 7, '', '', '2012-01-05 19:00:00', NULL, NULL, '2012-04-15 00:00:00', 0, 0, '', 'publicform', 'Niegger', 'Lin', 3, '', '', 'cabinet.niegger@dzuaozer.com', '', '', '', '', 'article', 2, 'mail', 'Current pharmaceutical biotechnology', '2011', 'Jul 8', '', '', 'Epub ahead of print', 'In Search of a Consensus Terminology in the Field of Platelet Concentrates for Surgical Use: Platelet-Rich Plasma (PRP), Platelet-Rich Fibrin (PRF), Fibrin Gel Polymerization and Leukocytes.', 'Dohan Ehrenfest DM', '', '1389-2010', '', '', 'pmid:21740379', 'écrit le 9.1 à:tr346@treiu.com > non, il ne l''a pas: attendre, tjrs ahead le 23.1, idem le 6.2, idem le 1.3, idem le 15.3, idem le 30.3, attendre', '', 'Commande saisie par 85.3.79.229 le 05/01/2012 19:16:43<br /> Commande modifiée par Marc Laurel le 09/01/2012 09:14:41 [volume - ]<br /> Commande modifiée par Marc Laurel le 09/01/2012 09:16:12 [remarques - stade - localisation - renouveler - ]<br /> Commande modifiée par Mary Kingston le 09/01/2012 10:27:32 [stade - stade - remarques - ]<br /> Commande modifiée par Marc Laurel le 09/01/2012 13:49:38 [remarques - ]<br /> Commande modifiée par Marc Laurel le 09/01/2012 13:49:58 [remarques - ]<br /> Commande modifiée par Marc Laurel le 09/01/2012 13:50:50 [remarques - renouveler - ]<br /> Commande modifiée par Gerard Dubois le 23/01/2012 09:39:37 [remarques - renouveler - ]<br /> Commande modifiée par Gerard Dubois le 30/01/2012 08:43:44 [renouveler - ]<br /> Commande modifiée par Gerard Dubois le 06/02/2012 16:14:08 [renouveler - remarques - ]<br /> Commande modifiée par Marc Laurel le 01/03/2012 12:29:26 [remarques - ]<br /> Commande modifiée par Marc Laurel le 01/03/2012 12:29:33 [renouveler - ]<br /> Commande modifiée par Marc Laurel le 15/03/2012 10:12:09 [remarques - renouveler - ]<br /> Commande modifiée par Marc Laurel le 30/03/2012 09:10:50 [renouveler - remarques - ]', '85.3.79.229', 1, '', '21740379', '224.654.7.44', 'http://www.univxyz.com/openillink/neworder.php'),
(15, 10, 7, '', '', '2012-01-08 20:00:00', NULL, NULL, '2012-04-15 00:00:00', 0, 0, '', 'publicform', 'Niegger', 'Lin', 3, '', '', 'cabinet.niegger@dzuaozer.com', '', '', '', '', 'article', 2, 'mail', 'Current pharmaceutical biotechnology', '2011', 'Jul 8', '', '', 'Epub ahead of print', 'Sports Medicine Applications of Platelet Rich Plasma.', 'Mishra A, Harmon K, Woodall J, Vieira A.', '', '1389-2010', '', '', 'pmid:21740373', 'écrit le 9.1 à: am453@gratrezu.com, tjrs ahead le 23.1, idem le 6.2, idem le 1.3, idem le 15.3, idem le 30.3, attendre\r\n', '', 'Commande saisie par 188.62.220.105 le 08/01/2012 21:19:25<br /> Commande modifiée par Marc Laurel le 09/01/2012 14:15:27 [volume - ]<br /> Commande modifiée par Marc Laurel le 09/01/2012 14:16:50 [remarques - stade - localisation - renouveler - ]<br /> Commande modifiée par Gerard Dubois le 18/01/2012 08:48:17 [auteurs - ]<br /> Commande modifiée par Marc Laurel le 18/01/2012 11:07:10 [renouveler - ]<br /> Commande modifiée par Gerard Dubois le 23/01/2012 09:38:41 [renouveler - remarques - ]<br /> Commande modifiée par Gerard Dubois le 30/01/2012 08:44:01 [renouveler - ]<br /> Commande modifiée par Gerard Dubois le 06/02/2012 16:13:29 [renouveler - remarques - ]<br /> Commande modifiée par Gerard Dubois le 06/02/2012 16:14:27 [renouveler - ]<br /> Commande modifiée par Marc Laurel le 01/03/2012 12:29:59 [renouveler - remarques - ]<br /> Commande modifiée par Marc Laurel le 15/03/2012 10:14:45 [renouveler - remarques - ]<br /> Commande modifiée par Marc Laurel le 30/03/2012 09:09:51 [remarques - renouveler - ]', '188.62.220.105', 1, '', '21740373', '224.654.7.44', 'http://www.univxyz.com/openillink/neworder.php'),
(16, 10, 24, '', '', '2012-01-09 21:00:00', NULL, NULL, '2012-05-10 00:00:00', 0, 0, '', '', 'Joss', 'Friederich', 7, '', '', 'Friederich.Joss@univxyz.com', '', '', '', '', 'article', 2, 'mail', 'Clinical rehabilitation', '2011', '', '', '', '', 'Early mobilization out of bed after ischaemic stroke reduces severe complications but not cerebral blood flow: a randomized controlled pilot trial.', 'Diserens K', '', '0269-2155', '', '', 'pmid:22144725', 'POUR DI: Epub attendre la pagination pour commnder Vu MF il n''a pas le pdf', '', 'Commande saisie par Franco Josquin le 09/01/2012 14:44:27<br /> Commande modifiée par Franco Josquin le 10/01/2012 16:55:26 [stade - ]<br /> Commande modifiée par Franco Josquin le 24/01/2012 08:59:09 [renouveler - ]<br /> Commande modifiée par Franco Josquin le 16/02/2012 16:17:07 [renouveler - ]<br /> Commande modifiée par Franco Josquin le 14/03/2012 15:22:16 [renouveler - ]<br /> Commande modifiée par Franco Josquin le 26/03/2012 07:57:13 [renouveler - ]<br /> Commande modifiée par Franco Josquin le 12/04/2012 14:14:47 [renouveler - ]', 'Franco Josquin', 0, '', '22144725', '224.654.7.44', 'http://www.univxyz.com/openillink/all.php'),
(17, 4, 8, '', '', '2012-01-11 22:00:00', '2012-01-25 07:00:00', '2012-02-03 00:00:00', NULL, 0, 0, '00556773345', 'publicform', 'Charles', 'Nicoleta', 2, '', '', 'cnicoleta@debiaphorm.com', '4236 3466463 34', 'Debiaphorm SA / Ch. du Tissage', '34563', 'Lausanne', 'book', 2, 'mail', 'Système financier national et développement économique : réflexion théorique sur le choix entre une politique néo-libérale et une politique d''intervention sur les systèmes financiers des économies en retard : rejet du monétarisme', '1992', '', '', '', '', '', 'Lurati, Francesco', 'Ed. Universitaires, Fribourg', '2827105977', '', '', '', 'KBR\r\ncdé à subito par erreur, renvoyé tout de suite le livre subito et cdé dans rero (Mary)/ prêt > 18.2', '', 'Commande saisie par 212.74.146.92 le 11/01/2012 16:23:18<br /> Commande modifiée par Marc Laurel le 11/01/2012 16:45:09 [stade - ref fournisseur - localisation - ]<br /> Commande modifiée par Gerard Dubois le 23/01/2012 10:25:27 [stade - ]<br /> Commande modifiée par Gerard Dubois le 23/01/2012 11:01:40 [stade - ref fournisseur - localisation - remarques - ]<br /> Commande modifiée par Marc Laurel le 25/01/2012 17:07:21 [stade - remarques - ]<br /> Commande modifiée par Marc Laurel le 25/01/2012 17:15:12<br /> Commande modifiée par Marc Laurel le 03/02/2012 09:23:18 [stade - ]', '212.74.146.92', 1, '', '', '224.654.7.44', 'http://www.univxyz.com/openillink/neworder.php'),
(18, 2, 11, '', '', '2012-01-15 06:00:00', NULL, NULL, NULL, 0, 0, 'SUBITO:2012032701440', 'publicform', 'Niegger', 'Lin', 3, '', '', 'cabinet.niegger@bluewon.ch', '', '', '', '', 'article', 2, 'mail', 'International journal of immunopathology and pharmacology', '2011', '24', '1 Suppl 2', '', '79-83', 'Platelet rich plasma and tendinopathy: state of the art.', 'Del Buono A', '', '0394-6320', '', '', 'pmid:21669143', 'recdé à mü le 27.3', '', 'Commande saisie par 85.3.22.72 le 15/01/2012 13:20:17<br /> Commande modifiée par Gerard Dubois le 16/01/2012 09:07:05 [stade - ref fournisseur - localisation - ]<br /> Commande modifiée par Gerard Dubois le 27/03/2012 12:37:13 [ref fournisseur - remarques - ]', '85.3.22.72', 1, '', '21669143', '224.654.7.44', 'http://www.univxyz.com/openillink/neworder.php'),
(19, 4, 8, '', '', '2012-01-16 07:00:00', '2012-01-19 10:00:00', '2012-02-20 00:00:00', NULL, 0, 0, '00555303', '', 'Neuter', 'Ronald', 9, '', '', 'ronald.neuter@bluewon.ch', '', '', '', '', 'book', 2, 'mail', 'Le cerveau pour les nuls', '2010', '', '', '', '', '', 'Sedel, Frédéric', 'Paris : First', '', '', '', 'RERO:R005662646', 'prêt > 13.2, prolongé jusqu''au 12.3', '', 'Commande saisie par Gerard Dubois le 16/01/2012 12:20:17<br /> Commande modifiée par Gerard Dubois le 16/01/2012 12:21:06 [stade - localisation - ref fournisseur - ]<br /> Commande modifiée par Marc Laurel le 19/01/2012 15:55:32 [stade - remarques - ]<br /> Commande modifiée par Marc Laurel le 19/01/2012 15:56:43 [remarques - ]<br /> Commande modifiée par Marc Laurel le 19/01/2012 15:59:44 [remarques - ]<br /> Commande modifiée par Gerard Dubois le 13/02/2012 09:36:55 [remarques - ]<br /> Commande modifiée par Gerard Dubois le 20/02/2012 08:39:43 [stade - ]', 'Gerard Dubois', 1, '', '', '224.654.7.44', 'http://www.univxyz.com/openillink/in.php'),
(20, 4, 5, '', '', '2012-01-19 10:00:00', '2012-01-19 11:00:00', '2012-03-08 00:00:00', NULL, 0, 0, '', '', 'Miranda Queiros', 'Joao', 4, 'GCP7384H', '', 'Joao.Miranda-Queiros@univxyz.com', '3278 42938 422', '', '', '', 'book', 2, 'mail', 'L''éthique de la santé : guide pour une intégration de l''éthique dans les pratiques infirmières', '2009 ', '', '', '', '', '', 'Saint-Arnaud, Jocelyne', '', '', '', '', '', 'ECVP 4398 \r\n2e cote 22.6 SAI \r\nDépôt salle HETRI > prêt fait à BUPSY jusqu''au 18.2(envoyer par navette interne)\r\n', '', 'Commande saisie par John Smith le 19/01/2012 13:19:37<br /> Commande modifiée par John Smith le 19/01/2012 13:20:06 [bibliotheque - ]<br /> Commande modifiée par Marc Laurel le 19/01/2012 14:36:33 [stade - localisation - ]<br /> Commande modifiée par Marc Laurel le 19/01/2012 15:04:22 [remarques - ]<br /> Commande modifiée par Marc Laurel le 19/01/2012 15:45:04 [stade - remarques - ]<br /> Commande modifiée par Marc Laurel le 08/03/2012 11:41:06 [stade - ]', 'John Smith', 3, '', '', '224.654.7.44', 'http://www.univxyz.com/openillink/in.php'),
(21, 11, 1, '', '', '2014-05-15 09:52:14', NULL, NULL, NULL, 0, 0, '', 'publicform', 'Dupont', 'Jaques', 2, '', '', 'j.dupont@priv-ent.com', '', '', '', '', 'article', 2, 'mail', 'Zdravookhranenie Kirgizii', '1976', '', '6', '', '35-7', '[Some physiological and hygienic studies of the working conditions of the workers in a glass factory].', 'Nedviga VI', '', '0132-8867', '', '', 'pmid:13579', '', '', 'Commande saisie par 127.0.0.1 le 2014-05-15 09:52:14 ', '', 1, '', '13579', '127.0.0.1', 'http://localhost/openillink-export/');

-- --------------------------------------------------------

--
-- Structure de la table `origins`
--

CREATE TABLE IF NOT EXISTS `origins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `library_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Contenu de la table `origins`
--

INSERT INTO `origins` (`id`, `library_id`, `name`) VALUES
(1, 1, 'Bibliothèque centrale'),
(2, 1, 'Bibliothèque centrale : Archives'),
(3, 1, 'Bibliothèque centrale : Salle du libre accès'),
(4, 1, 'Bibliothèque centrale : Compactus'),
(5, 1, 'Bibliothèque centrale : Dépôt'),
(6, 1, 'Doublon vérifié'),
(7, 1, 'Bibliothèque centrale : Expo de nouveautés'),
(8, 1, 'Bibliothèque centrale : Journaux électroniques sou'),
(9, 1, 'National Library of Medicine (NLM)'),
(10, 1, 'Bibliothèque centrale : Abonnement personnel'),
(11, 1, 'SUBITO'),
(12, 1, 'Disponible gratuitement sur le web'),
(13, 1, 'Demande à l''auteur'),
(14, 1, 'Bibliothèque centrale : Salle de références'),
(15, 1, 'Bibliothèque centrale : salle de reliure'),
(16, 2, 'Bibliothèque de l''institut XYZ'),
(17, 2, 'Bibliothèque de l''institut XYZ : Archives'),
(18, 3, 'Bibliothèque de l''institut ABC'),
(19, 3, 'Bibliothèque de l''institut ABC : Scan'),
(20, 4, 'Bibliothèque de la faculté JKL'),
(21, 5, 'Bibliothèque de la faculté MNO'),
(22, 5, 'Bibliothèque de la faculté MNO : Archives'),
(23, 6, 'Bibliothèque de la faculté PQR'),
(24, 7, 'Bibliothèque de la faculté STU'),
(25, 7, 'Bibliothèque de la faculté STU : Compactus');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Contenu de la table `services`
--

INSERT INTO `services` (`id`, `name`, `department`, `faculty`, `library_id`, `need_validation`) VALUES
(1, 'Radiologie', 'Radiology', 'Medicine', 1, 0),
(2, 'Entreprise privée', '', '', 1, 1),
(3, 'Médecin en cabinet privé', NULL, NULL, 1, 0),
(4, 'Gastroentrologie', 'Internal Medicine', 'Medicine', 1, 0),
(5, 'Neurologie', 'Neurosciences', 'Medicine', 3, 0),
(6, 'Neurochirurgie', 'Neurosciences', 'Medicine', 1, 0),
(7, 'Sociologie', 'Sociology', 'Humanities', 2, 0),
(8, 'Psychologie', 'Psychology', 'Humanities', 2, 0),
(9, 'Etudiant', NULL, 'Medicine', 1, 0),
(10, 'Transplantation', 'Transplantation', 'Medicine', 1, 0),
(11, 'Urgences', 'Emergency medicine', 'Medicine', 4, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

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
(12, 'Supprimée', 'Commande supprimée (erreur de saisie, spam, etc.)', 'red', '', 'trash');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login`, `password`, `library_id`, `is_active`, `admin_level`) VALUES
(1, 'Super administrateur', 'sadmin@unixyz.com', 'sadmin', '25d5080a3d547a8732da5a4ac849f8f4546065bd', 1, 1, 1),
(2, 'Utilisateur', 'user@unixyz.com', 'user', '1442271e04e0eb9553901b5a2f8dd9da5fcd64be', 7, 1, 3),
(3, 'Administrateur', 'admin@unixyz.com', 'admin', '6bf96975ed2f8ab090252d23916fe9757d48b9c5', 1, 1, 2),
(4, 'Administrateur 2', 'admin2@unixyz.com', 'admin2', '04ddc6ac6acfc85dce23500a283173281016cbe0', 1, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
