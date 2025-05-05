<?php
namespace Controllers;

use Models\Cart;
use Models\Products;

class CartController {
    private $cartModel;
    private $productModel;

    public function __construct() {
        $this->cartModel = new Cart();
        $this->productModel = new Products();
    }

    public function showCart() {
        $cart = $this->cartModel->getCart();
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $productInfo = $this->productModel->getProductById($productId);
            if ($productInfo) {
                $products[] = [
                    'id' => $productId,
                    'name' => $productInfo['name'],
                    'price' => $productInfo['price'],
                    'quantity' => $quantity,
                    'total' => $productInfo['price'] * $quantity
                ];
                $total += $productInfo['price'] * $quantity;
            }
        }

       
    $template = "views/cart.phtml";
    include_once 'views/layout.phtml';
    }

    public function add($idProduct, $quantity) {
        $this->cartModel->addProduct($idProduct, $quantity);
        header('Location: index.php?route=cart');
        exit;
    }

    public function delete($idProduct) {
        $this->cartModel->deleteProduct($idProduct);
        header('Location: index.php?route=cart');
        exit;
    }
}


