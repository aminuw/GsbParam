<div id="categories">
    <h2>Catégorie | <?php echo isset($laCategorie->libelle) ? $laCategorie->libelle : 'Tous nos produits' ?></h2>

    <?php if (!isset($lesMarques)): ?>
        <ul>
            <?php
            foreach ($lesCategories as $uneCategorie) {
                $idCategorie = $uneCategorie->id;
                $libCategorie = $uneCategorie->libelle;
            ?>
                <li>
                    <a class="text-decoration-none text-light"
                        href="index.php?uc=voirProduits&action=voirProduits&categorie=<?= $idCategorie ?>">
                        <?= $libCategorie ?></a>
                </li>
            <?php
            } ?>
        </ul>
    <?php endif; ?>

    <?php if (isset($lesMarques)): ?>
        <br>
        <form action="index.php?uc=voirProduits&action=nosProduits" method="POST">
            <label>Catégorie :</label><br>
            <select name="lstCategorie">
                <option value="tous">Toutes</option>
                <?php foreach ($lesCategories as $uneCategorie): ?>
                    <option value="<?= $uneCategorie->id ?>" <?= (isset($idCateg) && $idCateg == $uneCategorie->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($uneCategorie->libelle) ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Marque :</label><br>
            <select name="lstMarque">
                <option value="toutes">Toutes</option>
                <?php foreach ($lesMarques as $uneMarque): ?>
                    <option value="<?= $uneMarque->idMarque ?>" <?= (isset($idMarque) && $idMarque == $uneMarque->idMarque) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($uneMarque->libelleMarque) ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Prix Min :</label><br>
            <input type="number" step="0.01" name="txtPrixMin" placeholder="Ex: 10" value="<?= htmlspecialchars($prixMin ?? '') ?>"><br>

            <label>Prix Max :</label><br>
            <input type="number" step="0.01" name="txtPrixMax" placeholder="Ex: 100" value="<?= htmlspecialchars($prixMax ?? '') ?>"><br>

            <input type="submit" value="Filtrer">
        </form>
        <?php if (isset($erreurFiltre)): ?>
            <p style="color: red; font-size: 0.8em;"><?= $erreurFiltre ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>