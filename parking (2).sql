-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 05 Décembre 2015 à 19:40
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `parking`
--

-- --------------------------------------------------------

--
-- Structure de la table `listedattente`
--

CREATE TABLE IF NOT EXISTS `listedattente` (
  `positionattente` int(2) NOT NULL,
  `codeclient` int(5) NOT NULL,
  PRIMARY KEY (`positionattente`),
  KEY `codeclient` (`codeclient`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `listedattente`
--

INSERT INTO `listedattente` (`positionattente`, `codeclient`) VALUES
(3, 2),
(1, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Structure de la table `membresligues`
--

CREATE TABLE IF NOT EXISTS `membresligues` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `membresligues`
--

INSERT INTO `membresligues` (`id`, `prenom`, `nom`) VALUES
(1, 'Akram', 'JHINGOOR'),
(2, 'Kevin', 'GILIBERT'),
(3, 'Hicham', 'AZOULAI'),
(4, 'Cerine', 'ZERROUDI'),
(5, 'Christophe', 'SHAO');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `numnotif` int(3) NOT NULL,
  `datenotif` date NOT NULL,
  `nbjours` int(3) NOT NULL,
  `numuser` int(2) NOT NULL,
  PRIMARY KEY (`numnotif`),
  KEY `numuser` (`numuser`),
  KEY `numuser_2` (`numuser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `placeoccupee`
--

CREATE TABLE IF NOT EXISTS `placeoccupee` (
  `numoccupee` int(11) NOT NULL,
  `statut_place` int(11) NOT NULL,
  `codeclient` int(11) DEFAULT NULL,
  PRIMARY KEY (`numoccupee`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `placeoccupee`
--

INSERT INTO `placeoccupee` (`numoccupee`, `statut_place`, `codeclient`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `placeparking`
--

CREATE TABLE IF NOT EXISTS `placeparking` (
  `numplace` int(2) NOT NULL AUTO_INCREMENT,
  `datedebut` date NOT NULL,
  `echeance` date NOT NULL,
  PRIMARY KEY (`numplace`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `placeparking`
--

INSERT INTO `placeparking` (`numplace`, `datedebut`, `echeance`) VALUES
(1, '2015-12-07', '2015-12-14'),
(2, '2015-12-07', '2015-12-14'),
(3, '2015-12-05', '2015-12-10');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `numutil` int(5) NOT NULL AUTO_INCREMENT,
  `nomutil` varchar(20) NOT NULL,
  `prenomutil` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `motdepasse` varchar(40) NOT NULL,
  `dateinscription` date NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`numutil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`numutil`, `nomutil`, `prenomutil`, `email`, `motdepasse`, `dateinscription`, `admin`, `statut`) VALUES
(1, 'JHINGOOR', 'Akram', 'akram@admin.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-10', 1, 1),
(2, 'GILIBERT', 'Kevin', 'kev-gili@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-18', 0, 1),
(3, 'AZOULAI', 'Hicham', 'hicham@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-11-23', 0, 1),
(4, 'ZERROUDI', 'Cerine', 'cerisegroupama@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-12-01', 0, 1),
(5, 'SHAO', 'Christophe', 'chris@m2l.fr', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-12-05', 0, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `listedattente`
--
ALTER TABLE `listedattente`
  ADD CONSTRAINT `listedattente_ibfk_1` FOREIGN KEY (`codeclient`) REFERENCES `utilisateurs` (`numutil`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`numuser`) REFERENCES `utilisateurs` (`numutil`);

--
-- Contraintes pour la table `placeoccupee`
--
ALTER TABLE `placeoccupee`
  ADD CONSTRAINT `pparking_constraint` FOREIGN KEY (`numoccupee`) REFERENCES `placeparking` (`numplace`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
