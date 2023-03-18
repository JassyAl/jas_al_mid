<?php
    
    include_once '../../models/Quote.php';

    class Read {
      
        public function __construct(private Quote $quotes){

        }
        
        public function every_Quote($method){
          
          // results of query
          $results = $this->quotes->read();
          // number of rows 
          $num = $results->rowCount();
          // if data
          if($num > 0){ 
          // Initialize the array
          $quotes_arr = [];

          // Iterate over the results
          while($row = $results->fetch(PDO::FETCH_ASSOC)) {
              // Add the row's data to the array
              array_push($quotes_arr, [
                  'id' => $row['id'],
                  'quote' => $row['quote'],
                  'author' => $row['author'],
                  'category' => $row['category']
              ]);
            }
              // convert to JSON
              echo json_encode($quotes_arr);
            } else {
              // No quotes found, return message
              echo json_encode(
                array('message' => 'No Quotes Found')
              );
            }
          }
        }
    