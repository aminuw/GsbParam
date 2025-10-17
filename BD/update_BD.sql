-- Script de mise à jour de la base de données GsbParam
-- Ajout de la fonctionnalité de connexion client

-- 1. Création de la table `client`
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Modification de la table `commande`
-- NOTE : Les commandes existantes sont supprimées car elles ne respectent pas la nouvelle structure (pas de client associé).
DELETE FROM `contenir`;
DELETE FROM `commande`;

-- Suppression des colonnes devenues inutiles
ALTER TABLE `commande`
  DROP COLUMN `nomPrenomClient`,
  DROP COLUMN `adresseRueClient`,
  DROP COLUMN `cpClient`,
  DROP COLUMN `villeClient`,
  DROP COLUMN `mailClient`;

-- Modification de la colonne idClient pour la rendre nullable et du bon type
ALTER TABLE `commande`
  MODIFY `idClient` int(11) DEFAULT NULL;

-- Ajout de la contrainte de clé étrangère pour lier la commande au client
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_client` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
