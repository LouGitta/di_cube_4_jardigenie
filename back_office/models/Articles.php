<?php

namespace Models;

class Articles extends Database {
    
    public function getAllArticles() {
        $req = "SELECT * FROM articles 
                ORDER BY art_id DESC LIMIT 50";
        return $this->findAll($req);
    }

    public function getArticlesByCat($cat) {
        $req = "SELECT * FROM articles 
                WHERE art_category = ?
                ORDER BY art_id DESC LIMIT 50";
        return $this->findAll($req, [$cat]);
    }

    public function addNewArticle($data) {
        $this->addOne(  'articles',
                        'art_name, art_price, art_category, art_description, art_img',
                        '?,?,?,?,?',
                        $data);
    }
  
    public function getArticleById($id) {
        $req = "SELECT * FROM articles WHERE art_id = ?";
        return $this->findOne($req, [$id]);
    }
         
    public function updateArticleById($newData, $id) {
        $this->updateOne('articles', $newData, 'art_id', $id);
    }
    
    public function getImageArticlebyId($id) {
        $req = "SELECT art_img FROM articles WHERE art_id = ?";
        return $this->findOne($req, [$id]);
    }
    
    public function deleteArticleById($table, $idname, $id) {
        $this->deleteOneById($table, $idname, $id);
    }
    
    
}


