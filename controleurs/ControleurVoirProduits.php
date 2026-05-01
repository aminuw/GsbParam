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


    public function ajouterProduit()
    {
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        $lesUnites = $this->modeleFront->getLesUnites();
        include("vues/v_ajouterProduit.php");
    }

    public function validerAjoutProduit()
    {
        $id = $_POST['id'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $image = $_POST['image'];
        $quantiteStock = $_POST['quantiteStock'];
        $seuil_rupture = $_POST['seuil_rupture'];
        $mis_en_avant_date_debut = $_POST['mis_en_avant_date_debut'];
        $mis_en_avant_date_fin = $_POST['mis_en_avant_date_fin'];
        $idCateg = $_POST['idCateg'];
        $idMarque = $_POST['idMarque'];
        $idUnite = $_POST['idUnite'];

        $this->modeleFront->creerProduit($id, $description, $prix, $image, $idCategorie);

        echo "<p>Produit ajouté avec succès !</p>";
        $this->listeProduitsModif();
    }

    public function listeProduitsModif()
    {
        // 1. On récupère la liste pour l'afficher
        $lesProduits = $this->modeleFront->getTousLesProduits();
        include("vues/v_listeProduitsModif.php");
    }

    public function modifierProduit()
    {
        // 2. On affiche le formulaire avec les valeurs existantes
        $id = $_REQUEST['id']; // vient du lien de v_listeProduitsModif
        $leProduit = $this->modeleFront->getUnProduit($id);
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        $lesUnites = $this->modeleFront->getLesUnites();
        include("vues/v_modifierProduit.php");
    }

    public function validerModifProduit()
    {
        // 3. On enregistre en base les nouvelles données
        $idproduit = $_POST['idproduit'];
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $image = $_POST['image'];
        $quantiteStock = $_POST['quantiteStock'];
        $seuil_rupture = $_POST['seuil_rupture'];
        $mis_en_avant_date_debut = $_POST['mis_en_avant_date_debut'];
        $mis_en_avant_date_fin = $_POST['mis_en_avant_date_fin'];
        $idCateg = $_POST['idCateg'];
        $idMarque = $_POST['idMarque'];
        $idUnite = $_POST['idUnite'];

        $this->modeleFront->modifierProduit($id, $description, $prix, $image, $idCategorie);


        echo "<p>Produit mis à jour avec succès !</p>";
        $this->listeProduitsModif();
    }

    public function supprimerProduit()
    {
        $id = $_GET['id'];
        $this->modeleFront->supprimerProduit($id);

        echo "<p>Produit supprimé avec succès !</p>";
        $this->listeProduitsModif();
    }

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
            echo '<script>window.location.href = "index.php?uc=voirProduits&action=voirAvis&produit='.$idProduit.'";</script>';
            exit();
        } else {
            echo '<script>window.location.href = "index.php?uc=utilisateur&action=connexion";</script>';
            exit();
        }
    }
}
?>