<div class="container">
    <h2>Inscription</h2>

    <?php
    if (isset($message)) {
        echo '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
    }
    if (isset($erreurs) && !empty($erreurs)) {
        echo '<div class="alert alert-danger"><ul>';
        foreach ($erreurs as $erreur) {
            echo '<li>' . htmlspecialchars($erreur) . '</li>';
        }
        echo '</ul></div>';
    }
    ?>

    <p>Pour pouvoir commander, merci de vous inscrire.</p>
    <form action="index.php?uc=utilisateur&action=validerInscription" method="post">
        <fieldset>
            <legend>Vos informations personnelles</legend>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input id="nom" type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input id="prenom" type="text" name="prenom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email (login) :</label>
                <input id="email" type="email" name="mail" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe :</label>
                <input id="mdp" type="password" name="mdp" class="form-control" required>
            </div>
        </fieldset>
        <fieldset>
            <legend>Votre adresse</legend>
            <div class="form-group">
                <label for="rue">Rue :</label>
                <input id="rue" type="text" name="rue" class="form-control">
            </div>
            <div class="form-group">
                <label for="ville">Ville :</label>
                <input id="ville" type="text" name="ville" class="form-control">
            </div>
            <div class="form-group">
                <label for="cp">Code Postal :</label>
                <input id="cp" type="text" name="cp" class="form-control" pattern="[0-9]{5}">
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
        <a href="index.php?uc=utilisateur&action=connexion" class="btn btn-link">Déjà un compte ? Se connecter</a>
    </form>
</div>