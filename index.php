<!DOCTYPE html>
<html>
<head>
<title>Visos naujienos</title>
<link rel="shortcut icon" href="favicon.ico">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container pt-5">

<p><a href='index.php' class='btn btn-outline-primary'>Visos naujienos</a>
<a href='naujienu_sarasas.php' class='btn btn-outline-primary'>Naujienų sąrašas</a>
<a href='nauja_naujiena.php' class='btn btn-outline-primary'>Kurti naujieną</a><p>

<h1>Visos naujienos</h1>


<?php
include 'db.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Nepavyko: " . $conn->connect_error);
} 

$sql = "SELECT * FROM naujienos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  while($row = $result->fetch_assoc()) {
 
   echo " <h2>" . $row["pavadinimas"]."</h2>";
   echo "<p>" .$row["data"] . "</p> ";
   echo "<p>Kategorijos: " ;
    
    $nid =  $row["id"];
    $kat_sql = "SELECT kategorija FROM kategorijos, naujienu_kategorijos WHERE  naujienu_kategorijos.katID =  kategorijos.id AND naujID =  $nid";
    
  $res = $conn->query($kat_sql);
    
    if ($res->num_rows > 0) {
  $kats = "";
  while($rw = $res->fetch_assoc()) {
  $kats = $kats . $rw["kategorija"] . ", ";

  }
  $kats = rtrim($kats, ", ");
  echo   $kats  . "</p>" ;
  
  echo  "<p><a href='naujiena.php?nid=$nid'>Skaityti...</a>".  "<p><br>";

 }  
 
  
  }
 
  
} else {
  echo "Naujienų nėra";
}
$conn->close();
?> 

<div class="mt-4 p-2 bg-secondary text-white rounded">
   <p>&copy; Vincas Batulevičius, 2022</p>
</div>
</div>
</body>
</html> 

