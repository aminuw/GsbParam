<div id="produit_avis" class="container mt-4">
    <h2>Fiche produit : <?= htmlspecialchars($leProduit->nom) ?></h2>
    
    <div class="info-produit row mb-4">
        <div class="col-md-4">
            <img src="<?= htmlspecialchars($leProduit->image) ?>" alt="image produit" class="img-fluid rounded shadow-sm border">
        </div>
        <div class="col-md-8">
            <p><strong>Marque :</strong> <span class="text-primary fw-bold"><?= htmlspecialchars($leProduit->libelleMarque) ?></span></p>
            <p><strong>Contenance :</strong> <?= htmlspecialchars($leProduit->libelleUnite) ?></p>
            <p><strong>Description :</strong> <?= htmlspecialchars($leProduit->description) ?></p>
            <p><strong>Prix :</strong> <span class="badge bg-success fs-5"><?= htmlspecialchars($leProduit->prix) ?> €</span></p>
            <p>
                <strong>Note moyenne :</strong> 
                <?php if ($noteMoyenne): ?>
                    <span class="badge bg-warning text-dark fs-6"><?= $noteMoyenne ?> / 5</span>
                <?php else: ?>
                    <span class="text-muted">Aucun avis pour le moment.</span>
                <?php endif; ?>
            </p>
            <p>
                <strong>Disponibilité :</strong> 
                <?php if ($leProduit->quantiteStock > 0): ?>
                    <span class="text-success fw-bold">En stock (<?= $leProduit->quantiteStock ?> disponibles)</span>
                <?php else: ?>
                    <span class="text-danger fw-bold">Rupture de stock</span>
                <?php endif; ?>
            </p>
            
            <div class="mt-3">
                <a href="index.php?uc=gererPanier&produit=<?= $leProduit->id ?>&action=ajouterAuPanier" class="btn btn-primary">
                    <img src="assets/images/mettrepanier.png" alt="" style="height: 20px;"> Ajouter au panier
                </a>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <h3>Tous les avis</h3>
            <?php if (count($lesAvis) > 0): ?>
                <?php foreach ($lesAvis as $avis): ?>
                    <div class="un-avis card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($avis->prenom . ' ' . $avis->nom) ?> <span class="badge bg-primary float-end">Note : <?= $avis->note ?>/5</span></h5>
                            <h6 class="card-subtitle mb-2 text-muted">le <?= date('d/m/Y H:i', strtotime($avis->date_avis)) ?></h6>
                            <p class="card-text"><?= nl2br(htmlspecialchars($avis->commentaire)) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Il n'y a pas encore d'avis sur ce produit. Soyez le premier !</div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h3>Laisser un avis</h3>
            <div class="card">
                <div class="card-body">
                    <?php if (isset($_SESSION['client'])): ?>
                        <form method="POST" action="index.php?uc=voirProduits&action=validerAvis">
                            <input type="hidden" name="idProduit" value="<?= htmlspecialchars($leProduit->id) ?>">
                            <div class="mb-3">
                                <label for="note" class="form-label">Note (/5) :</label>
                                <select name="note" id="note" class="form-select" required>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Très bien</option>
                                    <option value="3">3 - Moyen</option>
                                    <option value="2">2 - Décevant</option>
                                    <option value="1">1 - Mauvais</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="commentaire" class="form-label">Votre avis :</label>
                                <textarea name="commentaire" id="commentaire" class="form-control" rows="4" required placeholder="Partagez votre expérience avec ce produit..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Envoyer mon avis</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">
                            <em>Vous devez être <a href="index.php?uc=utilisateur&action=connexion" class="alert-link">connecté(e)</a> pour laisser un avis.</em>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php if (count($lesProduitsAssocies) > 0): ?>
        <div class="produits-associes mt-4">
            <h3>Vous aimerez aussi...</h3>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach ($lesProduitsAssocies as $unP): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= htmlspecialchars($unP->image) ?>" class="card-img-top p-2" alt="<?= htmlspecialchars($unP->nom) ?>" style="height: 150px; object-fit: contain;">
                            <div class="card-body text-center">
                                <h6 class="card-title"><?= htmlspecialchars($unP->nom) ?></h6>
                                <p class="card-text text-primary fw-bold"><?= htmlspecialchars($unP->prix) ?> €</p>
                                <a href="index.php?uc=voirProduits&action=voirAvis&produit=<?= $unP->id ?>" class="btn btn-sm btn-outline-primary">Voir</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php?uc=voirProduits&action=nosProduits" class="btn btn-secondary">&larr; Retour aux produits</a>
    </div>
</div>
