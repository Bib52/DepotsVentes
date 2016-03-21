-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 21 Mars 2016 à 19:18
-- Version du serveur :  10.0.17-MariaDB
-- Version de PHP :  5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `depotsventes`
--

-- --------------------------------------------------------

--
-- Structure de la table `configurations`
--

CREATE TABLE `configurations` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `valeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `configurations`
--

INSERT INTO `configurations` (`id`, `nom`, `valeur`) VALUES
(1, 'Commission sur acheteur', 5),
(2, 'Commission sur déposant', 5);

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

CREATE TABLE `depots` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `depots`
--

INSERT INTO `depots` (`id`, `nom`, `prenom`, `email`, `adresse`, `telephone`) VALUES
(60, 'ah', 'aha', 'ahh@ajaj', 'hah', '0444505454');

-- --------------------------------------------------------

--
-- Structure de la table `modepaiements`
--

CREATE TABLE `modepaiements` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `modepaiements`
--

INSERT INTO `modepaiements` (`id`, `nom`, `etat`) VALUES
(18, 'Chèque', 0),
(23, 'Espèce', 1),
(24, 'Carte Bleue', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `reference` int(11) NOT NULL,
  `prix` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `etat` text NOT NULL,
  `id_depot` int(11) NOT NULL,
  `id_vente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`reference`, `prix`, `description`, `etat`, `id_depot`, `id_vente`) VALUES
(1, 10, 'je', 'En cours de vente', 60, 50),
(2, 35, 'zjas', 'En cours de vente', 60, 52),
(3, 10, 'ee', 'En cours de vente', 60, 54),
(4, 100, 'zzii', 'En cours de vente', 60, 54),
(5, 25, 'kz', 'En cours de vente', 60, 54),
(6, 30, 'jkek', 'En cours de vente', 60, 62);

-- --------------------------------------------------------

--
-- Structure de la table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permission` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `staff`
--

INSERT INTO `staff` (`id`, `nom`, `login`, `password`, `permission`) VALUES
(5, 'jsbsb', 'jzj', '$2y$10$HMliKqkhJ1JBlhKqcYQHbOHEeBXudnRUYctT4A3fm01S4kEc3jNdG', 'Admin'),
(9, 'ba', 'bab', '$2y$10$55msCO6MjzZqPtW0pQgnleWwI5QLWCoL2xFeXo5RrMyo2quRWVxBe', 'Staff'),
(10, 'bo', 'bo', '$2y$10$vFKq7ALPcqKAwxo1bNbdNux9vce/sfFQHrLtP63oxMw15G7LlSdce', 'Staff'),
(11, 'ole', 'la', '$2y$10$FMZbHJRpto1731jsA1ti7OJ.J2BsD7Oyi7tfLw5d0spyJreMqk3zK', 'Staff'),
(12, 'papa', 'papa', '$2y$10$0V/W1mlcku32/FUFHu3ev.0jQ58/SGTqUb0j08h0yj0XQ8jqTkObK', 'Staff');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `etat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ventes`
--

INSERT INTO `ventes` (`id`, `nom`, `prenom`, `adresse`, `ville`, `email`, `telephone`, `etat`) VALUES
(53, '', '', '', '', '', '', 'En cours'),
(54, '', '', '', '', '', '', 'En cours'),
(59, '', '', '', '', '', '', 'En cours'),
(60, '', '', '', '', '', '', 'En cours'),
(62, '', '', '', '', '', '', 'En cours');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depots`
--
ALTER TABLE `depots`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modepaiements`
--
ALTER TABLE `modepaiements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`reference`);

--
-- Index pour la table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT pour la table `modepaiements`
--
ALTER TABLE `modepaiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
