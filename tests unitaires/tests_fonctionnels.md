# Plan de Tests Fonctionnels - Authentification et Commande

Ce document décrit les tests manuels à effectuer pour vérifier la bonne implémentation des fonctionnalités d'authentification et de commande client.

---

### 1. Inscription (Création de compte)

| Test | Action à réaliser | Résultat attendu |
| :--- | :--- | :--- |
| 1.1 | Cliquer sur "S'inscrire" depuis le bandeau. | Affichage du formulaire d'inscription. |
| 1.2 | Remplir le formulaire avec des informations valides et uniques, puis valider. | Redirection vers la page de connexion avec un message "Inscription réussie !". Le client est créé en base de données. |
| 1.3 | Tenter de s'inscrire à nouveau avec la même adresse e-mail. | Un message d'erreur s'affiche sur la page d'inscription, indiquant que l'email est déjà utilisé. |
| 1.4 | Valider le formulaire en laissant des champs obligatoires (ex: nom, email) vides. | Un message d'erreur s'affiche, demandant de remplir tous les champs obligatoires. |

---

### 2. Connexion & Déconnexion

| Test | Action à réaliser | Résultat attendu |
| :--- | :--- | :--- |
| 2.1 | Depuis la page de connexion, saisir l'email et le mot de passe d'un utilisateur valide. | Redirection vers la page d'accueil. Le bandeau affiche "Bonjour, [Prénom]" et un lien "Déconnexion". |
| 2.2 | Tenter de se connecter avec un mot de passe incorrect. | Un message d'erreur "Email ou mot de passe incorrect" s'affiche sur la page de connexion. |
| 2.3 | Tenter de se connecter avec une adresse email qui n'existe pas en base de données. | Le même message d'erreur "Email ou mot de passe incorrect" s'affiche. |
| 2.4 | Une fois connecté, cliquer sur le lien "Déconnexion". | Redirection vers la page d'accueil. Le bandeau affiche à nouveau les liens "S'inscrire" et "Se connecter". |

---

### 3. Processus de Commande

| Test | Action à réaliser | Résultat attendu |
| :--- | :--- | :--- |
| 3.1 | Ajouter des produits au panier, puis cliquer sur "Mon panier" et "Passer la commande" sans être connecté. | Redirection vers la page de connexion avec un message "Vous devez être connecté pour passer une commande.". |
| 3.2 | Se connecter, ajouter des produits au panier, puis cliquer sur "Passer la commande". | Affichage de la page de commande avec les informations du client (nom, adresse, etc.) pré-remplies. |
| 3.3 | Vérifier que les champs d'information sur la page de commande sont en lecture seule (`readonly`). | Il est impossible de modifier son nom, son adresse, etc., sur cette page. |
| 3.4 | Cliquer sur le bouton "Confirmer la commande". | Affichage d'un message de succès "La commande a été enregistrée". Le panier est vidé. |
| 3.5 | **(BDD)** | Vérifier dans la table `commande` qu'une nouvelle ligne a été créée avec le bon `idClient`. Vérifier que la table `contenir` contient les produits de la commande. |

