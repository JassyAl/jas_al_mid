<?php

    include_once '../../models/Category.php';

    class Delete{
        public function __construct(private Category $cat){

        }
        // error handling
        public function delete($data){
            // parameter check
            if(!isset($data['id'])) {
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }            
            // get results
            $res = $this->cat->delete($data);
            // no data found
            if($res == false){
                $no_data = ["message" => 'category_id Not Found'];
                echo json_encode($no_data);
                exit;
            }
            // fetch results
            $cat_id = $res->fetch(PDO::FETCH_ASSOC);
            // create cat arr
            $category_arr = json_encode($cat_id);
            echo $category_arr;

        }

    }
