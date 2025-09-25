<?php
require_once 'modele/modele.php';
require_once 'modele/modeleFront.php';
//$bdd=getBdd();

$modele= new ModeleFront();
$categorie=$modele->getLesCategories();

var_dump($categorie);
$id='FO';
$produitCategorie=$modele->getLesProduitsDeCategorie($id);
var_dump($produitCategorie);