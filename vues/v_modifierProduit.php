<h1>Modifier le produit</h1>

<form action="index.php?uc=voirProduits&action=validerModifProduit" method="POST">
    <!-- Champ caché pour garder l'identifiant pour la mise à jour -->
    <input type="hidden" name="id" value="<?php echo $leProduit->id; ?>">
    
    ID Produit : <?php echo $leProduit->id; ?> <br><br>
    
    Description : <input type="text" name="description" value="<?php echo $leProduit->description; ?>"><br><br>
    
    Prix : <input type="text" name="prix" value="<?php echo $leProduit->prix; ?>"><br><br>
    
    Image (lien) : <input type="text" name="image" value="<?php echo $leProduit->image; ?>"><br><br>
    
    Catégorie : 
    <select name="idCategorie">
        <?php foreach($lesCategories as $uneCategorie) { ?>
            <!-- On pré-sélectionne la catégorie actuelle du produit avec if() -->
            <option value="<?php echo $uneCategorie->id; ?>" <?php if($uneCategorie->id == $leProduit->idCategorie) echo 'selected'; ?>>
                <?php echo $uneCategorie->libelle; ?>
            </option>
        <?php } ?>
    </select><br><br>
    
    <input type="submit" value="Mettre à jour le produit">
</form>
