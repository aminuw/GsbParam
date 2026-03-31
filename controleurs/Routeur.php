<?php
require_once 'controleurs/ControleurUtilisateur.php';
require_once 'controleurs/ControleurVoirProduits.php';
require_once 'controleurs/ControleurAccueil.php';
require_once 'controleurs/ControleurGererPanier.php';
/**
 * @class Routeur
 * @brief gère les routes (actions à exécuter en fonction des urls)
 */
class Routeur{
    
    private $ctrlVoirProduits;
    private $ctrlAccueil;
    private $ctrlGererPanier;
    private $ctrlUtilisateur;
    
    public function __construct(){
        
        $this->ctrlVoirProduits=new ControleurVoirProduits();
        $this->ctrlAccueil=new ControleurAccueil();
        $this->ctrlGererPanier=new ControleurGererPanier();
        $this->ctrlUtilisateur=new ControleurUtilisateur();
    }
    /** recupère les paramètres de l'url et active les contrôleurs nécessaires
    */
    public function routerRequete()
    {
    // traitement des paramètres de l'url
    if(isset($_REQUEST['uc']))
    	$uc = $_REQUEST['uc'];
        else $uc='accueil';
    if(isset($_REQUEST['action']))
    	$action = $_REQUEST['action'];
    else $action=null;
    switch($uc)
    {
        case 'accueil':
            $this->ctrlAccueil->accueil();break;
        case 'voirProduits' :
            switch ($action)
            {
                case null :
                case 'voirCategories' : {$this->ctrlVoirProduits->voirCategories();break;}
                case 'voirProduits' : {$this->ctrlVoirProduits->voirProduits($_REQUEST['categorie']);break;}
                case 'nosProduits' : {$this->ctrlVoirProduits->voirTousProduits();break;}
                case 'ajouterCategorie' : {$this->ctrlVoirProduits->ajouterCategorie();break;}
                case 'validerAjoutCategorie' : {$this->ctrlVoirProduits->validerAjoutCategorie();break;}
                case 'ajouterProduit' : {$this->ctrlVoirProduits->ajouterProduit();break;}
                case 'validerAjoutProduit' : {$this->ctrlVoirProduits->validerAjoutProduit();break;}
                case 'listeProduitsModif' : {$this->ctrlVoirProduits->listeProduitsModif();break;}
                case 'modifierProduit' : {$this->ctrlVoirProduits->modifierProduit();break;}
                case 'validerModifProduit' : {$this->ctrlVoirProduits->validerModifProduit();break;}
            }; break;
        case 'gererPanier' :
            switch ($action)
            {
                case null :
                case 'voirPanier' : {$this->ctrlGererPanier->voirPanier();break;}
                case 'ajouterAuPanier' : {$this->ctrlGererPanier->ajouterAuPanier($_REQUEST['produit']);break;}
                case 'supprimerUnProduit' : {$this->ctrlGererPanier->supprimerUnProduit($_REQUEST['produit']);break;}
                case 'viderPanier' : {$this->ctrlGererPanier->viderPanier();break;}
                case 'modifierQuantite': {$this->ctrlGererPanier->modifierQuantiteProduit($_REQUEST['produit'], $_REQUEST['qte']);break;}
                case 'passerCommande' : $this->ctrlGererPanier->passerCommande();break;
                case 'confirmerCommande' : $this->ctrlGererPanier->confirmerCommande();break;
                case 'viderPanier' : $this->ctrlGererPanier->viderPanier();break;
                default: {$this->ctrlGererPanier->voirPanier();break;}
            }; break;
             case 'utilisateur' :
            switch ($action)
            {
                case null :
                case 'inscription' : {$this->ctrlUtilisateur->inscription();break;}
                case 'validerInscription': {$this->ctrlUtilisateur->validerInscription();break;}
                case 'connexion' : {$this->ctrlUtilisateur->connexion();break;}
                case 'validerConnexion': {$this->ctrlUtilisateur->validerConnexion();break;}
                case 'deconnexion' : {$this->ctrlUtilisateur->deconnexion();break;}
            }; break;
        case 'administrer' :  // TODO Créer un contrôleur spécial pour l'administration du site
		break; 
    }
    }
}
