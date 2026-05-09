<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Modifier le produit : <?= htmlspecialchars($leProduit->nom) ?></h1>
        </div>
        <div class="card-body">
            <form action="index.php?uc=administrer&action=validerModifProduit" method="POST">
                <input type="hidden" name="idproduit" value="<?= $leProduit->id; ?>">
                
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-bold">ID Produit</label>
                        <input type="text" class="form-control bg-light" value="<?= $leProduit->id; ?>" disabled>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Nom du produit</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($leProduit->nom); ?>" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Image (lien ou chemin)</label>
                        <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($leProduit->image); ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($leProduit->description); ?></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Prix (€)</label>
                        <input type="number" step="0.01" name="prix" class="form-control" value="<?= $leProduit->prix; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Quantité en Stock</label>
                        <input type="number" name="quantiteStock" class="form-control" value="<?= $leProduit->quantiteStock; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Seuil de rupture</label>
                        <input type="number" name="seuil_rupture" class="form-control" value="<?= $leProduit->seuil_rupture; ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date de début mise en avant</label>
                        <input type="date" name="mis_en_avant_date_debut" class="form-control" value="<?= $leProduit->mis_en_avant_date_debut; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date de fin mise en avant</label>
                        <input type="date" name="mis_en_avant_date_fin" class="form-control" value="<?= $leProduit->mis_en_avant_date_fin; ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="idCateg" class="form-select">
                            <?php foreach($lesCategories as $uneCategorie) { ?>
                                <option value="<?= $uneCategorie->id; ?>" <?= ($uneCategorie->id == $leProduit->idCategorie) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($uneCategorie->libelle); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Marque</label>
                        <select name="idMarque" class="form-select">
                            <?php foreach($lesMarques as $uneMarque) { ?>
                                <option value="<?= $uneMarque->idMarque; ?>" <?= ($uneMarque->idMarque == $leProduit->idMarque) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($uneMarque->libelleMarque); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Unité de mesure</label>
                        <select name="idUnite" class="form-select">
                            <?php foreach($lesUnites as $uneUnite) { ?>
                                <option value="<?= $uneUnite->idUnite; ?>" <?= ($uneUnite->idUnite == $leProduit->idUnite) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($uneUnite->libelle); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="index.php?uc=administrer&action=listeProduitsModif" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-success px-5 fw-bold">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
