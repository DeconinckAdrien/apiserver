<?php
class Avis{

    // database connection and table name
    private $conn;
    private $table_name = "avis";

    // object properties
    public $name;
    public $description;
    public $created;
    public $avis_id;
    public $modified;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

         $stmt = $this->conn->prepare("SELECT * FROM avis");
         $stmt->execute();
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stmt;
    }
    // create product
    function create(){
      // sanitize
          $this->name=htmlspecialchars(strip_tags($this->name));
          $this->description=htmlspecialchars(strip_tags($this->description));
          $this->created=htmlspecialchars(strip_tags($this->created));

      $data = [
          'name' => $this->name,
          'description' => $this->description,
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
    // used when filling up the update product form
function readOne(){

  // sanitize
  $this->name=htmlspecialchars(strip_tags($this->name));
  $this->description=htmlspecialchars(strip_tags($this->description));
  $this->avis_id=htmlspecialchars(strip_tags($this->avis_id));
  $this->created=htmlspecialchars(strip_tags($this->created));


  $stmt = $this->conn->prepare("SELECT * FROM avis where avis_id=:id");
  $stmt->execute(array('id' => $this->avis_id));

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // set values to object properties
    $this->name = $row['name'];
    $this->description = $row['description'];
    $this->avis_id = $row['avis_id'];
    $this->created=$row['created'];
    $this->modified=$row['modified'];

}

function readLast(){

  // sanitize
  // $this->name=htmlspecialchars(strip_tags($this->name));
  // $this->description=htmlspecialchars(strip_tags($this->description));
  // $this->avis_id=htmlspecialchars(strip_tags($this->avis_id));
  // $this->created=htmlspecialchars(strip_tags($this->created));


  $stmt = $this->conn->prepare("SELECT * FROM avis where avis_id in (SELECT MAX(avis_id) from avis)");
  $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     // echo json_encode(array("message" => "Avis does not exist."));



    // set values to object properties
    $this->name = "s";
    $this->description = $row['description'];
    $this->avis_id = $row['avis_id'];
    $this->created=$row['created'];
    $this->modified=$row['modified'];

}

// update the product
function update(){


    // // sanitize
    // $this->name=htmlspecialchars(strip_tags($this->name));
    // $this->description=htmlspecialchars(strip_tags($this->description));
    // $this->id=htmlspecialchars(strip_tags($this->id));
    // echo json_encode(array("message" => $this->description));
    // echo json_encode(array("message" => $this->name));
    // echo json_encode(array("message" => $this->avis_id));

    // update query
    $stmt = $this->conn->prepare("UPDATE avis SET name = :name, description = :description WHERE avis_id = :id");
    $exec=$stmt->execute(array(
      'id' => $this->avis_id,
      'description' => $this->description,
      'name'=> $this->name
    ));

    // prepare query statement
    // $stmt = $this->conn->prepare($query);

    // execute the query
    if($exec){
        return true;
    }

    return false;
}

// delete the product
function delete(){
    // sanitize
    // $this->id=htmlspecialchars(strip_tags($this->id));

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

    // prepare query statement
    // $stmt = $this->conn->prepare($query);
    //
    // // sanitize
    // $keywords=htmlspecialchars(strip_tags($keywords));
     $keywords = "%{$keywords}%";
    //
    // // bind
    // $stmt->bindParam(1, $keywords);
    // $stmt->bindParam(2, $keywords);
    // $stmt->bindParam(3, $keywords);

    // execute query
    // $stmt->execute();

    return $stmt;
}

}
