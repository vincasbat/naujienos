 <!DOCTYPE html>
<html>
<head>
<title>Naujienų sąrašas</title>
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

<h1>Naujienų sąrašas</h1>



<?php
include 'db.php';


$conn = new mysqli($servername, $username, $password, $dbname);






if ($conn->connect_error) {
  die("Nepavyko: " . $conn->connect_error);
} 


if (!empty($_POST))  {

$nid = $_POST["nid"];

$sql = "DELETE FROM naujienos WHERE id=$nid";   
$sqkat = "DELETE FROM naujienu_kategorijos WHERE naujID=$nid";
$sqkom = "DELETE FROM komentarai WHERE nid=$nid";


if ($conn->query($sqkom) === TRUE) {
 
} else {
  echo "Ištrinti komentarų nepavyko: " . $conn->error;
}

if ($conn->query($sqkat) === TRUE) {
  
} else {
  echo "Ištrinti kategorijų nepavyko: " . $conn->error;
}


if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>  Naujiena ištrinta</div>";
} else {
  echo "Ištrinti naujienos nepavyko: " . $conn->error;
}



}

$sql = "SELECT * FROM naujienos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

echo "<table class='table'>";
  
  while($row = $result->fetch_assoc()) {
 $nid =  $row["id"];
   echo " <tr><td> " . $row["pavadinimas"]."&nbsp; </td> <td> <a href='keisti_naujiena.php?nid=$nid'> Redaguoti </a> &nbsp;</td> <td>";
   
 echo  "<form action='". htmlspecialchars($_SERVER['PHP_SELF']) . "' method='post'><input type='hidden' name='nid' 
value='$nid'><input type='submit' name='delete' value=' TRINTI '>
</form>";
 
 
 echo " </td></tr>";
  
  }
    echo "</table><br>";
 
  
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






