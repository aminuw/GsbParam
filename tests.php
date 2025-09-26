<?php
//test des méthodes de ModèleFront
require_once 'modele/modele.php';
require_once 'modele/modeleFront.php';

$modele= new ModeleFront();
$categorie=$modele->getLesCategories();

var_dump($categorie);
$id='FO';
$produitCategorie=$modele->getLesProduitsDeCategorie($id);
var_dump($produitCategorie);