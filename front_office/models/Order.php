<?php
namespace Models;

use Models\Database;

class Order extends Database {

    public function createOrder($user, $numberProduct, $totalPrice) {
        $data= [
            $user['id'],
            date('Y-m-d'),
            $numberProduct,
            $totalPrice
        ];
        return $this->addOne('orders', 'user_id, order_date, number_product, total_price', '?, ?, ?, ?', $data);
    }

    public function getOrder($user) {
        $req = "SELECT * FROM orders 
        WHERE user_id = ?
        ORDER BY order_date";
        return $this->findAll($req, [$user['id']]);
    }

    public function getOrdersByUser($userId) {
        $req = "SELECT * FROM orders 
        WHERE user_id = ?";
        return $this->findAll($req, [$userId]);
    }
}
