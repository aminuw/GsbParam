<div id="espace_client" class="container mt-4">
    <h1 class="mb-4">Mon Espace Client</h1>

    <div class="row">
        <!-- Menu latéral de l'espace client -->
        <div class="col-md-3">
            <div class="list-group shadow-sm mb-4" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-profil-list" data-bs-toggle="list" href="#list-profil" role="tab">Mon Profil</a>
                <a class="list-group-item list-group-item-action" id="list-commandes-list" data-bs-toggle="list" href="#list-commandes" role="tab">Mes Commandes</a>
                <a class="list-group-item list-group-item-action" id="list-avis-list" data-bs-toggle="list" href="#list-avis" role="tab">Mes Avis déposés</a>
            </div>
        </div>

        <!-- Contenu des onglets -->
        <div class="col-md-9">
            <div class="tab-content" id="nav-tabContent">
                
                <!-- Onglet Profil -->
                <div class="tab-pane fade show active" id="list-profil" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white fw-bold">Modifier mes informations personnelles</div>
                        <div class="card-body">
                            <?php if (isset($erreurs)): ?>
                                <div class="alert alert-danger shadow-sm">
                                    <ul class="mb-0">
                                        <?php foreach ($erreurs as $erreur): ?>
                                            <li><?= $erreur ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <form action="index.php?uc=utilisateur&action=modifierProfil" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nom</label>
                                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($_SESSION['client']->nom) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($_SESSION['client']->prenom) ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Adresse (Rue)</label>
                                        <input type="text" name="rue" class="form-control" value="<?= htmlspecialchars($_SESSION['client']->rue) ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Code Postal</label>
                                        <input type="text" name="cp" class="form-control" value="<?= htmlspecialchars($_SESSION['client']->cp) ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Ville</label>
                                        <input type="text" name="ville" class="form-control" value="<?= htmlspecialchars($_SESSION['client']->ville) ?>">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4">Enregistrer les modifications</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet Commandes -->
                <div class="tab-pane fade" id="list-commandes" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white fw-bold">Historique de mes commandes</div>
                        <div class="card-body">
                            <?php if (count($lesCommandes) == 0): ?>
                                <p class="text-muted">Vous n'avez pas encore passé de commande.</p>
                            <?php else: ?>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>N° Commande</th>
                                            <th>Date</th>
                                            <th>État</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($lesCommandes as $uneC): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($uneC->idCommande) ?></strong></td>
                                                <td><?= date('d/m/Y', strtotime($uneC->dateCommande)) ?></td>
                                                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($uneC->etat) ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Onglet Avis -->
                <div class="tab-pane fade" id="list-avis" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark fw-bold">Mes avis déposés</div>
                        <div class="card-body">
                            <?php if (count($lesAvis) == 0): ?>
                                <p class="text-muted">Vous n'avez pas encore déposé d'avis.</p>
                            <?php else: ?>
                                <?php foreach ($lesAvis as $unA): ?>
                                    <div class="border-bottom mb-3 pb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-1 text-primary"><?= htmlspecialchars($unA->nomProduit) ?></h6>
                                            <span class="badge bg-secondary">Note : <?= $unA->note ?>/5</span>
                                        </div>
                                        <p class="mb-1 small text-muted">Le <?= date('d/m/Y', strtotime($unA->date_avis)) ?></p>
                                        <p class="mb-0 italic">"<?= nl2br(htmlspecialchars($unA->commentaire)) ?>"</p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
