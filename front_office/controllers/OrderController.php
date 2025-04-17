<?php

namespace Controllers;

class OrderController {

    public function display() {

        if(isset($_SESSION['user'])) {
                $model = new \Models\Orders();
                $listOrders = $model->getOrders($_SESSION['user']['user_id']);

                // Affiche la vue
                $template = "orders.phtml";
                include_once 'views/layout.phtml';

        } else {
            // Si erreur sur le $_POST, et que donc il n'existe pas, on revient a la page d'accueil
            header('location: index.php?route=home');
            exit;
        }

    }
}