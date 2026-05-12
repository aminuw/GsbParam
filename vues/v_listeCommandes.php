<div id="gestion_commandes" class="container mt-4">
    <h1 class="mb-4">Gestion des Commandes</h1>

    <?php if (count($lesCommandes) == 0): ?>
        <div class="alert alert-warning">
            Aucune commande n'a été passée pour le moment.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead class="table-light">
                    <tr>
                        <th>ID Commande</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>État Actuel</th>
                        <th>Changer l'état</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lesCommandes as $uneC): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($uneC->idCommande) ?></strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($uneC->dateCommande)) ?></td>
                            <td><?= htmlspecialchars($uneC->prenom . ' ' . $uneC->nom) ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?= htmlspecialchars($uneC->etat) ?></span>
                            </td>
                            <td>
                                <form action="index.php?uc=administrer&action=modifierEtat" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="idCommande" value="<?= $uneC->idCommande ?>">
                                    <select name="idEtat" class="form-select form-select-sm me-2" style="width: 150px;">
                                        <?php foreach ($lesEtats as $unE): ?>
                                            <option value="<?= $unE->idEtat ?>" <?= ($unE->idEtat == $uneC->idEtat) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($unE->libelle) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success">Valider</button>
                                </form>
                            </td>
                            <td>
                                <a href="index.php?uc=administrer&action=voirArticles&id=<?= $uneC->idCommande ?>" class="btn btn-sm btn-primary">
                                    Liste des articles
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
