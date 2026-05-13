<div id="accueil">

    <!-- Hero : texte de bienvenue (original conservé) -->
    <div id="textAccueil">
        <h1>La société Gsb</h1>
        <h2>
            <p>vous souhaite la bienvenue sur son site de vente en ligne,<br/>
            de produits paramédicaux et bien-être<br/>
            à destination des particuliers.</p>
            <p>Avec plus de 2000 produits paramédicaux à la vente, GsbPara vous propose à
            un tarif compétitif un large panel de produits livrés rapidement chez vous !</p>
        </h2>
        <a href="index.php?uc=voirProduits&action=nosProduits" class="btn btn-outline-primary rounded-pill px-4 mt-2">
            Voir nos produits &rarr;
        </a>
    </div>

    <!-- Produits mis en avant (USR15) -->
    <?php if (!empty($lesProduitsEnAvant)): ?>
    <div class="section-alaune w-100">
        <div class="container">
            <div class="section-title">
                <span class="badge-alaune">&#9733; À la une</span>
                <h2 class="h4">Nos produits du moment</h2>
            </div>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                <?php foreach ($lesProduitsEnAvant as $unProduit): ?>
                <div class="col">
                    <a href="index.php?uc=voirProduits&action=voirAvis&produit=<?= htmlspecialchars($unProduit->id) ?>" class="text-decoration-none">
                        <div class="card-produit h-100">
                            <div class="img-wrapper">
                                <img src="<?= htmlspecialchars($unProduit->image) ?>" alt="<?= htmlspecialchars($unProduit->nom) ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-title fw-semibold mb-2"><?= htmlspecialchars($unProduit->nom) ?></p>
                                <div class="mt-auto d-flex justify-content-between align-items-center border-top pt-2">
                                    <span class="prix"><?= number_format($unProduit->prix, 2, ',', ' ') ?> &euro;</span>
                                    <span class="btn btn-sm btn-outline-primary btn-voir">Voir</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
