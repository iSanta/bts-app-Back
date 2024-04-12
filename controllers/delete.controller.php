<?php

require_once "models/delete.model.php";
class DeleteController{
    
    static public function deleteData($_table, $_id, $_nameId){
        $response = DeleteModel::deleteData($_table, $_id, $_nameId);
       
        $return = new DeleteController();
        $return-> fncResponse($response);
    }

    public function fncResponse($_response){

        #echo $_response;
        #return;

        if (!empty($_response)) {
            $json = array(
                'status' => 200,
                'results' => $_response
            );
        }
        else{
            $json = array(
                'status' => 404,
                'results' => 'Not found',
                'method' => 'DELETE'
            );
        }
        
        
        echo json_encode($json, http_response_code($json['status']));
    }
}