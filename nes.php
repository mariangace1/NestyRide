<?php 

//~ echo 'hola';

include('config.inc');

//~ $sql = "select * from entrada";
//~ $r = query($sql);
//~ print_r($r);exit;

$pas = array();

$pas['origenx'] = 2;
$pas['origeny'] = 2;

$pas['destinox'] = 6;
$pas['destinoy'] = 2.00001;

$con = array();

$con['origenx'] = 1;
$con['origeny'] = 1;

$con['destinox'] = 5;
$con['destinoy'] = 1.00001;

echo costo_distancia($pas,$con);

function costo_distancia($pas,$con){
	
	function proyeccion($px,$py,$l1x,$l1y,$l2x,$l2y){
		$px-=$l1x;
		$py-=$l1y;
		
		$r = proyectar($px,$py,$l2x-$l1x,$l2y-$l1y);
		
		
		$r['x']+=$l1x;
		$r['y']+=$l1y;
		
		return($r);
	}
	
	function proyectar($px,$py,$vx,$vy){
		$k = ($px*$vx + $py*$vy)/($vx*$vx+$vy*$vy);
		
		return array('x'=>$k*$vx , 'y'=>$k*$vy);
	}
	
	function distancia($ax,$ay,$bx,$by){
		return sqrt( pow($ax-$bx,2) + pow($ay-$by,2) ); 
	}
	
	$d = 0;
	
	$minx = min($con['origenx'],$con['destinox']);
	$maxx = max($con['origenx'],$con['destinox']);
	
	$miny = min($con['origeny'],$con['destinoy']);
	$maxy = min($con['origeny'],$con['destinoy']);
	
	//-------para el origen----------
	//hallar proyeccion
	
	$proyeccion = proyeccion($pas['origenx'],$pas['origeny'],$con['origenx'],$con['origeny'],$con['destinox'],$con['destinoy']);
	
	//si cae dentro
	
	if (  $minx <= $proyeccion['x'] && $proyeccion['x']<= $maxx ){
		//elegir la proyeccion
		$d+= distancia( $proyeccion['x'],$proyeccion['y'],$con['origenx'],$con['origeny'] );
	}else{//si no, elegir la distancia entre 2 puntos
		$d+= distancia( $pas['origenx'],$pas['origeny'],$con['origenx'],$con['origeny'] );
	}
	
	
	//---------repetir para el destino----------
	
	//hallar proyeccion
	
	$proyeccion = proyeccion($pas['destinox'],$pas['destinoy'],$con['origenx'],$con['origeny'],$con['destinox'],$con['destinoy']);
	
	//si cae dentro
	
	if (  $minx <= $proyeccion['x'] && $proyeccion['x']<= $maxx ){
		//elegir la proyeccion
		$d+= distancia( $proyeccion['x'],$proyeccion['y'],$con['destinox'],$con['destinoy'] );
		
	}else{//si no, elegir la distancia entre 2 puntos
		$d+= distancia( $pas['destinox'],$pas['destinoy'],$con['destinox'],$con['destinoy'] );
	}
	
	return $d;
}

function costo_tiempo(){
	
}



?>
