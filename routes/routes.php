<?php 

    $routesArray = explode("/", $_SERVER['REQUEST_URI']);
    $routesArray = array_filter($routesArray);
    
    /// null request
    if (count($routesArray) == 0) {
        $json = array(
            'status' => 404,
            'result' => 'Not found'
        );

        echo json_encode($json, http_response_code($json['status']));
        return;
    }

    ///Valid request
    if (count($routesArray) == 1 && isset($_SERVER['REQUEST_METHOD']) ) {
        $table = explode('?', $routesArray[1])[0] ;
        ///GET
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            include "services/get.php";

        }

        ///POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            include "services/post.php";


        }

        ///PUT
        if ($_SERVER['REQUEST_METHOD'] == "PUT") {
            include "services/put.php";
        }

        ///DELETE
        if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            include "services/delete.php";
        }
    }   

 
    

    
   
    
