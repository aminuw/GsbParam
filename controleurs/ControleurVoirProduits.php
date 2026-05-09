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
        $lesCategories = $this->modeleFront->getLesCategories();

        include("vues/v_choixCategorie.php");
        include("vues/v_produits.php");
    }

    public function voirTousProduits()
    {
        $idCateg = $_POST['lstCategorie'] ?? null;
        $prixMin = $_POST['txtPrixMin'] ?? null;
        $prixMax = $_POST['txtPrixMax'] ?? null;
        $idMarque = $_POST['lstMarque'] ?? null;
        $erreurFiltre = null;

        // On nettoie les valeurs pour éviter les erreurs avec les chaînes vides
        if ($prixMin === "") $prixMin = null;
        if ($prixMax === "") $prixMax = null;

        // Vérification des prix négatifs
        if (($prixMin !== null && $prixMin < 0) || ($prixMax !== null && $prixMax < 0)) {
            $erreurFiltre = "Les prix ne peuvent pas être négatifs.";
            $prixMin = null;
            $prixMax = null;
        }

        $lesProduits = $this->modeleFront->getProduitsFiltres($idCateg, $prixMin, $prixMax, $idMarque);
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        include("vues/v_choixCategorie.php");
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
        $lesProduitsAssocies = $this->modeleFront->getProduitsAssocies($idProduit);
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