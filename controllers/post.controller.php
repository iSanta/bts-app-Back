<?php

require_once "models/post.model.php";
class PostController{
    
    static public function postData($_table,$_data){
        $response = PostModel::postData($_table,$_data);
        $return = new PostController();
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
                'method' => 'POST'
            );
        }
        
        
        echo json_encode($json, http_response_code($json['status']));
    }
}