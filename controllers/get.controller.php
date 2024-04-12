<?php   

require_once "models/get.model.php";

class GetController{

    ///normal request
    static public function getData($_table, $_select, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $response = GetModel::getData($_table, $_select, $_orderBy, $_orderMode, $_startAt, $_endAt);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }

    ///relations without filters
    static public function getRelData($_rel,$_type, $_select, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $response = GetModel::getRelData($_rel,$_type, $_select, $_orderBy, $_orderMode, $_startAt, $_endAt);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }

    ///relations filtered
    static public function getRelDataFiltered($_rel,$_type, $_select, $_linkTo, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $response = GetModel::getRelDataFiltered($_rel,$_type, $_select, $_linkTo, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }

    ///filteredRequest
    static public function getDataFiltered($_table, $_select, $_linkTo, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $response = GetModel::getDataFiltered($_table, $_select, $_linkTo, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }
    ///Search not relations
    static public function getDataSearch($_table, $_select, $_linkTo, $_search, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $response = GetModel::getDataSearch($_table, $_select, $_linkTo, $_search, $_orderBy, $_orderMode, $_startAt, $_endAt);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }

    ///Search relations
    static public function getRelDataSearch($_rel,$_type, $_select, $_search, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $response = GetModel::getRelDataSearch($_rel,$_type, $_select, $_search, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }
    ///range
    static public function getDataRange($_table, $_select, $_linkTo, $_between1, $_between2, $_orderBy, $_orderMode, $_startAt, $_endAt, $_filterTo, $_inTo){
        $response = GetModel::getDataRange($_table, $_select, $_linkTo, $_between1, $_between2, $_orderBy, $_orderMode, $_startAt, $_endAt, $_filterTo, $_inTo);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }
    ///range relations
    static public function getRelDataRange($_rel,$_type, $_select, $_linkTo, $_between1, $_between2, $_orderBy, $_orderMode, $_startAt, $_endAt, $_filterTo, $_inTo){
        $response = GetModel::getRelDataRange($_rel,$_type, $_select, $_linkTo, $_between1, $_between2, $_orderBy, $_orderMode, $_startAt, $_endAt, $_filterTo, $_inTo);
        $return = new GetController();
        $return->fncResponse($response);
        return $response;
    }
    public function fncResponse($_response){

        #echo $_response;
        #return;

        if (!empty($_response)) {
            $json = array(
                'status' => 200,
                'total' => count($_response),
                'results' => $_response
            );
        }
        else{
            $json = array(
                'status' => 404,
                'results' => 'Not found',
                'method' => 'GET'
            );
        }
        
        
        echo json_encode($json, http_response_code($json['status']));
    }
}