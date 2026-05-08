-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : Dim 03 mai 2026 à 21:47
-- Version du serveur :  10.5.29-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_grp1`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `mdp` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `login`, `mdp`) VALUES
(1, 'adminX', 'adminX');

-- --------------------------------------------------------

--
-- Structure de la table `creators`
--

CREATE TABLE `creators` (
  `id_crea` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `nb_levels` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `creators`
--

INSERT INTO `creators` (`id_crea`, `login`, `mdp`, `nb_levels`) VALUES
(1, 'crea', 'crea', 0),
(2, 'crea2', 'crea2', 0);

-- --------------------------------------------------------

--
-- Structure de la table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `id_crea` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `nb_play` int(11) NOT NULL,
  `note_pos` int(11) NOT NULL,
  `note_neg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `levels`
--

INSERT INTO `levels` (`id`, `name`, `type`, `id_crea`, `level`, `nb_play`, `note_pos`, `note_neg`) VALUES
(1, 'NIveau premier', 1, 1, 1, 1, 1, 1),
(2, 'La cage de pierre', 2, 1, 2, 1, 1, 1),
(3, 'Le vol de la pierre', 1, 1, 1, 1, 1, 1),
(40, 'L\'envol du pigeon', 1, 1, 0, 0, 0, 0),
(41, 'HUH', 1, 2, 0, 0, 0, 0),
(61, 'Niveau jarvis métro bonnet', 1, 1, 0, 0, 0, 0),
(62, 'Niveau musical', 1, 1, 0, 0, 0, 0),
(63, 'Niveau_demo_Pour_oral', 1, 1, 0, 0, 0, 0),
(64, 'Niveau 9', 1, 1, 0, 0, 0, 0),
(65, 'hugolk', 1, 1, 0, 0, 0, 0),
(66, 'VraiNiveauDemo', 1, 1, 0, 0, 0, 0),
(67, 'pixel boss', 1, 1, 0, 0, 0, 0),
(68, 'TestRapide', 1, 1, 0, 0, 0, 0),
(69, 'test3004', 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `scores`
--

CREATE TABLE `scores` (
  `enregistrement` int(11) NOT NULL,
  `user_id` int(50) NOT NULL,
  `score` int(255) NOT NULL,
  `level_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `scores`
--

INSERT INTO `scores` (`enregistrement`, `user_id`, `score`, `level_id`) VALUES
(1, 1, 4, 1),
(2, 2, 4, 3),
(3, 1, 4, 1),
(4, 2, 4, 2),
(5, 1, 4, 3),
(45, 8, 3, 1),
(46, 8, 3, 1),
(47, 8, 10, 1),
(48, 8, 3, 1),
(49, 8, 2, 66),
(50, 8, 2, 66),
(51, 1, 6, 63),
(52, 1, 12, 63),
(53, 1, 24, 63),
(54, 1, 21, 63),
(55, 1, 51, 63),
(56, 1, 12, 63),
(57, 1, 12, 63),
(58, 1, 15, 63),
(59, 2, 11, 63),
(60, 2, 4, 63);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `levels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`levels`)),
  `pieces` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `login`, `mdp`, `levels`, `pieces`) VALUES
(1, 'user', 'user', '{\"mes_niveaux\":[\"HUH_1777219013\",\"LeFaahhDeLespace_1777218686\",\"test_jm_1777276726\",\"Niveau_demo_Pour_oral\",\"Nouveau Niveau\",\"mon vrai niveau\",\"L\'envol du pigeon\",\"pixel boss\",\"NIveau premier\",\"Niveau jarvis m\\u00e9tro bonnet\",\"TestRapide\"]}', 377),
(2, 'hugo', 'killian', '{\"mes_niveaux\":[\"LeFaahhDeLespace_1777218686\",\"HUH_1777219013\",\"downloads\\/level3.zip\",\"TestRapide\",\"test3004\"]}', 581),
(8, 'maxime', 'test', '{\"mes_niveaux\":[\"test_jm\",\"VraiNiveauDemo\"]}', 652),
(11, 'croco', 'wakanda', '{}', 0),
(12, 'gfdfgfd', 'gdfg', '{}', 0),
(13, 'gfdfgfd1', 'gfdfgfd1', '{}', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `creators`
--
ALTER TABLE `creators`
  ADD PRIMARY KEY (`id_crea`);

--
-- Index pour la table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`enregistrement`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `creators`
--
ALTER TABLE `creators`
  MODIFY `id_crea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `scores`
--
ALTER TABLE `scores`
  MODIFY `enregistrement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
