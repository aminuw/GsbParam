<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h1 class="h4 mb-0">Associations pour : <?= htmlspecialchars($leProduit->nom); ?></h1>
        </div>
        <div class="card-body">
            <p class="text-muted">Sélectionnez les produits qui seront suggérés ("Vous aimerez aussi...") sur la fiche de ce produit.</p>

            <form action="index.php?uc=administrer&action=validerAssociations" method="POST">
                <input type="hidden" name="idproduit" value="<?= $leProduit->id; ?>">
                
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="text-center" style="width: 80px;">Associer</th>
                                <th>Produit</th>
                                <th class="text-center">Prix</th>
                                <th class="text-center">Catégorie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tousLesProduits as $unP) { 
                                if ($unP->id != $leProduit->id) {
                                    $isAssocie = in_array($unP->id, $idsAssocies);
                            ?>
                                <tr class="<?= $isAssocie ? 'table-primary' : '' ?>">
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" name="associes[]" value="<?= $unP->id; ?>" <?= $isAssocie ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($unP->nom); ?></div>
                                        <div class="small text-muted">ID: <?= $unP->id ?></div>
                                    </td>
                                    <td class="text-center fw-bold"><?= number_format($unP->prix, 2); ?> €</td>
                                    <td class="text-center"><span class="badge bg-light text-dark border"><?= $unP->idCategorie; ?></span></td>
                                </tr>
                            <?php } 
                            } ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                    <a href="index.php?uc=administrer&action=listeProduitsModif" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">Enregistrer les associations</button>
                </div>
            </form>
        </div>
    </div>
</div>
