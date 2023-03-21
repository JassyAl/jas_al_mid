<?php

    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        public function __construct($database){
            $this->conn = $database->connect();
        }

        public function read(){
            // query all 
            $queryAll = 'SELECT 
            * FROM 
            ' . $this->table . ' 
            ORDER BY 
            id';
            //prepare
            $stmt = $this->conn->prepare($queryAll);
            // execute
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }           

        }
        public function read_single($id){
            $querySingle = 'SELECT * 
            FROM 
            ' . $this->table . '
            WHERE 
                id = :id 
            LIMIT 1';
            $stmt = $this->conn->prepare($querySingle);
            // bind
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            // try to query
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }

        }

        public function create($data) {
            $createQuery = ' INSERT INTO 
            ' . $this->table . '
            (id, category) 
            VALUES 
            ((SELECT setval(\'categories_id_seq\', 
            (SELECT MAX(id) FROM categories)+1)), :category) 
            RETURNING 
            id::text, category';

            $stmt = $this->conn->prepare($createQuery);

            // bind data
            $stmt->bindValue(":category", $data["category"], PDO::PARAM_STR);
            // try to execute
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }
        }
        
        public function update($data){
            $updateQuery = 'UPDATE 
            ' . $this->table . '
            SET 
            category = :category 
            WHERE 
            id = :id 
            RETURNING 
            id, category';

            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindValue(":category", $data["category"], PDO::PARAM_STR);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

            try {
                $stmt->execute();
                if($stmt->rowCount() === 0){
                    return false;
                }
                return $stmt;
                    
            }catch(PDOException $e){
                return false;

            }

        }
        public function delete($data){
            // DELETE
            $deleteQuery = 'DELETE FROM ' 
            . $this->table . '
            WHERE 
                id = :id 
            RETURNING   
                id';
            // prepare
            $stmt = $this->conn->prepare($deleteQuery);
            // bind
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);
            // execute
            try {
                $stmt->execute();
                if($stmt->rowCount() === 0){
                    return false;
                }
                return $stmt;
                    
            }catch(PDOException $e){
                return false;

            }
        }
    }

