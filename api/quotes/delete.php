<?php
    include_once '../../models/Quote.php';

    class Delete{
        public function __construct(private Quote $quotes){
        }
        public function delete($data){
            // if key exists 
            if(!array_key_exists('id', $data)){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            
            // get results
            $res = $this->quotes->delete($data);
            // none returned
            if($res == false){
                $noQuotes = ["message" => 'No Quotes Found'];
                echo json_encode($noQuotes);
                exit;
            }
            // fetch and make array
            $quote_id = $res->fetch(PDO::FETCH_ASSOC);
            // make json array
            $quote_arr = json_encode($quote_id);
            // return array
            echo $quote_arr;

            

        }

    }
