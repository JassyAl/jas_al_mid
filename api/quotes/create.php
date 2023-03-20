<?php 
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../models/Quote.php';
    class Create{
        public function __construct(private Quote $quotes){

        }
        public function create($quote){

            // check if parameters are fulfilled         
            if(!array_key_exists('quote', $quote) || 
            !array_key_exists('author_id', $quote) || 
            !array_key_exists('category_id', $quote) ||
            $quote['quote']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            // get results
            $res = $this->quotes->create($quote);
            
            // missing author 
            if($res == 2){  
                $missingAuth = ["message" => 'author_id Not Found'];
                echo json_encode($missingAuth);
            
                // missing category
            }else if($res == 1){
                $missingCat = ["message" => 'category_id Not Found'];
                echo json_encode($missingCat);
            
                // else send request  
            }else if($res){ 
                $quote_id = $res->fetch(PDO::FETCH_ASSOC);
                echo json_encode($quote_id);
            }

            // missing requirements
            else{  
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
        }
    }