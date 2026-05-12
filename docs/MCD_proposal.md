
## Proposition de modification de la Base de Données (MCD)

### 1. Création d'une table `client`
Cette table stockera les informations des utilisateurs inscrits.

| Nom de la colonne | Type          | Contraintes                 | Description                   |
|:------------------|:--------------|:----------------------------|:------------------------------|
| `id`              | INT           | PRIMARY KEY, AUTO_INCREMENT | Identifiant unique du client  |
| `nom`             | VARCHAR(50)   | NOT NULL                    | Nom de famille du client      |
| `prenom`          | VARCHAR(50)   | NOT NULL                    | Prénom du client              |
| `email`           | VARCHAR(100)  | NOT NULL, UNIQUE            | Adresse e-mail (servira de login) |
| `mdp`             | VARCHAR(255)  | NOT NULL                    | Mot de passe haché            |
| `adresse`         | VARCHAR(100)  |                             | Adresse postale               |
| `ville`           | VARCHAR(50)   |                             | Ville                         |
| `cp`              | VARCHAR(5)    |                             | Code Postal                   |

### 2. Modification de la table `commande`
On remplace les champs redondants par une clé étrangère vers la nouvelle table `client`.

| Action      | Nom de la colonne   | Description                                                                                             |
|:------------|:--------------------|:--------------------------------------------------------------------------------------------------------|
| Conserver   | `id`                | Identifiant de la commande                                                                              |
| Conserver   | `dateCommande`      | Date de la commande                                                                                     |
| Modifier    | `idClient`          | Deviendra une clé étrangère (FOREIGN KEY) vers `client(id)`. Peut être NULL si la commande est passée sans être connecté. |
| **Supprimer** | `nomPrenomClient`   | Information maintenant dans la table `client`                                                           |
| **Supprimer** | `adresseRueClient`  | Information maintenant dans la table `client`                                                           |
| **Supprimer** | `cpClient`          | Information maintenant dans la table `client`                                                           |
| **Supprimer** | `villeClient`       | Information maintenant dans la table `client`                                                           |
| **Supprimer** | `mailClient`        | Information maintenant dans la table `client`                                                           |
