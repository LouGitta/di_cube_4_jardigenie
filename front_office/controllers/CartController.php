<?php

use Models\Products;

require_once 'models/Cart.php';
require_once 'models/Products.php';

class CartController {
    private $db;
    private $cart;
    private $products;

    public function __construct($db){
        $this->db = $db;
        $this->cart = new Cart();
        $this->products = new Products($db);
    }

    public function add($idProduct, $quantity){
        $this->cart->addProduct($idProduct, $quantity);
        header('Location: index.php?page=cart');
    }

    public function delete($idProduct){
        $this->cart->deleteProduct($idProduct);
        header('Location: index.php?page=cart');
    }

    public function set($idProduct, $quantity){
        $this->cart->setQuantity($idProduct, $quantity);
        header('Location: index.php?page=cart');
    }

    public function showCart(){
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
    }
}
?>
