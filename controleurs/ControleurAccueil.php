<?php
/** @file ControleurAccueil.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @details Gère l'affichage de la page d'accueil du site
*/
require_once 'Modele/ModeleFront.php';
/**
 * @class ControleurAccueil
 * @brief contient la fonction qui gère l'accueil
 */
class ControleurAccueil{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }
    /**
	 * affiche la page d'accueil avec les produits mis en avant
	*/
    public function accueil(){
        // Nettoyage automatique des programmations expirées (exigence 2.b.7)
        $this->modeleFront->supprimerProgrammationsExpirees();
        // Récupération des produits actuellement mis en avant
        $lesProduitsEnAvant = $this->modeleFront->getProduitsEnAvant();
        include("vues/v_accueil.php");
    }

    public function mentionsLegales(){
        include("vues/v_mentionsLegales.php");
    }
}
