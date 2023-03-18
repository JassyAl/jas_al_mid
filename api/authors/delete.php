<?php

    include_once '../../models/Author.php';

    class Delete{
        public function __construct(private Author $auth){

        }
        // error handling
        public function delete($data){
            // parameter check
            if(!isset($data['id'])) {
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }            
            // get results
            $res = $this->auth->delete($data);
            // no data found
            if($res == false){
                $no_data = ["message" => 'author_id Not Found'];
                echo json_encode($no_data);
                exit;
            }
            // fetch results
            $auth_id = $res->fetch(PDO::FETCH_ASSOC);
            // create auth arr
            $author_arr = json_encode($auth_id);
            echo $author_arr;

        }

    }

    
