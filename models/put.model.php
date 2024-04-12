<?php

require_once "connection.php";
require_once "get.model.php";
class PutModel{
    static public function PutData($_table,$_data, $_id, $_nameId){
        ///validate id
        $response = GetModel::getDataFiltered($_table, $_nameId, $_nameId, $_id, null, null, null, null);

        if(empty($response)){
            $response = array(
                "status"=> "400",
                "message"=> "the field with the id that you are trying to modify does not exist"
            );
            return $response;
        }

        $set = "";
        foreach ($_data as $key => $value) {
            $set .= $key." = :".$key.",";
        }
        $set = substr($set,0,-1);

        $sql = "UPDATE $_table SET $set WHERE $_nameId = :$_nameId";

        $link = Connection::connect();
        $stmt = $link->prepare($sql);

        foreach ($_data as $key => $value) {
            $stmt->bindParam(":".$key, $_data[$key], PDO::PARAM_STR);
        }
        $stmt->bindParam(":".$_nameId, $_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $response = array(
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