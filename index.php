<?php
session_start();

// ici l'index va servir de ROOTER grâce au SWITCH

// Va permettre de faire un require tous les fichiers dès qu'on appèle un controlleur en instanciant une classe
spl_autoload_register(function($class) {                            // $class = Controllers/ArticleController
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';   // require_once controllers/ArticleController.php
});


if(array_key_exists('route', $_GET)):
    
    switch ($_GET['route']) {

        case 'home':
            $controller = new Controllers\ArticleController();
            $controller->display();
            break;

        case 'byCat':

            $controller = new Controllers\ArticleController();
            $controller->displayByCat();
            break;

        case 'addArticle':

            if(!array_key_exists('ref', $_GET) || $_GET['ref'] != "add") {
                // Afficher le formulaire
                $controller = new Controllers\ArticleController();
                $controller->displayForm();
            }else {
                // Soumettre le formulaire
                $controller = new Controllers\ArticleController();
                $controller->submitForm();
            }
            break;

        case 'editArticle':
        
            if(!array_key_exists('ref', $_GET) || $_GET['ref'] != "editArticle") {
                // Afficher le formulaire
                $controller = new Controllers\ArticleController();
                $controller->displayFormEditArticle($_GET['id']);
            }else {
                // Soumettre le formulaire
                $controller = new Controllers\ArticleController();
                $controller->submitFormEditArticle();
            }
            break;


        case 'deleteArticle':
                        
            if(isset($_GET['id']) && $_GET['id'] > 0) {

                $controller = new Controllers\ArticleController();
                $controller->deleteArticle($_GET['id']);
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