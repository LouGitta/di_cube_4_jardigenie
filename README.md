Back Office PHP – Dockerisé
Ce projet correspond à un back office PHP (pattern MVC), prêt à l’emploi grâce à Docker.


        Fonctionnalités :
    Front office :

- Création d'un compte
- Accès à des produits
- Possibilité de créer un panier avec plusieurs articles
- Création de commandes

    Back office : 
- CRUD User
- CRUD Articles
- Visualisation commandes

    Architecture MVC (Models, Views, Controllers)
    Prêt à être lancé via Docker (avec Apache et PHP)

     Pré-requis :
- Docker installé
- PHP

    Clone le projet :
- git clone https://github.com/LouGitta/di_cube_4_jardigenie.git
- cd di_cube_4_jardigenie

    Construis et lance les conteneurs :
- docker build -t jardigenie .
- docker run -d -p 8080:80 --name conteneur-jardigenie

    Accède à l'application :
- Ouvre http://localhost:8080 dans ton navigateur.

        Utilisation :
    Arrêter les services :
- docker-compose down



    Développement :
Structure MVC
Controllers : logique métier (dans /controllers)
Models : accès base de données, entités (dans /models)
Views : templates HTML/PHTML (dans /views)


    Auteurs
GITTA Lou
DIABY Aboubacar