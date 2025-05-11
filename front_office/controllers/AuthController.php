<?php
namespace Controllers;

require_once 'models/Database.php';
require 'models/User.php';

class AuthController {
    
    private $userModel;
    
    // public function __construct() {
    //     $this->userModel = new \models\User();
    // }
    
    public function showLoginForm() {

        $error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : null;
        
        if(isset($_SESSION['login_error'])) {
            unset($_SESSION['login_error']);
        }
        $template = 'auth/login.phtml';
        include_once 'views/layout.phtml';
    }
    
    public function login() {
        if(isset($_POST['mail']) && isset($_POST['password'])) {
            $email = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $userModel = new \models\User();
            
            $user = $userModel->findByEmail($email);
            
            if($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id'            => $user['user_id'],
                    'first_name'    => $user['first_name'],
                    'last_name'     => $user['last_name'],
                    'mail'          => $user['mail'],
                    'is_admin'      => $user['is_admin']
                ];
                
                header('Location: index.php?route=home');
                exit;
            } else {
                $_SESSION['login_error'] = 'Email ou mot de passe incorrect';
                header('Location: index.php?route=login');
                exit;
            }
        } else {
            $_SESSION['login_error'] = 'Veuillez remplir tous les champs';
            header('Location: index.php?route=login');
            exit;
        }
    }
    
    public function register() {
        // Initialiser le modèle si nécessaire
        if ($this->userModel === null) {
            $this->userModel = new \Models\User();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            
            
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
         
            if (empty($prenom) || empty($nom) || empty($email) || empty($password)) {
                $errors[] = 'Tous les champs sont obligatoires';
            }
            
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email invalide';
            }
            
            
            $userExists = $this->userModel->findByEmail($email);
            if ($userExists) {
                $errors[] = 'Cet email est déjà utilisé';
            }
            
            
            if ($password !== $confirm_password) {
                $errors[] = 'Les mots de passe ne correspondent pas';
            }
            
           
            if (strlen($password) < 8) {
                $errors[] = 'Le mot de passe doit contenir au moins 8 caractères';
            }
            
            if (empty($errors)) {
               
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Créer utilisateur
                $userData = [
                    'first_name'    => $prenom,
                    'last_name'     => $nom,
                    'mail'          => $email,
                    'password'      => $hashedPassword,
                    'register_date' => date('Y-m-d'),
                    'is_admin'      => 0
                ];
                
                $this->userModel->create($userData);
                
             
                header('Location: index.php?route=login&registered=success');
                exit;
            } else {
                $template = 'auth/register.phtml';
                include_once 'views/layout.phtml';
            }
        } else {
            $this->showRegisterForm();
        }
    }
    
    public function showRegisterForm() {
        $template = 'auth/register.phtml';
        include_once 'views/layout.phtml';
    }
    
    public function logout() {
        // Détruisez la session
        session_start();
        session_unset();
        session_destroy();
        
        // Redirigez vers la page d'accueil
        header('Location: index.php?route=home');
        exit;
    }
}
