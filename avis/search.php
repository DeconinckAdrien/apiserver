<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
// include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/avis.php';

// instantiate database and avis object
$database = new Database();
$db = $database->getConnection();

// initialize object
$avis = new Avis($db);

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query aviss
$stmt = $avis->search($keywords);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// foreach ($variable as $key => $value) {
   //array_push($aviss_arr["records"], $result);
   $avis_arr["records"]=$result;
   http_response_code(200);

   // show aviss data in json format
   echo json_encode($avis_arr);
?>
