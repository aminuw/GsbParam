<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">Gestion des Produits Associés</h2>
        <a href="index.php?uc=administrer&action=ajouterAssociation" class="btn btn-primary shadow-sm fw-bold">
            <i class="bi bi-plus-circle"></i> Créer une association
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (empty($lesAssociations)): ?>
                <div class="alert alert-warning text-center mb-0">
                    Il n'existe pas d'associations pour le moment.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produit 1</th>
                                <th>Produit 2 (Associé)</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lesAssociations as $assoc): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($assoc->nom1) ?></div>
                                        <div class="small text-muted">ID: <?= $assoc->idproduit ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($assoc->nom2) ?></div>
                                        <div class="small text-muted">ID: <?= $assoc->idproduit_associer ?></div>
                                    </td>
                                    <td class="text-end">
                                        <a href="index.php?uc=administrer&action=modifierAssociation&id1=<?= $assoc->idproduit ?>&id2=<?= $assoc->idproduit_associer ?>" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                        <a href="index.php?uc=administrer&action=supprimerAssociation&id1=<?= $assoc->idproduit ?>&id2=<?= $assoc->idproduit_associer ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette association ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
