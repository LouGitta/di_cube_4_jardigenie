<?php
session_start();

// ici l'index va servir de ROOTER grâce au SWITCH

// Va permettre de faire un require tous les fichiers dès qu'on appèle un controlleur en instanciant une classe
spl_autoload_register(function($class) {                            // $class = Controllers/ProductController
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';   // require_once controllers/ProductController.php
});


if(array_key_exists('route', $_GET)):
    
    switch ($_GET['route']) {

        case 'home':
            $controller = new Controllers\ProductController();
            $controller->display();
            break;

        case 'byCat':
            $controller = new Controllers\ProductController();
            $controller->displayByCat();
            break;

        case 'addProduct':
            if(!array_key_exists('ref', $_GET) || $_GET['ref'] != "add") {
                // Afficher le formulaire
                $controller = new Controllers\ProductController();
                $controller->displayForm();
            }else {
                // Soumettre le formulaire
                $controller = new Controllers\ProductController();
                $controller->submitForm();
            }
            break;

        case 'editProduct':
            if(!array_key_exists('ref', $_GET) || $_GET['ref'] != "editProduct") {
                // Afficher le formulaire
                $controller = new Controllers\ProductController();
                $controller->displayFormEditProduct($_GET['id']);
            }else {
                // Soumettre le formulaire
                $controller = new Controllers\ProductController();
                $controller->submitFormEditProduct();
            }
            break;

        case 'deleteProduct':
            if(isset($_GET['id']) && $_GET['id'] > 0) {
                $controller = new Controllers\ProductController();
                $controller->deleteProduct($_GET['id']);
            }
            header('location: index.php?route=home');
            exit;
            break; 
        
        case 'nouscontacter':
          //  $controller = new Controllers\PageController();
            // $controller->displayContact();
            // break;
            
        // Routes pour l'authentification
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Traitement de la connexion
                $controller = new Controllers\AuthController();
                $controller->login();
            } else {
                // Affichage du formulaire de connexion
                $controller = new Controllers\AuthController();
                $controller->showLoginForm();
            }
            break;
            
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Traitement de l'inscription
                $controller = new Controllers\AuthController();
                $controller->register();
            } else {
                // Affichage du formulaire d'inscription
                $controller = new Controllers\AuthController();
                $controller->showRegisterForm();
            }
            break;
            
        case 'logout':
            $controller = new Controllers\AuthController();
            $controller->logout();
            break;

        case 'cart':
            $controller = new Controllers\CartController();           
            $controller->showCart();
            break;

         case 'addCart':
            $controller = new Controllers\CartController();           
            $controller->add($_GET['idProduct'], $_GET['quantity']);
            break;

        case 'deleteCart':
            $controller = new Controllers\CartController();           
            $controller->delete($_GET['idProduct']);
            break;

         case 'checkout':
                $controller = new Controllers\OrderController();
                $controller->validateOrder();
                break;    

        default:
            header('Location: index.php?route=home');
            exit;
            break;
    }
    

else:
    header('Location: index.php?route=home');
    exit;
endif;
