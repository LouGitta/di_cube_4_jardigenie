<?php
namespace Controllers;
use Models\Order;
use Models\Cart;
use Models\OrderDetails;

class OrderController {

    public function validateOrder() {
        if (!isset($_SESSION['user_id'])) {
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

        $orderId = $orderModel->createOrder($_SESSION['user_id']);

        foreach ($cart as $productId => $quantity) {
            $orderDetailsModel->addDetail($orderId, $productId, $quantity);
        }

        $cartModel->emptyCart();

        $template = './views/order.phtml';
        include_once './views/layout.phtml';
    }
}
