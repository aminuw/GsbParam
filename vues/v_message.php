<?php
// Déterminer la classe CSS en fonction du type de message
$alertClass = "alert-info"; // Par défaut
if (isset($messageType)) {
    if ($messageType === "success") {
        $alertClass = "alert-success";
    } elseif ($messageType === "error") {
        $alertClass = "alert-danger";
    } elseif ($messageType === "warning") {
        $alertClass = "alert-warning";
    }
}
?>
<div class="container mt-4">
    <div id="message" class="alert <?= $alertClass ?>" role="alert">
        <?php if (isset($messageType)) { ?>
            <?php if ($messageType === "error"): ?>
                <strong>Erreur :</strong>
            <?php elseif ($messageType === "success"): ?>
                <strong>Succès :</strong>
            <?php endif; ?>
        <?php } ?>

        <?= htmlspecialchars($message) ?>
    </div>

    <div class="mt-3">
        <?php if (isset($messageType) && $messageType === "error"): ?>
            <a href="index.php?uc=gererPanier&action=voirPanier" class="btn btn-primary">Retour au panier</a>
        <?php else: ?>
            <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="index.php?uc=voirProduits&action=nosProduits" class="btn btn-secondary">Continuer les achats</a>
        <?php endif; ?>
    </div>
</div>