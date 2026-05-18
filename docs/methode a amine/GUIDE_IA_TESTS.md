# Guide d'Architecture Documentaire et de Tests Fonctionnels (Pour Agents / Bots)

Ce fichier sert de point de repère pour tout agent IA (ou développeur) qui reprendrait le projet GsbParam dans le futur. Il explique l'organisation de la documentation ("Méthode à Amine") et la procédure de test validée.

## 1. Contexte du Projet
L'objectif de cette documentation était d'harmoniser le suivi des User Stories (USR) avec la méthodologie de l'équipe (similaire à "la méthode à Jef"). Pour chaque USR métier du Trello, nous avons documenté le fonctionnement théorique puis généré des cas de tests pratiques.

## 2. Structure des Fichiers de Spécifications (USR*.txt)
Situés dans `docs/methode a amine/`, les fichiers `.txt` contiennent les spécifications techniques de chaque fonctionnalité.
**Structure type :**
- **Objectif** : Ce que fait la fonctionnalité.
- **Logique métier / SQL** : Les requêtes (souvent dans `ModeleFront.php`) associées.
- **Fonctionnalités implémentées** : Ce qui a été développé.
- **Sécurité et Robustesse** : Les contrôles côté serveur (ex: vérification de stock max).
- **Fichiers concernés** : La liste exacte des fichiers MVC (Vues, Contrôleurs, Modèles) impliqués.

## 3. Structure des Tests Fonctionnels (USR*_Tests.csv)
Afin de pouvoir les importer dans un tableur (Excel / LibreOffice Calc avec délimiteur point-virgule `;`), les plans de tests fonctionnels ont été convertis en `.csv`.
**Colonnes :**
1. `Étapes du cas testées` (ex: 1, 1-a, 2)
2. `Description du test effectué` (Action)
3. `Résultat attendu` (Comportement théorique)
4. `Résultat obtenu` (Comportement RÉEL observé lors du test par l'agent navigateur)
5. `Conformité` (ok / ko)

## 4. Stratégie d'Exécution des Tests
Les tests ont été exécutés dynamiquement en simulant un navigateur humain via l'IA. Ils sont répartis en 3 sessions (rôles) pour limiter les allers-retours de connexion :

### A. Session Visiteur (Non authentifié)
- **Cible :** `USR7` (Stock Produit simple), `USR13` (Mentions légales).
- **Validation :** Navigation publique, vérification des erreurs de panier (stock max dépassé).

### B. Session Client (Authentifié)
- **Identifiants :** `dupont@login.com` / `azerty45`
- **Cible :** `USR6` (Avis), `USR8` (Panier), `USR9` (Passage de commande).
- **Validation :** Dépôt d'avis (et blocage des doublons), modification dynamique du panier, soumission d'une commande avec vérification des formats (ex: Code Postal 'ABCD' rejeté).

### C. Session Administrateur (Authentifié)
- **Identifiants :** `admin@gsb.fr` / `admin`
- **Cible :** `USR3` (Catégories), `USR11` (Stocks globaux), `USR15` (Mises en avant).
- **Validation :** Création/Suppression (ex: blocage des ID en doublon), filtres de rupture de stock (pastilles rouges), dates de promotions (impossibilité de mettre une date de fin avant la date de début).

## 5. Instructions pour les Futures Interventions de l'IA
Si un agent doit tester de nouvelles fonctionnalités ou corriger un bug :
1. Lire la spécification technique (`USR*.txt`).
2. Ouvrir le `USR*_Tests.csv` correspondant.
3. Lancer un agent navigateur localement sur `http://localhost/GsbParam/index.php?uc=accueil` en utilisant les credentials ci-dessus. *Important : toujours effacer les champs pré-remplis de la page de login.*
4. Mettre à jour la colonne `Résultat obtenu` du CSV en fonction du comportement réel de l'application et non d'une supposition.
