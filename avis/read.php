<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/avis.php';

// instantiate database and avis object
$database = new Database();
$db = $database->getConnection();

// initialize object
$avis = new Avis($db);

// query avis
$stmt = $avis->read();
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($stmt);
//$num = $stmt->rowCount();

// check if more than 0 record found
// if($num>0){

    // aviss array
    //$avis_arr=array();
    //$avis_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //     // extract row
    //     // this will make $row['name'] to
    //     // just $name only
    //     extract($row);
    //
    //     $avis_item=array(
    //         "id" => $id,
    //         "name" => $name,
    //         // "description" => html_entity_decode($description),
    //         // "price" => $price,
    //         // "category_id" => $category_id,
    //         // "category_name" => $category_name
    //     );
    //   }
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     // foreach ($variable as $key => $value) {
        //array_push($aviss_arr["records"], $result);
        $avis_arr["records"]=$result;
     // }


    //}

    // set response code - 200 OK
    http_response_code(200);

    // show aviss data in json format
    echo json_encode($avis_arr);
//}

//else{

    // set response code - 404 Not found
    // http_response_code(404);
    //
    // // tell the user no aviss found
    // echo json_encode(
    //     array("message" => "Pas d'avis trouvé.")
    // );
//}
