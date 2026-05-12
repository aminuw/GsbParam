<?php

class ControleurUtilisateur
{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
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
                echo '<script>window.location.href = "index.php?uc=accueil";</script>';
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
        echo '<script>window.location.href = "index.php?uc=accueil";</script>';
        exit();
    }

    /**
     * Affiche l'espace client (Profil, Commandes, Avis)
     */
    function monCompte()
    {
        if (isset($_SESSION['client'])) {
            $idClient = $_SESSION['client']->idClient;
            $lesCommandes = $this->modeleFront->getCommandesByClient($idClient);
            $lesAvis = $this->modeleFront->getAvisByClient($idClient);
            include("vues/v_monCompte.php");
        } else {
            $this->connexion();
        }
    }

    /**
     * Traite la modification du profil client
     */
    function modifierProfil()
    {
        if (isset($_SESSION['client'])) {
            $idClient = $_SESSION['client']->idClient;
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $mail = trim($_POST['mail'] ?? '');
            $rue = trim($_POST['rue'] ?? '');
            $cp = trim($_POST['cp'] ?? '');
            $ville = trim($_POST['ville'] ?? '');

            $erreurs = array();

            if (empty($nom) || empty($prenom) || empty($mail)) {
                $erreurs[] = "Le nom, le prénom et l'email sont obligatoires.";
            }

            if (!empty($mail) && !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = "L'adresse email n'est pas valide.";
            }

            // Validation CP (format français simplifié)
            if (!empty($cp) && !preg_match("/^[0-9]{5}$/", $cp)) {
                $erreurs[] = "Le code postal doit comporter 5 chiffres.";
            }

            if (count($erreurs) == 0) {
                $idLogin = $_SESSION['client']->idLogin;
                $this->modeleFront->modifierProfil($idClient, $idLogin, $nom, $prenom, $rue, $cp, $ville, $mail);

                // Mise à jour des données en session pour affichage immédiat
                $_SESSION['client']->nom = $nom;
                $_SESSION['client']->prenom = $prenom;
                $_SESSION['client']->mail = $mail;
                $_SESSION['client']->rue = $rue;
                $_SESSION['client']->cp = $cp;
                $_SESSION['client']->ville = $ville;

                $message = "Votre profil a été mis à jour avec succès !";
                include("vues/v_message.php");
            }
            
            $this->monCompte();
        } else {
            $this->connexion();
        }
    }
}