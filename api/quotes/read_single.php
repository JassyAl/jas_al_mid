<?php

    include_once '../../models/Quote.php';

    class Read_Single{

        public function __construct(private Quote $quotes){
        }
        
        public function request_One($method, $id){

            // results of query
            $results = $this->quotes->read_single($id);
            // no data found
            if($results->rowCount() == 0){
                // display message
                echo json_encode(["message" => 'No Quotes Found']);
                exit;
            }else {
                // quotes array
                $quote_arr = array();
                // set rows to results returned
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                    //if no rows returned, there are no quotes, return message
                    if (!$row) {
                        echo json_encode(["message" => 'No Quotes Found']);
                        exit;
                    }
                    // begin row count if quote is found
                    if($results->rowCount() == 1){
                        $quote_arr = [
                            'id' => $row['id'],
                            'quote' => $row['quote'],
                            'author' => $row['author'],
                            'category' => $row['category']
                        ];
                    // push to array      
                    }else{                 
                        array_push($quote_arr, ['id'=>$id, 'quote'=>$quote,
                        'author'=>$author, 'category'=>$category]);
                    }
                }
          
                // Convert to JSON 
                echo json_encode($quote_arr);
            }

            
        }
    }