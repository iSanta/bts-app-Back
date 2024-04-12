<?php

require_once "connection.php";
require_once "get.model.php";
class DeleteModel{
    static public function deleteData($_table, $_id, $_nameId){
        ///validate id
        $response = GetModel::getDataFiltered($_table, $_nameId, $_nameId, $_id, null, null, null, null);

        if(empty($response)){
            $response = array(
                "status"=> "400",
                "message"=> "the field with the id that you are trying to modify does not exist"
            );
            return $response;
        }

        $sql = "DELETE FROM $_table WHERE $_nameId = :$_nameId";

        $link = Connection::connect();
        $stmt = $link->prepare($sql);

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