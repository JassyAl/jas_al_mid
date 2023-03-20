<?php 
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../models/Author.php';
    class Create{

        public function __construct(private Author $auth){

        }
        // create auth function
        public function create($data){
           // parameter input check
           if(!array_key_exists('author', $data) || $data['author']==""){
            echo json_encode(["message" => 'Missing Required Parameters']);
            exit;
            }            
            // results
            $res = $this->auth->create($data);
            // fetch results
            $auth_id = $res->fetch(PDO::FETCH_ASSOC);
            // encode to JSON
            $author_arr = json_encode($auth_id);
            // return author_arr
            echo $author_arr;

        }
    }
    