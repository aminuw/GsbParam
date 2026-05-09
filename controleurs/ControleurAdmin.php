<?php
class ControleurAdmin
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
        $lesMarques = $this->modeleFront->getLesMarques();
        $lesUnites = $this->modeleFront->getLesUnites();
        include("vues/v_ajouterProduit.php");
    }

    public function validerAjoutProduit()
    {
        $idproduit = trim($_POST['idproduit']);
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $prix = $_POST['prix'];
        $image = trim($_POST['image']);
        $quantiteStock = $_POST['quantiteStock'];
        $seuil_rupture = $_POST['seuil_rupture'];
        $mis_en_avant_date_debut = $_POST['mis_en_avant_date_debut'];
        $mis_en_avant_date_fin = $_POST['mis_en_avant_date_fin'];
        $idCateg = $_POST['idCateg'];
        $idMarque = $_POST['idMarque'];
        $idUnite = $_POST['idUnite'];

        $erreurs = array();

        if (empty($idproduit) || empty($nom) || empty($description) || empty($prix)) {
            $erreurs[] = "Tous les champs obligatoires doivent être remplis.";
        }

        if (strlen($idproduit) > 5) {
            $erreurs[] = "L'ID produit ne doit pas dépasser 5 caractères.";
        }

        if (!is_numeric($prix) || $prix < 0) {
            $erreurs[] = "Le prix doit être un nombre positif.";
        }

        if (!is_numeric($quantiteStock) || $quantiteStock < 0) {
            $erreurs[] = "La quantité en stock ne peut pas être négative.";
        }

        if (count($erreurs) > 0) {
            $lesCategories = $this->modeleFront->getLesCategories();
            $lesMarques = $this->modeleFront->getLesMarques();
            $lesUnites = $this->modeleFront->getLesUnites();
            include("vues/v_ajouterProduit.php");
        } else {
            $this->modeleFront->creerProduit(
                $idproduit,
                $nom,
                $description,
                $prix,
                $image,
                $quantiteStock,
                $seuil_rupture,
                $mis_en_avant_date_debut,
                $mis_en_avant_date_fin,
                $idCateg,
                $idMarque,
                $idUnite
            );
            $message = "Produit ajouté avec succès !";
            include("vues/v_message.php");
            $this->listeProduitsModif();
        }
    }

    public function modifierProduit()
    {
        $id = $_REQUEST['id'];
        $leProduit = $this->modeleFront->getUnProduit($id);
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        $lesUnites = $this->modeleFront->getLesUnites();
        include("vues/v_modifierProduit.php");
    }

    public function validerModifProduit()
    {
        $idproduit = $_POST['idproduit'];
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $prix = $_POST['prix'];
        $image = trim($_POST['image']);
        $quantiteStock = $_POST['quantiteStock'];
        $seuil_rupture = $_POST['seuil_rupture'];
        $mis_en_avant_date_debut = $_POST['mis_en_avant_date_debut'];
        $mis_en_avant_date_fin = $_POST['mis_en_avant_date_fin'];
        $idCateg = $_POST['idCateg'];
        $idMarque = $_POST['idMarque'];
        $idUnite = $_POST['idUnite'];

        $erreurs = array();

        if (empty($nom) || empty($description) || empty($prix)) {
            $erreurs[] = "Le nom, la description et le prix sont obligatoires.";
        }

        if (!is_numeric($prix) || $prix < 0) {
            $erreurs[] = "Le prix doit être un nombre positif.";
        }

        if (!is_numeric($quantiteStock) || $quantiteStock < 0) {
            $erreurs[] = "La quantité en stock ne peut pas être négative.";
        }

        if (!is_numeric($seuil_rupture) || $seuil_rupture < 0) {
            $erreurs[] = "Le seuil de rupture ne peut pas être négatif.";
        }

        if (!empty($mis_en_avant_date_debut) && !empty($mis_en_avant_date_fin)) {
            if ($mis_en_avant_date_fin < $mis_en_avant_date_debut) {
                $erreurs[] = "La date de fin de mise en avant est incohérente.";
            }
        }

        if (count($erreurs) > 0) {
            $leProduit = $this->modeleFront->getUnProduit($idproduit);
            $lesCategories = $this->modeleFront->getLesCategories();
            $lesMarques = $this->modeleFront->getLesMarques();
            $lesUnites = $this->modeleFront->getLesUnites();
            include("vues/v_modifierProduit.php");
        } else {
            $this->modeleFront->modifierProduit(
                $idproduit,
                $nom,
                $description,
                $prix,
                $image,
                $quantiteStock,
                $seuil_rupture,
                $mis_en_avant_date_debut,
                $mis_en_avant_date_fin,
                $idCateg,
                $idMarque,
                $idUnite
            );
            $message = "Produit modifié avec succès !";
            include("vues/v_message.php");
            $this->listeProduitsModif();
        }
    }

    public function supprimerProduit()
    {
        $id = $_GET['id'];
        $this->modeleFront->supprimerProduit($id);

        $message = "Produit supprimé avec succès !";
        $this->listeProduitsModif();
    }

    /**
     * Affiche l'interface de gestion des produits associés
     */
    public function gererAssociations()
    {
        $id = $_REQUEST['id'] ?? null;
        if ($id) {
            $leProduit = $this->modeleFront->getUnProduit($id);
            $tousLesProduits = $this->modeleFront->getTousLesProduits();
            $lesProduitsAssocies = $this->modeleFront->getProduitsAssocies($id);

            // Liste simple des IDs pour faciliter le cochage des cases
            $idsAssocies = array();
            foreach ($lesProduitsAssocies as $unP) {
                $idsAssocies[] = $unP->id;
            }

            include("vues/v_gererAssociations.php");
        } else {
            $this->listeProduitsModif();
        }
    }

    /**
     * Enregistre les modifications d'associations
     */
    public function validerAssociations()
    {
        $id = $_POST['idproduit'];
        $nouveauxAssocies = $_POST['associes'] ?? array();

        // On commence par supprimer toutes les associations actuelles de ce produit
        $anciens = $this->modeleFront->getProduitsAssocies($id);
        foreach ($anciens as $unA) {
            $this->modeleFront->supprimerAssociation($id, $unA->id);
        }

        // On ajoute les nouvelles associations cochées
        foreach ($nouveauxAssocies as $idAssoc) {
            if ($id != $idAssoc) { // Sécurité : pas d'auto-association
                $this->modeleFront->ajouterAssociation($id, $idAssoc);
            }
        }

        $message = "Les produits associés ont été mis à jour avec succès !";
        include("vues/v_message.php");
        $this->listeProduitsModif();
    }

    /**
     * Affiche la liste des commandes pour le back-office
     */
    public function gestionCommandes()
    {
        $lesCommandes = $this->modeleFront->getToutesLesCommandes();
        $lesEtats = $this->modeleFront->getTousLesEtats();
        include("vues/v_listeCommandes.php");
    }

    /**
     * Affiche le détail des articles d'une commande
     */
    public function voirArticles()
    {
        $idCommande = $_GET['id'];
        $lesArticles = $this->modeleFront->getArticlesCommande($idCommande);
        
        $totalCommande = 0;
        foreach($lesArticles as $unA) {
            $totalCommande += $unA->prix * $unA->qte;
        }
        
        include("vues/v_detailCommande.php");
    }

    /**
     * Modifie l'état d'une commande
     */
    public function modifierEtat()
    {
        $idCommande = $_POST['idCommande'];
        $idEtat = $_POST['idEtat'];
        
        $this->modeleFront->modifierEtatCommande($idCommande, $idEtat);
        
        $message = "État de la commande n°$idCommande mis à jour !";
        include("vues/v_message.php");
        $this->gestionCommandes();
    }
}
?>