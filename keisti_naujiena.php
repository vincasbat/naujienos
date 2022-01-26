<!DOCTYPE html>
<html>
<head>
<title>Redaguoti naujieną</title>
<link rel="shortcut icon" href="favicon.ico">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validateForm() {  
   
  let pavadinimas = document.forms["myForm"]["pavadinimas"].value;
  if (pavadinimas.length < 5) {
    alert("Reikia įrašyti pavadinimą");
    document.forms["myForm"]["pavadinimas"].focus();
    return false;
  }
  if (pavadinimas.length > 30) {
    alert("Per ilgas pavadinimas");
    document.forms["myForm"]["pavadinimas"].focus();
    return false;
  }
  
  
  let turinys = document.forms["myForm"]["turinys"].value;
  if (turinys.length < 1) {
    alert("Reikia įrašyti turinį");
    document.forms["myForm"]["turinys"].focus();
    return false;
  }
 
 if(turinys.length > 2000) {
    alert("Per ilgas naujienos turinys");
    document.forms["myForm"]["turinys"].focus();
    return false;
  }
 
  let isChecked = false;
  let checkboxes = document.getElementsByTagName("input");
for (let i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].type == "checkbox") {
         if( checkboxes[i].checked)  isChecked = true;
    }
}

if (!isChecked) {  alert("Pasirinkite bent vieną kategoriją");    return false;}
  
   
  return true;
} 

</script>
</head>
<body>
<div class="container pt-5">
<p><a href='index.php' class='btn btn-outline-primary'>Visos naujienos</a>
<a href='naujienu_sarasas.php' class='btn btn-outline-primary'>Naujienų sąrašas</a>
<a href='nauja_naujiena.php' class='btn btn-outline-primary'>Kurti naujieną</a><p>

 <h1>Naujienos redagavimas</h1>
<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

include 'db.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Nepavyko: " . $conn->connect_error);
} 



if (!empty($_POST))  {

$nid = $_POST["nid"];
$kategorijos = $_POST["kategorijos"];
$turinys = $_POST["turinys"];
$pavadinimas = $_POST["pavadinimas"];


$turinys = filter_var($turinys, FILTER_SANITIZE_STRING);
$pavadinimas = filter_var($pavadinimas, FILTER_SANITIZE_STRING);
if (filter_var($nid, FILTER_VALIDATE_INT) === false) {  echo("Klaida!"); exit();}

$sql = "UPDATE naujienos SET pavadinimas='$pavadinimas', turinys='$turinys', data=NOW() WHERE id=$nid";

if ($conn->query($sql) === TRUE) {


$sqkat = "DELETE FROM naujienu_kategorijos WHERE naujID=$nid";

if ($conn->query($sqkat) === TRUE) {
  
} else {
  echo "Ištrinti kategorijų nepavyko: " . $conn->error;
}


foreach ($kategorijos as $value) {
 
  $sq = "INSERT INTO naujienu_kategorijos (naujID, katID)  VALUES ($nid, $value)";
  if ($conn->query($sq) !== TRUE) echo "Kategorija $value neįrašyta";
  
}

echo "<div class='alert alert-success'>  Naujiena įrašyta</div>";
  
} else {
  echo "Klaida: " . $sql . "<br>" . $conn->error;
}



}//if post
else { 
$nid = $_GET["nid"]; 
} 

// skaitome naujienos duomenis:

  

$sql = "SELECT * FROM naujienos WHERE id = $nid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  while($row = $result->fetch_assoc()) {
 
   $pavadinimas = $row["pavadinimas"];
   $turinys = $row["turinys"];
  
   echo "<p>" .$row["data"] . "</p> ";
 
   $kat_sql = "SELECT kategorijos.kategorija, naujienu_kategorijos.katID FROM kategorijos, naujienu_kategorijos WHERE  naujienu_kategorijos.katID =  kategorijos.id AND naujID =  $nid";
    
  $res = $conn->query($kat_sql);
  
   $katIds = array();  
    if ($res->num_rows > 0) {
  
  while($rw = $res->fetch_assoc()) {
  array_push($katIds,$rw["katID"] );
  }
  

 }  //if
 

  
  }//while1
 
  
} else {
  echo "Naujienų nėra";
}

// skaitome naujienos duomenis end


?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="myForm" onsubmit="return validateForm()" >


<div class="mb-3 mt-3">
    <label for="pavadinimas" class="form-label">Pavadinimas</label>
    <input type="text" name="pavadinimas" id="pavadinimas"  class="form-control"  value="<?php echo $pavadinimas ?>">
  </div>

<input type="hidden" name="nid" value="<?php echo $nid ?>">


<div class="mb-3 mt-3">
 <label for="turinys">Turinys</label>
<textarea name="turinys" id="turinys" rows="5" class="form-control"     > <?php echo $turinys ?>  </textarea>
</div>

Kategorijos <br>
<?php


$sql = "SELECT * FROM kategorijos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

echo "<table class='table'>";
  
  while($row = $result->fetch_assoc()) {
 $kid =  $row["id"];
 
 $ckhecked = "";   if (in_array($kid, $katIds)) $ckhecked = "checked";
  
  echo " <tr><td><input type='checkbox' name='kategorijos[]'  value='$kid'   $ckhecked  >" . "</td><td>".$row["kategorija"]."</td></tr>";
 
  }
  
  echo "</table><br>";

}
$conn->close();
?>

<input type="submit"   value="Išsaugoti" >
</form>
<div class="mt-4 p-2 bg-secondary text-white rounded">
   <p>&copy; Vincas Batulevičius, 2022</p>
</div>
</div>
</body>
</html> 

