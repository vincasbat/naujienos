<!DOCTYPE html>
<html>
<head>
<title>Naujiena</title>
<link rel="shortcut icon" href="favicon.ico">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function validateForm() {  
  let elpastas = document.forms["myForm"]["elpastas"].value;  
  if (elpastas == "") {
    alert("Reikia įrašyti el. pašto adresą");
    document.forms["myForm"]["elpastas"].focus();
    return false;
  }
   
  if (!ValidateEmail(elpastas)) {
    alert("Neteisingas el. pašto adresas");
    document.forms["myForm"]["elpastas"].focus();
    return false;
  }
  
  let komentaras = document.forms["myForm"]["comment"].value;
  if (komentaras.length < 1) {
    alert("Reikia įrašyti komentarą");
    document.forms["myForm"]["comment"].focus();
    return false;
  }
  if (komentaras.length > 200) {
    alert("Per ilgas komentaras");
    document.forms["myForm"]["comment"].focus();
    return false;
  }
  
  return true;
} 

function ValidateEmail(inputText)
{
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(inputText.match(mailformat))
	{
	return true;
	}
	else
	{
	return false;
	}
}


</script>

</head>
<body>

<div class="container pt-5">
<p><a href='index.php' class='btn btn-outline-primary'>Visos naujienos</a>
<a href='naujienu_sarasas.php' class='btn btn-outline-primary'>Naujienų sąrašas</a>
<a href='nauja_naujiena.php' class='btn btn-outline-primary'>Kurti naujieną</a><p>
<?php


include 'db.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Nepavyko: " . $conn->connect_error);
} 




if (!empty($_POST))  {

$nid = $_POST["nid"];
$elpastas = $_POST["elpastas"];
$komentaras  = $_POST["comment"];


$elpastas = filter_var($elpastas, FILTER_SANITIZE_EMAIL);
$komentaras = filter_var($komentaras, FILTER_SANITIZE_STRING);
if (filter_var($nid, FILTER_VALIDATE_INT) === false) {  echo("Klaida!"); exit();}

$sql = "INSERT INTO komentarai (nid, elpastas, komentaras) VALUES ($nid, '$elpastas', '$komentaras')";

if ($conn->query($sql) === TRUE) {
  echo "<div class='alert alert-success'>  Komentaras įrašytas</div>";
} else {
  echo "Nepavyko: " . $sql . "<br>" . $conn->error;
}



}
else
{//GET:

$nid = $_GET["nid"];

}




if ($conn->connect_error) {
  die("Nepavyko: " . $conn->connect_error);
} 

$sql = "SELECT * FROM naujienos WHERE id=$nid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  while($row = $result->fetch_assoc()) {
 
   echo " <h2>" . $row["pavadinimas"]."</h2>";
   echo "<p>" .$row["data"] . "</p> ";
 echo "<p>" .$row["turinys"] . "</p> ";
 
 $kat_sql = "SELECT kategorija FROM kategorijos, naujienu_kategorijos WHERE  naujienu_kategorijos.katID =  kategorijos.id AND naujID =  $nid";
    
  $res = $conn->query($kat_sql);
    
    if ($res->num_rows > 0) {
  $kats = "<p>Kategorijos: ";
  while($rw = $res->fetch_assoc()) {
  $kats = $kats . $rw["kategorija"] . ", ";

  }
  $kats = rtrim($kats, ", ");
  echo   $kats  . "</p>" ;
 }
 
 
 echo "<div class='h6'> Komentarai</div>";
 
 $kom_sql = "SELECT * FROM komentarai WHERE nid =  $nid";
    
  $rs = $conn->query($kom_sql);
    
    if ($rs->num_rows > 0) {
  
  while($rwk = $rs->fetch_assoc()) {
  echo "<div class='lead'>".$rwk["elpastas"] . "</div>";
  echo $rwk["komentaras"] . "<br><br>";
  }
  
  
 }//end komentarai
 

 
}//while
}//if


$conn->close();
?>



<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="myForm" onsubmit="return validateForm()" >

<div class="mb-3 mt-3">
    <label for="elpastas" class="form-label">El. paštas</label>
    <input type="text" name="elpastas" id="elpastas"  class="form-control"  placeholder="Įrašykite el. pašto adresą">
  </div>


<div class="mb-3 mt-3">
 <label for="turinys">Komentaras</label>
<textarea name="comment" id="comment" rows="3" class="form-control"   placeholder="Rašykite komentarą..."  ></textarea>
</div>

<input type="hidden" name="nid"  value="<?php echo $nid; ?>" >
<input type="submit"   value="Komentuoti" >
</form>

<div class="mt-4 p-2 bg-secondary text-white rounded">
   <p>&copy; Vincas Batulevičius, 2022</p>
</div>
</div>
</body>
</html>
