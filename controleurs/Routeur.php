<?php
require_once 'controleurs/ControleurUtilisateur.php';
require_once 'controleurs/ControleurVoirProduits.php';
require_once 'controleurs/ControleurAccueil.php';
require_once 'controleurs/ControleurGererPanier.php';
require_once 'controleurs/ControleurCategories.php';
require_once 'controleurs/ControleurAdmin.php';
/**
 * @class Routeur
 * @brief gère les routes (actions à exécuter en fonction des urls)
 */
class Routeur
{
    private function requireAdmin()
    {
        if (!isset($_SESSION['client']) || $_SESSION['client']->role != 2) {
            echo '<script>alert("Accès refusé. Vous devez être administrateur."); window.location.href = "index.php?uc=accueil";</script>';
            exit();
        }
    }

    private $ctrlVoirProduits;
    private $ctrlAccueil;
    private $ctrlGererPanier;
    private $ctrlUtilisateur;
    private $ctrlCategories;
    private $ctrlAdministrer;


    public function __construct()
    {

        $this->ctrlVoirProduits = new ControleurVoirProduits();
        $this->ctrlAccueil = new ControleurAccueil();
        $this->ctrlGererPanier = new ControleurGererPanier();
        $this->ctrlUtilisateur = new ControleurUtilisateur();
        $this->ctrlCategories = new ControleurCategories();
        $this->ctrlAdministrer = new ControleurAdmin();
    }
    /** recupère les paramètres de l'url et active les contrôleurs nécessaires
     */
    public function routerRequete()
    {
        // traitement des paramètres de l'url
        if (isset($_REQUEST['uc']))
            $uc = $_REQUEST['uc'];
        else
            $uc = 'accueil';
        if (isset($_REQUEST['action']))
            $action = $_REQUEST['action'];
        else
            $action = null;
        switch ($uc) {
            case 'accueil':
                $this->ctrlAccueil->accueil();
                break;
            case 'mentionsLegales':
                $this->ctrlAccueil->mentionsLegales();
                break;
            case 'voirProduits':
                switch ($action) {
                    case null:

                    case 'voirProduits': {
                        $this->ctrlVoirProduits->voirProduits($_REQUEST['categorie']);
                        break;
                    }
                    case 'voirAvis': {
                        $this->ctrlVoirProduits->voirAvis($_REQUEST['produit']);
                        break;
                    }
                    case 'validerAvis': {
                        $this->ctrlVoirProduits->validerAvis();
                        break;
                    }
                    case 'nosProduits': {
                        $this->ctrlVoirProduits->voirTousProduits();
                        break;
                    }


                }
                ;
                break;
            case 'gererPanier':
                switch ($action) {
                    case null:
                    case 'voirPanier': {
                        $this->ctrlGererPanier->voirPanier();
                        break;
                    }
                    case 'ajouterAuPanier': {
                        $qte = $_REQUEST['qte'] ?? 1;
                        $this->ctrlGererPanier->ajouterAuPanier($_REQUEST['produit'], $qte);
                        break;
                    }
                    case 'supprimerUnProduit': {
                        $this->ctrlGererPanier->supprimerUnProduit($_REQUEST['produit']);
                        break;
                    }
                    case 'viderPanier': {
                        $this->ctrlGererPanier->viderPanier();
                        break;
                    }
                    case 'modifierQuantite': {
                        $this->ctrlGererPanier->modifierQuantiteProduit($_REQUEST['produit'], $_REQUEST['qte']);
                        break;
                    }
                    case 'passerCommande':
                        $this->ctrlGererPanier->passerCommande();
                        break;
                    case 'confirmerCommande':
                        $this->ctrlGererPanier->confirmerCommande();
                        break;
                    default: {
                        $this->ctrlGererPanier->voirPanier();
                        break;
                    }
                }
                ;
                break;
            case 'utilisateur':
                switch ($action) {
                    case null:
                    case 'inscription': {
                        $this->ctrlUtilisateur->inscription();
                        break;
                    }
                    case 'validerInscription': {
                        $this->ctrlUtilisateur->validerInscription();
                        break;
                    }
                    case 'connexion': {
                        $this->ctrlUtilisateur->connexion();
                        break;
                    }
                    case 'validerConnexion': {
                        $this->ctrlUtilisateur->validerConnexion();
                        break;
                    }
                    case 'deconnexion': {
                        $this->ctrlUtilisateur->deconnexion();
                        break;
                    }
                    case 'monCompte': {
                        $this->ctrlUtilisateur->monCompte();
                        break;
                    }
                    case 'modifierProfil': {
                        $this->ctrlUtilisateur->modifierProfil();
                        break;
                    }
                }
                ;
                break;


            case 'administrer':
                $this->requireAdmin();
                switch ($action) {
                    case 'listeProduitsModif': {
                        $this->ctrlAdministrer->listeProduitsModif();
                        break;
                    }
                    case 'ajouterProduit': {
                        $this->ctrlAdministrer->ajouterProduit();
                        break;
                    }
                    case 'validerAjoutProduit': {
                        $this->ctrlAdministrer->validerAjoutProduit();
                        break;
                    }
                    case 'modifierProduit': {
                        $this->ctrlAdministrer->modifierProduit();
                        break;
                    }
                    case 'validerModifProduit': {
                        $this->ctrlAdministrer->validerModifProduit();
                        break;
                    }
                    case 'supprimerProduit': {
                        $this->ctrlAdministrer->supprimerProduit();
                        break;
                    }
                    case 'gererAssociations': {
                        $this->ctrlAdministrer->gererAssociations();
                        break;
                    }
                    case 'ajouterAssociation': {
                        $this->ctrlAdministrer->ajouterAssociation();
                        break;
                    }
                    case 'validerAjoutAssociation': {
                        $this->ctrlAdministrer->validerAjoutAssociation();
                        break;
                    }
                    case 'supprimerAssociation': {
                        $this->ctrlAdministrer->supprimerAssociation();
                        break;
                    }
                    case 'modifierAssociation': {
                        $this->ctrlAdministrer->modifierAssociation();
                        break;
                    }
                    case 'validerModifAssociation': {
                        $this->ctrlAdministrer->validerModifAssociation();
                        break;
                    }
                    case 'gestionCommandes': {
                        $this->ctrlAdministrer->gestionCommandes();
                        break;
                    }
                    case 'voirArticles': {
                        $this->ctrlAdministrer->voirArticles();
                        break;
                    }
                    case 'modifierEtat': {
                        $this->ctrlAdministrer->modifierEtat();
                        break;
                    }
                    case 'gererPromotions': {
                        $this->ctrlAdministrer->gererPromotions();
                        break;
                    }
                    case 'ajouterPromotion': {
                        $this->ctrlAdministrer->ajouterPromotion();
                        break;
                    }
                    case 'validerAjoutPromotion': {
                        $this->ctrlAdministrer->validerAjoutPromotion();
                        break;
                    }
                    case 'supprimerPromotion': {
                        $this->ctrlAdministrer->supprimerPromotion();
                        break;
                    }
                }
                break;
            case 'categories':
                $this->requireAdmin();
                switch ($action) {
                    case 'listeCategories': {
                        $this->ctrlCategories->listeCategories();
                        break;
                    }
                    case 'ajouterCategorie': {
                        $this->ctrlCategories->ajouterCategorie();
                        break;
                    }
                    case 'validerAjoutCategorie': {
                        $this->ctrlCategories->validerAjoutCategorie();
                        break;
                    }
                    case 'modifierCategorie': {
                        $this->ctrlCategories->modifierCategorie();
                        break;
                    }
                    case 'validerModifCategorie': {
                        $this->ctrlCategories->validerModifCategorie();
                        break;
                    }
                    case 'supprimerCategorie': {
                        $this->ctrlCategories->supprimerCategorie();
                        break;
                    }
                }
                break;
        }
    }
}
