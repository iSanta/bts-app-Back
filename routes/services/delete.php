<?php
require_once "models/connection.php";
require_once "controllers/delete.controller.php";

if(isset($_GET['id']) && isset($_GET['nameId'])){
    $columns = array($_GET['nameId']);

    ///validate if table and forms make match
    if (empty(Connection::getColumnsData($table, $columns))) {
        $json = array(
            'status' => 400,
            'result' => 'Error: incorrect form fields, this fields does not match with the table columns'
        );

        echo json_encode($json, http_response_code($json['status']));
        return;
    }
    $response = new DeleteController();
    $response->deleteData($table, $_GET['id'], $_GET['nameId']);
    
}