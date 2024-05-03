-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 23 mars 2024 à 21:13
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
-- Base de données : `zzwarehouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `id_stock` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `type_mouvement` enum('Entree','Sortie') DEFAULT NULL,
  `date_commande` datetime DEFAULT current_timestamp(),
  `statut` enum('En attente','Validee','Invalidée') DEFAULT 'En attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_utilisateur`, `id_stock`, `quantite`, `type_mouvement`, `date_commande`, `statut`) VALUES
(1, 31, 1, 10, 'Sortie', '2024-03-23 18:12:45', 'Invalidée'),
(2, 9, 30, 90, 'Entree', '2024-03-23 18:39:39', 'En attente'),
(3, 27, 7, 17, 'Sortie', '2024-03-23 18:39:48', 'Validee'),
(4, 7, 1, 90, 'Entree', '2024-03-23 18:49:18', 'En attente'),
(5, 5, 1, 10, 'Sortie', '2024-03-23 20:19:46', 'En attente'),
(6, 6, 1, 10, 'Sortie', '2024-03-23 20:20:27', 'En attente'),
(7, 11, 1, 10, 'Sortie', '2024-03-23 20:20:51', 'En attente'),
(8, 17, 1, 10, 'Sortie', '2024-03-23 20:32:21', 'En attente'),
(9, 4, 1, 90, 'Entree', '2024-03-23 20:32:48', 'Validee'),
(10, 35, 1, 90, 'Sortie', '2024-03-23 20:37:18', 'Validee');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'client'),
(4, 'Fournisseur');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id_stock` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantite_disponible` int(11) DEFAULT NULL,
  `type` enum('Medicament','Materiel') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id_stock`, `nom`, `description`, `quantite_disponible`, `type`) VALUES
(1, 'Aspirine', 'Analgésique et antipyrétique', 2201, 'Medicament'),
(2, 'Stéthoscope', 'Instrument médical pour écouter les sons internes du corps', 10, 'Materiel'),
(3, 'Amoxicilline', 'Antibiotique', 10, 'Medicament'),
(4, 'Tensiomètre', 'Appareil pour mesurer la pression artérielle', 5, 'Materiel'),
(5, 'Ibuprofene', 'Anti-inflammatoire non stéroïdien', 75, 'Medicament'),
(6, 'Lampe frontale', 'Source de lumière portable pour les examens médicaux', 15, 'Materiel'),
(7, 'Paracétamol', 'Analgésique et antipyrétique', 183, 'Medicament'),
(8, 'Seringue', 'Instrument pour l\'injection de médicaments', 50, 'Materiel'),
(9, 'Omeprazole', 'Inhibiteur de la pompe à protons', 30, 'Medicament'),
(10, 'Thermomètre', 'Appareil pour mesurer la température corporelle', 20, 'Materiel'),
(11, 'Ciseaux médicaux', 'Instrument pour la découpe de matériaux médicaux', 8, 'Materiel'),
(12, 'Antihistaminique', 'Médicament pour le traitement des allergies', 40, 'Medicament'),
(13, 'Gants médicaux', 'Équipement de protection pour les mains', 100, 'Materiel'),
(14, 'Antiémétique', 'Médicament pour le traitement des nausées et vomissements', 25, 'Medicament'),
(15, 'Oxymètre de pouls', 'Appareil pour mesurer la saturation en oxygène dans le sang', 102, 'Materiel'),
(16, 'Fluorouracile', 'Médicament utilisé dans le traitement du cancer', 15, 'Medicament'),
(17, 'Cannule nasale', 'Dispositif pour l\'administration d\'oxygène par le nez', 30, 'Materiel'),
(18, 'Antibiotique topique', 'Médicament pour le traitement des infections cutanées', 50, 'Medicament'),
(19, 'Glucomètre', 'Appareil pour mesurer la glycémie', 9, 'Materiel'),
(20, 'Antidépresseur', 'Médicament pour le traitement de la dépression', 35, 'Medicament'),
(21, 'Masque facial', 'Équipement de protection pour le visage', 80, 'Materiel'),
(22, 'Anticoagulant', 'Médicament pour prévenir la formation de caillots sanguins', 60, 'Medicament'),
(23, 'Cathéter', 'Tube médical utilisé pour l\'administration de liquides ou de médicaments', 25, 'Materiel'),
(24, 'Antipyrétique', 'Médicament pour réduire la fièvre', 70, 'Medicament'),
(25, 'Oxygène portable', 'Dispositif pour l\'administration d\'oxygène en déplacement', 7, 'Materiel'),
(26, 'Antihypertenseur', 'Médicament pour le traitement de l\'hypertension artérielle', 45, 'Medicament'),
(27, 'Bandage élastique', 'Matériel de bandage extensible', 120, 'Materiel'),
(28, 'Antifongique', 'Médicament pour le traitement des infections fongiques', 55, 'Medicament'),
(29, 'Glaçons réutilisables', 'Équipement pour l\'application de froid thérapeutique', 18, 'Materiel'),
(30, 'Antiviral', 'Médicament pour le traitement des infections virales', 25, 'Medicament');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `blocked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `id_role`, `login_attempts`, `blocked_until`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$HOEKqeMinZGoMVkJ23n8J.BSIDe0P7dNpL2fgcsC4ipbqm1fjmz9a', 1, 0, NULL),
(2, 'user', 'user', 'user@gmail.com', '$2y$10$JVWmczTnD6UR85UUUWR0muap6SqVhm./W7gLnxJoBv3GOszVpYQlG', 2, 0, NULL),
(3, 'client', 'client', 'client@gmail.com', '$2y$10$aRLMc/TfeQqla4NLfYfgaeydy.GRsBt1Rmg07p.fVqbeph0/E8Oxa', 3, 0, NULL),
(4, 'fourniseur', 'fourniseur', 'fourniseur@gmail.com', '$2y$10$k2XmSb9HYiL6w984mvber.vsxXjAanwiNXggeOVIDdvONqeazy6JS', 4, 0, NULL),
(5, 'Zidane', 'Zinedine', 'zizou@gmail.com', '$2y$10$dvTVZL8MG9Zd4rMxrrAv3OBRcsvIEQAmh5m1TVGGmOzJpuQJXNZMS', 1, 0, NULL),
(6, 'San juan', 'Coco', 'coco92@gmail.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, '2024-02-25 14:58:10'),
(7, 'Nicolas', 'Barbet', 'n.barbet@le-fourniseur.com', '$2y$10$b/cXPWwVCik/otWCHEzw6OUDGwNEqNXmtrVH8DvFl9rgUcXn8eIGu', 4, 0, NULL),
(8, 'Smith', 'Emily', 'emilysmith@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(9, 'Johnson', 'Michael', 'michaeljohnson@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 4, 0, NULL),
(10, 'Davis', 'Jessica', 'jessicadavis@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(11, 'Brown', 'Christopher', 'chrisbrown@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(12, 'Wilson', 'Olivia', 'oliviawilson@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(13, 'Anderson', 'William', 'williamanderson@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(14, 'Taylor', 'Sophia', 'sophiataylor@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(15, 'Thomas', 'Ava', 'avathomas@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(16, 'Miller', 'James', 'jamesmiller@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(17, 'Anderson', 'Isabella', 'isabellaanderson@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(18, 'Wilson', 'Benjamin', 'benjaminwilson@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(19, 'Clark', 'Natalie', 'natalieclark@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(20, 'Parker', 'Daniel', 'danielparker@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 1, 0, NULL),
(21, 'Lewis', 'Sophie', 'sophielewis@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(22, 'Harris', 'Alexander', 'alexanderharris@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(23, 'Adams', 'Victoria', 'victoriaadams@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(24, 'Bell', 'Andrew', 'andrewbell@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(25, 'Carter', 'Grace', 'gracecarter@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(26, 'Butler', 'Henry', 'henrybutler@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(27, 'Baker', 'Lily', 'lilybaker@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpd', 3, 0, NULL),
(28, 'Brooks', 'David', 'davidbrooks@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(29, 'Mitchell', 'Emma', 'emmamitchell@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(30, 'Ward', 'Joseph', 'josephward@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(31, 'Collins', 'Chloe', 'chloecollins@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(32, 'Cook', 'Matthew', 'matthewcook@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(33, 'Gray', 'Ava', 'avagray@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(34, 'Bailey', 'Sophia', 'sophiabailey@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(35, 'Murphy', 'Oliver', 'olivermurphy@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(36, 'Scott', 'Isabella', 'isabellascott@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(37, 'Young', 'Lucas', 'lucasyoung@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(38, 'Stewart', 'Madison', 'madisonstewart@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(39, 'Price', 'Ethan', 'ethanprice@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `FK_id_stock` (`id_stock`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id_stock`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `FK_id_stock` FOREIGN KEY (`id_stock`) REFERENCES `stocks` (`id_stock`),
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
