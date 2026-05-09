<div id="detail_commande" class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détail de la commande n°<?= htmlspecialchars($idCommande) ?></h1>
        <a href="index.php?uc=administrer&action=gestionCommandes" class="btn btn-secondary">&larr; Retour à la liste</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            Articles commandés
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th>Marque</th>
                        <th>Catégorie</th>
                        <th class="text-center">Prix Unitaire</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lesArticles as $unA): ?>
                        <tr>
                            <td><?= htmlspecialchars($unA->nom) ?></td>
                            <td><?= htmlspecialchars($unA->libelleMarque) ?></td>
                            <td><?= htmlspecialchars($unA->libelleCateg) ?></td>
                            <td class="text-center"><?= number_format($unA->prix, 2) ?> €</td>
                            <td class="text-center"><?= $unA->qte ?></td>
                            <td class="text-end fw-semibold"><?= number_format($unA->prix * $unA->qte, 2) ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light border-top-2">
                    <tr>
                        <td colspan="5" class="text-end fw-bold fs-5">Prix Total de la commande :</td>
                        <td class="text-end fw-bold fs-5 text-primary"><?= number_format($totalCommande, 2) ?> €</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
