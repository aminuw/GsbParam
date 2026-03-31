<h1>Ajouter un produit</h1>

<form action="index.php?uc=voirProduits&action=validerAjoutProduit" method="POST">
    ID Produit : <input type="text" name="id"><br><br>
    Description : <input type="text" name="description"><br><br>
    Prix : <input type="text" name="prix"><br><br>
    Image (lien) : <input type="text" name="image"><br><br>
    Catégorie : 
    <select name="idCategorie">
        <?php foreach($lesCategories as $uneCategorie) { ?>
            <option value="<?php echo $uneCategorie->id; ?>"><?php echo $uneCategorie->libelle; ?></option>
        <?php } ?>
    </select><br><br>
    
    <input type="submit" value="Enregistrer le produit">
</form>
