<?php

require_once "models/connection.php";
require_once "controllers/post.controller.php";

if (isset($_POST)) {
    $columns = array();
    foreach (array_keys($_POST) as $key => $value) {
        array_push($columns, $value);
    }


    ///validate if table and forms make match
    if (empty(Connection::getColumnsData($table, $columns))) {
        $json = array(
            'status' => 400,
            'result' => 'Error: incorrect form fields, this fields does not match with the table columns'
        );

        echo json_encode($json, http_response_code($json['status']));
        return;
    }
    $response = new PostController();
    $response->postData($table, $_POST);

}