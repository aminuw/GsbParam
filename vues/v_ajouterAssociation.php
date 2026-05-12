<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Créer une association</h1>
        </div>
        <div class="card-body">
            <form action="index.php?uc=administrer&action=validerAjoutAssociation" method="POST">
                <div class="mb-3">
                    <label for="idProduit1" class="form-label">Produit 1</label>
                    <select class="form-select" id="idProduit1" name="idProduit1" required>
                        <?php foreach ($lesProduits as $unProduit): ?>
                            <option value="<?= htmlspecialchars($unProduit->id) ?>"><?= htmlspecialchars($unProduit->nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="idProduit2" class="form-label">Produit 2 (Associé)</label>
                    <select class="form-select" id="idProduit2" name="idProduit2" required>
                        <?php foreach ($lesProduits as $unProduit): ?>
                            <option value="<?= htmlspecialchars($unProduit->id) ?>"><?= htmlspecialchars($unProduit->nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php?uc=administrer&action=gererAssociations" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Créer l'association</button>
                </div>
            </form>
        </div>
    </div>
</div>
