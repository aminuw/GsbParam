<h1>Modifier le produit</h1>

<form action="index.php?uc=voirProduits&action=validerModifProduit" method="POST">
    <!-- Champ caché pour garder l'identifiant pour la mise à jour -->
    <input type="hidden" name="idproduit" value="<?php echo $leProduit->id; ?>">
    
    ID Produit : <?php echo $leProduit->id; ?> <br><br>
    
    Nom du produit : <input type="text" name="nom" value="<?php echo $leProduit->nom; ?>"><br><br>
    Description : <input type="text" name="description" value="<?php echo $leProduit->description; ?>"><br><br>
    Prix : <input type="text" name="prix" value="<?php echo $leProduit->prix; ?>"><br><br>
    Image (lien) : <input type="text" name="image" value="<?php echo $leProduit->image; ?>"><br><br>
    Quantité en Stock : <input type="number" name="quantiteStock" value="<?php echo $leProduit->quantiteStock; ?>"><br><br>
    Seuil de rupture : <input type="number" name="seuil_rupture" value="<?php echo $leProduit->seuil_rupture; ?>"><br><br>
    Date de mise en avant (début) : <input type="date" name="mis_en_avant_date_debut" value="<?php echo $leProduit->mis_en_avant_date_debut; ?>"><br><br>
    Date de mise en avant (fin) : <input type="date" name="mis_en_avant_date_fin" value="<?php echo $leProduit->mis_en_avant_date_fin; ?>"><br><br>
    
    Catégorie : 
    <select name="idCateg">
        <?php foreach($lesCategories as $uneCategorie) { ?>
            <option value="<?php echo $uneCategorie->id; ?>" <?php if($uneCategorie->id == $leProduit->idCategorie) echo 'selected'; ?>>
                <?php echo $uneCategorie->libelle; ?>
            </option>
        <?php } ?>
    </select><br><br>

    Marque : 
    <select name="idMarque">
        <?php foreach($lesMarques as $uneMarque) { ?>
            <option value="<?php echo $uneMarque->idMarque; ?>" <?php if($uneMarque->idMarque == $leProduit->idMarque) echo 'selected'; ?>>
                <?php echo $uneMarque->libelleMarque; ?>
            </option>
        <?php } ?>
    </select><br><br>

    Unité : 
    <select name="idUnite">
        <?php foreach($lesUnites as $uneUnite) { ?>
            <option value="<?php echo $uneUnite->idUnite; ?>" <?php if($uneUnite->idUnite == $leProduit->idUnite) echo 'selected'; ?>>
                <?php echo $uneUnite->libelle; ?>
            </option>
        <?php } ?>
    </select><br><br>
    
    <input type="submit" value="Mettre à jour le produit (V2)">
</form>
