<div id="commande">
<div class="contenuCentre">
<?php
if (isset($_SESSION['lesProduits']) && !empty($_SESSION['lesProduits']))
{
    $lesProduits = $_SESSION['lesProduits'];
    $montant = 0;
    foreach($lesProduits as $produit)
    {
        $montant = $montant + $produit['prix'] * $produit['qte'];
?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($produit['description'])?></h5>
                <p class="card-text">Prix : <?= htmlspecialchars($produit['prix'])?> €</p>
                <p class="card-text">Quantité : <?= htmlspecialchars($produit['qte'])?></p>
            </div>
        </div>
<?php
    }
?>
    <p>Montant total : <?= htmlspecialchars($montant) ?> €</p>
    <form method="POST" action="index.php?uc=gererPanier&action=confirmerCommande">
        <input type="hidden" name="valider" value="true">
        <button class="btn btn-primary" type="submit">Valider la commande</button>
    </form>
<?php
} else {
?>
    <p>Votre panier est vide.</p>
<?php
}
?>
</div>
</div>