<?php
    
    include_once '../../models/Author.php';

    class Read {
        public function __construct(private Author $auth){
        }
        public function every_Auth($method){
            $res = $this->auth->read();
            // number of rows
            $num = $res->rowCount();
            // if there is data
            if($num > 0){
                // create array with data
                // $auth_array = array();
                
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    $auth_array[] = ['id' => $row['id'], 'author' => $row['author']];
                }
                // convert to json
                echo json_encode($auth_array);
          
            } else {
                    // author not found
                    echo json_encode(array('message' => 'No Authors Found'));
                }
            }
        }
        