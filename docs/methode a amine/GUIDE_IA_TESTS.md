# Guide d'Architecture Documentaire et de Tests Fonctionnels (Pour Agents / Bots)

Ce fichier est un **méta-document** : il ne décrit pas une fonctionnalité métier, mais **comment lire, exécuter et documenter** les tests du projet GsbParam. Il s'adresse aux agents IA et aux développeurs qui reprennent le projet.

**Objectif :** harmoniser le suivi des User Stories (USR) du Trello avec la méthodologie de l'équipe (analogue à la [méthode à Jef](../methode%20a%20jef/)).

**Dernière session de tests documentée :** 19/05/2026 (navigateur sur WAMP local).

---

## 1. Contexte du projet

Pour chaque USR métier du périmètre Amine, le dossier `docs/methode a amine/` contient :

- une **spécification** (`USR*_*.txt`) : objectif, implémentation, sécurité, fichiers MVC ;
- un **plan de tests** (`USR*_Tests.csv`) : cas exécutables et journal des résultats réels.

La colonne `Résultat obtenu` des CSV est un **journal d'exécution** (observations navigateur), pas un modèle vide à remplir une seule fois.

---

## 2. Périmètre USR (méthode à Amine)

| USR | Thème | Fichiers | Rôle de test |
|-----|--------|----------|----------------|
| USR3 | Gestion catégories | `USR3_Gestion_Categorie.txt`, `USR3_Tests.csv` | Administrateur |
| USR6 | Avis produit | `USR6_gestion_des_avis_produit.txt`, `USR6_Tests.csv` | Client |
| USR7 | Stock produit simple | `USR7_Gestion_Stock_Produit_simple.txt`, `USR7_Tests.csv` | Visiteur (+ admin pour modif stock) |
| USR8 | Panier | `USR8_Gestion_du_panier_produit_simple.txt`, `USR8_Tests.csv` | Client |
| USR9 | Passage de commande | `USR9_Passer_la_commande.txt`, `USR9_Tests.csv` | Client |
| USR11 | Stocks globaux (back-office) | `USR11_Gestion_des_stocks.txt`, `USR11_Tests.csv` | Administrateur |
| USR13 | Mentions légales | `USR13_mention_legal.txt`, `USR13_Tests.csv` | Visiteur |
| USR15 | Mises en avant / promotions | `USR15_Produit_mis_en_avant.txt`, `USR15_Tests.csv` | Administrateur |

**Hors périmètre de ce guide :** USR documentées dans `docs/methode a jef/` (ex. USR2A, USR10, USR14). Voir aussi le [README.md](../../README.md) pour la vue d'ensemble du projet.

---

## 3. Structure type d'un fichier `USR*.txt`

- **Objectif** : besoin métier.
- **Fonctionnalités implémentées** : ce qui existe dans le code.
- **Tests et validation** : scénarios à couvrir.
- **Sécurité et robustesse** : contrôles serveur (stock, droits, intégrité).
- **Fichiers concernés** : contrôleurs, vues, `modele/ModeleFront.php`.

---

## 4. Structure des tests `USR*_Tests.csv`

- **Délimiteur :** point-virgule `;` (import Excel / LibreOffice Calc).
- **Encodage :** UTF-8 recommandé.

| Colonne | Contenu |
|---------|---------|
| Étapes du cas testées | Ex. `1`, `2-a` |
| Description du test effectué | Action réalisée |
| Résultat attendu | Comportement théorique |
| Résultat obtenu | Comportement **réel** observé |
| Conformité | `ok` ou `ko` |

---

## 5. Routage applicatif (`uc` / `action`)

Point d'entrée : `index.php`. Le routeur est dans `controleurs/Routeur.php`.

| `uc` | Contrôleur | Usage tests Amine |
|------|------------|-------------------|
| `accueil` | `ControleurAccueil` | Accueil, produits du moment (USR15) |
| `mentionsLegales` | `ControleurAccueil` | USR13 |
| `voirProduits` | `ControleurVoirProduits` | Catalogue, fiche/avis (USR6, USR7 affichage stock) |
| `gererPanier` | `ControleurGererPanier` | Panier, stock, commande (USR7, USR8, USR9) |
| `utilisateur` | `ControleurUtilisateur` | Connexion, profil (validations USR9 cas 3-a/3-b/3-c) |
| `categories` | `ControleurCategories` | CRUD catégories — **admin** (USR3) |
| `administrer` | `ControleurAdmin` | Produits, stocks, promos — **admin** (USR11, USR15) |

**URLs utiles pour les tests :**

```
http://localhost/GsbParam/index.php?uc=accueil
http://localhost/GsbParam/index.php?uc=mentionsLegales
http://localhost/GsbParam/index.php?uc=voirProduits&action=voirAvis&produit=c01
http://localhost/GsbParam/index.php?uc=voirProduits&action=voirProduits&categorie=CH
http://localhost/GsbParam/index.php?uc=gererPanier&action=voirPanier
http://localhost/GsbParam/index.php?uc=gererPanier&action=ajouterAuPanier&produit=c01&qte=1
http://localhost/GsbParam/index.php?uc=gererPanier&action=passerCommande
http://localhost/GsbParam/index.php?uc=utilisateur&action=connexion
http://localhost/GsbParam/index.php?uc=utilisateur&action=monCompte
http://localhost/GsbParam/index.php?uc=categories&action=listeCategories
http://localhost/GsbParam/index.php?uc=administrer&action=listeProduitsModif
http://localhost/GsbParam/index.php?uc=administrer&action=listeProduitsModif&filtre=critique
http://localhost/GsbParam/index.php?uc=administrer&action=gererPromotions
```

Les actions `administrer` et `categories` appellent `requireAdmin()` (rôle `2` en session).

---

## 6. Stratégie d'exécution par rôle (3 sessions)

Répartir les tests en **trois sessions** pour limiter les reconnexions. Entre chaque session : `index.php?uc=utilisateur&action=deconnexion`.

Comptes de test (voir aussi [docs/LOGIN DE CONNEXION](../LOGIN%20DE%20CONNEXION) et `BD/gsbparamv2 (1).sql`) :

### A. Session visiteur (non authentifié)

| USR | Validations |
|-----|-------------|
| USR7 | Affichage stock sur fiche produit ; blocage `ajouterAuPanier` si `qte` > stock |
| USR13 | Lien footer ; page mentions légales (éditeur, hébergeur, RGPD) |

### B. Session client

- **Identifiants :** `dupont@login.com` / `azerty45`
- **USR :** 6, 8, 9

| USR | Validations |
|-----|-------------|
| USR6 | Avis visibles ; formulaire si connecté ; un seul avis par produit |
| USR8 | Ajout, incrément quantité, suppression, vider panier |
| USR9 | Commande si connecté ; récapitulatif ; `confirmerCommande` ; validations profil |

**Connexion :** formulaire POST vers `uc=utilisateur&action=validerConnexion`, champs `mail` et `mdp`. Effacer tout contenu pré-rempli avant saisie. Soumettre avec le bouton ou Entrée après remplissage.

**Note USR9 :** le récapitulatif de commande (`v_commande.php`) est en **lecture seule**. Les cas 3-a (CP invalide), 3-b (email), 3-c (champ vide) se testent via **Mon compte** → `uc=utilisateur&action=monCompte` / `modifierProfil` (POST).

### C. Session administrateur

- **Identifiants :** `admin@gsb.fr` / `admin`
- **USR :** 3, 11, 15

| USR | Validations |
|-----|-------------|
| USR3 | Liste / ajout / doublon ID / suppression catégorie vide ; liste produits par `categorie=CH` |
| USR11 | Liste produits ; filtre `&filtre=critique` ; pastilles stock |
| USR15 | Liste promotions ; contraintes dates HTML5 ; affichage accueil |

---

## 7. Instructions pour les futures interventions IA

1. Lire le `USR*.txt` de la fonctionnalité.
2. Ouvrir le `USR*_Tests.csv` associé.
3. Vérifier que WAMP répond sur `http://localhost/GsbParam/index.php?uc=accueil`.
4. Exécuter les cas dans l'ordre de la session (visiteur → client → admin).
5. Noter dans **Résultat obtenu** ce qui est **réellement affiché** (messages, URL, quantités) — pas de supposition.
6. Mettre **Conformité** à `ok` ou `ko` ; en cas de `ko`, décrire l'écart dans Résultat obtenu.
7. Pour les formulaires POST (login, avis, catégorie, profil), privilégier la soumission explicite (bouton submit ou Entrée) après `browser_fill`.

**Produits de référence souvent utilisés :**

| ID | Produit | Usage |
|----|---------|--------|
| `c01` | Laino Shampooing (stock ~18, seuil critique) | USR7, USR11 |
| `c04` | Weleda Kids vanille | USR6, USR8, USR9 |

---

## 8. Limites connues (hors scope)

- Pas de tests automatisés PHPUnit / CI dans ce guide — uniquement **tests fonctionnels navigateur**.
- Pas de couverture des USR « méthode à Jef ».
- Certains cas destructifs ou longs (suppression catégorie avec produits, commande massive, promo expirée) peuvent être documentés comme « non rejoué » pour préserver la BDD de dev.
- Le README racine peut être en retard sur les `uc` (`administrer`, `categories`) ; se référer à `Routeur.php` en cas de doute.

---

## 9. Fichiers liés

| Fichier | Rôle |
|---------|------|
| `docs/methode a amine/USR*_*.txt` | Spécifications |
| `docs/methode a amine/USR*_Tests.csv` | Plans de tests + résultats |
| `docs/LOGIN DE CONNEXION` | Comptes de test |
| `controleurs/Routeur.php` | Routage à jour |
| `modele/ModeleFront.php` | Accès données / SQL |
