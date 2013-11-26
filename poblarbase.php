<?php
// Include database connection settings
include('config.inc');

$miSentenciaSQL = "INSERT INTO Entrada (usuario, rol, origenx, origeny, destinox, destinoy,tiempo, lugares) VALUES ('".$_POST["username"]."','".$_POST["rol"]."','".$_POST["ox"]."','".$_POST["oy"]."','".$_POST["dx"]."','".$_POST["dy"]."','".$_POST["fecha"]." ".$_POST["hora"]."','".$_POST["lugares"]."')";

if ($_POST["rol"] == "conductor"){
	for ($i = 0; $i <$_POST["lugares"] ; $i++){
		$resultado = mysql_query($miSentenciaSQL); 
	}
	
}else{
	$resultado = mysql_query($miSentenciaSQL); 
}

	

if (!$resultado){
 echo "Error al registrar la ruta"; exit;
 echo $miSentenciaSQL;
}
else
{
	//echo "Ruta insertada con &eacute;xito";
} 

$guardado_ok = true;

include('bienvenido.php');

              
?>

