-- ----------------------------
-- Script de peuplement de la base de données GsbParam
-- À partir de l'ancien MCD vers le nouveau script_bdd.sql
-- ----------------------------

-- 1. Nettoyage
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM contenir;
DELETE FROM commande;
DELETE FROM avis;
DELETE FROM associer;
DELETE FROM produit;
DELETE FROM client;
DELETE FROM login;
DELETE FROM marque;
DELETE FROM unite;
DELETE FROM categorie;
DELETE FROM etat_commande;
SET FOREIGN_KEY_CHECKS = 1;

-- 2. Peuplement: categorie
INSERT INTO categorie (idCateg, libelle) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- 3. Peuplement: unite
INSERT INTO unite (idUnite, libelle) VALUES
(1, 'Unité'),
(2, 'Tube 50ml'),
(3, 'Flacon 200ml'),
(4, 'Sachet 20'),
(5, 'Stick 4g');

-- 4. Peuplement: etat_commande
INSERT INTO etat_commande (idEtat, libelle) VALUES
(1, 'En attente'),
(2, 'Validée'),
(3, 'Expédiée'),
(4, 'Annulée');

-- 5. Peuplement: marque
INSERT INTO marque (idMarque, libelleMarque) VALUES
(1, 'Laino'), (2, 'Klorane'), (3, 'Weleda'), (4, 'Phytopulp'), (5, 'Nuxe'),
(6, 'Romon Nature'), (7, 'La Roche Posay'), (8, 'Futuro'), (9, 'Microlife'),
(10, 'Melapi'), (11, 'Meli'), (12, 'Avène'), (13, 'Mustela'),
(14, 'Isdin'), (15, 'Uriage'), (16, 'Bioderma');

-- 8. Peuplement: produit
INSERT INTO produit (idproduit, nom, description, prix, image, quantiteStock, seuil_rupture, mis_en_avant_date_debut, mis_en_avant_date_fin, idCateg, idMarque, idUnite) VALUES
('c01', 'Laino Shampooing Douche au Thé Vert BIO', 'Shampooing douche au thé vert BIO, format 200ml.', 4.00, 'assets/images/laino-shampooing-douche-au-the-vert-bio-200ml.png', 100, 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 1, 3),
('c02', 'Klorane fibres de lin baume après shampooing', 'Baume après shampooing aux fibres de lin.', 10.80, 'assets/images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', 80, 5, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 2, 3),
('c03', 'Weleda Kids 2in1 Shower & Shampoo Orange fruitée', 'Shampooing et douche 2 en 1 pour enfants, orange fruitée.', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', 120, 15, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 3, 3),
('c04', 'Weleda Kids 2in1 Shower & Shampoo vanille douce', 'Shampooing et douche 2 en 1 pour enfants, vanille douce.', 4.00, 'assets/images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', 110, 15, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 3, 3),
('c05', 'Klorane Shampooing sec à l\'extrait d\'ortie', 'Shampooing sec purifiant à l\'ortie.', 6.10, 'assets/images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', 50, 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 2, 3),
('c06', 'Phytopulp mousse volume intense', 'Mousse coiffante volume intense.', 18.00, 'assets/images/phytopulp-mousse-volume-intense-200ml.jpg', 40, 5, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 4, 3),
('c07', 'Bio Beaute by Nuxe Shampooing nutritif', 'Shampooing nutritif BIO.', 8.00, 'assets/images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', 60, 8, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'CH', 5, 3),
('f01', 'Nuxe Men Contour des Yeux Multi-Fonctions', 'Contour des yeux multi-fonctions pour homme.', 12.05, 'assets/images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', 30, 5, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 5, 1),
('f02', 'Tisane romon nature sommirel bio sachet 20', 'Tisane Sommirel BIO pour le sommeil.', 5.50, 'assets/images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', 200, 20, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 6, 4),
('f03', 'La Roche Posay Cicaplast crème pansement', 'Crème réparatrice Cicaplast.', 11.00, 'assets/images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', 150, 15, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 7, 2),
('f04', 'Futuro sport stabilisateur pour cheville', 'Attelle de cheville stabilisatrice.', 26.50, 'assets/images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', 20, 2, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 8, 1),
('f05', 'Microlife pèse-personne électronique weegschaal', 'Pèse-personne électronique de haute précision.', 63.00, 'assets/images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', 15, 2, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 9, 1),
('f06', 'Melapi Miel Thym Liquide 500g', 'Miel de thym liquide naturel.', 6.50, 'assets/images/melapi-miel-thym-liquide-500g.jpg', 90, 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 10, 1),
('f07', 'Meli Meliflor Pollen 200g', 'Pollen de fleur naturel.', 8.60, 'assets/images/melapi-pollen-250g.jpg', 75, 5, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'FO', 11, 1),
('p01', 'Avène solaire Spray très haute protection', 'Spray solaire SPF 50+, protection optimale.', 22.00, 'assets/images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', 140, 15, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 12, 3),
('p02', 'Mustela Solaire Lait très haute Protection', 'Lait solaire SPF 50+ pour bébés et enfants.', 17.50, 'assets/images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', 100, 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 13, 2),
('p03', 'Isdin Eryfotona aAK fluid', 'Fluide protecteur solaire haute technologie.', 29.00, 'assets/images/isdin-eryfotona-aak-fluid-100-50ml.jpg', 45, 5, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 14, 2),
('p04', 'La Roche Posay Anthélios 50+ Brume Visage', 'Brume solaire visage toucher sec.', 8.75, 'assets/images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', 85, 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 7, 1),
('p05', 'Nuxe Sun Huile Lactée Capillaire Protectrice', 'Huile lactée protectrice pour les cheveux au soleil.', 15.00, 'assets/images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', 65, 5, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 5, 2),
('p06', 'Uriage Bariésun stick lèvres SPF30 4g', 'Stick lèvres protecteur SPF 30.', 5.65, 'assets/images/uriage-bariesun-stick-levres-spf30-4g.jpg', 180, 20, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 15, 5),
('p07', 'Bioderma Cicabio creme SPF50+ 30ml', 'Crème réparatrice avec protection solaire.', 13.70, 'assets/images/bioderma-cicabio-creme-spf50-30ml.png', 95, 10, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'PS', 16, 2);

COMMIT;
