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

$sql = "select * from entrada";
$data = query($sql);

foreach ($data as $key => $val){
	
	if($val['origen'] && $val['destino'])
		continue;
	
	
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$val['origenx'].",".$val['origeny']."&sensor=false";
	$reponse = file_get_contents($url);
	$data = json_decode($reponse);
	$origen = $data->results[0]->formatted_address;
	
	
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$val['destinox'].",".$val['destinoy']."&sensor=false";
	$reponse = file_get_contents($url);
	$data = json_decode($reponse);
	$destino = $data->results[0]->formatted_address;
	
	
	$id = $val['id'];
	
	$sql = "update entrada set origen = '{$origen}', destino = '{$destino}' where id = {$id}";
	mysql_query($sql);
	
}

include('bienvenido.php');

              
?>

