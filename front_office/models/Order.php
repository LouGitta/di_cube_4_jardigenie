<?php
namespace Models;

use Models\Database;

class Order extends Database {

    public function createOrder($userId) {
        $req = "INSERT INTO orders (user_id, order_date) 
                VALUES (?, CURDATE())";

        return $this->addOne('orders', 'user_id, order_date', '?, CURDATE()', [$userId]);
    }

    public function getOrdersByUser($userId) {
        $req = "SELECT * FROM orders 
        WHERE user_id = ?";
        return $this->findAll($req, [$userId]);
    }
}
