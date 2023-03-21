<?php

include_once '../../models/Author.php';

    // error handling
    class Read_Single{
        public function __construct(private Author $auth){

        }
        public function request_One($method, $id){
            $auth_message = ["message" => 'author_id Not Found'];  
            // if author exists
            if($id == ''){
                echo json_encode($auth_message);
                exit;
            }
            // author query
            $res = $this->auth->read_single($id);
            // if authors return row count
            if($res->rowCount() == 0){
                echo json_encode($auth_message);
                exit;
            }else {
                // Create auth array
                $auth_array = array();
                
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $auth_array = array(
                    'id' => $id,
                    'author' => $author              
                  );             
                }
                // Convert JSON 
                echo json_encode($auth_array);
            }
            
        }
    }