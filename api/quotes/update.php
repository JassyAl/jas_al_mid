<?php

    include_once '../../models/Quote.php';

    class Update{

        public function __construct(private Quote $quotes){
        }

        public function update($data){
            // query parameters
            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('category_id', $data) || $data['category_id']=='' ||
             !array_key_exists('author_id', $data) || $data['author_id']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            // results of query
            $res = $this->quotes->update($data);

            // if category id does not exist
            if($res == 1){
                echo json_encode(["message" => 'category_id Not Found']);
                
            // if author id does not exist
            }else if($res == 2){
                echo json_encode(["message" => 'author_id Not Found']);
            }

            // if quotes do not exist
            else if(!$res){
                echo json_encode(["message" => 'No Quotes Found']);
            
                // return  quotes   
            }else if($res){
                $quote_id = $res->fetch(PDO::FETCH_ASSOC);
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

    