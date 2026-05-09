<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h2 class="h5 mb-0 fw-bold"><i class="bi bi-cart3 me-2"></i>Votre Panier</h2>
        </div>
        <div class="card-body">
            <?php if (empty($lesProduitsDuPanier)): ?>
                <p class="text-center text-muted py-5">Votre panier est vide.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">Prix Unitaire</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lesProduitsDuPanier as $unProduit): 
                                $id = $unProduit->id;
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $unProduit->image ?>" alt="" class="rounded me-3" style="width: 50px; height: 50px; object-fit: contain; background: #f8f9fa;">
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($unProduit->nom) ?></div>
                                                <div class="small text-muted"><?= substr(htmlspecialchars($unProduit->description), 0, 50) ?>...</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 150px;">
                                        <form action="index.php?uc=gererPanier&action=modifierQuantite" method="post" class="d-flex justify-content-center align-items-center">
                                            <input type="hidden" name="produit" value="<?= $id ?>">
                                            <input type="number" name="qte" value="<?= $qteProduits[$id] ?>" min="1" class="form-control form-control-sm" style="width: 60px;">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">OK</button>
                                        </form>
                                    </td>
                                    <td class="text-center fw-bold"><?= number_format($unProduit->prix, 2) ?> €</td>
                                    <td class="text-end">
                                        <a href="index.php?uc=gererPanier&produit=<?= $id ?>&action=supprimerUnProduit" class="btn btn-link p-0" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
                                            <img src="assets/images/retirerpanier.png" title="Retirer du panier" alt="Retirer" style="height: 30px;">
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <a href="index.php?uc=gererPanier&action=viderPanier" class="btn btn-outline-danger btn-sm">Vider le panier</a>
                    <a href="index.php?uc=gererPanier&action=passerCommande" class="btn btn-link p-0 border-0">
                        <img src="assets/images/commander.jpg" title="Passer la commande" alt="Commander" style="width: 150px;">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
