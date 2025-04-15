<?php

namespace Controllers;

class ArticleController {
    
    public function display() {
        // Afficher la page d'accueil
        // Il nous faut récupérer la liste de tous les articles depuis la BDD

        $model = new \Models\Articles();
        $listArticles = $model->getAllArticles();

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

                // Il nous faut récupérer la liste de tous les articles par CATEGORIE depuis la BDD en passant le parametre venu du formulaire
                $model = new \Models\Articles();
                $listArticles = $model->getArticlesByCat($_POST['cat']);

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
    
    // Formulaire pour ajouter un article
    public function displayForm () {

        $route = 'index.php?route=addArticle&ref=add';
        
        $newArticle = [
                'name'          => '',
                'price'         => '',
                'category'      => '',
                'description'   => '',
                'img'           => ''
        ];
        

        $template = "addarticle.phtml";
        include_once 'views/layout.phtml';              
    }

    // Validation de l'ajout d'un article + retour sur la home
    public function submitForm () {

        // On instancie notre tableau d'erreurs à vide pour les futurs messages d'erreurs de saisie du formulaire
        $errors = [];

       

        if(array_key_exists('name', $_POST) && array_key_exists('price', $_POST) && 
            array_key_exists('category', $_POST) && array_key_exists('description', $_POST)) {
                
    
            $newArticle = [
                'name'          => $_POST['name'],
                'price'         => trim($_POST['price']),
                'category'      => $_POST['category'],
                'description'   => $_POST['description'],
                'img'           => 'noPicture.png'
                    ];
        
                // Vérification de tous les champs
                if ( strlen($newArticle['name']) < 3) {
                    $errors[] = "Veuillez saisir un nom d'article de plus de 2 lettres";
                }

                if ($newArticle['price'] <= 0 || $newArticle['price'] >= 100000) {
                    $errors[] = "Veuillez saisir un prix entre 0 € et 100 000 €";
                }

                if ($newArticle['category'] == '') {
                    $errors[] = "Veuillez sélectionner une catégorie";
                }

                if ( strlen($newArticle['description']) < 3) {
                    $errors[] = "Veuillez saisir une description de plus de 2 lettres";
                }
             
                if (count($errors) == 0) {
         
                    // UPLOADER L'IMAGE
                    if( isset($_FILES['img']) && $_FILES['img']['name'] !== '' ) {
                        $dossier = "images";
                        $model = new \Models\Upload();
                        $newArticle['img'] = $model->upload($_FILES['img'], $dossier, $errors);
                      
                    }
                    // On enregistre toutes les données sous forme de tableau dans une variable data
                    $data = [
                                $newArticle['name'],
                                $newArticle['price'], 
                                $newArticle['category'], 
                                $newArticle['description'], 
                                $newArticle['img']
                    ];
                    
                    $model = new \Models\Articles();
                    $model->addNewArticle($data);
                    
        
                    //retour sur la home après ajout d'un nouvel article
                    header('Location: index.php');
                    exit();
                    
                    
                }
    
    
            }
            $route = 'index.php?route=addArticle&ref=add';

            $template = "addarticle.phtml";
            include_once 'views/layout.phtml';   
    }

      
    // Affichage du formulaire inculant l'article à modifier
    public function displayFormEditArticle ($id) {
        
            
        $route = 'index.php?route=editArticle&ref=editArticle&id='.$id;
        
        //récupération de l'article à modifier
        $model = new \Models\Articles();
        $artmodif = $model->getArticleById($id);

        
        $newArticle = [
                        'id'            => $artmodif['art_id'],
                        'name'          => $artmodif['art_name'],
                        'price'         => $artmodif['art_price'],
                        'category'      => $artmodif['art_category'],
                        'description'   => $artmodif['art_description'],
                        'img'           => $artmodif['art_img']
            ];

        
        $_SESSION['saveimg']=$artmodif['art_img'];
        
            // affiche la vue
            $template = "addarticle.phtml";
            include_once 'views/layout.phtml';       
    
    
    }


    //Sousmission des modification de l'article + retour sur l'accueil
    public function submitFormEditArticle() {


        $route = 'index.php?route=editArticle&ref=editArticle&id='.$_GET['id'];
        $errors=[];
                
        if ( isset( $_POST['name'] ) && 
            isset( $_POST['price'] ) && 
            
            isset( $_POST['category'] ) && 
            isset( $_POST['description'] )) {
                


            $newArticle = [
                            'id'            => $_GET['id'],
                            'name'          => $_POST['name'],
                            'price'         => trim($_POST['price']),
                            'category'      => $_POST['category'],
                            'description'   => $_POST['description'],
                            'img'           => $_SESSION['saveimg']       
                ];


            // Vérification de tous les champs
            if ( strlen($newArticle['name']) < 3) {
                $errors[] = "Veuillez saisir un nom d'article de plus de 2 lettres";
            }

            if ($newArticle['price'] <= 0 || $newArticle['price'] >= 100000) {
                $errors[] = "Veuillez saisir un prix entre 0 € et 100 000 €";
            }

            if ($newArticle['category'] == '') {
                $errors[] = "Veuillez sélectionner une catégorie";
            }

            if ( strlen($newArticle['description']) < 3) {
                $errors[] = "Veuillez saisir une description de plus de 2 lettres";
            }
            
            if (count($errors) == 0) {

                // On efface l'image du dossier images, à partir du moment où il y avait bien une image.
                
                if( isset($_FILES['img']) && $_FILES['img']['name'] !== '' )
                {

                    
                    if ($_SESSION['saveimg'] != 'noPicture.png' ) {
                        unlink('public/images/'.$_SESSION['saveimg']);
                    }
                    
                    $dossier = "images";
                    $model = new \Models\Upload();
                    $newArticle['img'] = $model->upload($_FILES['img'], $dossier, $errors);
                }

                
                    // On enregistre toutes les données sous forme de tableau dans une variable data
                    $newData = [
                        'art_name'          => $newArticle['name'],
                        'art_price'         => $newArticle['price'], 
                        'art_category'      => $newArticle['category'], 
                        'art_description'   => $newArticle['description'], 
                        'art_img'           => $newArticle['img']
                    ];
            

                
                $model = new \Models\Articles();
                $model->updateArticleById($newData, $_GET['id']);
              
               
               

                header('Location: index.php');
                exit();
               

            }
    
        }
        $template = "addarticle.phtml";
        include_once 'views/layout.phtml';      
    }

    //Supression d'un article
    public function deleteArticle($id) {

        $model = new \Models\Articles();
        $imageName = $model->getImageArticlebyId($id); 

        // Je supprime l'image de mon dossier dans la mesure où elle ne s'appelle pas "noPicture.png"
        if($imageName['art_img'] != "noPicture.png") {
            unlink('public/images/'.$imageName['art_img']); 
        }
        
        $model->deleteArticleById('articles', 'art_id', $id);
        

        
    }

}
