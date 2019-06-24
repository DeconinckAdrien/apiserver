<?php
//  headers necessaire
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/avis.php';

// instanciation de l'objet Database
$database = new Database();
// connection à la base de données
$db = $database->getConnection();

// instanciation de l'objet avis
$avis = new Avis($db);

// lecture de l'avis 
$stmt = $avis->read();
// récupère la ligne 
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $avis_arr["records"]=$result;

    // set response code - 200 OK
    http_response_code(200);

    // envoie l'avis au format Json
    echo json_encode($avis_arr);
