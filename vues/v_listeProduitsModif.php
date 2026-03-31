<h1>Choisir un produit à modifier</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Action</th>
    </tr>
    <?php foreach($lesProduits as $unProduit) { ?>
        <tr>
            <td><?php echo $unProduit->id; ?></td>
            <td><?php echo $unProduit->description; ?></td>
            <td><?php echo $unProduit->prix; ?></td>
            <td>
                <!-- Lien hypertexte menant au formulaire de modification, en passant l'ID du produit -->
                <a href="index.php?uc=voirProduits&action=modifierProduit&id=<?php echo $unProduit->id; ?>">Modifier</a>
            </td>
        </tr>
    <?php } ?>
</table>
