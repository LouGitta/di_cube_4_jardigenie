<?php
session_start();

// ici l'index va servir de ROOTER grâce au SWITCH

// Va permettre de faire un require tous les fichiers dès qu'on appèle un controlleur en instanciant une classe
spl_autoload_register(function($class) {                            // $class = Controllers/ProductController
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';   // require_once controllers/ProductController.php
});

// Fonction pour vérifier si l'utilisateur est admin
function checkAdminAccess() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
        header('Location: index.php?route=login');
        exit;
    }
}

if(array_key_exists('route', $_GET)):
    
    switch ($_GET['route']) {

        // Routes d'authentification admin
        case 'login':
            $controller = new Controllers\AdminController();
            $controller->showLoginForm();
            break;
            
        case 'login-post':
            $controller = new Controllers\AdminController();
            $controller->login();
            break;
            
        case 'logout':
            $controller = new Controllers\AdminController();
            $controller->logout();
            break;
            
        case 'dashboard':
            checkAdminAccess(); // Vérifie si l'utilisateur est admin
            $controller = new Controllers\AdminController();
            $controller->showDashboard();
            break;

        case 'home':
            checkAdminAccess(); // Ajouter cette vérification sur toutes les routes admin
            $controller = new Controllers\ProductController();
            $controller->display();
            break;

        case 'byCat':
            checkAdminAccess();
            $controller = new Controllers\ProductController();
            $controller->displayByCat();
            break;

        case 'addProduct':
            checkAdminAccess();
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
            checkAdminAccess();
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
            checkAdminAccess();           
            if(isset($_GET['id']) && $_GET['id'] > 0) {
                $controller = new Controllers\ProductController();
                $controller->deleteProduct($_GET['id']);
            }
            header('location: index.php?route=home');
            exit;
            break;

        case 'users':
            checkAdminAccess();
            $controller = new Controllers\UserController();
            $controller->display();
            break;
        
        case 'addUser':
            checkAdminAccess();
            if(!array_key_exists('ref', $_GET) || $_GET['ref'] != "add") {
                // Afficher le formulaire
                $controller = new Controllers\UserController();
                $controller->displayForm();
            }else {
                // Soumettre le formulaire
                $controller = new Controllers\UserController();
                $controller->submitForm();
            }
            break;

        case 'editUser':
            checkAdminAccess();
            if(!array_key_exists('ref', $_GET) || $_GET['ref'] != "editUser") {
                // Afficher le formulaire
                $controller = new Controllers\UserController();
                $controller->displayFormEditUser($_GET['id']);
            }else {
                // Soumettre le formulaire
                $controller = new Controllers\UserController();
                $controller->submitFormEditUser();
            }
            break;

        case 'deleteUser':
            checkAdminAccess();
            if(isset($_GET['id']) && $_GET['id'] > 0) {
                $controller = new Controllers\UserController();
                $controller->deleteUser($_GET['id']);
            }
            header('location: index.php?route=home');
            exit;
            break;
                    
        case 'orders':
            checkAdminAccess();
            $controller = new Controllers\OrderController();
            $controller->display();
            break;
            
        default:
            // Si l'utilisateur n'est pas connecté en tant qu'admin, rediriger vers la page de login
            if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
                header('Location: index.php?route=login');
            } else {
                header('Location: index.php?route=dashboard');
            }
            exit;
            break;
    } 
else:
    // Si l'utilisateur n'est pas connecté en tant qu'admin, rediriger vers la page de login
    if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
        header('Location: index.php?route=login');
    } else {
        header('Location: index.php?route=dashboard');
    }
    exit;
endif;
