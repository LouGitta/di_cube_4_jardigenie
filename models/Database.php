<?php

namespace Models;

require('config/config.php');

class Database {

    protected $bdd;
    
    //CONNEXION A LA BDD avec les informations présentes dans le fichier CONFIG
    public function __construct() {
        $this->bdd = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    }
    
    // toutes mes méthodes me permettant de realiser les requetes sql à la bdd
    
    protected function findAll($req, $params=[]) {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll(); // Récupérer les enregistrements avec plusieurs lignes
    }
    
    protected function findOne($req, $params=[]) {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch(); // Récupérer les enregistrements avec une ligne
    }
    
    protected function addOne(string $table, string $columns, string $values, $data ) {
        $query = $this->bdd->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        $query->execute($data);
        $query->closeCursor();
    }
    
    
    protected function getOneById($table, $columnId, $id) {
        $query = $this->bdd->prepare("SELECT * FROM " . $table . " WHERE ". $columnId ." = ? ");
        $query->execute([$id]);
        $data = $query->fetch();
        $query->closeCursor();
        return $data;
    }
    
    protected function updateOne($table, $newData, $condition, $val){

        // On initialise les sets comme étant une chaine de caractères vide
        $sets = '';
        // On boucle sur les data à mettre à jour pour préparer le data binding
        foreach( $newData as $key => $value )
        {
            // On concatène le nom des colonnes et le paramètre du data binding:  clé = :clé,
            $sets .= $key . ' = :' . $key . ',';
        }
        // On supprime le dernier caractère, donc la derniere virgule
        $sets = substr($sets, 0, -1);
        // On indique la requete SQL
        $sql = "UPDATE " . $table . " SET " . $sets . " WHERE " . $condition . " = :" . $condition;
        // On prépare la requete SQL
        $query = $this->bdd->prepare( $sql );
        // Pour chaque valeur de la recette, on lie la valeur de la clé à chaque :clé
        foreach( $newData as $key => $value ) {
            $query->bindValue(':' . $key, $value);
        }
        // On lie la valeur (par ex, l'id) de la condition à  :condition
        $query->bindValue( ':' . $condition, $val);
        // On execute la requete
        $query->execute();
        // On indique au serveur que notre requete est terminée
        $query->closeCursor();
    }
    
    protected function deleteOneById($table, $idname, $id) {
        $query = $this->bdd->prepare(
            "DELETE FROM " . $table . " WHERE " . $idname . " = ?"
            );
        $query->execute([$id]);
        $query->closeCursor();
        
        
        
    }
    
    
}