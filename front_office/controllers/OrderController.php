<?php
namespace Controllers;
use Models\Order;
use Models\Cart;
use Models\OrderDetails;

class OrderController {

    public function validateOrder() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $orderModel = new Order();
        $orderDetailsModel = new OrderDetails();
        $cartModel = new Cart();

        $cart = $cartModel->getCart();
        if (empty($cart)) {
            header('Location: index.php?route=cart');
            exit;
        }
        
        $orderModel->createOrder($_SESSION['user']);
        $order = $orderModel->getOrder($_SESSION['user']);
        $orderId = $order[0]['order_id'];

        foreach ($cart as $productId => $quantity) {
            $orderDetailsModel->addDetail($orderId, $productId, $quantity);
        }

        $cartModel->emptyCart();

        $template = './views/order.phtml';
        include_once './views/layout.phtml';
    }
}
