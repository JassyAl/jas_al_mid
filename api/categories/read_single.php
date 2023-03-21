<?php

include_once '../../models/Category.php';

    // error handling
    class Read_Single{
        public function __construct(private Category $cat){

        }
        public function request_One($method, $id){
            $cat_message = ["message" => 'category_id Not Found'];
            // if category exists
            if($id == ''){
                echo json_encode($cat_message);
                exit;
            }
            // category query
            $res = $this->cat->read_single($id);
            // if category return row count
            if($res->rowCount() == 0){
                echo json_encode($cat_message);
                exit;
            }else {
                // Create cat array
                $category_arr = array();
                
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
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