# Sujet BTS SIO - GSB Param (Boutique et Gestion de Catalogue)

## Contexte général

Ce projet a été réalisé **en binôme** dans le cadre de notre **dernière année de BTS SIO (Services Informatiques aux Organisations), option SLAM (Solutions Logicielles et Applications Métiers)**.

Le projet **GSB Paramédical** est une application web PHP destinée à la vente en ligne de produits paramédicaux pour le laboratoire GSB. Elle permet aux clients de **consulter le catalogue, gérer un panier et passer des commandes**, tout en fournissant un *Back-Office* complet à l'équipe GSB pour la gestion quotidienne (catalogue, stocks, commandes).

L'application est hébergée localement via **WAMP** et utilise une base de données **MySQL** (`gsbparamv2`).

---

## Architecture technique

| Composant | Détail |
|---|---|
| **Langage** | PHP (Orienté Objet), JavaScript, HTML5 |
| **Architecture** | MVC (Modèle – Vue – Contrôleur) |
| **Base de données** | MySQL via PDO |
| **CSS / UI** | Intégration front-end HTML/CSS |
| **Serveur** | WAMP (localhost) |
| **Routage** | Paramètre `uc` (use case) dans `index.php` |

### Point d'entrée : `index.php`

Le fichier `index.php` route les requêtes via la variable `$_REQUEST['uc']` et la classe `Routeur` :

| `uc` | Contrôleur | Accès |
|---|---|---|
| `utilisateur` | `ControleurUtilisateur.php` | Public |
| `voirProduits` | `ControleurVoirProduits.php` | Public / Administrateur |
| `gererPanier` | `ControleurGererPanier.php` | Public / Authentifié |
| `accueil` | `ControleurAccueil.php` | Public |
| (défaut) | `ControleurAccueil.php` | Public |

---

## Modèle Conceptuel de Données (MCD)

La base de données sépare rigoureusement la logique "Boutique" et "Comptes" avec ses entités principales :

### Entités clés

| Entité | Rôle | Clé primaire |
|---|---|---|
| **produit** | Cœur du catalogue (prix, description, seuils stock) | `idproduit` |
| **categorie** | Classification des produits dans le catalogue | `idCateg` |
| **client** | Fiche d'informations personnelles du client | `idClient` |
| **login** | Identifiants de connexion (email, mot de passe) | `idLogin` |
| **commande** | En-tête des commandes validées | `idCommande` |
| **contenir** | Lignes de commandes (association commande/produit) | Clés primaires `idCommande` & `idProduit` |
| **marque** / **unite** | Typologies et classifications secondaires | `idMarque` / `idUnite` |

### Relations importantes

- **client** ↔ **login** : un client est strictement lié à un compte (1:1)
- **client** ↔ **commande** : un client peut passer plusieurs commandes (1:N)
- **commande** ↔ **produit** : relation N:N via la table de liaison `contenir`
- **produit** ↔ **categorie** : un produit appartient à une catégorie
- **produit** ↔ **marque** / **unite** : un produit a une marque et une unité

---

## Modules fonctionnels implémentés

### 1. Connexion / Authentification (`uc=utilisateur`)
- Inscription de nouveaux clients avec enregistrement des coordonnées
- Login via l'adresse `mail`
- Mot de passe haché en `Bcrypt` (`password_hash`)
- Session PHP avec stockage de l'ID client, identifiants et données de panier

### 2. Gestion et Administration du catalogue (`uc=voirProduits`)

C'est un module central pour les administrateurs, avec un **CRUD complet** :

| Action | Description | Habilitation théorique |
|---|---|---|
| `voirCategories` | Afficher la liste des catégories | Public |
| `voirProduits` | Consulter les produits (avec filtres possibles) | Public |
| `ajouterProduit` | Créer un nouveau produit | Administrateur |
| `modifierProduit` | Modifier les informations d'un produit existant | Administrateur |
| `supprimerProduit`| Retirer un produit du catalogue | Administrateur |
| `ajouterCategorie`| Créer une nouvelle catégorie | Administrateur |

**Fonctionnalités spécifiques :**
- Gestion du **stock** avec système de seuil d'alerte (seuil de rupture)
- Animation / **Mise en avant** promo avec dates de début et fin

### 3. Gestion du Panier et Ventes (`uc=gererPanier`)
- Panier virtuel sauvegardé en mémoire de session (`$_SESSION`)
- Modification dynamique des quantités souhaitées
- Passage de commande **transactionnel** (ACID avec PDO et `rollback`/`commit` en cas d'erreur)

---

## Système de droits (habilitations)

*(Le système intégre une notion de base de rôle prête pour de futures évolutions, présente en BDD table `login`)*

| idRole (role) | Rôle | Droits actuels / cibles |
|---|---|---|
| **1** | Client standard | Consulter le catalogue, remplir son panier, passer des commandes |
| **2** | Administrateur (cible)| + Créer, modifier, supprimer des produits et catégories, gérer les états de commande |

---

## Fichiers du projet

```
GsbParam/
├── index.php                      ← Point d'entrée (initialisation)
├── config/.config.php             ← Configuration SQL (isolée)
├── modele/
│   ├── Modele.php                 ← Classe abstraite de connexion PDO & Transactions
│   └── ModeleFront.php            ← Fonctions et procédures SQL pour l'application
├── controleurs/
│   ├── Routeur.php                ← Fichier de routage (Switch 'uc' et 'action')
│   ├── ControleurAccueil.php      ← Logique accueil
│   ├── ControleurVoirProduits.php ← Logique gestion du catalogue
│   ├── ControleurGererPanier.php  ← Logique métier Ventes
│   └── ControleurUtilisateur.php  ← Logique authentification et inscriptions
├── vues/                          ← L'ensemble des templates d'affichage HTML/PHP
└── BD/   
    ├── gsbparamv2.sql             ← Script SQL complet
    └── ANCIEN_script_GSBPARAM.sql ← Archives bases de données
```

---

## Résumé

Ce projet est une **application de vente en ligne (e-commerce)** pour le laboratoire GSB, construite en **PHP Orienté Objet et MVC**. Elle couvre :

1. **L'authentification** et la création de compte client sécurisée.
2. **La gestion complète d'un catalogue produit** (CRUD + filtres + notions de stocks critiques).
3. **Le système complet de panier virtuel** et d'enregistrement en base des commandes.
4. **L'administration** de l'accueil et de son animation dynamique (produits mis en avant).

Ce socle démontre l'utilisation rigoureuse de **PDO transactionnel** (Commit/Rollback garanti), garantissant l'intégrité de la logique financière lors du passage en caisse.

---

## Réalisé par
* **Jef Ly**
* **Amine Agnaou**

