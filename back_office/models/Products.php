<?php

namespace Models;

class Products extends Database {
    
    public function getAllProducts() {
        $req = "SELECT * FROM products 
                ORDER BY product_id DESC LIMIT 50";
        return $this->findAll($req);
    }

    public function getProductsByCat($cat) {
        $req = "SELECT * FROM products 
                WHERE category = ?
                ORDER BY product_id DESC LIMIT 50";
        return $this->findAll($req, [$cat]);
    }

    public function addNewProduct($data) {
        $this->addOne(  'products',
                        'name, price, category, description, image',
                        '?,?,?,?,?',
                        $data);
    }
  
    public function getProductById($id) {
        $req = "SELECT * FROM products WHERE product_id = ?";
        return $this->findOne($req, [$id]);
    }
         
    public function updateProductById($newData, $id) {
        $this->updateOne('products', $newData, 'product_id', $id);
    }
    
    public function getImageProductbyId($id) {
        $req = "SELECT image FROM products WHERE product_id = ?";
        return $this->findOne($req, [$id]);
    }
    
    public function deleteProductById($table, $idname, $id) {
        $this->deleteOneById($table, $idname, $id);
    }
    
    
}


