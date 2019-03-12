<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate avis object
include_once '../objects/avis.php';

$database = new Database();
$db = $database->getConnection();

$avis = new Avis($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));// make sure data is not empty
// echo json_encode(array("message" => $data));
if(
    !empty($data->name) &&
    !empty($data->description)
){

    // set avis property values
    $avis->name = $data->name;
    $avis->description = $data->description;
    $avis->created = date('Y-m-d H:i:s');

    // create the avis
    if($avis->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Avis was created."));
    }

    // if unable to create the avis, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create avis."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create avis. Data is incomplete."));
}
?>
