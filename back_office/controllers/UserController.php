<?php

namespace Controllers;

class UserController {
    
    public function display() {
        // Afficher la page d'accueil
        // Il nous faut récupérer la liste de tous les users depuis la BDD

        $model = new \Models\User();
        $listUsers = $model->getAllUsers();

        // Affiche la vue
        $template = "users.phtml";
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

                // Il nous faut récupérer la liste de tous les users par CATEGORIE depuis la BDD en passant le parametre venu du formulaire
                $model = new \Models\User();
                $listUsers = $model->getUsersByCat($_POST['cat']);

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
    
    // Formulaire pour ajouter un user
    public function displayForm () {

        $route = 'index.php?route=addUser&ref=add';
        
        $newUser = [
                'first_name'    => '',
                'last_name'     => '',
                'mail'          => '',
                'password'      => '',
                'register_date' => '',
                'is_admin'      => ''
        ];
        

        $template = "adduser.phtml";
        include_once 'views/layout.phtml';              
    }

    // Validation de l'ajout d'un user + retour sur la home
    public function submitForm () {

        // On instancie notre tableau d'erreurs à vide pour les futurs messages d'erreurs de saisie du formulaire
        $errors = [];

        if(array_key_exists('first_name', $_POST) && array_key_exists('last_name', $_POST) && 
            array_key_exists('mail', $_POST) && array_key_exists('password', $_POST)) {
                
            $newUser = [
                'first_name'    => $_POST['first_name'],
                'last_name'     => $_POST['last_name'],
                'mail'          => $_POST['mail'],
                'password'      => $_POST['password'],
                'register_date' => date("Y-m-d"),
                'is_admin'      => isset($_POST['is_admin']) ? 1 : 0
            ];
        
                // Vérification de tous les champs
                if ( strlen($newUser['first_name']) < 3) {
                    $errors[] = "Veuillez saisir un nom d'user de plus de 2 lettres";
                }

                if ( strlen($newUser['last_name']) < 3) {
                    $errors[] = "Veuillez saisir un nom d'user de plus de 2 lettres";
                }

                if ($newUser['mail'] == '') {
                    $errors[] = "Veuillez sélectionner une catégorie";
                }

                if ( strlen($newUser['password']) < 3) {
                    
                    $errors[] = "Veuillez saisir une password de plus de 2 lettres";
                }
             
                if (count($errors) == 0) {
                    $hashedPassword = password_hash($newUser['password'], PASSWORD_DEFAULT);
                    
                    // On enregistre toutes les données sous forme de tableau dans une variable data
                    $data = [
                                $newUser['first_name'],
                                $newUser['last_name'],
                                $newUser['mail'],
                                $hashedPassword,
                                $newUser['register_date'],
                                $newUser['is_admin']
                    ];
                    
                    $model = new \Models\User();
                    $model->addNewUser($data);
                    
        
                    //retour sur la home après ajout d'un nouvel user
                    header('Location: index.php?route=users');
                    exit();
                    
                    
                }
    
    
            }
            $route = 'index.php?route=addUser&ref=add';

            $template = "adduser.phtml";
            include_once 'views/layout.phtml';   
    }

      
    // Affichage du formulaire inculant l'user à modifier
    public function displayFormEditUser ($id) {
        
            
        $route = 'index.php?route=editUser&ref=editUser&id='.$id;
        
        //récupération de l'user à modifier
        $model = new \Models\User();
        $usermodif = $model->getUserById($id);

        
        $newUser = [
                        'id'            => $usermodif['user_id'],
                        'first_name'    => $usermodif['first_name'],
                        'last_name'     => $usermodif['last_name'],
                        'mail'          => $usermodif['mail'],
                        'password'      => $usermodif['password'],
                        'register_date' => $usermodif['register_date'],
                        'is_admin'      => $usermodif['is_admin']
            ];
        
            // affiche la vue
            $template = "adduser.phtml";
            include_once 'views/layout.phtml';       
    
    
    }


    //Sousmission des modification de l'user + retour sur l'accueil
    public function submitFormEditUser() {

        $route = 'index.php?route=editUser&ref=editUser&id='.$_GET['id'];
        $errors=[];
                
        if ( isset( $_POST['first_name'] )
            && isset( $_POST['last_name'] )
            && isset( $_POST['mail'] )
            && isset( $_POST['password'] )
            )
            {

            $newUser = [
                        'id'            => $_GET['id'],
                        'first_name'    => $_POST['first_name'],
                        'last_name'     => $_POST['last_name'],
                        'mail'          => $_POST['mail'],
                        'password'      => $_POST['password'],
                        'is_admin'      => isset($_POST['is_admin']) ? 1 : 0
                    ];

            // Vérification de tous les champs
            if ( strlen($newUser['first_name']) < 3) {
                $errors[] = "Veuillez saisir un prénom de plus de 2 lettres";
            }

            if ( strlen($newUser['last_name']) < 3) {
                $errors[] = "Veuillez saisir un nom de plus de 2 lettres";
            }

            if ($newUser['mail'] == '') {
                $errors[] = "Veuillez sélectionner une catégorie";
            }

            if ( strlen($newUser['password']) < 3) {
                $errors[] = "Veuillez saisir un mot de passe de plus de 2 lettres";
            }
            
            if (count($errors) == 0) {
                
                // On enregistre toutes les données sous forme de tableau dans une variable data
                $newData = [
                    'first_name'    => $newUser['first_name'],
                    'last_name'     => $newUser['last_name'], 
                    'mail'          => $newUser['mail'], 
                    'password'      => $newUser['password'],
                    'is_admin'      => $newUser['is_admin']
                ];
            
                $model = new \Models\User();
                $model->updateUserById($newData, $_GET['id']);
              
                header('Location: index.php?route=users');
                exit();
            }
    
        }
        $template = "adduser.phtml";
        include_once 'views/layout.phtml';      
    }

    //Supression d'un user
    public function deleteUser($id) {

        $model = new \Models\User();      
        $model->deleteUserById('users', 'user_id', $id);
        
    }

}
