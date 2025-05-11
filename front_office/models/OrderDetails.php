<?php
namespace Models;

class OrderDetails extends Database {

    public function addDetail($orderId, $productId, $quantity) {
        $productModel = new Products();
        $product = $productModel->getProductById($productId);
        $data = [
            $orderId,
            $productId,
            $quantity,
            $product['price']
        ];
        return $this->addOne('order_details', 'order_id, product_id, quantity, unit_price', '?, ?, ?, ?', $data);
    }
}
