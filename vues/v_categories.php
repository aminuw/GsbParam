<div id="categories">
    <h2>Catégorie | <?php echo isset($laCategorie->libelle) ? $laCategorie->libelle : 'Tous nos produits' ?></h2>

    <?php if (!isset($lesMarques)): ?>
        <ul>
            <?php
            foreach ($lesCategories as $uneCategorie) {
                $idCategorie = $uneCategorie->id;
                $libCategorie = $uneCategorie->libelle;
            ?>
                <li>
                    <a class="text-decoration-none text-light"
                        href="index.php?uc=voirProduits&action=voirProduits&categorie=<?= $idCategorie ?>">
                        <?= $libCategorie ?></a>
                </li>
            <?php
            } ?>
        </ul>
    <?php endif; ?>

    <?php if (isset($lesMarques)): ?>
    <div id="categories" class="mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="card-title mb-0 fs-6 fw-bold text-uppercase">Filtrer les produits</h5>
        </div>
        <div class="card-body">
            <form action="index.php?uc=voirProduits&action=nosProduits" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Catégorie</label>
                    <select name="lstCategorie" class="form-select form-select-sm">
                        <option value="tous" <?= (!isset($idCateg) || $idCateg == 'tous') ? 'selected' : '' ?>>Toutes les catégories</option>
                        <?php foreach($lesCategories as $uneCategorie): ?>
                            <option value="<?= $uneCategorie->id ?>" <?= (isset($idCateg) && $idCateg == $uneCategorie->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($uneCategorie->libelle) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Marque</label>
                    <select name="lstMarque" class="form-select form-select-sm">
                        <option value="toutes" <?= (!isset($idMarque) || $idMarque == 'toutes') ? 'selected' : '' ?>>Toutes les marques</option>
                        <?php foreach($lesMarques as $uneMarque): ?>
                            <option value="<?= $uneMarque->idMarque ?>" <?= (isset($idMarque) && $idMarque == $uneMarque->idMarque) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($uneMarque->libelleMarque) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Prix (€)</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" step="0.01" name="txtPrixMin" class="form-control form-control-sm" placeholder="Min" value="<?= htmlspecialchars($prixMin ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="txtPrixMax" class="form-control form-control-sm" placeholder="Max" value="<?= htmlspecialchars($prixMax ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Appliquer les filtres</button>
                    <a href="index.php?uc=voirProduits&action=nosProduits" class="btn btn-outline-secondary btn-sm small">Réinitialiser</a>
                </div>
            </form>

            <?php if (isset($erreurFiltre)): ?>
                <div class="alert alert-danger mt-3 py-2 small mb-0"><?= $erreurFiltre ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
    <?php endif; ?>
</div>