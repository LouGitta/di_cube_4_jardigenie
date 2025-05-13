<?php
namespace Controllers;
use Models\Order;
use Models\Cart;
use Models\OrderDetails;
use Models\Products;


class OrderController {

    public function display() {

        $model = new Order();
        $listOrders = $model->getOrdersByUser($_SESSION['user']['id']);

        // Affiche la vue
        $template = "orders.phtml";
        include_once 'views/layout.phtml';
    }

    public function validateOrder() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
    
        $orderModel = new Order();
        $orderDetailsModel = new OrderDetails();
        $cartModel = new Cart();
        $productModel = new Products(); 
    
        $cart = $cartModel->getCart();
        if (empty($cart)) {
            header('Location: index.php?route=cart');
            exit;
        }
    
        $numberProduct = 0;
        $totalPrice = 0.0;
    
        foreach ($cart as $productId => $quantity) {
            $numberProduct += $quantity;
            $product = $productModel->getProductById($productId);
            $totalPrice += $product['price'] * $quantity;
        }
    
        $orderModel->createOrder($_SESSION['user'], $numberProduct, $totalPrice);
        $order = $orderModel->getOrder($_SESSION['user']);
        $orderId = $order[0]['order_id'];
    
        foreach ($cart as $productId => $quantity) {
            $orderDetailsModel->addDetail($orderId, $productId, $quantity);
        }
    
        $cartModel->emptyCart();
    
        $template = './views/orderConfirmed.phtml';
        include_once './views/layout.phtml';
    }
    
}
