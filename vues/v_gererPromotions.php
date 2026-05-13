<div class="container py-4">
    <div class="admin-card card">
        <div class="admin-header d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0 fw-bold">&#9733; Programmation des Mises en Avant</h1>
            <a href="index.php?uc=administrer&action=ajouterPromotion" class="btn btn-warning btn-sm fw-bold text-dark">
                + Nouvelle programmation
            </a>
        </div>

        <div class="card-body p-4">
            <?php if (isset($message)): ?>
                <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($lesProgrammations)): ?>
                <div class="text-center py-5">
                    <p class="text-muted mb-3">Aucune programmation de mise en avant n'est active ou programmée.</p>
                    <a href="index.php?uc=administrer&action=ajouterPromotion" class="btn btn-primary rounded-pill px-4">
                        + Créer la première programmation
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th class="text-center">Date de début</th>
                                <th class="text-center">Date de fin</th>
                                <th class="text-center">Statut</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lesProgrammations as $prog):
                                $today = date('Y-m-d');
                                $isActive = ($prog->mis_en_avant_date_debut <= $today && $prog->mis_en_avant_date_fin >= $today);
                                $isFuture = ($prog->mis_en_avant_date_debut > $today);
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?= htmlspecialchars($prog->image) ?>" alt=""
                                                 style="width:44px;height:44px;object-fit:contain;background:#f8f9fa;border-radius:6px;padding:3px;">
                                            <span class="fw-semibold"><?= htmlspecialchars($prog->nom) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($prog->mis_en_avant_date_debut)) ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($prog->mis_en_avant_date_fin)) ?></td>
                                    <td class="text-center">
                                        <?php if ($isActive): ?>
                                            <span class="badge badge-active rounded-pill px-3 py-2">En cours</span>
                                        <?php elseif ($isFuture): ?>
                                            <span class="badge badge-future rounded-pill px-3 py-2">Programmée</span>
                                        <?php else: ?>
                                            <span class="badge badge-expired rounded-pill px-3 py-2">Expirée</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="index.php?uc=administrer&action=supprimerPromotion&id=<?= htmlspecialchars($prog->id) ?>"
                                           class="btn btn-outline-danger btn-sm rounded-pill"
                                           onclick="return confirm('Supprimer la programmation de « <?= htmlspecialchars(addslashes($prog->nom)) ?> » ?');">
                                            Supprimer
                                        </a>
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
