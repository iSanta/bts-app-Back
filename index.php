<?php 

    ///Error file
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'C:\wamp64\www\BTSAPI');

    ///cors
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("content-type: application/json; charset-uft-8");
    

    ///Requires
    require_once "controllers/routes.controller.php";

    $index = new RoutesController();
    $index -> index();