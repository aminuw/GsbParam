<div class="container py-4">
    <div class="admin-card card" style="max-width:660px; margin:auto;">
        <div class="admin-header">
            <h1 class="h4 mb-0 fw-bold">Nouvelle Programmation de Mise en Avant</h1>
            <p class="mb-0 small opacity-75 mt-1">Choisissez un produit et définissez sa période de mise en avant sur la page d'accueil</p>
        </div>

        <div class="card-body p-4">
            <?php if (!empty($erreurs)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($erreurs as $erreur): ?>
                            <li><?= htmlspecialchars($erreur) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="index.php?uc=administrer&action=validerAjoutPromotion" method="post">

                <div class="mb-4">
                    <label for="idProduit" class="form-label fw-semibold">Produit à mettre en avant</label>
                    <select name="idProduit" id="idProduit" class="form-select" required>
                        <option value="">-- Choisir un produit --</option>
                        <?php foreach ($lesProduits as $unProduit): ?>
                            <option value="<?= htmlspecialchars($unProduit->id) ?>">
                                <?= htmlspecialchars($unProduit->nom) ?>
                                <?= ($unProduit->mis_en_avant_date_debut !== null) ? ' ⚠ déjà programmé' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text text-warning-emphasis">Les produits marqués ⚠ ont déjà une programmation active.</div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="dateDebut" class="form-label fw-semibold">Date de début</label>
                        <input type="date" name="dateDebut" id="dateDebut" class="form-control"
                               min="<?= date('Y-m-d') ?>" required>
                        <div class="form-text">Ne peut pas être dans le passé</div>
                    </div>
                    <div class="col-md-6">
                        <label for="dateFin" class="form-label fw-semibold">Date de fin</label>
                        <input type="date" name="dateFin" id="dateFin" class="form-control"
                               min="<?= date('Y-m-d') ?>" required>
                        <div class="form-text">Doit être après la date de début</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="index.php?uc=administrer&action=gererPromotions" class="btn btn-outline-secondary rounded-pill px-4">
                        &larr; Annuler
                    </a>
                    <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold text-dark">
                        Valider la programmation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('dateDebut').addEventListener('change', function () {
    const df = document.getElementById('dateFin');
    df.min = this.value;
    if (df.value && df.value <= this.value) df.value = '';
});
</script>
