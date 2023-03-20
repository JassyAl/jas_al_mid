<?php
    class Quote {
        private $conn;
        private $table = 'quotes';

        private $joinQuery ='SELECT 
            q.id, 
            q.quote, 
            a.author,
            c.category
        FROM 
            quotes q
        INNER JOIN 
            authors a
        ON 
            q.author_id = a.id
        INNER JOIN 
            categories c
        ON 
            q.category_id = c.id';
        

        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        public function __construct($database){
            $this->conn = $database->connect();
        }

        public function read(){
            // GET all  quotes
            $getAll = $this->joinQuery . ' ORDER BY q.id';
            $stmt = $this->conn->prepare($getAll);
            // query 
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }           

        }
        
        public function read_single($id){
            // get single quote
            $querySingle = 'SELECT * FROM (' . $this->joinQuery . $id;
            
            $stmt = $this->conn->prepare($querySingle);

            // query 
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }

        }
        

        public function create($data) {
            // create quotes with aall fields
            $createQuery = ' INSERT INTO 
            ' . $this->table . '
            (id, quote, author_id, category_id) 
            VALUES 
            ((SELECT setval(\'quotes_id_seq\', 
            (SELECT MAX(id) FROM quotes)+1)), :quote, :author_id, :category_id)
            RETURNING id, quote, author_id, category_id';

            $stmt = $this->conn->prepare($createQuery);

            // bind values
            $stmt->bindValue(":quote", $data["quote"], PDO::PARAM_STR);
            $stmt->bindValue(":author_id", $data["author_id"], PDO::PARAM_INT);
            $stmt->bindValue(":category_id", $data["category_id"], PDO::PARAM_INT);
            
            // Try to execute 
            try {
                if ($stmt->execute()) {
                    return $stmt;
                }
            } catch (PDOException $e) {
                $errorInfo = $e->errorInfo;
                if ($errorInfo[0] === '23503') {
                    $str = $e->getMessage();
                    $catOrder = '/category_id/';
                    $authOrder = '/author_id/';
                    if (preg_match($catOrder, $str)) {
                        // category err
                        return 1;
                    } else {
                        // author_id 
                        return 2;
                    }
                }
            }

        }

        public function update($data){
            //for PUT - update
            $updateQuery = 'UPDATE 
            ' . $this->table . '
            SET quote = :quote,
            author_id = :author_id,
            category_id = :category_id
            WHERE id = :id RETURNING id, quote, author_id, category_id';

            $stmt = $this->conn->prepare($updateQuery);
            // bind values
            $stmt->bindValue(":quote", $data["quote"], PDO::PARAM_STR);
            $stmt->bindValue(":author_id", $data["author_id"], PDO::PARAM_INT);
            $stmt->bindValue(":category_id", $data["category_id"], PDO::PARAM_INT);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

            // query
            try{                
                if($stmt->execute()){
                    if($stmt->rowCount() === 0){
                        return false;
                    }
                    return $stmt;                
                }
            }catch(PDOException $e){
                // search key violation
                if($e->getCode()==='23503') {
                    $str = $e->getMessage();
                    
                    $catOrder = '/category_id/';
                    $authOrder = '/author_id/';
                    if(preg_match($catOrder, $str)){
                        // no cat_id
                        return 1;
                    }
                    elseif(preg_match($authOrder, $str)){
                        // no auth id
                        return 2;
                    }else{
                        // missing id
                        return 3;
                    }
                }
                
            }
            
        }
        public function delete($data){
            $deleteQuery = 'DELETE FROM 
            ' . $this->table . '
            WHERE 
            id = :id 
            RETURNING 
            id';

            $stmt = $this->conn->prepare($deleteQuery);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

            //execute
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