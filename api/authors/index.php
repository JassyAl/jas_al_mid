<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    include_once 'create.php';
    include_once 'delete.php';
    include_once 'read_single.php';
    include_once 'read.php';
    include_once 'update.php';


    //Instantiate DB & connect
    $database = new Database();
    //Instantiate author obj
    $auth = new Author($database);
    
    //switch for methods
    switch ($method){
        case "GET":   
            if(isset($_GET['id']) ){
                $id = $_GET['id']; 
                // read one author
                $requests  = new Read_Single($auth);
                $requests ->request_One($method, $id);   
            }else { 
                // read all authors
                $requests  = new Read($auth);
                $requests ->every_Auth($method);
            }
            break;

        // POST METHOD
        case "POST":  
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests = new Create($auth);
            $requests->create($data);
            break;

        // PUT METHOD
        case "PUT":   
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests  = new Update($auth);
            $requests ->update($data);
            break;

        // DELETE METHOD
        case "DELETE":  
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests  = new Delete($auth);
            $requests ->delete($data);            
            break;

        // DEFAULT METHOD
        default:  
            $requests  = new Read($auth);
            $requests ->every_Auth($method);
            break;
    }
    


