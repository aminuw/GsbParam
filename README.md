# Sujet BTS SIO - GSB Param (Catalogue et Commandes)

## Contexte général

Ce projet a été adapté ou réalisé dans le cadre du BTS SIO (Services Informatiques aux Organisations), option SLAM (Solutions Logicielles et Applications Métiers).

Le projet **GsbParam** est une application web PHP orientée objet, destinée à la gestion d'un catalogue de produits (matériel paramédical ou produits du laboratoire GSB). Elle permet la consultation des produits, la gestion d'un panier d'achat, la passation de commandes, et offre des fonctionnalités d'administration pour la gestion du catalogue (CRUD sur les produits et catégories).

L'application est conçue pour être hébergée localement via WAMP et utilise une base de données MySQL.

## Architecture technique

| Composant | Détail |
| --- | --- |
| **Langage** | PHP (Orienté Objet) |
| **Architecture** | MVC (Modèle – Vue – Contrôleur) |
| **Base de données** | MySQL via PDO |
| **Serveur** | WAMP (localhost) |
| **Routage** | Paramètre `uc` (use case) dans `index.php` et `Routeur` |

## Point d'entrée : `index.php`

Le fichier `index.php` initialise l'application et délègue le traitement à la classe `Routeur`. Le routage s'effectue via le paramètre `uc` passé dans l'URL :

| uc | Contrôleur | Rôle / Accès |
| --- | --- | --- |
| `accueil` | `ControleurAccueil.php` | Page d'accueil de la boutique. (Public) |
| `voirProduits` | `ControleurVoirProduits.php` | Affichage du catalogue et administration des produits (CRUD). |
| `gererPanier` | `ControleurGererPanier.php` | Gestion du panier (ajout/suppression/quantité) et validation de commande. |
| `utilisateur` | `ControleurUtilisateur.php` | Inscription, connexion, déconnexion des clients. |

## Modules fonctionnels implémentés

### 1. Connexion / Authentification (`uc=utilisateur`)
*   Inscription de nouveaux clients avec enregistrement des coordonnées.
*   Création sécurisée des identifiants avec mots de passe hachés (`password_hash`).
*   Identification des utilisateurs pour le passage des commandes.

### 2. Gestion du catalogue (`uc=voirProduits`)
*   **Navigation** : Consultation des produits par catégorie ou affichage du catalogue complet.
*   **Administration** :
    *   **Catégories** : Création de nouvelles catégories.
    *   **Produits** : Ajout, modification et suppression de produits.
    *   Gestion détaillée : stocks, seuils de rupture, mise en avant promo (`mis_en_avant`), marques et unités.

### 3. Panier et Commandes (`uc=gererPanier`)
*   **Panier virtuel** : Ajout rapide au panier, modification dynamique des quantités, suppression d'articles (géré avec les sessions `$_SESSION`).
*   **Système de commande** :
    *   Validation formelle du panier.
    *   Enregistrement transactionnel de l'en-tête de commande (`commande`) et des lignes d'articles (`contenir`).

## Structure de la Base de Données

Le modèle s'articule autour de deux axes majeurs :
*   **Le Catalogue** :
    *   `produit` : Détails des produits (nom, description, prix, quantités).
    *   `categorie`, `marque`, `unite` : Typologies et classifications.
*   **Les Ventes & Comptes** :
    *   `client` : Fiches informatives des clients.
    *   `login` : Comptes permettant l'authentification (rôles et mots de passe).
    *   `commande` : Enregistrement temporel des paniers validés.
    *   `contenir` : Table d'association entre commandes et produits commandés (quantités).

*L'intégrité est garantie par l'utilisation de transactions SQL (commit/rollback) lors d'opérations sensibles comme la création d'une commande.*

## Fichiers et Dossiers du projet

```text
GsbParam/
├── index.php                      ← Point d'entrée et initialisation
├── config/.config.php             ← (Configuration SQL isolée)
├── controleurs/
│   ├── Routeur.php                ← Dispatcher principal
│   ├── ControleurAccueil.php      ← Logique accueil
│   ├── ControleurVoirProduits.php ← Logique métier Catalogue
│   ├── ControleurGererPanier.php  ← Logique métier Ventes
│   └── ControleurUtilisateur.php  ← Logique métier Comptes
├── modele/
│   ├── Modele.php                 ← Classe abstraite de connexion PDO
│   └── ModeleFront.php            ← Requête SQL pour les actions Front/Back
├── vues/                          ← L'ensemble des templates d'affichage
│   ├── v_bandeau.php
│   ├── v_modifierProduit.php
│   └── ...
└── BD/                            ← Scripts de création de la BDD (SQL)
```

## Résumé

Le projet GsbParam est une plateforme e-commerce MVC robuste démontrant des compétences clés en développement web :
*   L'abstraction d'une base de données via une architecture objet en PHP.
*   La sécurisation des transactions (PDO, requêtes préparées, commit/rollback, hachage de mot de passe).
*   La gestion complète d'interfaces avec maintien des états via le système de session.
