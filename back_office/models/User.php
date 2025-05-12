<?php
namespace Models;

class User extends Database {
    
    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE mail = ?";
        return $this->findOne($query, [$email]);
    }
    
    public function create($userData) {  
        $columns = "first_name, last_name, mail, password, is_admin, register_date";
        $values = "?, ?, ?, ?, ?, NOW()";
        $data = [
            $userData['first_name'], 
            $userData['last_name'], 
            $userData['mail'], 
            $userData['password'],
            $userData['is_admin'] ?? 0 
        ];
        
        return $this->addOne('users', $columns, $values, $data);
    }
    
    public function findById($id) {
        return $this->getOneById('users', 'user_id', $id);
    }
    
    public function update($userData, $id) {
        return $this->updateOne('users', $userData, 'user_id', $id);
    }
    
    public function delete($id) {
        return $this->deleteOneById('users', 'user_id', $id);
    }

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