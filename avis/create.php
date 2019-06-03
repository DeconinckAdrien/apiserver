<?php
// en-têtes nécessaires
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// récupérer la connexion à la base de données
include_once '../config/database.php';

include_once '../objects/avis.php';

$database = new Database();
$db = $database->getConnection();
$msg="message";
$avis = new Avis($db);

// récupérer les données postées
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->name) &&
    !empty($data->description)
){

    // donner les valeurs aux propriétés de l'avis
    $avis->name = $data->name;
    $avis->description = $data->description;
    $avis->created = date('Y-m-d H:i:s');

    // créer l'avis
    if($avis->create()){

        // code 201 si avis créé
        http_response_code(201);

        // Si besoin de récuperer un message pour confirmation
        echo json_encode(array($msg => "Votre avis a bien été partagé."));
    }

    // Si erreur
    else{

        // code 503 si erreur
        http_response_code(503);

        // Si besoin de récuperer un message pour voir l'erreur
        echo json_encode(array($msg => "Impossible de créer l'avis."));
    }
}

// Si les données sont incomplètes
else{

    // code 400 pour mauvaise requête
    http_response_code(400);

    // Si besoin de récuperer un message pour voir l'erreur
    echo json_encode(array($msg => "Impossible de créer l'avis. Les données sont incomplètes."));
}
?>
