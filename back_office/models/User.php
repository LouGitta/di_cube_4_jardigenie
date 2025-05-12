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
}