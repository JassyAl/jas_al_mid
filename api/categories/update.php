<?php

    include_once '../../models/Category.php';

    class Update{
        public function __construct(private Category $cat){
        }
        public function update($data){
            // parameter check
            $req_params = ['id', 'category'];
            foreach($req_params as $key) {
                if(empty($data[$key])) {
                    echo json_encode(["message" => 'Missing Required Parameters']);
                    exit;
                }
            }
            // get data
            $res = $this->cat->update($data);
            // if not correct, return message
            if(!$res){
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }
            // fetch and makee array
            $cat_id = $res->fetch(PDO::FETCH_ASSOC);
            // return array
            echo json_encode($cat_id);
        }
    }