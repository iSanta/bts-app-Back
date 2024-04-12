<?php
require_once "models/connection.php";
require_once "controllers/put.controller.php";

if(isset($_GET['id']) && isset($_GET['nameId'])){

    $data = array();
    parse_str(file_get_contents('php://input'), $data);
    
    $columns = array();
    foreach (array_keys($data) as $key => $value) {
        array_push($columns, $value);
    }
    array_push($columns, $_GET['nameId']);
    $columns = array_unique($columns);


    ///validate if table and forms make match
    if (empty(Connection::getColumnsData($table, $columns))) {
        $json = array(
            'status' => 400,
            'result' => 'Error: incorrect form fields, this fields does not match with the table columns'
        );

        echo json_encode($json, http_response_code($json['status']));
        return;
    }
    $response = new PutController();
    $response->putData($table, $data, $_GET['id'], $_GET['nameId']);
    
}