<?php

namespace Models;

class Orders extends Database {
    
    public function getAllOrders() {
        $req = "SELECT * FROM orders 
                ORDER BY order_id DESC LIMIT 50";
        return $this->findAll($req);
    }
  
    public function getOrderById($id) {
        $req = "SELECT * FROM orders WHERE order_id = ?";
        return $this->findOne($req, [$id]);
    }
         
    public function updateOrderById($newData, $id) {
        $this->updateOne('orders', $newData, 'order_id', $id);
    }

}


