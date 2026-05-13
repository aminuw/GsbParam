<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">Gestion du Catalogue Produits</h1>
            <div>
                <?php if (isset($filtreCritique) && $filtreCritique): ?>
                    <a href="index.php?uc=administrer&action=listeProduitsModif" class="btn btn-outline-light btn-sm me-2">Voir tous les produits</a>
                <?php else: ?>
                    <a href="index.php?uc=administrer&action=listeProduitsModif&filtre=critique" class="btn btn-warning btn-sm fw-bold text-dark me-2">Stocks Critiques</a>
                <?php endif; ?>
                <a href="index.php?uc=administrer&action=ajouterProduit" class="btn btn-success btn-sm fw-bold">+ Nouveau Produit</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Catégorie</th>
                            <th>Marque</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lesProduits as $unProduit) { ?>
                            <tr>
                                <td class="ps-3"><span class="badge bg-secondary"><?php echo $unProduit->id; ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $unProduit->image; ?>" alt="" class="rounded me-2" style="width: 40px; height: 40px; object-fit: contain; background: #f8f9fa;">
                                        <div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($unProduit->nom); ?></div>
                                            <div class="small text-muted"><?php echo substr(htmlspecialchars($unProduit->description), 0, 50) . '...'; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-bold"><?php echo number_format($unProduit->prix, 2); ?> €</td>
                                <td>
                                    <?php if($unProduit->quantiteStock <= $unProduit->seuil_rupture): ?>
                                        <span class="badge bg-danger">Alerte : <?php echo $unProduit->quantiteStock; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?php echo $unProduit->quantiteStock; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="small"><?php echo $unProduit->idCategorie; ?></span></td>
                                <td><span class="small"><?php echo $unProduit->idMarque; ?></span></td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        <a href="index.php?uc=administrer&action=modifierProduit&id=<?php echo $unProduit->id; ?>" class="btn btn-outline-primary btn-sm" title="Modifier">
                                            <i class="bi bi-pencil"></i> Modif.
                                        </a>
                                        <a href="index.php?uc=administrer&action=gererAssociations&id=<?php echo $unProduit->id; ?>" class="btn btn-outline-info btn-sm" title="Associer">
                                            Assoc.
                                        </a>
                                        <a href="index.php?uc=administrer&action=supprimerProduit&id=<?php echo $unProduit->id; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');" title="Supprimer">
                                            Suppr.
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
