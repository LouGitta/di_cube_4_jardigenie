<?php

namespace Controllers;

class OrderController {
    
    public function display() {
        // Il nous faut récupérer la liste de toutes les commandes depuis la BDD

        $model = new \Models\Orders();
        $listOrders = $model->getAllOrders();

        // Affiche la vue
        $template = "orders.phtml";
        include_once 'views/layout.phtml'; 

    }

    public function displayByStatus() {
        // Afficher la page d'accueil avec une selection par status


        // On vérifie ici avec cette condition que le SELECT qui se nomme 'status' a bien été rempli dans le formulaire
        if(array_key_exists('status', $_POST)) {

            if ($_POST['cat'] == '') {
                //Si rien n'est sélectionné on revient sur la home
                header('location: index.php?route=home');
                exit;

            } else {

                // Il nous faut récupérer la liste de tous les products par CATEGORIE depuis la BDD en passant le parametre venu du formulaire
                $model = new \Models\Orders();
                $listOrders = $model->getOrdersByCat($_POST['cat']);

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
