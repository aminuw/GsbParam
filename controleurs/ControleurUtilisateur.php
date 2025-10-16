<?php

class ControleurUtilisateur{
	private $modeleFront;
	
	public function __construct()
    {
        $this->modeleFront=new ModeleFront();
    }


    function inscription()
    {
        include("vues/v_inscription.php");
    }

    function connexion()
    {
        include("vues/v_connexion.php");
    }

    function deconnexion()
    {
        include("vues/v_deconnexion.php");
    }
}