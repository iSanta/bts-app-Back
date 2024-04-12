<?php

require_once "connection.php";
class PostModel{
    static public function postData($_table,$_data){

        $columns = "";
        $params = "";
        foreach ($_data as $key => $value) {
            $columns .= $key.",";
            $params .= ":".$key.",";
        }
        $columns = substr($columns,0,-1);
        $params = substr($params,0,-1);

        $sql = "INSERT INTO $_table ($columns) VALUES ($params)";

        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        foreach ($_data as $key => $value) {
            $stmt->bindParam(":".$key, $_data[$key], PDO::PARAM_STR);
        }
        if ($stmt->execute()) {
            $response = array(
                "lastId" =>  $link->lastInsertId(),
                "status"=> "success",
                "message"=> "The process end successfully"
            );
            return $response;
        }
        else{
            return  $link->errorInfo();
        }
        
    }

    
}