<?php
class Avis{

    // connexion à la base + nom de la table
    private $conn;


    // Propriétés des objets
    public $name;
    public $description;
    public $created;
    public $avis_id;
    public $modified;
    public $desc='description';

    //construction de la bd
    public function __construct($db){
        $this->conn = $db;
    }

    // lire les produits
    function read(){

         $stmt = $this->conn->prepare("SELECT * FROM avis");
         $stmt->execute();

        return $stmt;
    }
    // créer les produits

    function create(){
          $this->name=htmlspecialchars(strip_tags($this->name));
          $this->description=htmlspecialchars(strip_tags($this->description));
          $this->created=htmlspecialchars(strip_tags($this->created));

      $data = [
          'name' => $this->name,
          $this->desc => $this->description,
          'created' => $this->created,
      ];
      $sql = "INSERT INTO avis (name, description, created) VALUES (:name, :description, :created)";
      $stmt=  $this->conn->prepare($sql);
      $executed = $stmt->execute($data);

      if($executed){
          return true;
      }

      return false;

    }
    // lire un produit
function readOne(){

  // enelver les caractères pouvant poser problème
  $this->name=htmlspecialchars(strip_tags($this->name));
  $this->description=htmlspecialchars(strip_tags($this->description));
  $this->avis_id=htmlspecialchars(strip_tags($this->avis_id));
  $this->created=htmlspecialchars(strip_tags($this->created));


  $stmt = $this->conn->prepare("SELECT * FROM avis where avis_id=:id");
  $stmt->execute(array('id' => $this->avis_id));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // donner les valeurs aux attributs
    $this->name = $row['name'];
    $this->description = $row['description'];
    $this->avis_id = $row['avis_id'];
    $this->created=$row['created'];
    $this->modified=$row['modified'];

}

function readLast(){


  $stmt = $this->conn->prepare("SELECT * FROM avis where avis_id in (SELECT MAX(avis_id) from avis)");
  $stmt->execute();


    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    $this->name = $row['name'];
    $this->description = $row[$this->desc];
    $this->avis_id = $row['avis_id'];
    $this->created=$row['created'];
    $this->modified=$row['modified'];

}

// update the product
function update(){


    // mettre à jour
    $stmt = $this->conn->prepare("UPDATE avis SET name = :name, description = :description WHERE avis_id = :id");
    $exec=$stmt->execute(array(
      'id' => $this->avis_id,
      $this->desc => $this->description,
      'name'=> $this->name
    ));
    if($exec){
        return true;
    }

    return false;
}

// suppression du produit
function delete(){

    // delete query
    $stmt = $this->conn->prepare("DELETE FROM avis WHERE avis_id = :id");

    $stmt->execute(array(
      'id' => $this->avis_id,
    ));

    $count = $stmt->rowCount();


    if($count==1){
        return true;
    }

    return false;

}

// search products
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
