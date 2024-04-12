<?php 

require_once "controllers/get.controller.php";


$select = $_GET['select'] ?? '*';
$orderBy = $_GET['orderBy'] ?? null;
$orderMode = $_GET['orderMode'] ?? null;
$startAt = $_GET['startAt'] ?? null;
$endAt = $_GET['endAt'] ?? null;
$filterTo = $_GET['filterTo'] ?? null;
$inTo = $_GET['inTo'] ?? null;



$response = new GetController();


///filtered request
if (isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['rel']) && !isset($_GET['type'])) {
    $response->getDataFiltered($table, $select, $_GET['linkTo'], $_GET['equalTo'], $orderBy, $orderMode, $startAt, $endAt);
}
//not filtered relations
else if(isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])) {
    $response->getRelData($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt);
}
//filtered relations
else if(isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['equalTo'])) {
    $response->getRelDataFiltered($_GET['rel'], $_GET['type'], $select, $_GET['linkTo'], $_GET['equalTo'], $orderBy, $orderMode, $startAt, $endAt);
}
//search without relations
else if(!isset($_GET['rel']) && !isset($_GET['type']) &isset($_GET['linkTo']) && isset($_GET['search'])){
    $response->getDataSearch($table, $select, $_GET['linkTo'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt);
}
//search with relations
else if(isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['search'])){
    $response->getRelDataSearch($_GET['rel'], $_GET['type'], $select, $_GET['linkTo'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt);
}
// range
else if(isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2']) && !isset($_GET['rel']) && !isset($_GET['type'])){
    $response->getDataRange($table, $select, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
}
// range with relations
else if(isset($_GET['rel']) && isset($_GET['type']) && $table == "relations" && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])){
    $response->getRelDataRange($_GET['rel'], $_GET['type'], $select, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
}
///normal request
else{
    $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
}

