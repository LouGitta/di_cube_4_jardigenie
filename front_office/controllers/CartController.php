<?php

namespace Controllers;

use Models\Products;
use Models\Cart;

require_once 'models/Cart.php';
require 'models/Products.php';

class CartController {

    public function add(){
        $model = new \Models\Cart();
        $model->addProduct($_GET['product_id'], $_GET['quantity']);
        header('Location: index.php?route=cart');
    }

    public function delete($idProduct){
        $model = new \Models\Cart();
        $model->deleteProduct($idProduct);
        header('Location: index.php?route=cart');
    }

    public function edit($idProduct, $quantity){
        $model = new \Models\Cart();
        $model->setQuantity($idProduct, $quantity);
        header('Location: index.php?route=cart');
    }

    public function showCart(){
        $model = new \Models\Cart();
        $cart = $model->getCart();
        $products = [];
        $total = 0;
    
        foreach ($cart as $key => $value) {
            $productModel = new \Models\Products();
            $productInfo = $productModel->getProductById($key);
            $productInfo['quantity'] = $value;
            $productInfo['total'] = $productInfo['price'] * $value;
            $total += $productInfo['total'];
            $products[] = $productInfo; // <== On ajoute chaque produit
        }
    
        $template = "views/cart.phtml";
        include_once 'views/layout.phtml';
    }

}
?>
