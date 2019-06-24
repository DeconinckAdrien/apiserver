<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


include_once '../config/database.php';
include_once '../objects/avis.php';

// Instancie l'objet Database
$database = new Database();
$db = $database->getConnection();

// Instancie l'objet avis
$avis = new Avis($db);

// Lit le dernier avis publier 
$avis->readLast();

// vérification de la valeur du champ nom 
 if($avis->name!=null){
     // création d'un tableau associatif 
     $avis_arr = array(
         "id" =>  $avis->avis_id,
         "name" => $avis->name,
         "description" => $avis->description,
         "created" => $avis->created,
         "modified" => $avis->modified,

     );

     // set response code - 200 OK
     http_response_code(200);

     // Envoie le tableau sous un format Json
     echo json_encode($avis_arr);
 }

 else{ // erreur 
     // set response code - 404 Not found
     http_response_code(404);

     // Notifie l'utilisateur que l'avis n'existe pas 
     echo json_encode(array("message" => "Avis does not exist."));
 }
?>
