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

    function validerInscription()
    {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $mail = $_POST['mail'] ?? '';
        $mdp = $_POST['mdp'] ?? '';
        $rue = $_POST['rue'] ?? '';
        $ville = $_POST['ville'] ?? '';
        $cp = $_POST['cp'] ?? '';

        if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($mdp)) {
            $result = $this->modeleFront->creerClient($nom, $prenom, $mail, $mdp, $rue, $ville, $cp);

            if ($result) {
                $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                include("vues/v_connexion.php");
            } else {
                $erreurs[] = "Une erreur est survenue lors de l'inscription. L'adresse email est peut-être déjà utilisée.";
                include("vues/v_inscription.php");
            }
        } else {
            $erreurs[] = "Tous les champs obligatoires doivent être remplis.";
            include("vues/v_inscription.php");
        }
    }

    function validerConnexion()
    {
        $mail = $_POST['mail'] ?? '';
        $mdp = $_POST['mdp'] ?? '';

        if (!empty($mail) && !empty($mdp)) {
            $client = $this->modeleFront->getUnClientByMail($mail);

            if ($client && password_verify($mdp, $client->mdp)) {
                $_SESSION['client'] = $client;
                header('Location: index.php');
                exit();
            } else {
                $erreurs[] = "Email ou mot de passe incorrect.";
                include("vues/v_connexion.php");
            }
        } else {
            $erreurs[] = "Veuillez saisir votre email et votre mot de passe.";
            include("vues/v_connexion.php");
        }
    }

    function connexion()
    {
        include("vues/v_connexion.php");
    }

    function deconnexion()
    {
        session_destroy();
        header('Location: index.php');
        exit();
    }
}