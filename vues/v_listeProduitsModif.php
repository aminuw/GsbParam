<h1>Choisir un produit à modifier</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Action :</th>
    </tr>
    <?php foreach($lesProduits as $unProduit) { ?>
        <tr>
            <td><?php echo $unProduit->id; ?></td>
            <td><?php echo $unProduit->description; ?></td>
            <td><?php echo $unProduit->prix; ?></td>
            <td>
                <a href="index.php?uc=voirProduits&action=modifierProduit&id=<?php echo $unProduit->id; ?>">Modifier</a>
                <a href="index.php?uc=voirProduits&action=supprimerProduit&id=<?php echo $unProduit->id; ?>"class="text-danger">Supprimer</a>
            </td>
        </tr>
    <?php } ?>
</table>
