<?php
    
    include_once '../../models/Category.php';

    class Read {
        public function __construct(private Category $cat){
        }
        
        public function every_Cat($method){
            $results = $this->cat->read();
            // number of rows
            $num = $results->rowCount();
            // if there is data
            if($num > 0){
                // create array with data
                // $category_arr = array();
                
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                    $category_arr[] = ['id' => $row['id'], 'category' => $row['category']];
                }
                // Turn to JSON & output
                echo json_encode($category_arr);
          
            } else {
                    // No categories
                    echo json_encode(
                    array('message' => 'No Categories Found')
                    );
                }
        }
    }