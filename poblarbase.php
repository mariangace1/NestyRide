<?php
        // Include database connection settings
       include('config.inc');

              	$miSentenciaSQL = "INSERT INTO Entrada (usuario, rol, origenx, origeny, destinox, destinoy,hora,fecha, lugares) VALUES ('".$_POST["username"]."','".$_POST["rol"]."','".$_POST["ox"]."','".$_POST["oy"]."','".$_POST["dx"]."','".$_POST["dy"]."','".$_POST["hora"]."','".$_POST["fecha"]."','".$_POST["lugares"]."')";
        			//$miSentenciaSQL = "INSERT INTO image (image) VALUES ('".$path."')";
        			$resultado = mysql_query($miSentenciaSQL); 
        			//echo $miSentenciaSQL;

        			if (!$resultado){
        			 echo "Error al registrar el empleado";
        			 echo $miSentenciaSQL;
        			}
        			else
        			{
        			echo "

              Ruta insertada con &eacute;xito";
        			} mysql_close($con); 
              
?>

alta