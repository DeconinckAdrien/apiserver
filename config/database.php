<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;


class Database{
  public function getConnection(){
$pdo = (new SQLiteConnection())->connect();
  if ($pdo != null){
    // $stmt = $pdo->prepare("SELECT * FROM avis where avis_id = :avisid");
    // $stmt->execute(array('avisid' => 2));
    // $result = $stmt->fetchAll();
    // print_r($result);
  }
  else{
    echo 'Erreur de connexion à la base de données !';
  }
  return $pdo;
}
}
