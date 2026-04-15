<div id="contenu" class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title mb-0">Ajouter une nouvelle catégorie</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($message)): ?>
                        <div class="alert alert-success">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($erreurs)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($erreurs as $erreur): ?>
                                    <li><?php echo $erreur; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?uc=categories&action=validerAjoutCategorie" method="post">
                        <div class="mb-3">
                            <label for="id" class="form-label">Identifiant (3 caractères max)</label>
                            <input type="text" class="form-control" id="id" name="id" maxlength="3" required
                                placeholder="Ex: BIO">
                            <div class="form-text">L'identifiant doit être unique et comporter au maximum 3 caractères.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="libelle" class="form-label">Libellé</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" required
                                placeholder="Ex: Produits Bio">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-secondary">Enregistrer la catégorie</button>
                            <a href="index.php?uc=voirProduits&action=voirCategories"
                                class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>