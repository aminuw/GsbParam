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
			$req = 'select id, libelle from categorie';
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
			$req = 'SELECT id, libelle FROM categorie WHERE id=:idCategorie';
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
			$req = 'select id, description, prix, image, idCategorie from produit where idCategorie =:idCategorie';
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
			$req = 'select id, description, prix, image, idCategorie from produit';
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
					$req = 'select id, description, prix, image, idCategorie from produit where id = "' . $unIdProduit . '"';
					$res = $this->executerRequete($req);
					$unProduit = $res->fetch(PDO::FETCH_OBJ);
					$lesProduits[] = $unProduit;
				}
			} else // on souhaite tous les produits
			{
				$req = 'select id, description, prix, image, idCategorie from produit;';
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
			$hashedMdp = password_hash($mdp, PASSWORD_DEFAULT);
			$req = 'INSERT INTO utilisateur (nom, prenom, mail, mdp, rue, ville, cp) VALUES (:nom, :prenom, :mail, :mdp, :rue, :ville, :cp)';
			$tab = array(
				'nom' => $nom,
				'prenom' => $prenom,
				'mail' => $email,
				'mdp' => $hashedMdp,
				'rue' => $rue,
				'ville' => $ville,
				'cp' => $cp
			);
			$res = $this->executerRequete($req, $tab);
			return $res;
		} catch (PDOException $e) {
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
			$req = 'SELECT * FROM utilisateur WHERE mail = :mail';
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
			$reqMaxId = "SELECT MAX(id) AS maxId FROM commande";
			$resMaxId = $this->executerRequete($reqMaxId);
			$rowMaxId = $resMaxId->fetch(PDO::FETCH_OBJ);
			$lastId = $rowMaxId->maxId;

			if ($lastId === null) {
				$idCommande = 1;
			} else {
				$idCommande = $lastId + 1;
			}
			$date = date('Y-m-d H:i:s');
			$req = "INSERT INTO commande(id, idClient, dateCommande) VALUES (:id, :idClient, :date)";
			$tab = array('id' => $idCommande, 'idClient' => $idClient, 'date' => $date);
			$this->executerRequete($req, $tab);

			foreach ($lesIdProduit as $unIdProduit) {
				$qte = $lesQuantites[$unIdProduit] ?? 1;
				$req = "INSERT INTO contenir (idCommande, idProduit, qte) VALUES (:idCommande, :idProduit, :qte)";
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
			$req = 'INSERT INTO categorie (id, libelle) VALUES (:id, :libelle)';
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

	public function creerProduit($id, $description, $prix, $image, $idCategorie)
	{
		$req = "INSERT INTO produit (id, description, prix, image, idCategorie) VALUES (:id, :description, :prix, :image, :idCategorie)";
		$tab = array(
			'id' => $id, 
			'description' => $description, 
			'prix' => $prix, 
			'image' => $image, 
			'idCategorie' => $idCategorie
		);
		$this->executerRequete($req, $tab);
	}

	public function getUnProduit($id)
	{
		$req = "SELECT * FROM produit WHERE id=:id";
		$tab = array('id' => $id);
		$res = $this->executerRequete($req, $tab);
		return $res->fetch(PDO::FETCH_OBJ);
	}

	public function modifierProduit($id, $description, $prix, $image, $idCategorie)
	{
		$req = "UPDATE produit SET description = :description, prix = :prix, image = :image, idCategorie = :idCategorie WHERE id = :id";
		$tab = array(
			'id' => $id, 
			'description' => $description, 
			'prix' => $prix, 
			'image' => $image, 
			'idCategorie' => $idCategorie
		);
		$this->executerRequete($req, $tab);
	}

}
?>