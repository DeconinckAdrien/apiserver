<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/avis.php';

// instantiate database and avis object
$database = new Database();
$db = $database->getConnection();

// initialize object
$avis = new Avis($db);

// query avis
$stmt = $avis->read();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $avis_arr["records"]=$result;

    // set response code - 200 OK
    http_response_code(200);

    // show aviss data in json format
    echo json_encode($avis_arr);
