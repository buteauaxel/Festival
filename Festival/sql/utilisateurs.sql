-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 12 Novembre 2015 à 15:45
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `festival`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `ID` int(5) DEFAULT NULL,
  `Nom` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `MotDePasse` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Organisation` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Privilège` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID`, `Nom`, `MotDePasse`, `Organisation`, `Privilège`) VALUES
(0, 'Joliverie', 'Joliverie', 'Joliverie', 'Administrateur'),
(1, 'Philippe MAURICE', 'PMAURICE', 'Collège de Moka', 'Gérant');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
