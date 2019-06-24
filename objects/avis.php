<?php
class Avis{

    // variable base de données
    private $conn;


    // propriétés d'objet
    public $name;
    public $description;
    public $created;
    public $avis_id; // identificateur 
    public $modified;
    public $desc='description';

    // constructeur de l'objet avis 
    public function __construct($db){
        $this->conn = $db;
    }

    // Fonction de lecture d'un avis 
    function read(){
        // envoie d'une requêtte SQL et récupération de sa réponse
         $stmt = $this->conn->prepare("SELECT * FROM avis");
         $stmt->execute();

        return $stmt;
    }
    // Création d'un avis 

    function create(){
          $this->name=htmlspecialchars(strip_tags($this->name));
          $this->description=htmlspecialchars(strip_tags($this->description));
          $this->created=htmlspecialchars(strip_tags($this->created));
        
      $data = [
          'name' => $this->name,
          $this->desc => $this->description,
          'created' => $this->created,
      ];
        // requêtte SQl 
      $sql = "INSERT INTO avis (name, description, created) VALUES (:name, :description, :created)";
      $stmt=  $this->conn->prepare($sql);
      $executed = $stmt->execute($data);

      if($executed){
          return true;
      }

      return false;

    }
    // used when filling up the update product form
function readOne(){

 // récupération des propriétés de l'objet pour un update
  $this->name=htmlspecialchars(strip_tags($this->name));
  $this->description=htmlspecialchars(strip_tags($this->description));
  $this->avis_id=htmlspecialchars(strip_tags($this->avis_id));
  $this->created=htmlspecialchars(strip_tags($this->created));

    
  $stmt = $this->conn->prepare("SELECT * FROM avis where avis_id=:id");
  // envoie requêtte SQL
  $stmt->execute(array('id' => $this->avis_id));

    // Obtient la ligne récupérée
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



   // Modifie les valeurs des propriétés de l'objet
    $this->name = $row['name'];
    $this->description = $row['description'];
    $this->avis_id = $row['avis_id'];
    $this->created=$row['created'];
    $this->modified=$row['modified'];

}

    // lecture du dernier avis publier
function readLast(){

  
  $stmt = $this->conn->prepare("SELECT * FROM avis where avis_id in (SELECT MAX(avis_id) from avis)");
  // envoie requêtte SQL select
  $stmt->execute();

    // Obtient la ligne récupérée
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // Modifie les valeurs des propriétés de l'objet
    //$desc='description';
    $this->name = $row['name'];
    $this->description = $row[$this->desc];
    $this->avis_id = $row['avis_id'];
    $this->created=$row['created'];
    $this->modified=$row['modified'];

}

// Met à jour un avis
function update(){


    
    $stmt = $this->conn->prepare("UPDATE avis SET name = :name, description = :description WHERE avis_id = :id");
    // Envoie requêtte SQL 
    $exec=$stmt->execute(array(
      'id' => $this->avis_id,
      $this->desc => $this->description,
      'name'=> $this->name
    ));

    $count = $stmt->rowCount();

    //
    if($count==1){
        return true;
    }

    return false;
    // execute the query
    // if($exec){
    //     return true;
    // }
    //
    // return false;
}

// supprime un avis 
function delete(){

    
    $stmt = $this->conn->prepare("DELETE FROM avis WHERE avis_id = :id");
    // supprime dans la base de donnée 
    $stmt->execute(array(
      'id' => $this->avis_id,
    ));

    $count = $stmt->rowCount();


    if($count==1){
        return true;
    }

    return false;

}

// Fonction de recherche d'un avis 
function search($keywords){
$keywords = "%{$keywords}%";
    // select all query
    $stmt = $this->conn->prepare("SELECT * from avis WHERE description LIKE :s OR name LIKE :s");

    $stmt->execute(array(
      's' =>$keywords,
    ));
     $keywords = "%{$keywords}%";
    return $stmt;
}

}
