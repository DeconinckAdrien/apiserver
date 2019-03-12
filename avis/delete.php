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

// get avis id
$data = json_decode(file_get_contents("php://input"));

// set avis id to be deleted
$avis->avis_id = $data->id;

// delete the avis
if($avis->delete()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Avis was deleted."));
}

// if unable to delete the avis
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete avis."));
}
?>
