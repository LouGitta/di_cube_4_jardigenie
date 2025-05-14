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

1. **Clone le projet** :
    ```bash
    git clone https://github.com/LouGitta/di_cube_4_jardigenie.git
    cd di_cube_4_jardigenie
    ```
2. **Construis et lance les conteneurs** :
    ```bash
    docker build -t jardigenie .
    docker run -d -p 8080:80 --name conteneur-jardigenie jardigenie
    ```
3. **Accède à l'application** :  
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
- **Views** : templates HTML/PHTML (dans `/views`)

---

## Auteurs

- GITTA Lou
- DIABY Aboubacar
- BOMPOIL Arthur
