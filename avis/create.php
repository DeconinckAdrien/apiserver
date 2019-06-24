<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../objects/avis.php';

$database = new Database();
// connection à la base de données 
$db = $database->getConnection();
$msg="message";
// instanciation de l'objet avis 
$avis = new Avis($db);

// récupère les données du formulaire et vérification de leurs contenus
$data = json_decode(file_get_contents("php://input"));// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->description)
){

    // change les valeurs des propriétés de l'objet 
    $avis->name = $data->name;
    $avis->description = $data->description;
    $avis->created = date('Y-m-d H:i:s');
   
    // appelle de la fonction créé avis 
    if($avis->create()){

        // set response code - 201 created
        http_response_code(201);

        // Envoie du message de confirmation de la création de l'avis 
        echo json_encode(array($msg => "Événement partagé"));
    }

    // Si cela n'a pas fonctionné 
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // Envoie du message d'echec
        echo json_encode(array($msg => "Erreur lors du partage de l'événement"));
    }
}

// données incomplètes
else{

    // set response code - 400 bad request
    http_response_code(400);

    // envoie du message d'erreur
    echo json_encode(array($msg => "Erreur lors du partage de l'événement. Données incomplètes."));
}
?>
