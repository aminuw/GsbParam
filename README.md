# Sujet BTS SIO - GSB Param (Boutique et Gestion de Catalogue)

## Contexte général

Ce projet a été réalisé en binôme dans le cadre de la dernière année de BTS SIO (Services Informatiques aux Organisations), option SLAM (Solutions Logicielles et Applications Métiers).

Le projet **GSB Paramédical** (Phase 2) est la réalisation d'un site e-commerce et d'une application d’administration complète pour le laboratoire GSB. L'objectif est de présenter et de vendre en ligne des produits paramédicaux, tout en fournissant un *Back-Office* complet à l'équipe GSB pour la gestion quotidienne (catalogue, stocks, commandes). Le projet s'appuie et prolonge les travaux initiaux de M. Jouin.

L'application respecte les contraintes légales européennes (RGPD, Mentions Légales) et suit une architecture robuste.

## Architecture technique

| Composant | Détail |
| :--- | :--- |
| **Langage** | PHP (Orienté Objet), JavaScript, HTML5 |
| **Architecture** | Modèle – Vue – Contrôleur (MVC) |
| **Base de données** | MySQL (`gsbparamv2`) requêtée via PDO |
| **CSS / UI** | Intégration front-end responsive fonctionnant sur tous navigateurs standards |
| **Serveur & Local** | Hébergement (WAMP) / Prévision environnement production |
| **Routage** | Contrôleur frontal `index.php` avec passage du paramètre Use Case (`uc`) |
| **Gestion** | Itérations Agile (Scrum via Trello) et Versionning Git |

## Point d'entrée : `index.php`

Le fichier `index.php` est le point de départ de l'application. Après l'initialisation des sessions (`session_start()`), le trafic est routé vers les contrôleurs spécifiques selon le paramètre `uc` :

| `uc` | Contrôleur ciblé | Description (Use Case) |
| :--- | :--- | :--- |
| `accueil` | `ControleurAccueil.php` | Page d'accueil publique (USR 15) |
| `voirProduits` | `ControleurVoirProduits.php` | Catalogue côté client (USR 4, 5) et gestion côté Admin (USR 3, 12, 7) |
| `gererPanier` | `ControleurGererPanier.php` | Fonctionnalités d'achat client et prise de commande (USR 8) |
| `utilisateur` | `ControleurUtilisateur.php` | Espace, inscription et authentification client (USR 14) |

## Modèle Conceptuel de Données (MCD)

La base de données sépare rigoureusement la logique "Boutique" et "Comptes".

| Entités Clés | Rôle & Attributs principaux |
| :--- | :--- |
| **`produit`** | Cœur du catalogue. Gère les descriptions, prix, `quantiteStock`, `seuil_rupture`, ainsi que les dates de `mis_en_avant` pour la page d'accueil. |
| **`categorie`** / **`marque`** / **`unite`** | Dictionnaires de typologies des produits (relations 1:N). |
| **`client`** | Fiche nominative (Nom, prénom, adresse, CP, Ville). |
| **`login`** | Données d'authentification (email, mot de passe hashé, rôle). Un client possède strictement 1 login. |
| **`commande`** | En-tête de validation d'achat avec historique et affectation d'un `idEtat`. |
| **`contenir`** | Lignes de commandes identifiant les produits et quantités associées aux commandes passées. |

*(Nota : Les données non utilisées de manière répétitive sont dé-dupliquées conformément aux formes normales ; par ex. une adresse est dans `client` et non dans `commande`).*

## Fonctionnalités Métier & Use Cases (USR) Implémentés

Construit sur une approche orientée utilisateur, l'outil propose deux grands espaces : le Back-Office (Administrateur) et le Front-Office (Client).

### 🛠 Espace Administration (Back-Office)

*   **Gestion du Catalogue (USR 3, USR 12)** : L'administrateur peut procéder au CRUD complet des produits et catégories. Une logique métier interdit la suppression d'une catégorie contenant encore des produits.
*   **Suivi des Stocks (USR 7)** : Un écran dédié permet de modifier les stocks restants. Un système d'alerte identifie les produits atteignant le **seuil de rupture** (quantité en stock <= seuil critique), bloquant par la suite leur commande côté client.
*   **Animation du Site (USR 15)** : Possibilité de programmer la mise en avant de produits sur la page d'accueil via des dates de début et de fin.
*   **Gestion Ventes & Commandes (USR 10)** : Tableau de suivi des commandes avec changement de statut (en cours de livraison, terminée, etc.).

### 🛍 Espace Client (Front-Office)

*   **Catalogue Dynamique (USR 4)** : Affichage exhaustif des produits. Des filtres paramétrables (Catégorie, Prix, Marque) facilitent la recherche utilisateur.
*   **Achat en ligne (USR 5, USR 8)** : Consultation des fiches produits détaillées. Ajout dans un panier virtuel sauvegardé en session (`$_SESSION`). Le client peut en ajuster les quantités avant de confirmer. La commande nécessite la création préalable d'un compte (RGPD).
*   **Processus d'Inscription sécurisé** : Mot de passe haché par algorithmes forts, et séparation par rôle dans la base de données.
*   **Espace Personnel (USR 14)** : Consultation des informations du compte, historique des commandes passées.

## Sécurité & Intégrité des données

Les opérations de validation (ex. Création de compte Client + Login, ou enregistrement d'une Commande + Lignes de paniers) s'effectuent par le système transactionnel de PDO (`$this->beginTransaction()`, `$this->commit()`, `$this->rollBack()`). Si l'enregistrement d'une ligne de panier échoue, l'intégralité de la commande est annulée pour protéger la cohérence financière des données.

## Réalisé par
* **Jef Ly**
* **Amine Agnaou**

*(Projet d'étude examiné basé sur le cas GSB Paramédical)*
