<?php

namespace Models;

class Users extends Database {
    
    public function getAllUsers() {
        $req = "SELECT * FROM users 
                ORDER BY user_id DESC LIMIT 50";
        return $this->findAll($req);
    }

    public function addNewUser($data) {
        $this->addOne(  'users',
                        'first_name, last_name, mail, password, register_date, is_admin',
                        '?,?,?,?,?,?',
                        $data);
    }
  
    public function getUserById($id) {
        $req = "SELECT * FROM users WHERE user_id = ?";
        return $this->findOne($req, [$id]);
    }
         
    public function updateUserById($newData, $id) {
        $this->updateOne('users', $newData, 'user_id', $id);
    }
    
    public function deleteUserById($table, $idname, $id) {
        $this->deleteOneById($table, $idname, $id);
    }
}


