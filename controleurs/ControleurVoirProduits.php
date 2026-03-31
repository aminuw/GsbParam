<?php
/**
 * @file ControleurVoirProduits.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @details contient les fonctions pour voir les produits

 * regroupe les fonctions pour voir les produits
 */
/**
 * @class ControleurVoirProduits
 * @brief contient les fonctions pour gérer l'affichage des produits
 */
class ControleurVoirProduits{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront=new ModeleFront();
    }
	/**
	 * Affiche les produits
	 *
	 * si $categ contient un idCategorie affiche les produits d'une catégorie
	 * @param $categ un identifiant de la catégorie de produits à afficher
	*/
    public function voirProduits($categ){
		$lesProduits=$this->modeleFront->getLesProduitsDeCategorie($categ);
        $laCategorie=$this->modeleFront->getLesInfosCategorie($categ);
       // var_dump($laCategorie);
        $lesCategories=$this->modeleFront->getLesCategories();
        
        include("vues/v_choixCategorie.php");
        include("vues/v_produits.php");
    }

    public function voirTousProduits(){
        $lesProduits=$this->modeleFront->getTousLesProduits();
        $lesCategories=$this->modeleFront->getLesCategories();
        include("vues/v_produits.php");
    }
	/**
	 * Affiche le menu à gauche contenant les catégories
	*/
    public function voirCategories(){
		$lesCategories=$this->modeleFront->getLesCategories();
        include("vues/v_choixCategorie.php");
	}

    
    public function ajouterCategorie(){
        include("vues/v_ajouterCategorie.php");
    }

    public function validerAjoutCategorie(){
        $id = $_POST['id'] ?? '';
        $libelle = $_POST['libelle'] ?? '';

        $erreurs = array();
        if (empty($id) || strlen($id) > 3) {
            $erreurs[] = "L'identifiant doit comporter entre 1 et 3 caractères.";
        }
        if (empty($libelle)) {
            $erreurs[] = "Le libellé ne peut pas être vide.";
        }

        if (count($erreurs) == 0) {
            $resultat = $this->modeleFront->creerCategorie($id, $libelle);
            if ($resultat) {
                $message = "La catégorie a été ajoutée avec succès !";
                $lesCategories = $this->modeleFront->getLesCategories();
                include("vues/v_choixCategorie.php");
            } else {
                $erreurs[] = "Une erreur est survenue lors de l'ajout. L'identifiant est peut-être déjà utilisé.";
                include("vues/v_ajouterCategorie.php");
            }
        } else {
            include("vues/v_ajouterCategorie.php");
        }
    }
}

?>

