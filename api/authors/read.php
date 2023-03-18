<?php
    
    include_once '../../models/Author.php';

    class Read {
        public function __construct(private Author $auth){
        }
        public function every_Auth($method){
            $results = $this->auth->read();
            // number of rows
            $num = $results->rowCount();
            // if there is data
            if($num > 0){
                // create array with data
                // $author_arr = array();
                
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                    $author_arr[] = ['id' => $row['id'], 'author' => $row['author']];
                }
                // Turn to JSON & output
                echo json_encode($author_arr);
          
            } else {
                    // No Authors
                    echo json_encode(array('message' => 'No Authors Found'));
                }
            }
        }
        