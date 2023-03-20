<?php

    include_once '../../models/Quote.php';

class Read_Single {

    public function __construct(private Quote $quotes) {}

    public function request_One($method, $id) {

        // results of query
        $res = $this->quotes->read_single($id);
        // no data found
        if($res->rowCount() == 0) {
            // display message
            $emptyRows = (["message" => 'No Quotes Found']);
            echo json_encode($emptyRows);
            exit;
        } else {
            // quotes array
            $quotes_array = array();
            // set rows to results returned
            while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                if ($res->rowCount()==1){
                    $quotes_array = array(
                // assign values to variables
                'id' =>$id,
                'quote' =>$quote,
                'author' =>$author,
                'category' =>$category
                );
                
            } else{
                array_push($quotes_array, ['id' => $id, 'quote' => $quote, 'author' => $author, 'category' => $category]);
            }
        }
            // Convert to JSON 
            echo json_encode($quotes_array);
        }
    }
}

