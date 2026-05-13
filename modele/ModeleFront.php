<?php
/** 
 * Mission : architecture MVC GsbParam

 * @file ModeleFront.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @details contient les fonctions d'accès BD pour le FrontEnd
 */
require_once 'modele/Modele.php';
/**
 * @class ModeleFront
 * @brief contient les fonctions d'accès aux infos de la BD pour les utilisateurs
 */
class ModeleFront extends Modele
{
	/**
	 * Retourne toutes les catégories 
	 *
	 * @return array $lesLignes le tableau des catégories (tableau d'objets)
	 */
	public function getLesCategories()
	{
		try {
			$req = 'select idCateg as id, libelle from categorie';
			$res = $this->executerRequete($req);
			$lesLignes = $res->fetchAll(PDO::FETCH_OBJ);
			return $lesLignes;
		} catch (PDOException $e) {
			throw $e;
		}
	}
	/**
	 * Retourne toutes les informations d'une catégorie passée en paramètre
	 *
	 * @param string $idCategorie l'id de la catégorie
	 * @return object $laLigne la catégorie (objet)
	 */
	public function getLesInfosCategorie($idCategorie)
	{
		try {
			$req = 'SELECT idCateg AS id, libelle FROM categorie WHERE idCateg=:idCategorie';
			$tab = array('idCategorie' => $idCategorie);
			$res = $this->executerRequete($req, $tab);
			$laLigne = $res->fetch(PDO::FETCH_OBJ);
			return $laLigne;
		} catch (PDOException $e) {
			throw $e;
		}
	}
	/**
	 * Retourne sous forme d'un tableau tous les produits de la
	 * catégorie passée en argument
	 * 
	 * @param string $idCategorie  l'id de la catégorie dont on veut les produits
	 * @return array $lesLignes un tableau des produits de la categ passée en paramètre (tableau d'objets)
	 */

	public function getLesProduitsDeCategorie($idCategorie)
	{
		try {
			$req = 'SELECT idproduit AS id, nom, description, prix, image, quantiteStock, seuil_rupture, mis_en_avant_date_debut, mis_en_avant_date_fin, idCateg AS idCategorie, idMarque, idUnite FROM produit WHERE idCateg =:idCategorie';
			$tab = array('idCategorie' => $idCategorie);
			$res = $this->executerRequete($req, $tab);
			$lesLignes = $res->fetchAll(PDO::FETCH_OBJ);
			return $lesLignes;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	public function getTousLesProduits()
	{
		try {
			$req = 'SELECT idproduit AS id, nom, description, prix, image, quantiteStock, seuil_rupture, mis_en_avant_date_debut, mis_en_avant_date_fin, idCateg AS idCategorie, idMarque, idUnite FROM produit';
			$res = $this->executerRequete($req);
			$lesLignes = $res->fetchAll(PDO::FETCH_OBJ);
			return $lesLignes;
		} catch (PDOException $e) {
			throw $e;
		}
	}
	/**
	 * Retourne les produits concernés par le tableau des idProduits passé en argument (si null retourne tous les produits)
	 *
	 * @param array $desIdsProduit tableau d'idProduits
	 * @return array $lesProduits un tableau contenant les infos des produits dont les id ont été passé en paramètre
	 */
	public function getLesProduitsDuTableau($desIdsProduit = null)
	{
		try {
			$lesProduits = array();
			if ($desIdsProduit != null) {
				foreach ($desIdsProduit as $unIdProduit) {
					$req = 'SELECT idproduit AS id, nom, description, prix, image, idCateg AS idCategorie FROM produit WHERE idproduit = :idProduit';
					$res = $this->executerRequete($req, array('idProduit' => $unIdProduit));
					$unProduit = $res->fetch(PDO::FETCH_OBJ);
					$lesProduits[] = $unProduit;
				}
			} else // on souhaite tous les produits
			{
				$req = 'SELECT idproduit AS id, nom, description, prix, image, idCateg AS idCategorie FROM produit;';
				$res = $this->executerRequete($req);
				$lesProduits = $res->fetchAll(PDO::FETCH_OBJ);
			}
			return $lesProduits;
		} catch (PDOException $e) {
			throw $e;
		}
	}
	/**
	 * Crée un client
	 *
	 * @param string $nom
	 * @param string $prenom
	 * @param string $email
	 * @param string $mdp
	 * @param string $adresse
	 * @param string $ville
	 * @param string $cp
	 * @return PDOStatement|false
	 */
	public function creerClient($nom, $prenom, $email, $mdp, $rue, $ville, $cp)
	{
		try {
			$this->beginTransaction();
			$hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);

			// Generate idLogin since there is no AUTO_INCREMENT
			$resMaxLogin = $this->executerRequete('SELECT MAX(idLogin) as maxId FROM login');
			$rowMaxLogin = $resMaxLogin->fetch(PDO::FETCH_OBJ);
			$idLogin = ($rowMaxLogin->maxId === null) ? 1 : $rowMaxLogin->maxId + 1;

			// 1. Insert into login
			$reqLogin = 'INSERT INTO login (idLogin, mail, mdp, role) VALUES (:idLogin, :mail, :mdp, 1)';
			$this->executerRequete($reqLogin, array('idLogin' => $idLogin, 'mail' => $email, 'mdp' => $hashedMdp));

			// Generate idClient since there is no AUTO_INCREMENT
			$resMaxClient = $this->executerRequete('SELECT MAX(idClient) as maxId FROM client');
			$rowMaxClient = $resMaxClient->fetch(PDO::FETCH_OBJ);
			$idClient = ($rowMaxClient->maxId === null) ? 1 : $rowMaxClient->maxId + 1;

			// 2. Insert into client
			$reqClient = 'INSERT INTO client (idClient, nom, prenom, rue, ville, cp, idLogin) VALUES (:idClient, :nom, :prenom, :rue, :ville, :cp, :idLogin)';
			$tab = array(
				'idClient' => $idClient,
				'nom' => $nom,
				'prenom' => $prenom,
				'rue' => $rue,
				'ville' => $ville,
				'cp' => $cp,
				'idLogin' => $idLogin
			);
			$res = $this->executerRequete($reqClient, $tab);
			$this->commit();
			return $res;
		} catch (PDOException $e) {
			$this->rollBack();
			throw $e;
		}
	}

	/**
	 * Récupère un client par son email
	 *
	 * @param string $mail
	 * @return object|false
	 */
	public function getUnClientByMail($mail)
	{
		try {
			$req = 'SELECT l.idLogin, l.mail, l.mdp, l.role, c.idClient, c.nom, c.prenom, c.rue, c.cp, c.ville FROM login l JOIN client c ON l.idLogin = c.idLogin WHERE l.mail = :mail';
			$tab = array('mail' => $mail);
			$res = $this->executerRequete($req, $tab);
			$client = $res->fetch(PDO::FETCH_OBJ);
			return $client;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Crée une commande 
	 *
 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
 * tableau d'idProduit passé en paramètre
 * @param string $nom nom du client
 * @param string $rue rue du client
 * @param string $cp cp du client
 * @param string $ville ville du client
 * @param string $mail mail du client
 * @param array $lesIdProduit tableau contenant les id des produits commandés

*/
	public function creerCommande($idClient, $lesIdProduit, $lesQuantites = null)
	{
		try {
			$this->beginTransaction();
			//recuperer la derniere id de commande
			$reqMaxId = "SELECT MAX(CAST(idCommande AS UNSIGNED)) AS maxId FROM commande";
			$resMaxId = $this->executerRequete($reqMaxId);
			$rowMaxId = $resMaxId->fetch(PDO::FETCH_OBJ);
			$lastId = $rowMaxId->maxId;

			if ($lastId === null) {
				$idCommande = 1;
			} else {
				$idCommande = $lastId + 1;
			}
			$date = date('Y-m-d H:i:s');
			$req = "INSERT INTO commande(idCommande, idClient, dateCommande, idEtat) VALUES (:idCommande, :idClient, :date, 1)";
			$tab = array('idCommande' => $idCommande, 'idClient' => $idClient, 'date' => $date);
			$this->executerRequete($req, $tab);

			foreach ($lesIdProduit as $unIdProduit) {
				$qte = $lesQuantites[$unIdProduit] ?? 1;
				$req = "INSERT INTO contenir (idCommande, idproduit, qte) VALUES (:idCommande, :idProduit, :qte)";
				$tab2 = array('idCommande' => $idCommande, 'idProduit' => $unIdProduit, 'qte' => $qte);
				$this->executerRequete($req, $tab2);
			}

			$this->commit();

			return array('success' => true, 'message' => 'Commande enregistrée avec succès.');
		} catch (PDOException $e) {
			$this->rollBack();

			return array('success' => false, 'message' => 'Erreur lors de l\'enregistrement de la commande : ' . $e->getMessage());
		}
	}

	/**
	 * Ajoute une nouvelle catégorie dans la base de données
	 *
	 * @param string $id L'identifiant de la catégorie (3 caractères)
	 * @param string $libelle Le libellé de la catégorie
	 * @return PDOStatement|false
	 */
	public function creerCategorie($id, $libelle)
	{
		try {
			$req = 'INSERT INTO categorie (idCateg, libelle) VALUES (:id, :libelle)';
			$tab = array(
				'id' => $id,
				'libelle' => $libelle
			);
			$res = $this->executerRequete($req, $tab);
			return $res;
		} catch (PDOException $e) {
			throw $e;
		}
	}

	public function getUnProduit($id)
	{
		$req = "SELECT p.idproduit AS id, p.nom, p.description, p.prix, p.image, p.quantiteStock, p.seuil_rupture, 
                       p.mis_en_avant_date_debut, p.mis_en_avant_date_fin, p.idCateg AS idCategorie, 
                       p.idMarque, m.libelleMarque, p.idUnite, u.libelle AS libelleUnite 
                FROM produit p
                INNER JOIN marque m ON p.idMarque = m.idMarque
                INNER JOIN unite u ON p.idUnite = u.idUnite
                WHERE p.idproduit=:id";
		$tab = array('id' => $id);
		$res = $this->executerRequete($req, $tab);
		return $res->fetch(PDO::FETCH_OBJ);
	}

	public function getLesMarques()
	{
		$req = 'SELECT idMarque, libelleMarque FROM marque';
		$res = $this->executerRequete($req);
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	public function getLesUnites()
	{
		$req = 'SELECT idUnite, libelle FROM unite';
		$res = $this->executerRequete($req);
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	public function creerProduit($idproduit, $nom, $description, $prix, $image, $quantiteStock, $seuil_rupture, $mis_en_avant_date_debut, $mis_en_avant_date_fin, $idCateg, $idMarque, $idUnite)
	{
		$req = "INSERT INTO produit (idproduit, nom, description, prix, image, quantiteStock, seuil_rupture, mis_en_avant_date_debut, mis_en_avant_date_fin, idCateg, idMarque, idUnite) 
                VALUES (:idproduit, :nom, :description, :prix, :image, :quantiteStock, :seuil_rupture, :mis_en_avant_date_debut, :mis_en_avant_date_fin, :idCateg, :idMarque, :idUnite)";
		$tab = array(
			'idproduit' => $idproduit,
			'nom' => $nom,
			'description' => $description,
			'prix' => $prix,
			'image' => $image,
			'quantiteStock' => $quantiteStock,
			'seuil_rupture' => $seuil_rupture,
			'mis_en_avant_date_debut' => $mis_en_avant_date_debut,
			'mis_en_avant_date_fin' => $mis_en_avant_date_fin,
			'idCateg' => $idCateg,
			'idMarque' => $idMarque,
			'idUnite' => $idUnite
		);
		$this->executerRequete($req, $tab);
	}

	public function modifierProduit($idproduit, $nom, $description, $prix, $image, $quantiteStock, $seuil_rupture, $mis_en_avant_date_debut, $mis_en_avant_date_fin, $idCateg, $idMarque, $idUnite)
	{
		$req = "UPDATE produit SET nom = :nom, description = :description, prix = :prix, image = :image, quantiteStock = :quantiteStock, seuil_rupture = :seuil_rupture, mis_en_avant_date_debut = :mis_en_avant_date_debut, mis_en_avant_date_fin = :mis_en_avant_date_fin, idCateg = :idCateg, idMarque = :idMarque, idUnite = :idUnite WHERE idproduit = :idproduit";
		$tab = array(
			'idproduit' => $idproduit,
			'nom' => $nom,
			'description' => $description,
			'prix' => $prix,
			'image' => $image,
			'quantiteStock' => $quantiteStock,
			'seuil_rupture' => $seuil_rupture,
			'mis_en_avant_date_debut' => $mis_en_avant_date_debut,
			'mis_en_avant_date_fin' => $mis_en_avant_date_fin,
			'idCateg' => $idCateg,
			'idMarque' => $idMarque,
			'idUnite' => $idUnite
		);
		$this->executerRequete($req, $tab);
	}

	public function supprimerProduit($id)
	{
		$req = "DELETE FROM produit WHERE idproduit=:id";
		$tab = array('id' => $id);
		$this->executerRequete($req, $tab);
	}

	public function modifierCategorie($id, $libelle)
	{
		$req = "UPDATE categorie SET libelle = :libelle WHERE idCateg = :id";
		$tab = array(
			'id' => $id,
			'libelle' => $libelle
		);
		return $this->executerRequete($req, $tab);
	}

	public function supprimerCategorie($id)
	{
		$req = "DELETE FROM categorie WHERE idCateg = :id";
		$tab = array('id' => $id);
		$this->executerRequete($req, $tab);
	}

	public function checkProduitsCateg($idCateg)
	{
		$req = "SELECT COUNT(*) AS nb FROM produit WHERE idCateg = :idCateg";
		$tab = array('idCateg' => $idCateg);
		$res = $this->executerRequete($req, $tab);
		$nb = $res->fetchColumn();
		return $nb;
	}

	public function getAvisByProduit($idProduit)
	{
		$req = "SELECT a.note, a.commentaire, a.date_avis, c.prenom, c.nom FROM avis a JOIN client c ON a.idClient = c.idClient WHERE a.idproduit = :idProduit ORDER BY a.date_avis DESC";
		$tab = array('idProduit' => $idProduit);
		$res = $this->executerRequete($req, $tab);
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	public function getNoteMoyenneProduit($idProduit)
	{
		$req = "SELECT AVG(note) as moyenne FROM avis WHERE idproduit = :idProduit";
		$tab = array('idProduit' => $idProduit);
		$res = $this->executerRequete($req, $tab);
		$moyenne = $res->fetch(PDO::FETCH_OBJ)->moyenne;
		return $moyenne ? round($moyenne, 1) : null;
	}

	public function aDejaDonneAvis($idClient, $idProduit)
	{
		$req = "SELECT COUNT(*) AS nb FROM avis WHERE idClient = :idClient AND idproduit = :idProduit";
		$tab = array('idClient' => $idClient, 'idProduit' => $idProduit);
		$res = $this->executerRequete($req, $tab);
		$nb = $res->fetchColumn();
		return $nb > 0;
	}

	public function ajouterAvis($note, $commentaire, $idClient, $idProduit)
	{
		try {
			if ($this->aDejaDonneAvis($idClient, $idProduit)) {
				throw new Exception("Vous avez déjà donné votre avis sur ce produit.");
			}

			$this->beginTransaction();
			
			$resMaxAvis = $this->executerRequete('SELECT MAX(idAvis) as maxId FROM avis');
			$rowMaxAvis = $resMaxAvis->fetch(PDO::FETCH_OBJ);
			$idAvis = ($rowMaxAvis->maxId === null) ? 1 : $rowMaxAvis->maxId + 1;

			$dateAvis = date('Y-m-d H:i:s');
			$req = 'INSERT INTO avis (idAvis, note, commentaire, date_avis, idClient, idproduit) VALUES (:idAvis, :note, :commentaire, :date_avis, :idClient, :idproduit)';
			$tab = array(
				'idAvis' => $idAvis,
				'note' => $note,
				'commentaire' => $commentaire,
				'date_avis' => $dateAvis,
				'idClient' => $idClient,
				'idproduit' => $idProduit
			);
			
			$res = $this->executerRequete($req, $tab);
			$this->commit();
			return $res;
		} catch (PDOException $e) {
			$this->rollBack();
			throw $e;
		}
	}


	public function getProduitsFiltres($idCateg = null, $prixMin = null, $prixMax = null, $idMarque = null)
	{
		try {
			$req = 'SELECT idproduit AS id, nom, description, prix, image, quantiteStock, seuil_rupture, idCateg AS idCategorie, idMarque, idUnite FROM produit WHERE 1=1';
			$tab = array();

			if ($idCateg && $idCateg != 'tous') {
				$req .= ' AND idCateg = :idCateg';
				$tab['idCateg'] = $idCateg;
			}
			if ($idMarque && $idMarque != 'toutes') {
				$req .= ' AND idMarque = :idMarque';
				$tab['idMarque'] = $idMarque;
			}
			if ($prixMin !== null) {
				$req .= ' AND prix >= :prixMin';
				$tab['prixMin'] = $prixMin;
			}
			if ($prixMax !== null) {
				$req .= ' AND prix <= :prixMax';
				$tab['prixMax'] = $prixMax;
			}

			$req .= ' ORDER BY prix ASC';

			$res = $this->executerRequete($req, $tab);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}
	public function getToutesLesAssociations()
	{
		try {
			$req = 'SELECT a.idproduit, a.idproduit_associer, p1.nom AS nom1, p2.nom AS nom2 
					FROM associer a 
					INNER JOIN produit p1 ON a.idproduit = p1.idproduit
					INNER JOIN produit p2 ON a.idproduit_associer = p2.idproduit';
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne les produits associés à un produit
	 * @param string $idProduit
	 * @return array
	 */
	public function getProduitsAssocies($idProduit)
	{
		try {
			$req = 'SELECT p.idproduit AS id, p.nom, p.prix, p.image 
					FROM produit p 
					INNER JOIN associer a ON p.idproduit = a.idproduit_associer 
					WHERE a.idproduit = :idProduit';
			$res = $this->executerRequete($req, array('idProduit' => $idProduit));
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Ajoute une association entre deux produits
	 * @param string $idProduit
	 * @param string $idAssoc
	 */
	public function ajouterAssociation($idProduit, $idAssoc)
	{
		$req = 'INSERT INTO associer (idproduit, idproduit_associer) VALUES (:idProduit, :idAssoc)';
		$this->executerRequete($req, array('idProduit' => $idProduit, 'idAssoc' => $idAssoc));
	}

	/**
	 * Supprime une association entre deux produits
	 * @param string $idProduit
	 * @param string $idAssoc
	 */
	public function supprimerAssociation($idProduit, $idAssoc)
	{
		try {
			$req = 'DELETE FROM associer WHERE idproduit = :idProduit AND idproduit_associer = :idAssoc';
			$this->executerRequete($req, array('idProduit' => $idProduit, 'idAssoc' => $idAssoc));
		} catch (PDOException $e) {
			throw $e;
		}
	}
	/**
	 * Retourne toutes les commandes triées par ID décroissant
	 * @return array
	 */
	public function getToutesLesCommandes()
	{
		try {
			$req = 'SELECT c.idCommande, c.dateCommande, cl.nom, cl.prenom, e.libelle AS etat, e.idEtat 
					FROM commande c 
					INNER JOIN client cl ON c.idClient = cl.idClient 
					INNER JOIN etat_commande e ON c.idEtat = e.idEtat 
					ORDER BY CAST(c.idCommande AS UNSIGNED) DESC';
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne les articles d'une commande avec les détails produits
	 * @param string $idCommande
	 * @return array
	 */
	public function getArticlesCommande($idCommande)
	{
		try {
			$req = 'SELECT p.idproduit, p.nom, p.prix, m.libelleMarque, cat.libelle AS libelleCateg, co.qte 
					FROM contenir co 
					INNER JOIN produit p ON co.idproduit = p.idproduit 
					INNER JOIN marque m ON p.idMarque = m.idMarque 
					INNER JOIN categorie cat ON p.idCateg = cat.idCateg 
					WHERE co.idCommande = :idCommande';
			$res = $this->executerRequete($req, array('idCommande' => $idCommande));
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne tous les états de commande possibles
	 * @return array
	 */
	public function getTousLesEtats()
	{
		try {
			$req = 'SELECT idEtat, libelle FROM etat_commande';
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Modifie l'état d'une commande
	 * @param string $idCommande
	 * @param int $idEtat
	 */
	public function modifierEtatCommande($idCommande, $idEtat)
	{
		try {
			$req = 'UPDATE commande SET idEtat = :idEtat WHERE idCommande = :idCommande';
			$this->executerRequete($req, array('idCommande' => $idCommande, 'idEtat' => $idEtat));
		} catch (PDOException $e) {
			throw $e;
		}
	}
	/**
	 * Retourne les avis déposés par un client
	 * @param int $idClient
	 * @return array
	 */
	public function getAvisByClient($idClient)
	{
		try {
			$req = 'SELECT a.note, a.commentaire, a.date_avis, p.nom AS nomProduit 
					FROM avis a 
					INNER JOIN produit p ON a.idproduit = p.idproduit 
					WHERE a.idClient = :idClient 
					ORDER BY a.date_avis DESC';
			$res = $this->executerRequete($req, array('idClient' => $idClient));
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne les commandes passées par un client
	 * @param int $idClient
	 * @return array
	 */
	public function getCommandesByClient($idClient)
	{
		try {
			$req = 'SELECT c.idCommande, c.dateCommande, e.libelle AS etat 
					FROM commande c 
					INNER JOIN etat_commande e ON c.idEtat = e.idEtat 
					WHERE c.idClient = :idClient 
					ORDER BY c.dateCommande DESC';
			$res = $this->executerRequete($req, array('idClient' => $idClient));
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Modifie le profil d'un client
	 */
	public function modifierProfil($idClient, $idLogin, $nom, $prenom, $rue, $cp, $ville, $mail)
	{
		try {
			$this->beginTransaction();

			$req1 = 'UPDATE client SET nom = :nom, prenom = :prenom, rue = :rue, cp = :cp, ville = :ville 
					WHERE idClient = :idClient';
			$tab1 = array(
				'idClient' => $idClient,
				'nom' => $nom,
				'prenom' => $prenom,
				'rue' => $rue,
				'cp' => $cp,
				'ville' => $ville
			);
			$this->executerRequete($req1, $tab1);

			$req2 = 'UPDATE login SET mail = :mail WHERE idLogin = :idLogin';
			$tab2 = array('idLogin' => $idLogin, 'mail' => $mail);
			$this->executerRequete($req2, $tab2);
			
			$this->commit();
		} catch (PDOException $e) {
			$this->rollBack();
			throw $e;
		}
	}

	/**
	 * Retourne les produits dont le stock est inférieur ou égal au seuil de rupture
	 * @return array
	 */
	public function getProduitsStockCritique()
	{
		try {
			$req = 'SELECT idproduit AS id, nom, description, prix, image, quantiteStock, seuil_rupture, mis_en_avant_date_debut, mis_en_avant_date_fin, idCateg AS idCategorie, idMarque, idUnite 
					FROM produit 
					WHERE quantiteStock <= seuil_rupture 
					ORDER BY quantiteStock ASC';
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne les produits actuellement mis en avant (date du jour comprise dans la période)
	 */
	public function getProduitsEnAvant()
	{
		try {
			$req = 'SELECT idproduit AS id, nom, prix, image, mis_en_avant_date_debut, mis_en_avant_date_fin
					FROM produit
					WHERE mis_en_avant_date_debut IS NOT NULL
					  AND mis_en_avant_date_fin IS NOT NULL
					  AND CURDATE() BETWEEN mis_en_avant_date_debut AND mis_en_avant_date_fin';
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Supprime (réinitialise à NULL) les programmations dont la date de fin est dépassée
	 */
	public function supprimerProgrammationsExpirees()
	{
		try {
			$req = 'UPDATE produit SET mis_en_avant_date_debut = NULL, mis_en_avant_date_fin = NULL
					WHERE mis_en_avant_date_fin IS NOT NULL AND mis_en_avant_date_fin < CURDATE()';
			$this->executerRequete($req);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Retourne la liste de tous les produits ayant une programmation de mise en avant (actuelle ou future)
	 */
	public function getLesProgrammations()
	{
		try {
			$req = 'SELECT idproduit AS id, nom, image, mis_en_avant_date_debut, mis_en_avant_date_fin
					FROM produit
					WHERE mis_en_avant_date_debut IS NOT NULL
					ORDER BY mis_en_avant_date_debut ASC';
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Crée ou met à jour la programmation de mise en avant pour un produit
	 */
	public function creerPromotion($idProduit, $dateDebut, $dateFin)
	{
		try {
			$req = 'UPDATE produit SET mis_en_avant_date_debut = :dateDebut, mis_en_avant_date_fin = :dateFin
					WHERE idproduit = :id';
			$tab = array('id' => $idProduit, 'dateDebut' => $dateDebut, 'dateFin' => $dateFin);
			$this->executerRequete($req, $tab);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Supprime la programmation de mise en avant d'un produit (remet les dates à NULL)
	 */
	public function supprimerPromotion($idProduit)
	{
		try {
			$req = 'UPDATE produit SET mis_en_avant_date_debut = NULL, mis_en_avant_date_fin = NULL
					WHERE idproduit = :id';
			$tab = array('id' => $idProduit);
			$this->executerRequete($req, $tab);
		} catch (PDOException $e) {
			throw $e;
		}
	}
}
?>