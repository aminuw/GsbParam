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
        $id = $_POST['id'] ?? '';
        $libelle = $_POST['libelle'] ?? '';

        if (empty($id) || empty($libelle)) {
            $erreurs[] = "L'identifiant et le libellé ne peuvent pas être vides.";
            $laCategorie = (object) ['id' => $id, 'libelle' => $libelle];
            include("vues/v_modifierCategorie.php");
        } else {
            if ($this->modeleFront->modifierCategorie($id, $libelle)) {
                $message = "La catégorie a été modifiée avec succès !";
                $lesCategories = $this->modeleFront->getLesCategories();
                include("vues/v_listeCategorie.php");
            } else {
                $erreurs[] = "Une erreur est survenue lors de la modification.";
                $laCategorie = (object) ['id' => $id, 'libelle' => $libelle];
                include("vues/v_modifierCategorie.php");
            }
        }
    }

    public function supprimerCategorie()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->modeleFront->checkProduitsCateg($id)) {
                $erreurs[] = "La catégorie ne peut pas être supprimée car elle contient des produits.";
            } else {
                $this->modeleFront->supprimerCategorie($id);
                $message = "La catégorie a été supprimée avec succès !";
            }
        } else {
            $erreurs[] = "Aucune catégorie n'a été sélectionnée.";
        }
        $lesCategories = $this->modeleFront->getLesCategories();
        include("vues/v_listeCategorie.php");
    }

}