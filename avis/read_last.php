<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/avis.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare avis object
$avis = new Avis($db);

// read the details of avis to be edited
$avis->readLast();

 if($avis->name!=null){
     // create array
     $avis_arr = array(
         "id" =>  $avis->avis_id,
         "name" => $avis->name,
         "description" => $avis->description,
         "created" => $avis->created,
         "modified" => $avis->modified,

     );

     // set response code - 200 OK
     http_response_code(200);

     // make it json format
     echo json_encode($avis_arr);
 }

 else{
     // set response code - 404 Not found
     http_response_code(404);

     // tell the user avis does not exist
     echo json_encode(array("message" => "Avis does not exist."));
 }
?>
