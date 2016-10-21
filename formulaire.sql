
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 09 Septembre 2016 à 12:14
-- Version du serveur: 10.0.20-MariaDB
-- Version de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `u750678748_formu`
--

-- --------------------------------------------------------

--
-- Structure de la table `formulaire`
--

CREATE TABLE IF NOT EXISTS `formulaire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identite` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `studio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `direct` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `formulaire`
--

INSERT INTO `formulaire` (`id`, `identite`, `studio`, `direct`, `nom`) VALUES
(1, 'clement', 'Telephone', 'Direct', 'Nadine Morano'),
(2, 'clement', 'Studio', 'Direct', 'Sylvain Franz'),
(3, 'clement', 'Studio', 'Direct', 'Eric Wernet'),
(5, 'clement', 'Studio', 'Direct', 'Richard Lioger'),
(6, 'cecile', 'Studio', 'PAD', 'Hugues Bied-Charreton');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
