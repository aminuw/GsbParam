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
			print "Erreur !: " . $e->getMessage();
			die();
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
			print "Erreur !: " . $e->getMessage();
			die();
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
			print "Erreur !: " . $e->getMessage();
			die();
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
			print "Erreur !: " . $e->getMessage();
			die();
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
					$req = 'SELECT idproduit AS id, nom, description, prix, image, idCateg AS idCategorie FROM produit WHERE idproduit = "' . $unIdProduit . '"';
					$res = $this->executerRequete($req);
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
			print "Erreur !: " . $e->getMessage();
			die();
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
			print "Erreur !: " . $e->getMessage();
			die();
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
			print "Erreur !: " . $e->getMessage();
			die();
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
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	public function getUnProduit($id)
	{
		$req = "SELECT idproduit AS id, nom, description, prix, image, quantiteStock, seuil_rupture, mis_en_avant_date_debut, mis_en_avant_date_fin, idCateg AS idCategorie, idMarque, idUnite FROM produit WHERE idproduit=:id";
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
		$this->executerRequete($req, $tab);
	}

	public function supprimerCategorie($id)
	{
		$req = "DELETE FROM categorie WHERE idCateg = :id";
		$tab = array('id' => $id);
		$this->executerRequete($req, $tab);
	}

}
?>