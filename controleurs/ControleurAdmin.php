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
            try {
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
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    $erreurs[] = "Erreur : L'identifiant produit '$idproduit' est déjà utilisé.";
                } else {
                    $erreurs[] = "Erreur lors de l'ajout : " . $e->getMessage();
                }
                $lesCategories = $this->modeleFront->getLesCategories();
                $lesMarques = $this->modeleFront->getLesMarques();
                $lesUnites = $this->modeleFront->getLesUnites();
                include("vues/v_ajouterProduit.php");
            }
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
            try {
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
                $messageType = "success";
                include("vues/v_message.php");
                $this->listeProduitsModif();
            } catch (PDOException $e) {
                $message = "Erreur lors de la modification du produit : " . $e->getMessage();
                $messageType = "error";
                include("vues/v_message.php");
                $this->listeProduitsModif();
            }
        }
    }

    public function supprimerProduit()
    {
        $id = $_GET['id'];
        try {
            $this->modeleFront->supprimerProduit($id);
            $message = "Produit supprimé avec succès !";
        } catch (PDOException $e) {
            // Code 23000 = Violation de contrainte d'intégrité (clé étrangère)
            if ($e->getCode() == '23000') {
                $message = "Erreur : Impossible de supprimer ce produit car il est lié à des commandes ou des associations existantes.";
            } else {
                $message = "Erreur lors de la suppression : " . $e->getMessage();
            }
            $messageType = "error";
        }

        include("vues/v_message.php");
        $this->listeProduitsModif();
    }

    /**
     * Affiche l'interface de gestion des produits associés globale
     */
    public function gererAssociations()
    {
        $lesAssociations = $this->modeleFront->getToutesLesAssociations();
        include("vues/v_gererAssociations.php");
    }

    public function ajouterAssociation()
    {
        $lesProduits = $this->modeleFront->getTousLesProduits();
        include("vues/v_ajouterAssociation.php");
    }

    public function validerAjoutAssociation()
    {
        $idProduit1 = $_POST['idProduit1'];
        $idProduit2 = $_POST['idProduit2'];

        if ($idProduit1 == $idProduit2) {
            $message = "Erreur : Un produit ne peut pas être associé à lui-même.";
            include("vues/v_message.php");
            $this->ajouterAssociation();
        } else {
            try {
                $this->modeleFront->ajouterAssociation($idProduit1, $idProduit2);
                $message = "L'association a été créée avec succès !";
                $messageType = "success";
                include("vues/v_message.php");
                $this->gererAssociations();
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    $message = "Erreur : Cette association existe déjà.";
                } else {
                    $message = "Erreur lors de l'association : " . $e->getMessage();
                }
                $messageType = "error";
                include("vues/v_message.php");
                $this->ajouterAssociation();
            }
        }
    }

    public function supprimerAssociation()
    {
        $id1 = $_GET['id1'];
        $id2 = $_GET['id2'];
        try {
            $this->modeleFront->supprimerAssociation($id1, $id2);
            $message = "Association supprimée avec succès !";
            $messageType = "success";
        } catch (PDOException $e) {
            $message = "Erreur lors de la suppression de l'association : " . $e->getMessage();
            $messageType = "error";
        }
        include("vues/v_message.php");
        $this->gererAssociations();
    }

    public function modifierAssociation()
    {
        $id1 = $_GET['id1'];
        $id2 = $_GET['id2'];
        
        $lesProduits = $this->modeleFront->getTousLesProduits();
        include("vues/v_modifierAssociation.php");
    }

    public function validerModifAssociation()
    {
        $ancienId1 = $_POST['ancienId1'];
        $ancienId2 = $_POST['ancienId2'];
        $idProduit1 = $_POST['idProduit1'];
        $idProduit2 = $_POST['idProduit2'];

        if ($idProduit1 == $idProduit2) {
            $message = "Erreur : Un produit ne peut pas être associé à lui-même.";
            $messageType = "error";
            include("vues/v_message.php");
            $this->gererAssociations();
        } else {
            try {
                // On tente d'ajouter la nouvelle association d'abord
                // Si elle existe déjà, ça va lever une exception 23000
                if ($ancienId1 != $idProduit1 || $ancienId2 != $idProduit2) {
                    $this->modeleFront->ajouterAssociation($idProduit1, $idProduit2);
                    // Si l'ajout a réussi, on supprime l'ancienne
                    $this->modeleFront->supprimerAssociation($ancienId1, $ancienId2);
                }
                $message = "L'association a été modifiée avec succès !";
                $messageType = "success";
                include("vues/v_message.php");
                $this->gererAssociations();
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    $message = "Erreur : La nouvelle association choisie existe déjà.";
                } else {
                    $message = "Erreur lors de la modification : " . $e->getMessage();
                }
                $messageType = "error";
                include("vues/v_message.php");
                $this->gererAssociations();
            }
        }
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
        
        try {
            $this->modeleFront->modifierEtatCommande($idCommande, $idEtat);
            $message = "État de la commande n°$idCommande mis à jour !";
            $messageType = "success";
        } catch (PDOException $e) {
            $message = "Erreur lors de la mise à jour de l'état : " . $e->getMessage();
            $messageType = "error";
        }
        include("vues/v_message.php");
        $this->gestionCommandes();
    }
}
?>