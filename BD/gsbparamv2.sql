-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 01 avr. 2026 à 14:45
-- Version du serveur : 11.5.2-MariaDB
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbparamv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `associer`
--

DROP TABLE IF EXISTS `associer`;
CREATE TABLE IF NOT EXISTS `associer` (
  `idproduit` varchar(5) NOT NULL,
  `idproduit_associer` varchar(5) NOT NULL,
  PRIMARY KEY (`idproduit`,`idproduit_associer`),
  KEY `associer_idproduit_associer_FK` (`idproduit_associer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `idAvis` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `date_avis` datetime NOT NULL,
  `idClient` int(11) NOT NULL,
  `idproduit` varchar(5) NOT NULL,
  PRIMARY KEY (`idAvis`),
  KEY `avis_idClient_FK` (`idClient`),
  KEY `avis_idproduit_FK` (`idproduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCateg` char(3) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`idCateg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCateg`, `libelle`) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `idLogin` int(11) NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `client_idLogin_FK` (`idLogin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `idCommande` varchar(32) NOT NULL,
  `dateCommande` datetime DEFAULT NULL,
  `idClient` int(11) NOT NULL,
  `idEtat` int(11) NOT NULL,
  PRIMARY KEY (`idCommande`),
  KEY `commande_idClient_FK` (`idClient`),
  KEY `commande_idEtat_FK` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `idproduit` varchar(5) NOT NULL,
  `idCommande` varchar(32) NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`idproduit`,`idCommande`),
  KEY `contenir_idCommande_FK` (`idCommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `etat_commande`
--

DROP TABLE IF EXISTS `etat_commande`;
CREATE TABLE IF NOT EXISTS `etat_commande` (
  `idEtat` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `etat_commande`
--

INSERT INTO `etat_commande` (`idEtat`, `libelle`) VALUES
(1, 'En attente'),
(2, 'Validée'),
(3, 'Expédiée'),
(4, 'Annulée');

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `idLogin` int(11) NOT NULL,
  `mdp` varchar(150) NOT NULL,
  `role` smallint(6) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`idLogin`),
  UNIQUE KEY `mail_login_UNQ` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `idMarque` int(11) NOT NULL,
  `libelleMarque` varchar(30) NOT NULL,
  PRIMARY KEY (`idMarque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`idMarque`, `libelleMarque`) VALUES
(1, 'Laino'),
(2, 'Klorane'),
(3, 'Weleda'),
(4, 'Phytopulp'),
(5, 'Nuxe'),
(6, 'Romon Nature'),
(7, 'La Roche Posay'),
(8, 'Futuro'),
(9, 'Microlife'),
(10, 'Melapi'),
(11, 'Meli'),
(12, 'Avène'),
(13, 'Mustela'),
(14, 'Isdin'),
(15, 'Uriage'),
(16, 'Bioderma');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `idproduit` varchar(5) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` char(100) DEFAULT NULL,
  `quantiteStock` int(11) NOT NULL,
  `seuil_rupture` int(11) NOT NULL,
  `mis_en_avant_date_debut` date NOT NULL,
  `mis_en_avant_date_fin` date NOT NULL,
  `idCateg` char(3) NOT NULL,
  `idMarque` int(11) NOT NULL,
  `idUnite` int(11) NOT NULL,
  PRIMARY KEY (`idproduit`),
  KEY `produit_idCateg_FK` (`idCateg`),
  KEY `produit_idMarque_FK` (`idMarque`),
  KEY `produit_idUnite_FK` (`idUnite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idproduit`, `nom`, `description`, `prix`, `image`, `quantiteStock`, `seuil_rupture`, `mis_en_avant_date_debut`, `mis_en_avant_date_fin`, `idCateg`, `idMarque`, `idUnite`) VALUES
('c01', 'Laino Shampooing Douche au Thé Vert BIO', 'Shampooing douche au thé vert BIO, format 200ml.', 4.00, 'assets/images/laino-shampooing-douche-au-the-vert-bio-200ml.png', 100, 10, '2026-04-01', '2026-05-01', 'CH', 1, 3),
('c02', 'Klorane fibres de lin baume après shampooing', 'Baume après shampooing aux fibres de lin.', 10.80, 'assets/images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', 80, 5, '2026-04-01', '2026-05-01', 'CH', 2, 3),
('c03', 'Weleda Kids 2in1 Shower & Shampoo Orange fruitée', 'Shampooing et douche 2 en 1 pour enfants, orange fruitée.', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', 120, 15, '2026-04-01', '2026-05-01', 'CH', 3, 3),
('c04', 'Weleda Kids 2in1 Shower & Shampoo vanille douce', 'Shampooing et douche 2 en 1 pour enfants, vanille douce.', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', 110, 15, '2026-04-01', '2026-05-01', 'CH', 3, 3),
('c05', 'Klorane Shampooing sec à l\'extrait d\'ortie', 'Shampooing sec purifiant à l\'ortie.', 6.10, 'assets/images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', 50, 10, '2026-04-01', '2026-05-01', 'CH', 2, 3),
('c06', 'Phytopulp mousse volume intense', 'Mousse coiffante volume intense.', 18.00, 'assets/images/phytopulp-mousse-volume-intense-200ml.jpg', 40, 5, '2026-04-01', '2026-05-01', 'CH', 4, 3),
('c07', 'Bio Beaute by Nuxe Shampooing nutritif', 'Shampooing nutritif BIO.', 8.00, 'assets/images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', 60, 8, '2026-04-01', '2026-05-01', 'CH', 5, 3),
('f01', 'Nuxe Men Contour des Yeux Multi-Fonctions', 'Contour des yeux multi-fonctions pour homme.', 12.05, 'assets/images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', 30, 5, '2026-04-01', '2026-05-01', 'FO', 5, 1),
('f02', 'Tisane romon nature sommirel bio sachet 20', 'Tisane Sommirel BIO pour le sommeil.', 5.50, 'assets/images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', 200, 20, '2026-04-01', '2026-05-01', 'FO', 6, 4),
('f03', 'La Roche Posay Cicaplast crème pansement', 'Crème réparatrice Cicaplast.', 11.00, 'assets/images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', 150, 15, '2026-04-01', '2026-05-01', 'FO', 7, 2),
('f04', 'Futuro sport stabilisateur pour cheville', 'Attelle de cheville stabilisatrice.', 26.50, 'assets/images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', 20, 2, '2026-04-01', '2026-05-01', 'FO', 8, 1),
('f05', 'Microlife pèse-personne électronique weegschaal', 'Pèse-personne électronique de haute précision.', 63.00, 'assets/images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', 15, 2, '2026-04-01', '2026-05-01', 'FO', 9, 1),
('f06', 'Melapi Miel Thym Liquide 500g', 'Miel de thym liquide naturel.', 6.50, 'assets/images/melapi-miel-thym-liquide-500g.jpg', 90, 10, '2026-04-01', '2026-05-01', 'FO', 10, 1),
('f07', 'Meli Meliflor Pollen 200g', 'Pollen de fleur naturel.', 8.60, 'assets/images/melapi-pollen-250g.jpg', 75, 5, '2026-04-01', '2026-05-01', 'FO', 11, 1),
('p01', 'Avène solaire Spray très haute protection', 'Spray solaire SPF 50+, protection optimale.', 22.00, 'assets/images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', 140, 15, '2026-04-01', '2026-05-01', 'PS', 12, 3),
('p02', 'Mustela Solaire Lait très haute Protection', 'Lait solaire SPF 50+ pour bébés et enfants.', 17.50, 'assets/images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', 100, 10, '2026-04-01', '2026-05-01', 'PS', 13, 2),
('p03', 'Isdin Eryfotona aAK fluid', 'Fluide protecteur solaire haute technologie.', 29.00, 'assets/images/isdin-eryfotona-aak-fluid-100-50ml.jpg', 45, 5, '2026-04-01', '2026-05-01', 'PS', 14, 2),
('p04', 'La Roche Posay Anthélios 50+ Brume Visage', 'Brume solaire visage toucher sec.', 8.75, 'assets/images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', 85, 10, '2026-04-01', '2026-05-01', 'PS', 7, 1),
('p05', 'Nuxe Sun Huile Lactée Capillaire Protectrice', 'Huile lactée protectrice pour les cheveux au soleil.', 15.00, 'assets/images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', 65, 5, '2026-04-01', '2026-05-01', 'PS', 5, 2),
('p06', 'Uriage Bariésun stick lèvres SPF30 4g', 'Stick lèvres protecteur SPF 30.', 5.65, 'assets/images/uriage-bariesun-stick-levres-spf30-4g.jpg', 180, 20, '2026-04-01', '2026-05-01', 'PS', 15, 5),
('p07', 'Bioderma Cicabio creme SPF50+ 30ml', 'Crème réparatrice avec protection solaire.', 13.70, 'assets/images/bioderma-cicabio-creme-spf50-30ml.png', 95, 10, '2026-04-01', '2026-05-01', 'PS', 16, 2);

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

DROP TABLE IF EXISTS `unite`;
CREATE TABLE IF NOT EXISTS `unite` (
  `idUnite` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`idUnite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `unite`
--

INSERT INTO `unite` (`idUnite`, `libelle`) VALUES
(1, 'Unité'),
(2, 'Tube 50ml'),
(3, 'Flacon 200ml'),
(4, 'Sachet 20'),
(5, 'Stick 4g');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `associer`
--
ALTER TABLE `associer`
  ADD CONSTRAINT `associer_idproduit_FK` FOREIGN KEY (`idproduit`) REFERENCES `produit` (`idproduit`),
  ADD CONSTRAINT `associer_idproduit_associer_FK` FOREIGN KEY (`idproduit_associer`) REFERENCES `produit` (`idproduit`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_idClient_FK` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `avis_idproduit_FK` FOREIGN KEY (`idproduit`) REFERENCES `produit` (`idproduit`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_idLogin_FK` FOREIGN KEY (`idLogin`) REFERENCES `login` (`idLogin`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_idClient_FK` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `commande_idEtat_FK` FOREIGN KEY (`idEtat`) REFERENCES `etat_commande` (`idEtat`);

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_idCommande_FK` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`idCommande`),
  ADD CONSTRAINT `contenir_idproduit_FK` FOREIGN KEY (`idproduit`) REFERENCES `produit` (`idproduit`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_idCateg_FK` FOREIGN KEY (`idCateg`) REFERENCES `categorie` (`idCateg`),
  ADD CONSTRAINT `produit_idMarque_FK` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`idMarque`),
  ADD CONSTRAINT `produit_idUnite_FK` FOREIGN KEY (`idUnite`) REFERENCES `unite` (`idUnite`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
