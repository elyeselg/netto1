-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 06 mai 2021 à 15:04
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `netto1`
--
CREATE DATABASE IF NOT EXISTS `netto1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `netto1`;

-- --------------------------------------------------------

--
-- Structure de la table `entretien`
--

DROP TABLE IF EXISTS `entretien`;
CREATE TABLE IF NOT EXISTS `entretien` (
  `IDENTRETIEN` int(10) NOT NULL AUTO_INCREMENT,
  `DATEENTRETIEN` date DEFAULT NULL,
  PRIMARY KEY (`IDENTRETIEN`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `entretien_operation`
--

DROP TABLE IF EXISTS `entretien_operation`;
CREATE TABLE IF NOT EXISTS `entretien_operation` (
  `IDENTRETIEN` int(10) NOT NULL,
  `IDOPERATION` int(10) NOT NULL,
  PRIMARY KEY (`IDENTRETIEN`,`IDOPERATION`),
  KEY `I_FK_ENTRETIEN_OPERATION_ENTRETIEN` (`IDENTRETIEN`),
  KEY `I_FK_ENTRETIEN_OPERATION_OPERATION` (`IDOPERATION`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `IDMARQUE` int(15) NOT NULL AUTO_INCREMENT,
  `NOMMARQUE` varchar(30) NOT NULL,
  PRIMARY KEY (`IDMARQUE`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`IDMARQUE`, `NOMMARQUE`) VALUES
(1, 'Peugeot'),
(2, 'Citroën'),
(3, 'Renault'),
(4, 'Opel'),
(5, 'Toyota');

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

DROP TABLE IF EXISTS `modele`;
CREATE TABLE IF NOT EXISTS `modele` (
  `IDMODELE` int(15) NOT NULL AUTO_INCREMENT,
  `IDMARQUE` int(15) NOT NULL,
  `NOMMODELE` char(30) NOT NULL,
  PRIMARY KEY (`IDMODELE`),
  KEY `FK_MODÈLE_MARQUE` (`IDMARQUE`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modele`
--

INSERT INTO `modele` (`IDMODELE`, `IDMARQUE`, `NOMMODELE`) VALUES
(1, 1, '207'),
(2, 1, '208'),
(3, 1, '308'),
(5, 2, 'C3'),
(6, 2, 'C4'),
(7, 2, 'Jumper'),
(8, 3, 'Master'),
(9, 3, 'Espace'),
(10, 3, 'Trafic'),
(11, 4, 'Movano'),
(12, 4, 'Vivaro'),
(13, 4, 'Combo Cargo'),
(14, 5, 'Proace'),
(15, 5, 'Tacoma'),
(16, 5, 'Highlander');

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

DROP TABLE IF EXISTS `operation`;
CREATE TABLE IF NOT EXISTS `operation` (
  `IDOPERATION` int(10) NOT NULL AUTO_INCREMENT,
  `NOMOPERATION` char(255) NOT NULL,
  PRIMARY KEY (`IDOPERATION`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `operation`
--

INSERT INTO `operation` (`IDOPERATION`, `NOMOPERATION`) VALUES
(1, 'Vidange'),
(2, 'Filtre à huile'),
(3, 'Filtre à air'),
(4, 'Filtre à carburant'),
(5, 'Filtre à habitacle'),
(6, 'Vérifier niveau d\'huile moteur'),
(7, 'Contrôlez le niveau du liquide de refroidissement'),
(8, 'Contrôlez les niveaux des liquides de freins et de direction assistée'),
(9, 'Testez l\'état de la batterie'),
(10, 'Entretenir les pneumatiques'),
(11, 'Gardez les freins en bonne état');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `LOGIN` char(50) DEFAULT NULL,
  `PASS` char(50) DEFAULT NULL,
  `EMAIL` char(50) DEFAULT NULL,
  `NOM` char(50) DEFAULT NULL,
  `PRENOM` char(50) DEFAULT NULL,
  `ADMIN` int(1) DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`ID`, `LOGIN`, `PASS`, `EMAIL`, `NOM`, `PRENOM`, `ADMIN`) VALUES
(4, 'Admin', 'azerty', 'admin@gmail.com', 'Responsable', 'Administrateur', 1);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `IDVEHICULE` int(10) NOT NULL AUTO_INCREMENT,
  `IDMODELE` char(15) NOT NULL,
  `IDENTRETIEN` int(10) DEFAULT NULL,
  `IMMAT` char(10) DEFAULT NULL,
  `KILOMETRAGE` int(50) DEFAULT NULL,
  PRIMARY KEY (`IDVEHICULE`),
  KEY `I_FK_VEHICULE_MODELE` (`IDMODELE`),
  KEY `l_FK_VEHICULE_ENTRETIEN` (`IDENTRETIEN`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
