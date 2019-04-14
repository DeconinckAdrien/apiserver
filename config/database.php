<?php

require 'vendor/autoload.php';

use App\SQLiteConnection;


class Database{
  public function getConnection(){
$pdo = (new SQLiteConnection())->connect();
  if ($pdo != null){
    echo 'Connexion réussie !';
  }
  else{
    echo 'Erreur de connexion à la base de données !';
  }
  return $pdo;
}
}
