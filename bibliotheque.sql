-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 jan. 2026 à 10:38
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bibliothèque`
--

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE `emprunt` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL,
  `est_en_retard` tinyint(1) NOT NULL DEFAULT 0,
  `nombre_prolongations` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique_emprunt`
--

CREATE TABLE `historique_emprunt` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `utilisateur_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL,
  `date_retour_effectif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL,
  `date_demande` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `_resume` text DEFAULT NULL,
  `isbn` varchar(13) NOT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `nb_exemplaires_total` int(11) NOT NULL,
  `nb_exemplaires_disponible` int(11) NOT NULL,
  `est_disponible` tinyint(1) NOT NULL DEFAULT 1,
  `format` varchar(50) DEFAULT NULL,
  `editeur` varchar(100) DEFAULT NULL,
  `date_publication` date DEFAULT NULL,
  `mots_cles` varchar(255) DEFAULT NULL,
  `image_couverture` varchar(500) DEFAULT NULL,
  `type_support` varchar(50) DEFAULT NULL,
  `_collection` varchar(100) DEFAULT NULL,
  `nb_pages` int(11) DEFAULT NULL,
  `sudoc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `titre`, `auteur`, `_resume`, `isbn`, `categorie`, `nb_exemplaires_total`, `nb_exemplaires_disponible`, `est_disponible`, `format`, `editeur`, `date_publication`, `mots_cles`, `image_couverture`, `type_support`, `_collection`, `nb_pages`, `sudoc`) VALUES
(1, 'PHP pour les Nuls', 'Jean-Pierre', 'Apprendre le PHP facilement.', '978-3-16-1484', 'Informatique', 5, 5, 1, 'Broché', 'Editions Tech', '2023-01-01', 'PHP,Web', 'php_pour_les_nuls.jpg', 'Livre', 'Collection Pour les Nuls', 300, '123456789'),
(3, 'HTML pour les nuls', 'Jean Dupont', 'Apprendre l\'HTML pour les nuls', '978-2-07-0414', 'Informatique', 10, 10, 1, 'broché', 'Gallimard', '2022-01-01', 'HTML, Informatique', 'html_pour_les_nuls.jpg', 'Livre', 'Folio', 96, '123456789');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `mail_iut` varchar(255) NOT NULL,
  `num_etudiant` varchar(50) DEFAULT NULL,
  `formation` varchar(100) DEFAULT NULL,
  `est_admin` tinyint(1) NOT NULL DEFAULT 0,
  `peut_emprunter` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `mdp`, `mail_iut`, `num_etudiant`, `formation`, `est_admin`, `peut_emprunter`) VALUES
(1, 'Dupont', 'Jean', 'password123', 'jean.dupont@mmi.edu', '20230001', 'MMI', 0, 1),
(2, 'GERVAUD', 'Alexis', 'password', 'alexis.gervaud@iut-dijon.u-bourgogne.fr', '1234656847', 'MMI', 0, 1),
(3, 'Moreira', 'Celine', 'password', 'celine.moreira@iut-dijon.u-bourgogne.fr', NULL, NULL, 0, 1),
(4, 'Pierre', 'Hugo', 'password', 'biblio@iut-dijon.u-bourgogne.fr', NULL, NULL, 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `livre_id` (`livre_id`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail_iut` (`mail_iut`),
  ADD UNIQUE KEY `num_etudiant` (`num_etudiant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `emprunt_ibfk_2` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
