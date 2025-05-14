# Jardigenie – Dockerisé

Ce projet propose un **front** et un **back office** prêt à l’emploi grâce à Docker pour votre site de jardinage préféré.

---

## Fonctionnalités

- **Architecture MVC** (Models, Views, Controllers)
- Prêt à être lancé via Docker

### Front office

- Création d'un compte
- Accès à des produits
- Possibilité de créer un panier avec plusieurs articles
- Création de commandes

### Back office

- CRUD User
- CRUD Articles
- Visualisation des commandes

---

## Pré-requis

- Docker installé
- PHP installé

---

## Installation

1. **Importe la base de données** :
    - Accède à phpMyAdmin via Wamp (**assure-toi que le port utilisé est bien `3306`**).
    - Crée une nouvelle base de données et appelle la jardigenie
    - Sélectionne cette base puis clique sur l’onglet **Importer**.
    - Clique sur **Choisir un fichier** puis sélectionne le fichier `bdd.sql` dans le dossier `bdd` à la racine du projet.
    - Clique sur **Exécuter** pour lancer l’import.
    - Vérifie que toutes les tables et données nécessaires sont bien présentes.
2. **Clone le projet** :
    ```bash
    git clone -b docker --single-branch https://github.com/LouGitta/di_cube_4_jardigenie.git
    cd di_cube_4_jardigenie
    ```
3. **Construis et lance les conteneurs** :
    ```bash
    docker-compose up -d --build
    ```
4. **Accède à l'application** :  
    Ouvre [http://localhost:8080](http://localhost:8080) dans ton navigateur.

---

## Utilisation

- **Arrêter les services** :
    ```bash
    docker-compose down
    ```

---

## Développement

**Structure MVC :**

- **Controllers** : logique métier (dans `/controllers`)
- **Models** : accès base de données, entités (dans `/models`)
- **Views** : templates PHTML (dans `/views`)

---

## Auteurs

- GITTA Lou
- DIABY Aboubacar
- BOMPOIL Arthur
