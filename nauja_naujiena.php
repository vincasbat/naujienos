<!DOCTYPE html>
<html>
<head>
<title>Kurti naujieną</title>
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

<h1>Nauja naujiena</h1>
<?php
include 'db.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Nepavyko: " . $conn->connect_error);
} 


if (!empty($_POST))  {


$kategorijos = $_POST["kategorijos"];
$turinys = $_POST["turinys"];
$pavadinimas = $_POST["pavadinimas"];


$turinys = filter_var($turinys, FILTER_SANITIZE_STRING);
$pavadinimas = filter_var($pavadinimas, FILTER_SANITIZE_STRING);

$sql = "INSERT INTO naujienos (pavadinimas, turinys, data)  VALUES ('$pavadinimas', '$turinys', NOW())";

if ($conn->query($sql) === TRUE) {
$last_id = $conn->insert_id;       

foreach ($kategorijos as $value) {
  $sq = "INSERT INTO naujienu_kategorijos (naujID, katID)  VALUES ($last_id, $value)";
  if ($conn->query($sq) !== TRUE) echo "Kategorija $value neįrašyta";
  
}

 
  echo "<div class='alert alert-success'>  Naujiena sukurta</div>";
} else {
  echo "Klaida: " . $sql . "<br>" . $conn->error;
}



}//if post




?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="myForm" onsubmit="return validateForm()" >

<div class="mb-3 mt-3">
    <label for="pavadinimas" class="form-label">Pavadinimas</label>
    <input type="text" name="pavadinimas" id="pavadinimas" placeholder="Įrašykite pavadinimą" class="form-control">
  </div>

<div class="mb-3 mt-3">
 <label for="turinys">Turinys</label>
<textarea name="turinys" id="turinys" rows="5" class="form-control"   placeholder="Naujienos turinys"  ></textarea>
</div>
Kategorijos: <br>
<?php


$sql = "SELECT * FROM kategorijos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

echo "<table class='table'>";
  
  while($row = $result->fetch_assoc()) {
 $kid =  $row["id"];
  
  echo " <tr><td><input type='checkbox' name='kategorijos[]'  value='$kid'     > " . " </td><td> ".$row["kategorija"]."</td></tr>";
 
  }
  
  echo "</table><br>";

}
$conn->close();
?>

<input type="submit"   value="Sukurti" >
</form>

<div class="mt-4 p-2 bg-secondary text-white rounded">
   <p>&copy; Vincas Batulevičius, 2022</p>
</div>

</div>
</body>
</html> 

