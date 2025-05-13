<?php

namespace Controllers;

class ProductController {
    
    public function display() {
        // Afficher la page d'accueil
        // Il nous faut récupérer la liste de tous les products depuis la BDD

        $model = new \Models\Products();
        $listProducts = $model->getAllProducts();

        // Affiche la vue
        $template = "home.phtml";
        include_once 'views/layout.phtml';
        

    }

    public function displayByCat() {
        // Afficher la page d'accueil avec une selection par catégorie


        // On vérifie ici avec cette condition que le SELECT qui se nomme 'cat' a bien été rempli dans le formulaire de la home
        if(array_key_exists('cat', $_POST)) {

            if ($_POST['cat'] == '') {
                //Si rien n'est sélectionné on revient sur la home
                header('location: index.php?route=home');
                exit;

            } else {

                // Il nous faut récupérer la liste de tous les products par CATEGORIE depuis la BDD en passant le parametre venu du formulaire
                $model = new \Models\Products();
                $listProducts = $model->getProductsByCat($_POST['cat']);

                // Affiche la vue
                $template = "home.phtml";
                include_once 'views/layout.phtml';
                
            }

        } else {
            // Si erreur sur le $_POST, et que donc il n'existe pas, on revient a la page d'accueil
            header('location: index.php?route=home');
            exit;
        }

    }

}
