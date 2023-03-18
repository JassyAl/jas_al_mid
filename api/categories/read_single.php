<?php

include_once '../../models/Category.php';

    // error handling
    class Read_Single{
        public function __construct(private Category $cat){

        }
        public function request_One($method, $id){
            // if category exists
            if($id == ""){
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }
            // category query
            $results = $this->cat->read_single($id);
            // if cats return row count
            if($results->rowCount() == 0){
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }else {
                // Create cat array
                $category_arr = array();
                
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $category_arr = array(
                    'id' => $id,
                    'category' => $category              
                  );             
                }
                // Convert JSON 
                echo json_encode($category_arr);
            }
            
        }
    }