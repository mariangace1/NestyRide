<?php 

include('config.inc');

$sql = "select * from entrada";
$data = query($sql);

function doitallandgivememyrides($id){
	
	global $data;
	
	$sol = inicializar_solucion();
	$sol = recocido_simulado($sol);
	$ids = mis_parejas($id,$sol);
	
	$rides = array();
	foreach ($ids as $key => $val){
		$rides[] = $data[$val];
	}
	
	return $rides;
	
}

function mis_parejas($id,$solucion){
	$ids = array();
	foreach ($solucion['parejas'] as $key => $val){
		if ($val['p'] == $id){
			$ids[] = $val['c'];
		}
		if ($val['c'] == $id){
			$ids[] = $val['p'];
		}
		
	}
	
	return $ids;
	
}

function inicializar_solucion(){
	
	$sol = array();
	
	//cargar datos
	
	$sql = "select * from entrada where rol = 'pasajero'";
	$result = query($sql);
	
	$sol['pasajeros'] = array_keys($result);
	
	$sql = "select * from entrada where rol = 'conductor'";
	$result = query($sql);
	
	$sol['conductores'] = array_keys($result);
	
	$sol['parejas'] = array();
	
	//parejas al azar
	
	shuffle($sol['pasajeros']);
	shuffle($sol['conductores']);
	
	$num_pasajeros = count($sol['pasajeros']);
	$num_conductores = count( $sol['conductores']);
	
	$mayor = "";
	
	if ($num_pasajeros > $num_conductores){
		$mayor = "pasajeros";
	}else{
		$mayor = "conductores";
	}
	
	$sol['mayor'] = $mayor;
	
	$min = min( count($sol['pasajeros']), count( $sol['conductores']) );
	
	for ($i = 0; $i <$min ; $i++){
		$sol['parejas'][] = array('p'=>$sol['pasajeros'][$i],'c'=>$sol['conductores'][$i]);
		unset($sol['pasajeros'][$i]);
		unset($sol['conductores'][$i]);
	}
	
	return $sol;
}

function nueva_solucion($solucion){
	
	if ($solucion['mayor'] && mt_rand(0,1)){
		//swap con los de afuera
		$pareja_random = array_rand($solucion['parejas']);
		$afuera_random = array_rand($solucion[$solucion['mayor']]);
		
		$temp = 0;
		$temp = $solucion['parejas'][$pareja_random][$solucion['mayor'][0]]; 
		$solucion['parejas'][$pareja_random][$solucion['mayor'][0]] = $solucion[$solucion['mayor']][$afuera_random]; 
		$solucion[$solucion['mayor']][$afuera_random] = $temp; 
		
	}else{
		
		//swap parejas
		$randoms = array_rand($solucion['parejas'],2);
		$temp = 0;
		$temp = $solucion['parejas'][$randoms[0]]['p']; 
		$solucion['parejas'][$randoms[0]]['p'] = $solucion['parejas'][$randoms[1]]['p']; 
		$solucion['parejas'][$randoms[1]]['p'] = $temp; 
		
	}
	
	return $solucion;
		
	
}

function costo_solucion($solucion,$debug = false){
	$costo = 0;
	
	foreach ($solucion['parejas'] as $key => $val){
		global $data;
		$costo += costo($data[$val['p']] , $data[$val['c']] ,$debug); 
	}
	return $costo;		
}

function recocido_simulado($solucion,$T=10000000.0,$cool=0.95,$debug = false){
	
	while ($T>0.1){
		//generate new solution
		$solucion2 = nueva_solucion($solucion);
		
		// Calculate the current cost and the new cost
		$ea=costo_solucion($solucion);
		$eb=costo_solucion($solucion2);
		$p=pow(exp(1),(-$eb-$ea)/$T);
		
		// Is it better, or does it make the probability cutoff?
		
		if ($eb<$ea || mt_rand() / mt_getrandmax() < $p){
			$solucion = $solucion2;
		}
		
		if ($debug){
			echo "{$ea}
		";
		}
		
		
		// Decrease the temperature
		$T=$T*$cool;
		
	}
	
	return $solucion;
}

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

function costo_distancia($pas,$con){
	
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

// la distancia en minutos
function costo_tiempo($pas,$con,$debug = false){
	
	$to_time = strtotime($pas['tiempo']);
	$from_time = strtotime($con['tiempo']);
	
	if ($debug){
		echo round(abs($to_time - $from_time) / 60,2);
	}
	
	return abs($to_time - $from_time) / 60;
}

function costo($pas,$con,$debug = false){
	$k_tiempo = 1;
	$k_distancia = 1/0.001347342;
	
	$c_dist = costo_distancia($pas,$con);
	$c_tiempo = costo_tiempo($pas,$con,$debug);
	
	if ($debug){
		echo "distancia:{$c_dist} , tiempo:{$c_tiempo}
		";
	}
	
	
	return $k_distancia * $c_dist + $k_tiempo * $c_tiempo;

}



?>
