<?php

require_once "models/put.model.php";
class PutController{
    
    static public function putData($_table,$_data, $_id, $_nameId){
        $response = PutModel::putData($_table,$_data, $_id, $_nameId);
       
        $return = new PutController();
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
                'method' => 'PUT'
            );
        }
        
        
        echo json_encode($json, http_response_code($json['status']));
    }
}