<?php
namespace Controllers;

class AdminController {
    private $userModel;
    
    public function __construct() {
        // Le modèle sera initialisé uniquement quand nécessaire
    }
    
    private function getUserModel() {
        if (!isset($this->userModel)) {
            require_once __DIR__ . '/../Models/User.php';
            $this->userModel = new \models\User();
        }
        return $this->userModel;
    }
    
    public function showLoginForm() {
        $errors = isset($_SESSION['admin_login_error']) ? [$_SESSION['admin_login_error']] : [];
        unset($_SESSION['admin_login_error']);
        
        require_once __DIR__ . '/../views/auth/login.phtml';
    }
    
    public function showDashboard() {
        // Vérifier si l'utilisateur est connecté et admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
            header('Location: index.php?route=admin-login');
            exit;
        }
        
        require_once __DIR__ . '/../views/dashboard.phtml';
    }
    
    public function login() {
        if(isset($_POST['mail']) && isset($_POST['password'])) {
            $email = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            $user = $this->getUserModel()->findByEmail($email);
            
            if($user && password_verify($password, $user['password']) && $user['is_admin'] == 1) {
                $_SESSION['user'] = $user;
                header('Location: index.php?route=admin-dashboard');
                exit;
            } else {
                $_SESSION['admin_login_error'] = "Email ou mot de passe incorrect";
                header('Location: index.php?route=admin-login');
                exit;
            }
        }
        
        header('Location: index.php?route=admin-login');
        exit;
    }
    
    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php?route=admin-login');
        exit;
    }
    
}
  
