-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 13 Mars 2016 à 21:51
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
(39, 'bd', 'hb', 'H@H', 'H', '0444505454'),
(40, 'djjh', 'jhkjl', 'jhj@ah', 'zjzj', '0444505454'),
(41, 'abh', 'abhcoco', 'a@acd', 'abhkz', '0444505454'),
(42, 'hah', 'hhh', 'h@ha', 'hhh', '0444505454'),
(43, 'oeieu', 'oie', 'a@a', 'oii', '0444505454'),
(46, 'jhj', 'j', 'k@k', 'hj', '0444505454'),
(47, 'edjeh', 'j', 'p@a', 'jh', '0444505454'),
(48, 'edjeh', 'j', 'p@abh', 'jh', '0444505454'),
(49, 'edjeh', 'je', 'ap@abh', 'jhe', '0444505454'),
(50, 'ekek', 'kzkzk', 'ak@oao', 'kzkzk', '0444505454'),
(51, 'jejez', 'jeje', 'apap@apap', 'zjzjzj', '0444505454'),
(52, 'ejejklzkl', 'jzjjz', 'jzj@jzk', 'jjzj', '0444505454'),
(53, 'blala', 'kakakfsd', 'dhdh@ddhdh', 'akaka', '0444505454'),
(54, 'DNJSB', 'HHHIUhedeze', 'niuy@huy', 'iuhhin', '0444505454'),
(55, 'fijofjio', 'iojeiskds', 'z@z', 'iojioj', '0444505454'),
(56, 'hguugy', 'yufyf', 'ugyug@jj', 'uugufy', '0189289244');

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
(1, 10045, 'zhje', 'En stock', 46, 0),
(10, 10, 'hzh', 'En stock', 41, 0),
(88, 100, 'dd', 'En stock', 38, 0),
(89, 125, 'av', 'En stock', 2, 0),
(100, 100, 'sjsjj', 'En stock', 38, 0),
(105, 10045, 'zhje', 'En stock', 22, 0),
(124, 10, 'djsj', 'En stock', 23, 0),
(147, 10, 'ad', 'En stock', 12, 0),
(149, 14, 'ok', 'En stock', 41, 0),
(178, 1010, 'sjjk', 'En stock', 22, 0),
(257, 10, 'ekek', 'En stock', 47, 0),
(287, 20, 'zkzk', 'En stock', 52, 0),
(333, 25, 'nhs', 'En stock', 3, 0),
(365, 17, 'azsbxj', 'En stock', 1, 0),
(427, 20, 'ldd', 'En stock', 34, 0),
(507, 20, 'ldd', 'En stock', 34, 0),
(517, 20, 'ldd', 'En stock', 34, 0),
(527, 20, 'ldd', 'En stock', 34, 0),
(554, 10, 'ihuhi', 'En stock', 56, 0),
(627, 20, 'ldd', 'En stock', 34, 0),
(641, 10, 'pull', 'En stock', 23, 0),
(687, 10, 'pojn', 'En stock', 21, 0),
(784, 100, 'az', 'En stock', 19, 0),
(987, 350, 'ordinateur', 'En stock', 23, 0),
(1210, 122, 'dzzoo', 'En stock', 52, 0),
(1477, 20, 'alo', 'En stock', 41, 0),
(1897, 25, 'abh', 'En stock', 41, 0),
(2154, 100, 'djjd', 'En stock', 50, 0),
(4457, 100, 'sjsj', 'En stock', 41, 0),
(7478, 10, 'ekeie', 'En stock', 50, 0),
(7844, 10, 'as', 'En stock', 20, 0),
(8578, 10, 'heh', 'En stock', 38, 0),
(50450, 10, 'eke', 'En stock', 52, 0),
(80987, 25, 'fffc', 'En stock', 55, 0),
(504554, 1100, 'fojfo', 'En stock', 55, 0),
(545405, 100, 'keke', 'En stock', 51, 0),
(808898, 1100, 'zhjesqffq', 'En stock', 54, 0),
(1054545, 100, 'ekej', 'En stock', 41, 0),
(8088080, 10050, 'qffqfzfer', 'En stock', 54, 0);

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
-- Index pour les tables exportées
--

--
-- Index pour la table `depots`
--
ALTER TABLE `depots`
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
-- AUTO_INCREMENT pour la table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT pour la table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
