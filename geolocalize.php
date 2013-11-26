<?php 

include('config.inc');

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

?>
