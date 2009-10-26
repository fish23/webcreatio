-- phpMyAdmin SQL Dump
-- version 3.2.2.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pondělí 26. října 2009, 18:24
-- Verze MySQL: 5.1.37
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `moneyzzz`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `wc_resources`
--

CREATE TABLE IF NOT EXISTS `wc_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `wc_resources`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `wc_roles`
--

CREATE TABLE IF NOT EXISTS `wc_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`),
  KEY `id_parent` (`id_parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `wc_roles`
--

INSERT INTO `wc_roles` (`id`, `id_parent`, `role`) VALUES
(1, NULL, 'guest'),
(2, NULL, 'member'),
(3, 2, 'administrator');

-- --------------------------------------------------------

--
-- Struktura tabulky `wc_users`
--

CREATE TABLE IF NOT EXISTS `wc_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `realname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `registered` decimal(10,0) unsigned NOT NULL,
  `lastlogin` decimal(10,0) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `wc_users`
--

INSERT INTO `wc_users` (`id`, `realname`, `username`, `password`, `registered`, `lastlogin`) VALUES
(1, 'Administrator', 'admin', 'admin', 0, 0),
(2, 'Tester', 'tester', 'test', 0, 0),
(3, 'Demo', 'demo', '', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `wc_users_roles`
--

CREATE TABLE IF NOT EXISTS `wc_users_roles` (
  `id_user` bigint(20) unsigned NOT NULL,
  `id_role` int(10) unsigned NOT NULL,
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `wc_users_roles`
--

INSERT INTO `wc_users_roles` (`id_user`, `id_role`) VALUES
(1, 3),
(2, 2);
