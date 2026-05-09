<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><?php echo empty($laCategorie) ? 'Nos Produits' : 'Produits : ' . htmlspecialchars($laCategorie->libelle); ?></h2>
    </div>

    <?php if (count($lesProduits) == 0): ?>
        <div class="alert alert-info text-center shadow-sm py-4">
            <i class="bi bi-search fs-1 d-block mb-3"></i>
            <h5 class="mb-0">Désolé, aucun produit ne correspond à votre recherche.</h5>
            <p class="text-muted mt-2">Essayez de modifier vos filtres ou de réinitialiser la recherche.</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="liste-produits">
            <?php foreach ($lesProduits as $unProduit): 
                $id = $unProduit->id;
                $nom = $unProduit->nom;
                $prix = $unProduit->prix;
                $image = $unProduit->image;
            ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 product-card overflow-hidden">
                        <div class="position-relative">
                            <img src="<?= $image ?>" class="card-img-top p-3" alt="<?= htmlspecialchars($nom) ?>" style="height: 200px; object-fit: contain; background: #fff;">
                            <span class="position-absolute top-0 end-0 m-2 badge bg-primary"><?= number_format($prix, 2) ?> €</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title h6 fw-bold mb-3"><?= htmlspecialchars($nom) ?></h5>
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="index.php?uc=voirProduits&action=voirAvis&produit=<?= $id ?>" class="btn btn-outline-dark btn-sm">
                                        <i class="bi bi-info-circle me-1"></i> Détails / Avis
                                    </a>
                                    <a href="index.php?uc=gererPanier&produit=<?= $id ?>&action=ajouterAuPanier" class="btn btn-primary btn-sm fw-bold">
                                        <i class="bi bi-cart-plus me-1"></i> Ajouter au panier
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>
