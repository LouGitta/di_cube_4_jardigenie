<?php
namespace Models;

class OrderDetails extends Database {

    public function addDetail($orderId, $productId, $quantity) {
        $productModel = new Products();
        $product = $productModel->getProductById($productId);

        $req = "INSERT INTO order_details (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)";
        return $this->addOne('order_details', 'order_id, product_id, quantity, unit_price', '?, ?, ?, ?', [$orderId, $productId, $quantity, $product['price']]);
    }
}
