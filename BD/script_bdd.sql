-- ----------------------------------------------------------
-- Script MYSQL pour mcd 
-- ----------------------------------------------------------


-- ----------------------------
-- Table: categorie
-- ----------------------------
CREATE TABLE categorie (
  idCateg CHAR(3) NOT NULL,
  libelle VARCHAR(50) NOT NULL,
  CONSTRAINT categorie_PK PRIMARY KEY (idCateg)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: unite
-- ----------------------------
CREATE TABLE unite (
  idUnite INT NOT NULL,
  libelle VARCHAR(50) NOT NULL,
  CONSTRAINT unite_PK PRIMARY KEY (idUnite)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: login
-- ----------------------------
CREATE TABLE login (
  idLogin INT NOT NULL,
  mdp VARCHAR(150) NOT NULL,
  role SMALLINT NOT NULL,
  CONSTRAINT login_PK PRIMARY KEY (idLogin)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: etat_commande
-- ----------------------------
CREATE TABLE etat_commande (
  idEtat INT NOT NULL,
  libelle VARCHAR(50) NOT NULL,
  CONSTRAINT etat_commande_PK PRIMARY KEY (idEtat)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: marque
-- ----------------------------
CREATE TABLE marque (
  idMarque INT NOT NULL,
  libelleMarque VARCHAR(30) NOT NULL,
  CONSTRAINT marque_PK PRIMARY KEY (idMarque)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: produit
-- ----------------------------
CREATE TABLE produit (
  idproduit VARCHAR(5) NOT NULL,
  nom VARCHAR(100) NOT NULL,
  description TEXT,
  prix DECIMAL(10,2),
  image CHAR(100),
  quantiteStock INT NOT NULL,
  seuil_rupture INT NOT NULL,
  mis_en_avant_date_debut DATE NOT NULL,
  mis_en_avant_date_fin DATE NOT NULL,
  idCateg CHAR(3) NOT NULL,
  idMarque INT NOT NULL,
  idUnite INT NOT NULL,
  CONSTRAINT produit_PK PRIMARY KEY (idproduit),
  CONSTRAINT produit_idCateg_FK FOREIGN KEY (idCateg) REFERENCES categorie (idCateg),
  CONSTRAINT produit_idMarque_FK FOREIGN KEY (idMarque) REFERENCES marque (idMarque),
  CONSTRAINT produit_idUnite_FK FOREIGN KEY (idUnite) REFERENCES unite (idUnite)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: client
-- ----------------------------
CREATE TABLE client (
  idClient INT NOT NULL,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100),
  rue VARCHAR(255),
  cp VARCHAR(10),
  ville VARCHAR(100),
  idLogin INT NOT NULL,
  CONSTRAINT client_PK PRIMARY KEY (idClient),
  CONSTRAINT client_idLogin_FK FOREIGN KEY (idLogin) REFERENCES login (idLogin)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: avis
-- ----------------------------
CREATE TABLE avis (
  idAvis INT NOT NULL,
  note INT NOT NULL,
  commentaire VARCHAR(255) NOT NULL,
  date_avis DATETIME NOT NULL,
  idClient INT NOT NULL,
  idproduit VARCHAR(5) NOT NULL,
  CONSTRAINT avis_PK PRIMARY KEY (idAvis),
  CONSTRAINT avis_idClient_FK FOREIGN KEY (idClient) REFERENCES client (idClient),
  CONSTRAINT avis_idproduit_FK FOREIGN KEY (idproduit) REFERENCES produit (idproduit)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: associer
-- ----------------------------
CREATE TABLE associer (
  idproduit VARCHAR(5) NOT NULL,
  idproduit_associer VARCHAR(5) NOT NULL,
  CONSTRAINT associer_PK PRIMARY KEY (idproduit, idproduit_associer),
  CONSTRAINT associer_idproduit_FK FOREIGN KEY (idproduit) REFERENCES produit (idproduit),
  CONSTRAINT associer_idproduit_associer_FK FOREIGN KEY (idproduit_associer) REFERENCES produit (idproduit)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: commande
-- ----------------------------
CREATE TABLE commande (
  idCommande VARCHAR(32) NOT NULL,
  dateCommande DATETIME,
  idClient INT NOT NULL,
  idEtat INT NOT NULL,
  CONSTRAINT commande_PK PRIMARY KEY (idCommande),
  CONSTRAINT commande_idClient_FK FOREIGN KEY (idClient) REFERENCES client (idClient),
  CONSTRAINT commande_idEtat_FK FOREIGN KEY (idEtat) REFERENCES etat_commande (idEtat)
)ENGINE=InnoDB;


-- ----------------------------
-- Table: contenir
-- ----------------------------
CREATE TABLE contenir (
  idproduit VARCHAR(5) NOT NULL,
  idCommande VARCHAR(32) NOT NULL,
  qte INT NOT NULL,
  CONSTRAINT contenir_PK PRIMARY KEY (idproduit, idCommande),
  CONSTRAINT contenir_idproduit_FK FOREIGN KEY (idproduit) REFERENCES produit (idproduit),
  CONSTRAINT contenir_idCommande_FK FOREIGN KEY (idCommande) REFERENCES commande (idCommande)
)ENGINE=InnoDB;

ALTER TABLE login ADD mail VARCHAR(255) NOT NULL;
ALTER TABLE login ADD CONSTRAINT mail_login_UNQ UNIQUE (mail);
