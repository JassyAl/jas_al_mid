<?php

    include_once '../../models/Quote.php';

    class Update{

        public function __construct(private Quote $quotes){
        }

        public function update($data){
            // query parameters
            $required_params = ['id', 'category_id', 'author_id'];
            // check parameters
            foreach ($required_params as $param) {
                if (!array_key_exists($param, $data) || $data[$param] === '') {
                    echo json_encode(["message" => 'Missing Required Parameters']);
                    exit;
                }
            }
            // results of query
            $results = $this->quotes->update($data);
            // if category id does not exist
            if($results == 1){
                echo json_encode(["message" => 'category_id Not Found']);
            // if author id does not exist
            }else if($results == 2){
                echo json_encode(["message" => 'author_id Not Found']);
            }
            // if quotes do not exist
            else if(!$results){
                echo json_encode(["message" => 'No Quotes Found']);
            // return  quotes   
            }else if($results){
                $quote_id = $results->fetch(PDO::FETCH_ASSOC);
                $quote_obj= json_encode($quote_id);
                echo $quote_obj;
            }
            // missing required parameters
            else{
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

        }

    }

    