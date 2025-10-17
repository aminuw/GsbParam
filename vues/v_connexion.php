
<div class="container">
    <h2>Connexion</h2>

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

    <form action="index.php?uc=utilisateur&action=validerConnexion" method="post">
        <fieldset>
            <div class="form-group">
                <label for="email">Email (login) :</label>
                <input id="email" type="email" name="mail" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe :</label>
                <input id="mdp" type="password" name="mdp" class="form-control" required>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <a href="index.php?uc=utilisateur&action=inscription" class="btn btn-link">Pas encore de compte ? S'inscrire</a>
    </form>
</div>
