<?php

namespace Models;

class Orders extends Database {

    public function getOrders($id) {
        $req = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
        return $this->findAll($req, $id);
    }

}