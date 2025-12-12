<?php
/**
 * Mission GsbParam PHP Objet
 * 
 * @file ControleurGererPanier.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @brief contient les fonctions pour gérer le panier

 * regroupe les fonctions pour gérer le panier, et les erreurs de saisie dans le formulaire de commande
*/
/**
 * @class ControleurGererPanier
 * @brief contient les fonctions pour gérer le panier
 */
class ControleurGererPanier
{
	private $modeleFront;

	public function __construct()
	{
		$this->modeleFront = new ModeleFront();
		$this->initPanier();
	}
	/**
	 * Initialise le panier
	 *
	 * Crée un tableau $_SESSION['produits'] en session dans le cas
	 * où il n'existe pas déjà
	 */
	function initPanier()
	{
		if (!isset($_SESSION['produits'])) {
			$_SESSION['produits'] = array();

		}
	}	/**

  * Voir le panier
  *
  * permet d'afficher les produits contenus dans le panier
  * leur descriptif est récupéré grâce à chaque id par getLesProduitsDuTableau()
 */
	function voirPanier()
	{
		$n = $this->nbProduitsDuPanier();
		if ($n > 0) {
			$desIdProduit = $this->getLesIdProduitsDuPanier();
			$lesProduitsDuPanier = $this->modeleFront->getLesProduitsDuTableau($desIdProduit);
			$qteProduits = $this->getQte();
			include("vues/v_panier.php");
		} else {
			$message = "Le panier est vide !";
			include("vues/v_message.php");
		}
	}
	/**
	 * Retourne la quantité de chaque produit dans le panier
	 *
	 * @return array $qte tableau associatif idProduit => quantité
	 */
	function getQte()
	{
		return $_SESSION['produits'];
	}
	/**
	 * Vide le panier
	 *
	 * Supprime le tableau $_SESSION['produits']
	 */
	function viderPanier()
	{
		unset($_SESSION['produits']);
		$this->voirPanier();
	}
	/**
	 * Ajoute un produit au panier
	 *
	 * Teste si le produit est déjà dans la variable session 
	 * ajoute le produit à la variable de session dans le cas où
	 * où le produit n'a pas été trouvé

	* @param Produit $idProduit Le produit à ajouter au panier 
	*/
	function ajouterAuPanier($idProduit)
	{
		if (isset($_SESSION['produits'][$idProduit])) {
			$_SESSION['produits'][$idProduit]++;
		} else {
			$_SESSION['produits'][$idProduit] = 1;
		}
		$this->voirPanier();
	}

	function supprimerUnProduit($idProduit)
	{
		if (isset($_SESSION['produits'][$idProduit])) {
			unset($_SESSION['produits'][$idProduit]);
		} else {
			$msgErreurs[] = 'Ce produit ne peut pas être supprimé.';
			include("vues/v_erreurs.php");
		}
		$this->voirPanier();

	}
	/**
	 * Retourne les produits du panier
	 *
	 * Retourne le tableau des identifiants de modeleFront

	* @return array $_SESSION['produits'] le tableau des id produits du panier 
	*/
	function getLesIdProduitsDuPanier()
	{
		return array_keys($_SESSION['produits']);

	}
	/**
	 * Retourne le nombre de produits du panier
	 *
	 * Teste si la variable de session existe
	 * et retourne le nombre d'éléments de la variable session

	* @return int $n
	*/
	function nbProduitsDuPanier()
	{
		$n = 0;
		if (isset($_SESSION['produits'])) {
			$n = count($_SESSION['produits']);
		}
		return $n;
	}
	/**
	 * Affiche le formulaire de commande
	 */
	function passerCommande()
	{
		$n = $this->nbProduitsDuPanier();
		if ($n > 0) {
			if (isset($_SESSION['client'])) {
				$client = $_SESSION['client'];
				$nom = $client->nom . ' ' . $client->prenom;
				$rue = $client->rue;
				$ville = $client->ville;
				$cp = $client->cp;
				$mail = $client->mail;
				include("vues/v_commande.php");
			} else {
				$erreurs[] = "Vous devez être connecté pour passer une commande.";
				include("vues/v_connexion.php");
			}
		} else {
			$message = "Votre panier est vide !";
			include("vues/v_message.php");
		}
	}
	/**
	 * Traite les informations du formulaire de commande
	 *
	 * si les informations sont OK : enregistre la commande et son contenu
	 * sinon affiche les erreurs de saisie et le formulaire vide
	 */
	function confirmerCommande()
	{
		if (isset($_SESSION['client'])) {
			$idClient = $_SESSION['client']->id;
			$lesIdProduits = $this->getLesIdProduitsDuPanier();
			$lesQuantites = $this->getQte();

			$resultat = $this->modeleFront->creerCommande($idClient, $lesIdProduits, $lesQuantites);

			if ($resultat['success']) {
				$message = "La commande a été enregistrée avec succès. Merci de votre visite !";
				$messageType = "success";
				$this->supprimerPanier();
			} else {
				$message = "Échec de l'enregistrement de la commande. " . $resultat['message'];
				$messageType = "error";
			}
			include("vues/v_message.php");
		} else {
			// Sécurité : si l'utilisateur n'est pas connecté, on le redirige.
			header('Location: index.php?uc=utilisateur&action=connexion');
		}
	}
	/**
	 * Supprime le panier
	 *
	 * Supprime le tableau $_SESSION['produits']
	 */
	function supprimerPanier()
	{
		unset($_SESSION['produits']);
	}

	function modifierQuantiteProduit($idProduit, $qte)
	{
		if (isset($_SESSION['produits'][$idProduit])) {
			if ($qte > 0) {
				$_SESSION['produits'][$idProduit] = $qte;
			} else {
				unset($_SESSION['produits'][$idProduit]);
			}
		}
		$this->voirPanier();
	}
	/**
	 * teste si une chaîne a un format de code postal
	 *
	 * Teste le nombre de caractères de la chaîne et le type entier (composé de chiffres)

	* @param string $codePostal  la chaîne testée
	* @return boolean $ok vrai ou faux
	*/
	function estUnCp($codePostal)
	{
		return strlen($codePostal) == 5 && $this->estEntier($codePostal);
	}
	/**
	 * teste si une chaîne est un entier
	 *
	 * Teste si la chaîne ne contient que des chiffres

	* @param string $valeur la chaîne testée
	* @return boolean $ok vrai ou faux
	*/

	function estEntier($valeur)
	{
		return preg_match("/[^0-9]/", $valeur) == 0;
	}
	/**
	 * Teste si une chaîne a le format d'un mail
	 *
	 * Utilise les expressions régulières

	* @param string $mail la chaîne testée
	* @return boolean $ok vrai ou faux
	*/
	function estUnMail($mail)
	{
		return preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $mail);
	}
	/**
	 * Retourne un tableau d'erreurs de saisie pour une commande
	 *
	 * @param string $nom  chaîne testée
	 * @param  string $rue chaîne
	 * @param string $ville chaîne
	 * @param string $cp chaîne
	 * @param string $mail  chaîne 
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	 */
	function getErreursSaisieCommande($nom, $rue, $ville, $cp, $mail)
	{
		$lesErreurs = array();
		if ($nom == "") {
			$lesErreurs[] = "Il faut saisir le champ nom";
		}
		if ($rue == "") {
			$lesErreurs[] = "Il faut saisir le champ rue";
		}
		if ($ville == "") {
			$lesErreurs[] = "Il faut saisir le champ ville";
		}
		if ($cp == "") {
			$lesErreurs[] = "Il faut saisir le champ code postal";
		} else {
			if (!$this->estUnCp($cp)) {
				$lesErreurs[] = "erreur de code postal";
			}
		}
		if ($mail == "") {
			$lesErreurs[] = "Il faut saisir le champ mail";
		} else {
			if (!$this->estUnMail($mail)) {
				$lesErreurs[] = "erreur de mail";
			}
		}
		return $lesErreurs;
	}
}