-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 déc. 2020 à 09:43
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gbaf`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(127) NOT NULL,
  `prenom` varchar(127) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id_user`, `nom`, `prenom`, `username`, `password`, `question`, `reponse`, `photo`) VALUES
(1, 'Vincent', 'Cassel', 'Vincent', '$2y$10$FzokmEaB6mvH4aXmj8x1jOmMD.FlzEuoywKCsUekKH5JE7NYJvFjy', 'année de naissance', '$2y$10$fFJ6SghaPf5jd0hiK8fCaelB/rrpVjeQRpj9Zkmo8BGOECR8Ono3a', '69121484807Cassel.jpg'),
(2, 'Dujardin', 'jean', 'Jean', '$2y$10$lHeK1oJF8utrFqlvk5TLAe55m7H5uZ9b.0KbLvQRwlWuyQ8nm9kT.', 'année de naissance', '$2y$10$o2MdwR2M636TYTS2Qq26Z.ojTOMCQsRsQ2TCw.MTEM6NT39Yi8FDS', '23804974023Dujardin.jpg'),
(3, 'Duris', 'Romain', 'Romain', '$2y$10$R9MZZcO7IgGtGk8.GGkSH.3TQSkw6bewW/HSOS8.plO90G7dBW2zW', 'année de naissance', '$2y$10$vLqCgTFkPt/l2malPKlYseyCDMoaJ2WAN1WA5Dgth8CjUXiluGcKO', '42390403167Duris.jpeg'),
(4, 'Sy', 'Omar', 'Omar', '$2y$10$fjy8tomBTJwK37OHjKC6PeAk2mp3lT5E.g0Yv5VF63cznYPexa0Me', 'année de naissance', '$2y$10$vXNncUtK8yVsOg3SmOvSjewsCb7/cD6zhnVyP7DY5jkmhD/JTFiJC', '33867087983Sy.jpg'),
(5, 'Depardieu', 'Gérard', 'Gérard', '$2y$10$qtzy1Nw/RsvjnMmH1GCuguiH17MV1gYcY2K7qKOFb4yAWPotT/d2e', 'année de naissance', '$2y$10$yda6ZoQiKp6SqYT/WCDHkePJyJj3dBThqss8i775mW6zksY1qUit6', '11135352201Depardieu.jpg'),
(6, 'Tautou', 'Audrey', 'Audrey', '$2y$10$bnt4l5WOF2l/a2B0LqF7SeMv4eteK.Hv652Wjx3tzigehHFMYZKDG', 'année de naissance', '$2y$10$ZrS.3CKqLRGpbIXc1CC0W.RJdpXhTieji/QvNANvk5NLwgHawIvmq', '13629399017Tautou.jpg'),
(7, 'Cotillard', 'Marion', 'Marion', '$2y$10$MauROy0h52R3/0KrmyeShOn9y7m/qSAbLRr1HVaVundxsw.ffFPYq', 'année de naissance', '$2y$10$1HIk3sf/ZcQa7.HVSLJf4.1TtYym41tWlKHW2IvLtmyZSz4v6wwKu', '21126637656Cottilard.jpg'),
(8, 'Baye', 'Nathalie', 'Nathalie', '$2y$10$L8c04MwPQzGOR5L027lfSezHt0liujvcV2a5L8pbIlaLJ7FzV74qW', 'année de naissance', '$2y$10$BydCv9pLs2AJ306q1riU5ea4oAcwRZsqs22QzC9rM.rFBX7vdszSq', '31035579618Baye.jpg'),
(9, 'Deneuve', 'Catherine', 'Catherine', '$2y$10$KU0hH/1n8VbFtJWNgT2Iku5xjQOYRzB2o9/XzsApUIvoM/1ErLO/O', 'année de naissance', '$2y$10$Xv3oFoIotGAmCBWNPmM6TuPqdAXWATH61UWV3sKze.V6aY8d/uF5W', '77804848898Deneuve.jpg'),
(10, 'Cottin', 'Camille', 'Camille', '$2y$10$1jWVT8DNiP1.uI064OVKWuBghO7CC6uihE7ybfnyXpTQWeiixY3VW', 'année de naissance', '$2y$10$oxCGFvcuXONWhIa64e/i0.UOXsA3dxy1.jQGQZWeYBkgDHPyoQE6O', '28922886630Cottin.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `actor`
--

CREATE TABLE `actor` (
  `id_actor` int(11) NOT NULL,
  `actor` varchar(127) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `actor`
--

INSERT INTO `actor` (`id_actor`, `actor`, `description`, `logo`) VALUES
(1, 'Formation&co\r\n', '\"Formation&co est une association française présente sur tout le territoire.\r\nNous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un crédit et un accompagnement professionnel et personnalisé.\r\nNotre proposition : \r\n- un financement jusqu’à 30 000€ ;\r\n- un suivi personnalisé et gratuit ;\r\n- une lutte acharnée contre les freins sociétaux et les stéréotypes.\r\n\r\nLe financement est possible, peu importe le métier : coiffeur, banquier, éleveur de chèvres… . Nous collaborons avec des personnes talentueuses et motivées.\r\nVous n’avez pas de diplômes ? Ce n’est pas un problème pour nous ! Nos financements s’adressent à tous.\"\r\n', 'formation_co.png'),
(2, 'Protectpeople', '\"Protectpeople finance la solidarité nationale.\r\nNous appliquons le principe édifié par la Sécurité sociale française en 1945 : permettre à chacun de bénéficier d’une protection sociale.\r\n\r\nChez Protectpeople, chacun cotise selon ses moyens et reçoit selon ses besoins.\r\nProectecpeople est ouvert à tous, sans considération d’âge ou d’état de santé.\r\nNous garantissons un accès aux soins et une retraite.\r\nChaque année, nous collectons et répartissons 300 milliards d’euros.\r\nNotre mission est double :\r\nsociale : nous garantissons la fiabilité des données sociales ;\r\néconomique : nous apportons une contribution aux activités économiques.\"\r\n', 'protectpeople.png'),
(3, 'DSA France', '\"Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales.\r\nNous accompagnons les entreprises dans les étapes clés de leur évolution.\r\nNotre philosophie : s’adapter à chaque entreprise.\r\nNous les accompagnons pour voir plus grand et plus loin et proposons des solutions de financement adaptées à chaque étape de la vie des entreprises.\"\r\n', 'dsa_france.png'),
(4, 'CDE', '\"La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation. \r\nSon président est élu pour 3 ans par ses pairs, chefs d’entreprises et présidents des CDE.\"\r\n', 'cde.png');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id_post`, `id_user`, `id_actor`, `date_add`, `post`) VALUES
(1, 10, 1, '2020-12-09 17:11:37', 'On ne comprend pas ce qu\'est la science de la chaussure, quand on ne comprend pas ce qu\'est la science.'),
(2, 2, 1, '2020-12-09 17:19:35', 'L\'essentiel n\'est pas de vivre, mais de bien vivre.'),
(3, 3, 1, '2020-12-09 17:19:36', 'Chacun, parce qu\'il pense, est seul responsable de la sagesse ou de la folie de sa vie, c\'est-à-dire de sa destinée.'),
(5, 4, 1, '2020-12-09 17:19:38', 'Garde-toi de donner par force aux enfants l\'aliment des études, mais que se soit en le mêlant à leur jeux, afin d\'être encore plus capable d\'apercevoir quelles sont les inclinations naturelles de chacun.'),
(6, 5, 1, '2020-12-09 17:19:39', 'Le propre de la sagesse et de la vertu est de gouverner bien ; le propre de l\'injustice et de l\'ignorance est de gouverner mal.'),
(7, 6, 1, '2020-12-09 17:19:40', 'Si l\'on interroge bien les hommes, en posant bien les questions, ils découvrent d\'eux-mêmes la vérité sur chaque chose.'),
(8, 7, 1, '2020-12-09 17:19:41', 'L\'opinion est quelque chose d\'intermédiaire entre la connaissance et l\'ignorance.'),
(9, 8, 1, '2020-12-09 17:19:42', 'Si tu veux contrôler le peuple, commence par contrôler sa musique.'),
(10, 9, 1, '2020-12-09 17:19:43', 'Il ne dépend que de nous de suivre la route qui monte et d\'éviter celle qui descend.'),
(11, 1, 1, '2020-12-09 17:21:20', 'Le poste où l\'on s\'est soi-même placé, dans la pensée qu\'il était le meilleur, ou qu\'il nous était assigné par un chef, il faut y demeurer et en courir les risques sans tenir compte de la mort ni de rien d\'autre sinon du déshonneur.');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `id_vote` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  `vote` enum('like','dislike') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vote`
--

INSERT INTO `vote` (`id_vote`, `id_user`, `id_actor`, `vote`) VALUES
(1, 10, 1, 'like'),
(2, 1, 1, 'like'),
(3, 2, 1, 'like'),
(4, 3, 1, 'like'),
(5, 4, 1, 'like'),
(6, 5, 1, 'like'),
(7, 6, 1, 'like'),
(8, 7, 1, 'like'),
(9, 8, 1, 'like'),
(10, 10, 1, 'like'),
(11, 2, 2, 'dislike'),
(12, 3, 2, 'like'),
(13, 5, 2, 'dislike'),
(14, 7, 2, 'dislike'),
(15, 9, 2, 'dislike'),
(16, 10, 2, 'dislike'),
(17, 1, 2, 'like');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`id_actor`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id_vote`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `actor`
--
ALTER TABLE `actor`
  MODIFY `id_actor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
