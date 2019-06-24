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

// connection à la base
$database = new Database();
$db = $database->getConnection();

// instanciation de l'objet avis
$avis = new Avis($db);

// on récupère l'ID de l'avis à supprimer 
$data = json_decode(file_get_contents("php://input"));

// modification de la propriété d'objet ID 
$avis->avis_id = $data->id;

// Suppression de l'avis 
if($avis->delete()){

    // set response code - 200 ok
    http_response_code(200);

    // Envoie du message de confirmation
    echo json_encode(array("message" => "Événement supprimé"));
}

// Si le message n'a pas pu être supprimer 
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // Envoie du message d'erreur
    echo json_encode(array("message" => "Impossible de supprimer l'évènement"));
}
?>
