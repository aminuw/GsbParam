<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h1 class="h4 mb-0">Ajouter un nouveau produit au catalogue</h1>
        </div>
        <div class="card-body">
            <?php if (isset($erreurs)): ?>
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        <?php foreach ($erreurs as $erreur): ?>
                            <li><?= $erreur ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="index.php?uc=administrer&action=validerAjoutProduit" method="POST">
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">ID Produit (5 car.)</label>
                        <input type="text" name="idproduit" class="form-control" maxlength="5" placeholder="Ex: F0001" required>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label fw-bold">Nom du produit</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nom complet du produit" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Description détaillée pour la fiche produit..." required></textarea>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-bold">Image (lien ou chemin)</label>
                        <input type="text" name="image" class="form-control" placeholder="assets/images/..." required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Prix (€)</label>
                        <input type="number" step="0.01" name="prix" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Quantité Stock</label>
                        <input type="number" name="quantiteStock" class="form-control" placeholder="10" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Seuil rupture</label>
                        <input type="number" name="seuil_rupture" class="form-control" value="5" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date début mise en avant (opt.)</label>
                        <input type="date" name="mis_en_avant_date_debut" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date fin mise en avant (opt.)</label>
                        <input type="date" name="mis_en_avant_date_fin" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="idCateg" class="form-select">
                            <?php foreach($lesCategories as $uneCategorie) { ?>
                                <option value="<?= $uneCategorie->id; ?>"><?= htmlspecialchars($uneCategorie->libelle); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Marque</label>
                        <select name="idMarque" class="form-select">
                            <?php foreach($lesMarques as $uneMarque) { ?>
                                <option value="<?= $uneMarque->idMarque; ?>"><?= htmlspecialchars($uneMarque->libelleMarque); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Unité de mesure</label>
                        <select name="idUnite" class="form-select">
                            <?php foreach($lesUnites as $uneUnite) { ?>
                                <option value="<?= $uneUnite->idUnite; ?>"><?= htmlspecialchars($uneUnite->libelle); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="index.php?uc=administrer&action=listeProduitsModif" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">Créer le produit</button>
                </div>
            </form>
        </div>
    </div>
</div>
