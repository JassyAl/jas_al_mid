<?php 
   
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, categoryization, X-Requested-With');

    include_once '../../models/Category.php';
    class Create{

        public function __construct(private Category $cat){

        }
        // create cat function
        public function create($data){
           // parameter input check
            if(empty($data['category'])) {
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }            
            // results
            $res = $this->cat->create($data);
            // fetch results
            $cat_id = $res->fetch(PDO::FETCH_ASSOC);
            // encode to JSON
            $category_arr = json_encode($cat_id);
            // return category_arr
            echo $category_arr;

        }
    }
    