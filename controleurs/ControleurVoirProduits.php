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
class ControleurVoirProduits
{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }
    /**
     * Affiche les produits
     *
     * si $categ contient un idCategorie affiche les produits d'une catégorie
     * @param $categ un identifiant de la catégorie de produits à afficher
     */
    public function voirProduits($categ)
    {
        $lesProduits = $this->modeleFront->getLesProduitsDeCategorie($categ);
        $laCategorie = $this->modeleFront->getLesInfosCategorie($categ);
        // var_dump($laCategorie);
        $lesCategories = $this->modeleFront->getLesCategories();

        include("vues/v_choixCategorie.php");
        include("vues/v_produits.php");
    }

    public function voirTousProduits()
    {
        $lesProduits = $this->modeleFront->getTousLesProduits();
        $lesCategories = $this->modeleFront->getLesCategories();
        include("vues/v_produits.php");
    }
    /**
     * Affiche le menu à gauche contenant les catégories
     */



    public function voirAvis($idProduit)
    {
        $leProduit = $this->modeleFront->getUnProduit($idProduit);
        $lesAvis = $this->modeleFront->getAvisByProduit($idProduit);
        $noteMoyenne = $this->modeleFront->getNoteMoyenneProduit($idProduit);
        include("vues/v_avis.php");
    }

    public function validerAvis()
    {
        $idProduit = $_POST['idProduit'];
        $note = $_POST['note'];
        $commentaire = $_POST['commentaire'];

        if (isset($_SESSION['client'])) {
            $idClient = $_SESSION['client']->idClient;
            $this->modeleFront->ajouterAvis($note, $commentaire, $idClient, $idProduit);
            echo '<script>window.location.href = "index.php?uc=voirProduits&action=voirAvis&produit=' . $idProduit . '";</script>';
            exit();
        } else {
            echo '<script>window.location.href = "index.php?uc=utilisateur&action=connexion";</script>';
            exit();
        }
    }
}
?>