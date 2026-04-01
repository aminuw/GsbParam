<h1>Ajouter un produit</h1>

<form action="index.php?uc=voirProduits&action=validerAjoutProduit" method="POST">
    ID Produit (5 caractères) : <input type="text" name="idproduit"><br><br>
    Nom du produit : <input type="text" name="nom"><br><br>
    Description : <input type="text" name="description"><br><br>
    Prix : <input type="text" name="prix"><br><br>
    Image (lien) : <input type="text" name="image"><br><br>
    Quantité en Stock : <input type="number" name="quantiteStock"><br><br>
    Seuil de rupture : <input type="number" name="seuil_rupture"><br><br>
    Date de mise en avant (début) : <input type="date" name="mis_en_avant_date_debut"><br><br>
    Date de mise en avant (fin) : <input type="date" name="mis_en_avant_date_fin"><br><br>
    
    Catégorie : 
    <select name="idCateg">
        <?php foreach($lesCategories as $uneCategorie) { ?>
            <!-- Attention: l'id côté objet reste "id" car on a utilisé un alias dans le modèle pour ne pas tout casser -->
            <option value="<?php echo $uneCategorie->id; ?>"><?php echo $uneCategorie->libelle; ?></option>
        <?php } ?>
    </select><br><br>

    Marque : 
    <select name="idMarque">
        <?php foreach($lesMarques as $uneMarque) { ?>
            <option value="<?php echo $uneMarque->idMarque; ?>"><?php echo $uneMarque->libelleMarque; ?></option>
        <?php } ?>
    </select><br><br>

    Unité : 
    <select name="idUnite">
        <?php foreach($lesUnites as $uneUnite) { ?>
            <option value="<?php echo $uneUnite->idUnite; ?>"><?php echo $uneUnite->libelle; ?></option>
        <?php } ?>
    </select><br><br>
    
    <input type="submit" value="Enregistrer le produit (V2)">
</form>
