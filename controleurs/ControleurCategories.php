<?php
class ControleurCategories
{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }

    public function voirCategories()
    {
        $lesCategories = $this->modeleFront->getLesCategories();
        include("vues/v_choixCategorie.php");
    }

    public function listeCategories()
    {
        $lesCategories = $this->modeleFront->getLesCategories();
        include("vues/v_listeCategorie.php");
    }


    public function ajouterCategorie()
    {
        include("vues/v_ajouterCategorie.php");
    }

    public function validerAjoutCategorie()
    {
        $id = $_POST['id'] ?? '';
        $libelle = $_POST['libelle'] ?? '';

        $erreurs = array();
        if (empty($id) || strlen($id) > 3) {
            $erreurs[] = "L'identifiant doit comporter entre 1 et 3 caractères.";
        }
        if (empty($libelle)) {
            $erreurs[] = "Le libellé ne peut pas être vide.";
        }

        if (count($erreurs) == 0) {
            $resultat = $this->modeleFront->creerCategorie($id, $libelle);
            if ($resultat) {
                $message = "La catégorie a été ajoutée avec succès !";
                $lesCategories = $this->modeleFront->getLesCategories();
                include("vues/v_listeCategorie.php");
            } else {
                $erreurs[] = "Une erreur est survenue lors de l'ajout. L'identifiant est peut-être déjà utilisé.";
                include("vues/v_ajouterCategorie.php");
            }
        } else {
            include("vues/v_ajouterCategorie.php");
        }
    }

    public function modifierCategorie()
    {
        $id = $_REQUEST['id'] ?? null;
        if ($id) {
            $laCategorie = $this->modeleFront->getLesInfosCategorie($id);
            include("vues/v_modifierCategorie.php");
        } else {
            $this->listeCategories();
        }
    }

    public function validerModifCategorie()
    {
        $id = $_POST['id'];
        $libelle = $_POST['libelle'];

        $this->modeleFront->modifierCategorie($id, $libelle);

        $this->listeCategories();
    }

    public function supprimerCategorie()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->modeleFront->supprimerCategorie($id);
        }
        $this->listeCategories();
    }

}