<div class="container mt-4">
    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark d-flex align-items-center">
            <i class="bi bi-pencil-square me-2"></i>
            <h2 class="h4 mb-0">Modifier la catégorie</h2>
        </div>
        <div class="card-body">
            <form action="index.php?uc=categories&action=validerModifCategorie" method="POST">
                <input type="hidden" name="id" value="<?= $laCategorie->id; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold d-block">Identifiant :</label>
                    <span class="badge bg-secondary p-2 ms-2 fs-6"><?= $laCategorie->id; ?></span>
                </div>

                <div class="mb-4">
                    <label for="libelle" class="form-label fw-bold">Nouveau Libellé :</label>
                    <input type="text" id="libelle" name="libelle" class="form-control"
                        value="<?= htmlspecialchars($laCategorie->libelle); ?>" required>
                    <div class="form-text">Entrez le nouveau nom de la catégorie.</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-4 fw-bold">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                    <a href="index.php?uc=categories&action=listeCategories" class="btn btn-outline-secondary px-4">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>