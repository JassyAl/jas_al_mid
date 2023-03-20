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
    include_once '../../models/Quote.php'; 

    include_once 'create.php';
    include_once 'delete.php';
    include_once 'read_single.php';
    include_once 'read.php';
    include_once 'update.php';
    
 
    
    // Instatiate DB & connect
    $database = new Database();
    // Instantiate Quote onj
    $quotes = new Quote($database);

       // GET METHOD
       switch ($method){
        case "GET": 
             // quote id
            if(isset($_GET['id']) ){ 
                $id = ' WHERE q.id = ' . $_GET['id'] . ') as quotes';                
                $requests = new Read_Single($quotes);
                $requests->request_One($method, $id);
            }elseif(isset($_GET['author_id'])) { 
                $id = ' WHERE q.author_id = ' . $_GET['author_id'] . ') as quotes
                ORDER BY id';                              
                $requests = new Read_Single($quotes);
                $requests->request_One($method, $id);
            }elseif(isset($_GET['category_id']) && isset($_GET['random'])){
                $id = ' WHERE q.category_id = ' . $_GET['category_id'] . 
                ') as quotes ORDER BY RANDOM() LIMIT 1';
                $requests = new Read_Single($quotes);
                $requests->request_One($method, $id);
                // cateogry_id
            }elseif(isset($_GET['category_id'])){ 
                $id = ' WHERE q.category_id = ' . $_GET['category_id'] . ') as quotes
                ORDER BY id';                             
                $requests = new Read_Single($quotes);
                $requests->request_One($method, $id);
            }elseif(isset($_GET['random'])){
                $id = ') as quotes ORDER BY RANDOM() LIMIT 1';
                $requests = new Read_Single($quotes);
                $requests->request_One($method, $id);
                // else read all
            }else{  
                $requests = new Read($quotes);
                $requests->every_Quote($method);
            }
            
            break; 

        // POST METHOD            
        case "POST": 
            $data = (array) json_decode(file_get_contents("php://input"));
            $requests = new Create($quotes);
            $requests->create($data);      
            break;

        // PUT METHOD
        case "PUT":  
            $data = (array) json_decode(file_get_contents("php://input"));        
            $requests = new Update($quotes);
            $requests->update($data);
        break;

        // DELETE METHOD
        case "DELETE":  
            $data = (array) json_decode(file_get_contents("php://input"));       
            $requests = new Delete($quotes);
            $requests->delete($data);
        break;
    }