-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 23 Mars 2016 à 22:16
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
(1, 'Commission', 5);

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
(69, 'lolo', 'LO', 'a@a', 'A', '0444505454'),
(70, 'lolo', 'LO', 'b@as', 'A', '0444505454'),
(71, 'lolo', 'LO', 'dddd@dd', 'A', '0444505454'),
(72, 'lolo', 'LO', 'pod@a', 'A', '0444505454'),
(73, 'lolo', 'LO', 'poiz@paa', 'A', '0444505454'),
(74, 'lolo', 'dcoo', 'pk@ao', 'oaoa', '0444505454'),
(77, 'lop', 'oi', 'io@iu', 'io', '0444505454');

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
(24, 'Carte Bleue', 1),
(30, 'Espèce', 1);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` int(11) NOT NULL,
  `prix` double NOT NULL,
  `mode_paiements` varchar(255) NOT NULL,
  `id_vente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `paiements`
--

INSERT INTO `paiements` (`id`, `prix`, `mode_paiements`, `id_vente`) VALUES
(12, 10.5, 'Carte Bleue', 124),
(13, 15.75, 'Carte Bleue', 126),
(14, 42, 'Carte Bleue', 129),
(15, 15.75, 'Carte Bleue', 131),
(16, 15.75, 'Carte Bleue', 134),
(17, 15.75, 'Carte Bleue', 136),
(18, 10.5, 'Carte Bleue', 138),
(19, 36.75, 'Carte Bleue', 139),
(20, 36.75, 'Carte Bleue', 141),
(21, 47.25, 'Carte Bleue', 143),
(22, 47.25, 'Carte Bleue', 145),
(23, 47.25, 'Carte Bleue', 146),
(24, 10.5, 'Carte Bleue', 147),
(25, 36.75, 'Carte Bleue', 148),
(26, 10.5, 'Espèce', 149),
(27, 10.5, 'Carte Bleue', 150),
(28, 36.75, 'Carte Bleue', 151),
(29, 10.5, 'Carte Bleue', 152),
(30, 10.5, 'Carte Bleue', 154),
(31, 10.5, 'Carte Bleue', 155),
(32, 10.5, 'Carte Bleue', 156),
(33, 10.5, 'Carte Bleue', 156),
(34, 10.5, 'Carte Bleue', 157),
(35, 10.5, 'Carte Bleue', 158),
(36, 10.5, 'Carte Bleue', 159),
(37, 10.5, 'Carte Bleue', 160),
(38, 10.5, 'Carte Bleue', 161),
(39, 10.5, 'Carte Bleue', 162),
(40, 10.5, 'Carte Bleue', 162),
(41, 10.5, 'Carte Bleue', 163),
(44, 63, 'Carte Bleue', 173),
(45, 26.25, 'Espèce', 174),
(48, 52.5, 'Espèce', 177),
(52, 42, 'Espèce', 181),
(66, 36.75, 'Carte Bleue', 194),
(67, 36.75, 'Carte Bleue', 194),
(68, 15.75, 'Carte Bleue', 198);

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
(1, 10, 'd', 'Vendu', 74, 173),
(2, 25, 'sosoos', 'Vendu', 74, 173),
(3, 25, 'sosoo', 'Vendu', 74, 173),
(4, 15, 'ppso', 'Vendu', 74, 198),
(5, 10, 'ssi', 'Vendu', 73, 174),
(6, 15, 'sos', 'Vendu', 73, 174),
(7, 30, 'aksi', 'Vendu', 73, 177),
(8, 20, 'alo', 'Vendu', 71, 177),
(9, 25, 'poi', 'En stock', 71, 0),
(10, 35, 'didi', 'Vendu', 70, 194),
(11, 40, 'poiu', 'En stock', 70, 0),
(12, 50, 'poiuh', 'En stock', 70, 0),
(15, 40, 'lkjh', 'Vendu', 70, 181),
(20, 15, 'oto', 'En stock', 77, 0),
(21, 10, 'ajsj', 'En cours de vente', 77, 200),
(22, 45, 'skjkkl', 'En stock', 77, 0),
(23, 30, 'ksksk', 'En stock', 77, 0),
(24, 25, 'jkskjsd', 'En stock', 77, 0),
(25, 10, 'kskls', 'En stock', 77, 0);

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
(12, 'papa', 'papa', '$2y$10$0V/W1mlcku32/FUFHu3ev.0jQ58/SGTqUb0j08h0yj0XQ8jqTkObK', 'Staff'),
(13, 'toto', 'tata', '$2y$10$faEmkiVxRGtL87BL.WQb6.Q9sNBnvCfq90nnitDSQZSOWRn6PTATS', 'Staff'),
(15, 'mou', 'mourad', '$2y$10$0yt5WB2eSWHZArVUYMsLDOU2E70I3Df6zRxP7Fpyjhu.aSSO9AoSq', 'Admin');

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
  `etat` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ventes`
--

INSERT INTO `ventes` (`id`, `nom`, `prenom`, `adresse`, `ville`, `email`, `telephone`, `etat`, `date`) VALUES
(171, '', '', '', '', '', '', 'En cours', '0000-00-00'),
(173, '', '', '', '', '', '', 'Finie', '0000-00-00'),
(174, '', '', '', '', '', '', 'Finie', '0000-00-00'),
(177, '', '', '', '', '', '', 'Finie', '0000-00-00'),
(181, '', '', '', '', '', '', 'Finie', '0000-00-00'),
(194, '', '', '', '', '', '', 'Finie', '0000-00-00'),
(195, '', '', '', '', '', '', 'En cours', '0000-00-00'),
(197, '', '', '', '', '', '', 'En cours', '2016-03-23'),
(198, '', '', '', '', '', '', 'Finie', '2016-03-23'),
(200, '', '', '', '', '', '', 'En cours', '2016-03-23');

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
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT pour la table `modepaiements`
--
ALTER TABLE `modepaiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT pour la table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
