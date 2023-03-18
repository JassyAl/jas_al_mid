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
                $emptyRows = (["message" => 'No Quotes Found']);
                echo json_encode($emptyRows);
                exit;
            }else {
                // quotes array
                $quotes_array = array();
                // set rows to results returned
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                    // assign values to variables
                    $id = $row['id'];
                    $quote = $row['quote'];
                    $author = $row['author'];
                    $category = $row['category'];
                    
                    // create quote array
                    $quote = [
                        'id'=>$id,
                        'quote'=>$quote, 
                        'author'=>$author, 
                        'category'=>$category
                    ];
                    
                    // add quote to quotes_array
                    array_push($quotes_array, $quote);
               // push to array      
}                  
    array_push($quotes_array, ['id'=>$id, 'quote'=>$quote,
                     'author'=>$author, 'category'=>$category]);


          
                // Convert to JSON 
                echo json_encode($quotes_array);
            }

            
        }
    }