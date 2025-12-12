<div id="commande" class="container">
    <h2>Récapitulatif de la commande</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Informations de livraison</h5>
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> <?= htmlspecialchars($nom ?? '') ?></p>
            <p><strong>Adresse :</strong> <?= htmlspecialchars($rue ?? '') ?></p>
            <p><strong>Ville :</strong> <?= htmlspecialchars($cp ?? '') ?> <?= htmlspecialchars($ville ?? '') ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($mail ?? '') ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Produits commandés</h5>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['produits']) && !empty($_SESSION['produits'])) {
                // Récupérer les produits du panier
                $lesIdProduits = array_keys($_SESSION['produits']);
                $modeleFront = new ModeleFront();
                $lesProduits = $modeleFront->getLesProduitsDuTableau($lesIdProduits);
                $qteProduits = $_SESSION['produits'];
                $montant = 0;

                echo '<table class="table table-striped">';
                echo '<thead><tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Sous-total</th></tr></thead>';
                echo '<tbody>';

                foreach ($lesProduits as $produit) {
                    $qte = $qteProduits[$produit->id];
                    $sousTotal = $produit->prix * $qte;
                    $montant += $sousTotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($produit->description) ?></td>
                        <td><?= htmlspecialchars($produit->prix) ?> €</td>
                        <td><?= htmlspecialchars($qte) ?></td>
                        <td><?= htmlspecialchars($sousTotal) ?> €</td>
                    </tr>
                    <?php
                }
                echo '</tbody>';
                echo '</table>';
                ?>
                <div class="text-end">
                    <h4>Total : <?= htmlspecialchars($montant) ?> €</h4>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php?uc=gererPanier&action=voirPanier" class="btn btn-secondary">Modifier le panier</a>
                    <form method="POST" action="index.php?uc=gererPanier&action=confirmerCommande">
                        <button class="btn btn-success btn-lg" type="submit">Confirmer la commande</button>
                    </form>
                </div>
                <?php
            } else {
                ?>
                <p class="alert alert-warning">Votre panier est vide.</p>
                <a href="index.php?uc=voirProduits&action=nosProduits" class="btn btn-primary">Voir nos produits</a>
                <?php
            }
            ?>
        </div>
    </div>
</div>