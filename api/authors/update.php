<?php

    include_once '../../models/Author.php';

    class Update{
        public function __construct(private Author $auth){
        }
        public function update($data){
            // parameter check
            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('author', $data) || $data['author']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            // get data
            $res = $this->auth->update($data);
            // if not correct, return message
            if(!$res){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }
            // fetch and create array
            $auth_id = $res->fetch(PDO::FETCH_ASSOC);
            echo json_encode($auth_id);
        }
    }