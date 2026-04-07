<?php
class ControleurAdministrer
{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }

    public function listeProduitsModif()
    {
        $lesProduits = $this->modeleFront->getTousLesProduits();
        include("vues/v_listeProduitsModif.php");
    }

    public function ajouterProduit()
    {
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques    = $this->modeleFront->getLesMarques();
        $lesUnites     = $this->modeleFront->getLesUnites();
        include("vues/v_ajouterProduit.php");
    }

    public function validerAjoutProduit()
    {
        $idproduit              = $_POST['idproduit'];
        $nom                    = $_POST['nom'];
        $description            = $_POST['description'];
        $prix                   = $_POST['prix'];
        $image                  = $_POST['image'];
        $quantiteStock          = $_POST['quantiteStock'];
        $seuil_rupture          = $_POST['seuil_rupture'];
        $mis_en_avant_date_debut = $_POST['mis_en_avant_date_debut'];
        $mis_en_avant_date_fin  = $_POST['mis_en_avant_date_fin'];
        $idCateg                = $_POST['idCateg'];
        $idMarque               = $_POST['idMarque'];
        $idUnite                = $_POST['idUnite'];

        $this->modeleFront->creerProduit(
            $idproduit, $nom, $description, $prix, $image,
            $quantiteStock, $seuil_rupture,
            $mis_en_avant_date_debut, $mis_en_avant_date_fin,
            $idCateg, $idMarque, $idUnite
        );

        $message = "Produit ajouté avec succès !";
        $this->listeProduitsModif();
    }

    public function modifierProduit()
    {
        $id            = $_REQUEST['id'];
        $leProduit     = $this->modeleFront->getUnProduit($id);
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques    = $this->modeleFront->getLesMarques();
        $lesUnites     = $this->modeleFront->getLesUnites();
        include("vues/v_modifierProduit.php");
    }

    public function validerModifProduit()
    {
        $idproduit              = $_POST['idproduit'];
        $nom                    = $_POST['nom'];
        $description            = $_POST['description'];
        $prix                   = $_POST['prix'];
        $image                  = $_POST['image'];
        $quantiteStock          = $_POST['quantiteStock'];
        $seuil_rupture          = $_POST['seuil_rupture'];
        $mis_en_avant_date_debut = $_POST['mis_en_avant_date_debut'];
        $mis_en_avant_date_fin  = $_POST['mis_en_avant_date_fin'];
        $idCateg                = $_POST['idCateg'];
        $idMarque               = $_POST['idMarque'];
        $idUnite                = $_POST['idUnite'];

        $this->modeleFront->modifierProduit(
            $idproduit, $nom, $description, $prix, $image,
            $quantiteStock, $seuil_rupture,
            $mis_en_avant_date_debut, $mis_en_avant_date_fin,
            $idCateg, $idMarque, $idUnite
        );

        $message = "Produit modifié avec succès !";
        $this->listeProduitsModif();
    }

    public function supprimerProduit()
    {
        $id = $_GET['id'];
        $this->modeleFront->supprimerProduit($id);

        $message = "Produit supprimé avec succès !";
        $this->listeProduitsModif();
    }
}
?>
