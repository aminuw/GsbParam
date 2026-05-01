<div id="produit_avis" class="container mt-4">
    <h2>Avis sur le produit : <?= htmlspecialchars($leProduit->nom) ?></h2>
    
    <div class="info-produit row mb-4">
        <div class="col-md-3">
            <img src="<?= htmlspecialchars($leProduit->image) ?>" alt="image produit" class="img-fluid rounded">
        </div>
        <div class="col-md-9">
            <p><strong>Description :</strong> <?= htmlspecialchars($leProduit->description) ?></p>
            <p><strong>Prix :</strong> <span class="badge bg-success"><?= htmlspecialchars($leProduit->prix) ?> €</span></p>
            <p>
                <strong>Note moyenne :</strong> 
                <?php if ($noteMoyenne): ?>
                    <span class="badge bg-warning text-dark fs-6"><?= $noteMoyenne ?> / 5</span>
                <?php else: ?>
                    <span class="text-muted">Aucun avis pour le moment.</span>
                <?php endif; ?>
            </p>
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

    <div class="mt-4">
        <a href="index.php?uc=voirProduits&action=nosProduits" class="btn btn-secondary">&larr; Retour aux produits</a>
    </div>
</div>
