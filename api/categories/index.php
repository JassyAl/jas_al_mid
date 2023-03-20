<?php

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    include_once 'create.php';
    include_once 'delete.php';
    include_once 'read_single.php';
    include_once 'read.php';
    include_once 'update.php';

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
    // Instantiate DB & connect
    $database = new Database();
    // Instantiate Category obj
    $cat = new Category($database);
    
    // switch for methods
    switch ($method){
        case "GET":   
            if(isset($_GET['id']) ){
                $id = $_GET['id']; 
                // read one Category
                $requests  = new Read_Single($cat);
                $requests ->request_One($method, $id);   
            }else { 
                // read all Categories
                $requests  = new Read($cat);
                $requests ->every_Cat($method);
            }
            break;

        // POST METHOD
        case "POST":  
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests = new Create($cat);
            $requests->create($data);
            break;

        // PUT METHOD
        case "PUT":   
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests  = new Update($cat);
            $requests ->update($data);
            break;

        // DELETE METHOD
        case "DELETE":  
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests  = new Delete($cat);
            $requests ->delete($data);            
            break;
        
        // DEFAULT METHOD
        default:  
            $requests  = new Read($cat);
            $requests ->every_Cat($method);
            break;
    }
    

