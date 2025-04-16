<?php
class Cart {
    public function __construct(){
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }
    }

    public function addProduct($idProduct, $quantity){
        if(isset($_SESSION['cart'][$idProduct])){
            $_SESSION['cart'][$idProduct] += $quantity;
        } else {
            $_SESSION['cart'][$idProduct] = $quantity;
        }
    }

    public function setQuantity($idProduct, $quantity){
        if(isset($_SESSION['cart'][$idProduct])){
            $_SESSION['cart'][$idProduct] = $quantity;
        }
    }

    public function deleteProduct($idProduct){
        unset($_SESSION['Cart'][$idProduct]);
    }

    public function getCart(){
        return $_SESSION['cart'];
    }

    public function emptyCart(){
        $_SESSION['Cart'] = [];
    }
}
?>
