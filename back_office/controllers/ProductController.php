<?php

namespace Controllers;

class ProductController {
    
    public function display() {
        // Afficher la page d'accueil
        // Il nous faut récupérer la liste de tous les products depuis la BDD

        $model = new \Models\Products();
        $listProducts = $model->getAllProducts();

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

                // Il nous faut récupérer la liste de tous les products par CATEGORIE depuis la BDD en passant le parametre venu du formulaire
                $model = new \Models\Products();
                $listProducts = $model->getProductsByCat($_POST['cat']);

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
    
    // Formulaire pour ajouter un product
    public function displayForm () {

        $route = 'index.php?route=addProduct&ref=add';
        
        $newProduct = [
                'name'          => '',
                'price'         => '',
                'category'      => '',
                'description'   => '',
                'image'           => ''
        ];
        

        $template = "addproduct.phtml";
        include_once 'views/layout.phtml';              
    }

    // Validation de l'ajout d'un product + retour sur la home
    public function submitForm () {

        // On instancie notre tableau d'erreurs à vide pour les futurs messages d'erreurs de saisie du formulaire
        $errors = [];

       

        if(array_key_exists('name', $_POST) && array_key_exists('price', $_POST) && 
            array_key_exists('category', $_POST) && array_key_exists('description', $_POST)) {
                
            $newProduct = [
                'name'          => $_POST['name'],
                'price'         => trim($_POST['price']),
                'category'      => $_POST['category'],
                'description'   => $_POST['description'],
                'image'         => $_FILES['image']['name']
                    ];
        
                // Vérification de tous les champs
                if ( strlen($newProduct['name']) < 3) {
                    $errors[] = "Veuillez saisir un nom d'product de plus de 2 lettres";
                }

                if ($newProduct['price'] <= 0 || $newProduct['price'] >= 100000) {
                    $errors[] = "Veuillez saisir un prix entre 0 € et 100 000 €";
                }

                if ($newProduct['category'] == '') {
                    $errors[] = "Veuillez sélectionner une catégorie";
                }

                if ( strlen($newProduct['description']) < 3) {
                    $errors[] = "Veuillez saisir une description de plus de 2 lettres";
                }
             
                if (count($errors) == 0) {
         
                    // UPLOADER L'IMAGE
                    if( isset($_FILES['image']) && $_FILES['image']['name'] !== '' ) {
                        $dossier = "images";
                        $model = new \Models\Upload();
                        $newProduct['image'] = $model->upload($_FILES['image'], $dossier, $errors);
                      
                    }
                    // On enregistre toutes les données sous forme de tableau dans une variable data
                    $data = [
                                $newProduct['name'],
                                $newProduct['price'], 
                                $newProduct['category'], 
                                $newProduct['description'], 
                                $newProduct['image']
                    ];
                    
                    $model = new \Models\Products();
                    $model->addNewProduct($data);
                    
        
                    //retour sur la home après ajout d'un nouvel product
                    header('Location: index.php/?route=home');
                    exit();
                    
                    
                }
    
    
            }
            $route = 'index.php?route=addProduct&ref=add';

            $template = "addproduct.phtml";
            include_once 'views/layout.phtml';   
    }

      
    // Affichage du formulaire inculant l'product à modifier
    public function displayFormEditProduct ($id) {
        
            
        $route = 'index.php?route=editProduct&ref=editProduct&id='.$id;
        
        //récupération de l'product à modifier
        $model = new \Models\Products();
        $artmodif = $model->getProductById($id);

        
        $newProduct = [
                        'id'            => $artmodif['product_id'],
                        'name'          => $artmodif['name'],
                        'price'         => $artmodif['price'],
                        'category'      => $artmodif['category'],
                        'description'   => $artmodif['description'],
                        'image'           => $artmodif['image']
            ];

        
        $_SESSION['saveimage']=$artmodif['image'];
        
            // affiche la vue
            $template = "addproduct.phtml";
            include_once 'views/layout.phtml';       
    
    
    }


    //Sousmission des modification de l'product + retour sur l'accueil
    public function submitFormEditProduct() {


        $route = 'index.php?route=editProduct&ref=editProduct&id='.$_GET['id'];
        $errors=[];
                
        if ( isset( $_POST['name'] ) && 
            isset( $_POST['price'] ) && 
            
            isset( $_POST['category'] ) && 
            isset( $_POST['description'] )) {
                


            $newProduct = [
                            'id'            => $_GET['id'],
                            'name'          => $_POST['name'],
                            'price'         => trim($_POST['price']),
                            'category'      => $_POST['category'],
                            'description'   => $_POST['description'],
                            'image'           => $_SESSION['saveimage']       
                ];


            // Vérification de tous les champs
            if ( strlen($newProduct['name']) < 3) {
                $errors[] = "Veuillez saisir un nom d'product de plus de 2 lettres";
            }

            if ($newProduct['price'] <= 0 || $newProduct['price'] >= 100000) {
                $errors[] = "Veuillez saisir un prix entre 0 € et 100 000 €";
            }

            if ($newProduct['category'] == '') {
                $errors[] = "Veuillez sélectionner une catégorie";
            }

            if ( strlen($newProduct['description']) < 3) {
                $errors[] = "Veuillez saisir une description de plus de 2 lettres";
            }
            
            if (count($errors) == 0) {

                // On efface l'image du dossier images, à partir du moment où il y avait bien une image.
                
                if( isset($_FILES['image']) && $_FILES['image']['name'] !== '' )
                {

                    
                    if ($_SESSION['saveimage'] != 'noPicture.png' ) {
                        unlink('public/images/'.$_SESSION['saveimage']);
                    }
                    
                    $dossier = "images";
                    $model = new \Models\Upload();
                    $newProduct['image'] = $model->upload($_FILES['image'], $dossier, $errors);
                }

                
                    // On enregistre toutes les données sous forme de tableau dans une variable data
                    $newData = [
                        'name'          => $newProduct['name'],
                        'price'         => $newProduct['price'], 
                        'category'      => $newProduct['category'], 
                        'description'   => $newProduct['description'], 
                        'image'           => $newProduct['image']
                    ];
            

                
                $model = new \Models\Products();
                $model->updateProductById($newData, $_GET['id']);
              
               
               

                header('Location: index.php');
                exit();
               

            }
    
        }
        $template = "addproduct.phtml";
        include_once 'views/layout.phtml';      
    }

    //Supression d'un product
    public function deleteProduct($id) {

        $model = new \Models\Products();
        $imageName = $model->getImageProductbyId($id); 

        // Je supprime l'image de mon dossier dans la mesure où elle ne s'appelle pas "noPicture.png"
        if($imageName['image'] != "noPicture.png") {
            unlink('public/images/'.$imageName['image']); 
        }
        
        $model->deleteProductById('products', 'product_id', $id);
        

        
    }

}
