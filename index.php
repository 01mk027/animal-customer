<?php
class Customer
{
  public $id,$first_name,$last_name,$email,$gender;
  public function __construct($id,$first_name,$last_name,$email,$gender)
  {
    $this->id = $id;
    $this->first_name = $first_name;
    $this->last_name = $last_name; 
    $this->email = $email;
    $this->gender = $gender; 
  }
}

class Animal
{
  public $id,$animal_name;
  public $info = array();
  public function __construct($Id,$Animal_name)
  {
    $this->id = $Id;
    $this->animal_name = $Animal_name;
  }
}


class AnimalFactory
{  
  public function create()
  {
     $db = new PDO('sqlite:tekbasproject.sqlite');
     $resultsList = array();
     $result = $db->query('SELECT * FROM animal');
     foreach($result as $r)
     {
      $resultsList[] = new Animal($r['id'],$r['animal_name']); 
     }
     return $resultsList;     
  }   
}

class CustomerFactory
{
  public function create()
  {
    $db = new PDO('sqlite:tekbasproject.sqlite');
    $resultsList = array();    
    $results = $db->query('SELECT * FROM customer');
    foreach($results as $r)
    {
      $resultsList[] = new Customer($r['id'],$r['first_name'],$r['last_name'],$r['email'],$r['gender']);
    }
    return $resultsList;
  }
    
}  


?>
<html>
<head>
<title>ANIMAL OWNER INFORMATION</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h1 class="text-center">WELCOME TO INFORMATION PAGE</h1></div>
  <div class="panel-body">
    <p class="text-center"> This web page contains 2 tables. First table shows customer with their owned animals. Second table which is positioned below first table shows non-owned animals. When web page is refreshed, owner of animals is changed also, animals are owned RANDOMLY.</p>
  </div>
<?php
//error_reporting(0);
$a = CustomerFactory::create();
//echo count($a);
$animalArray=array();
$animal = AnimalFactory::create();
$isMan;
foreach($animal as $anm)
{
  $animalArray[] = $anm->animal_name;
}
$ownedAnimals=array();
$kelime = array();
//echo "<table border=1>";
?><table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Gender</th>
      <th scope="col">Owned Animal</th>
    </tr>
<?php foreach($a as $x)
{
  if($x->gender == 'Male')
  {
    $ranmale = rand(0,77);
    $kelime[0] = $animalArray[$ranmale];
    $ownedAnimals[] = $kelime[0];
    $kelime[1] = ""; 
    $kelime[2] = "";
    $isMan = true;
      
  } 
  else
  {
    $ranfemale  = rand(0,77);
    $ranfemale2 = rand(0,77);
    $ranfemale3 = rand(0,77);
    $kelime[0] = $animalArray[$ranfemale]; 
    $ownedAnimals[] = $kelime[0];
    $kelime[1] = $animalArray[$ranfemale2];
    $ownedAnimals[] = $kelime[1]; 
    $kelime[2] = $animalArray[$ranfemale3]; 
    $ownedAnimals[] = $kelime[2];
    $isMan = false;
     
  }
  if($isMan == true)
  {
    echo "<tr><td>".$x->id."</td><td>".$x->first_name."</td><td>".$x->last_name."</td><td>".$x->email."</td><td>".$x->gender."</td><td>"
    .$kelime[0]."</td></tr>";
  }
  else
  {
    echo "<tr><td>".$x->id."</td><td>".$x->first_name."</td><td>".$x->last_name."</td><td>".$x->email."</td><td>".$x->gender."</td><td>"
    .$kelime[0]."/".$kelime[1]."/".$kelime[2]."</td></tr>";

  }
}
echo "</table>";
$diff = array();
$diff = array_diff($animalArray, $ownedAnimals);
//echo "<table border=1>";
?>
<br>
<table class="table">
<thead>
<tr>
<th scope="col">Not Owned Animals</th>
</tr>
<?php
//echo "<tr><td><b>Non-owned Animals</b></td></tr>";
foreach($diff as $df)
{
  echo "<tr><td>". $df ."</td></tr>";
}
?>
</body>
</html>