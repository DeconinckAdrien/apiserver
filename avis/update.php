<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/avis.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare avis object
$avis = new Avis($db);
// get id of avis to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of avis to be edited
$avis->avis_id = $data->id;

// set avis property values
$avis->name = $data->name;
$avis->description = $data->description;


// update the avis
if($avis->update()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "L'événement a été mis à jour"));
}

// if unable to update the avis, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Impossible de mettre à jour l'avis"));
}
?>
