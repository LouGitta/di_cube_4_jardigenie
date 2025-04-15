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
        
        case 'nouscontacter' :
            $controller = new Controllers\PageController();
            $controller->displayContact();
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