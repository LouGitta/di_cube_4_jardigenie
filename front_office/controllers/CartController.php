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
        header('Location: index.php?page=cart');
    }

    public function delete($idProduct){
        $model = new \Models\Cart();
        $model->deleteProduct($idProduct);
        header('Location: index.php?page=cart');
    }

    public function edit($idProduct, $quantity){
        $model = new \Models\Cart();
        $model->setQuantity($idProduct, $quantity);
        header('Location: index.php?page=cart');
    }

    public function showCart(){
        $model = new \Models\Cart();
        $cart = $model->getCart();
        $product = $model->getNumberOfProducts();
        $total = 0;
        foreach ($cart as $key => $value) {
            $productModel = new \Models\Products();
            $productInfo = $productModel->getProductById($key);
            $productInfo['quantite'] = $value;
            $total += $productInfo['price'] * $value;
            $productInfo['total'] = $productInfo['price'] * $value;
        } 
            
        include 'views/cart.php';
    } 
       

        
/*     public function showCart(){
        $content = [];
        $total = 0;
        foreach($this->cart->getCart() as $idProduct => $quantity){
            $product = $this->products->getProductById($idProduct);
            $product['quantite'] = $quantity;
            $product['total'] = $product['prix'] * $quantity;
            $total += $product['total'];
            $content[] = $product;
        }
        include 'views/cart.php';
    } */
}
?>
