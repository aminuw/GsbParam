<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h1 class="h4 mb-0">Modifier l'association</h1>
        </div>
        <div class="card-body">
            <form action="index.php?uc=administrer&action=validerModifAssociation" method="POST">
                <input type="hidden" name="ancienId1" value="<?= htmlspecialchars($id1) ?>">
                <input type="hidden" name="ancienId2" value="<?= htmlspecialchars($id2) ?>">
                
                <div class="mb-3">
                    <label for="idProduit1" class="form-label">Produit 1</label>
                    <select class="form-select" id="idProduit1" name="idProduit1" required>
                        <?php foreach ($lesProduits as $unProduit): ?>
                            <option value="<?= htmlspecialchars($unProduit->id) ?>" <?= ($unProduit->id == $id1) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($unProduit->nom) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="idProduit2" class="form-label">Produit 2 (Associé)</label>
                    <select class="form-select" id="idProduit2" name="idProduit2" required>
                        <?php foreach ($lesProduits as $unProduit): ?>
                            <option value="<?= htmlspecialchars($unProduit->id) ?>" <?= ($unProduit->id == $id2) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($unProduit->nom) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php?uc=administrer&action=gererAssociations" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning fw-bold px-4">Modifier l'association</button>
                </div>
            </form>
        </div>
    </div>
</div>
