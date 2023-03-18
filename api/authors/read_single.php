<?php

include_once '../../models/Author.php';

    // error handling
    class Read_Single{
        public function __construct(private Author $auth){

        }
        public function request_One($method, $id){
            // if author exists
            if($id == ""){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }
            // author query
            $results = $this->auth->read_single($id);
            // if auths return row count
            if($results->rowCount() == 0){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }else {
                // Create auth array
                $author_arr = array();
                
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $author_arr = array(
                    'id' => $id,
                    'author' => $author              
                  );             
                }
                // Convert JSON 
                echo json_encode($author_arr);
            }
            
        }
    }