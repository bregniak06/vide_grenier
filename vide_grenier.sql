-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 03 fév. 2025 à 19:10
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vide_grenier`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `categories` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `date_poste` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `titre`, `description`, `prix`, `image`, `categories`, `user_id`, `telephone`, `date_poste`) VALUES
(1, 'nn', 'jfeufeuf', 5454.00, 'uploads/67886238ea3c9_mes.png', NULL, NULL, '45454545', '2025-01-16 01:34:48'),
(4, 'nn', 'jbujub', 45.00, 'uploads/678875a60ddfd_loupe.png', NULL, NULL, '45454545', '2025-01-16 02:57:42'),
(5, 'vetement', 'pour homme et femme', 200.00, 'uploads/6788fd135183c_vetement.webp', NULL, NULL, '93459674', '2025-01-16 12:35:31'),
(6, 'asbat', 'patati patata', 200.00, 'uploads/67890434eef0b_ferre a repasser .webp', NULL, NULL, '93459674', '2025-01-16 13:05:56'),
(7, 'vetement', 'iiknin', 1.21, 'uploads/6791a5ba5684c_bonjour.jpg', NULL, NULL, '45454545', '2025-01-23 02:13:14'),
(8, 'vetement', 'iiknin', 1.21, 'uploads/6791a5c0cce61_bonjour.jpg', NULL, NULL, '45454545', '2025-01-23 02:13:20'),
(9, 'vetement', 'miypyi', 77.00, 'uploads/6791acbf374ed_gettyimages-1341846254-612x612.jpg', NULL, NULL, '93459674', '2025-01-23 02:43:11'),
(13, 'vetement', 'ltufou', 4484.00, 'uploads/6791b5e35a857_bonjour.jpg', NULL, NULL, '93459674', '2025-01-23 03:22:11'),
(16, 'hvhv', 'iùhhiyglyf', 4500.00, 'uploads/67a0227403564_WhatsApp Image 2024-12-09 at 20.23.26 (1).jpeg', 2, 17, '45454545', '2025-02-03 01:57:08'),
(17, 'vetement', '!ùluh^mou_h', 44.00, 'uploads/67a0243e70095_Home Page.png', 1, 16, '45454545', '2025-02-03 02:04:46');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Appareils électroniques'),
(2, 'Appareils ménagers'),
(3, 'Appareils utilitaires');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `date_inscription`) VALUES
(5, 'bregniak', 'andrewolvgang@gmail.com', '$2y$10$BAqvxkZzg03DVkKpKxrwaORhZ.WBEdcWeBNUKl7rNmCsCT/U64Jqa', '2025-01-15 23:44:30'),
(6, 'bobo', 'toitreandre@gmail.com', '$2y$10$OCS0r0mPH5dKA28HslWQbOupgRJei0ifKk2urDuy9LYBX4x/hUihm', '2025-01-16 03:38:57'),
(7, 'bobobo', 'bobo@bobo', '$2y$10$RsMJw4qBC3W6qiS7wFnWA.0/5i8jbDIlAaDaO93pn5i0FLRQ6oD3y', '2025-01-16 12:57:14'),
(9, 'baba', 'baba@baba', '$2y$10$E7F8aheyt.YXqf.uK1qf/ebWf8sKIBtLt2Kqbz7eWCbKjO/szGJOS', '2025-01-16 12:59:47'),
(10, 'cacarote', 'cacarote@gmail.com', '$2y$10$muRnRPQVNHW2140qJtCjreXW4uZplG26MKggSPwLbX0Y3LmHgSOum', '2025-01-23 12:44:28'),
(11, 'cacarote1', 'cacarote1@gmail.com', '$2y$10$afPyjC6xqsyzvEJ39hTlM.ADrW6Sjm2ldBpwxW8Z5/AmQstnzam5u', '2025-02-03 01:24:36'),
(13, 'cacarote2', 'cacarote2@gmail.com', '$2y$10$l6sfzJd4Mxvd6CAWfn7c8ufCsWVpgZk0JR/20bsfjecVkxuFocuVW', '2025-02-03 01:33:39'),
(16, 'tro', 'tro@gmail.com', '$2y$10$EFp/z0Mq8MFLZrh9buaNHeH1Y2FdKCWuR/gZ8axx3dz5TzfPsOfVq', '2025-02-03 01:37:00'),
(17, 'h', 'h@gmail.com', '$2y$10$zjSidKJJXI9U2Aqnkn50HeAWHmufFa10GvEzB68TuP4pMJjmN0zV.', '2025-02-03 01:56:18');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categories`),
  ADD KEY `utilisateur_id` (`user_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`categories`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `annonces_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
