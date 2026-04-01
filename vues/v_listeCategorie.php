<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-tags me-2"></i>Liste des catégories</h2>
        <a href="index.php?uc=voirProduits&action=ajouterCategorie" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Ajouter une catégorie
        </a>
    </div>
    <table class="table table-hover table-striped table-bordered shadow-sm">
        <thead class="table-dark text-center">
            <tr>
                <th scope="col" style="width: 100px;">ID</th>
                <th scope="col">Libellé</th>
                <th scope="col" style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lesCategories as $uneCategorie): 
                $idCategorie = $uneCategorie->id;
                $libCategorie = $uneCategorie->libelle;
            ?>
            <tr>
                <td class="text-center align-middle"><?= $idCategorie ?></td>
                <td class="align-middle fw-semibold"><?= $libCategorie ?></td>
                <td class="text-center align-middle">
                    <div class="btn-group" role="group">
                        <a class="btn btn-outline-primary btn-sm"
                            href="index.php?uc=voirProduits&action=voirProduits&categorie=<?= $idCategorie ?>"
                            title="Voir les produits">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a class="btn btn-outline-warning btn-sm"
                            href="index.php?uc=voirProduits&action=modifierCategorie&id=<?= $idCategorie ?>"
                            title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a class="btn btn-outline-danger btn-sm"
                            href="index.php?uc=voirProduits&action=supprimerCategorie&id=<?= $idCategorie ?>"
                            onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')"
                            title="Supprimer">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>