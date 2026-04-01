<h1>Choisir un produit à modifier</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Image</th>
        <th>Stock</th>
        <th>Seuil rupture</th>
        <th>Début mise en avant</th>
        <th>Fin mise en avant</th>
        <th>Catégorie</th>
        <th>Marque</th>
        <th>Unité</th>
        <th>Action :</th>
    </tr>
    <?php foreach($lesProduits as $unProduit) { ?>
        <tr>
            <td><?php echo $unProduit->id; ?></td>
            <td><strong><?php echo $unProduit->nom; ?></strong></td>
            <td><?php echo $unProduit->description; ?></td>
            <td><?php echo $unProduit->prix; ?> €</td>
            <!-- On affiche juste le nom du lien de l'image pour que ça rentre dans le tableau -->
            <td><?php echo basename($unProduit->image); ?></td>
            <td><?php echo $unProduit->quantiteStock; ?></td>
            <td><?php echo $unProduit->seuil_rupture; ?></td>
            <td><?php echo $unProduit->mis_en_avant_date_debut; ?></td>
            <td><?php echo $unProduit->mis_en_avant_date_fin; ?></td>
            <td><?php echo $unProduit->idCategorie; ?></td>
            <td><?php echo $unProduit->idMarque; ?></td>
            <td><?php echo $unProduit->idUnite; ?></td>
            <td>
                <a href="index.php?uc=voirProduits&action=modifierProduit&id=<?php echo $unProduit->id; ?>">Modifier</a><br>
                <a href="index.php?uc=voirProduits&action=supprimerProduit&id=<?php echo $unProduit->id; ?>" class="text-danger">Supprimer</a>
            </td>
        </tr>
    <?php } ?>
</table>
