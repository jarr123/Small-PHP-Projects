
<?php

function mostrarFormularioEquipos($equipos,$liga){
	
	echo "<h1>$liga</h1>";
	echo '<fieldset><form method="post" action="formulario.php">';
	for ($i=0; $i < $equipos ; $i++) { 
		echo"Equipo $i: "."<input type=\"text\" name=\"$i\"/><br />";
	}

	echo '<input type="hidden" name="equipos" value="'."$equipos".'" />';
	echo '<input type="hidden" name="liga" value="'."$liga".'" />';
	echo '<input type="submit" name="envioEquipos" value="Enviar" /><br />';
	echo '<input type="reset" name="reset" value="Resetear" /><br />';
	echo '</form></fieldset>';

}

function almacenaLiga($direccion,$nombreLiga){
	
	$f = fopen($direccion,'a');
	
	if($f){
		flock($f,LOCK_SH);	// Bloqueamos.
		fwrite($f,"$nombreLiga\n");
		flock($f,LOCK_UN);	// Bloqueamos.
		fclose($f);
		
	}else{		
		echo 'Se ha producido un error a la hora de abrir el archivo';
	}
	
}

function almacenaEquipos($direccion,$nombreLiga,$equipos){
	
	$f = fopen($direccion,'a');
	
	if($f){
		
		foreach ($equipos as $key => $value) {
			flock($f,LOCK_SH);	// Bloqueamos.
			fwrite($f,"$nombreLiga\t$value\n");
			flock($f,LOCK_UN);	// Bloqueamos.
	}
		fclose($f);
		
	}else{		
		echo 'Se ha producido un error a la hora de abrir el archivo';
	}
	
}

function ligas($direccion){
	$f = fopen($direccion,'r');
	
	if($f){
		flock($f,LOCK_SH);	// Bloqueamos.
		$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		while(!feof($f)){
			$cont[] = $linea[0];
			$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		}
		flock($f,LOCK_UN);	// Bloqueamos.
	}else{
		
		echo 'Se ha producido un error a la hora de abrir el archivo';
	}
	return $cont;
}
function equipos($direccion,$liga){
	$flag = false;
	$f = fopen($direccion,'r');
	
	if($f){
		flock($f,LOCK_SH);	// Bloqueamos.
		$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		while(!feof($f)){
			if($linea[0] == $liga){
				$cont[] = $linea[1];
				$flag = true;
			}
			$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		}
		flock($f,LOCK_UN);	// Bloqueamos.
	}else{
		
		echo 'Se ha producido un error a la hora de abrir el archivo';
	}
	if($flag == true)
		return $cont;
	else 
		return -1;
	
}

function buscarVisitantes($direccion,$liga,$local){
	$flag = false;
	$flag2 = true;
	if(file_exists($direccion) != false){	// Si existe.
		
		$f2 = fopen($direccion,'r');
		
		if($f2){
			
			flock($f2,LOCK_SH);	// Bloqueamos.
			$linea = fgetcsv($f2,999,"\t"); 	// Guardamos el contenido en el array $linea.
			while(!feof($f2)){
				if($linea[1] == $local){	// Si existe como local en el archivo de resultados.
					$visitantes[] = $linea[3];
					$flag=true;
				}
				$linea = fgetcsv($f2,999,"\t");
			}
				
			flock($f2,LOCK_UN);	// Bloqueamos.
			fclose($f2);
		}else{
			
			echo 'Se ha producido un error a la hora de abrir el archivo.';			
		}
		
	}
	
		$f = fopen('ficheros/equipos.csv','r');
		
		if($f){
			flock($f,LOCK_SH);	// Bloqueamos.
			$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
			while(!feof($f)){
				if($linea[0] == $liga){	// Están en la misma liga.
					if($linea[1] != $local && $flag == false){	// O no existe, o existe el archivo pero no está nuestro local todavia.			
						$visitantesFinales[]=$linea[1];
						$flag2 = true;
					}elseif($linea[1] != $local && !in_array($linea[1],$visitantes)){	// Existe el archivo, y además existe el local en el archivo anterior. Además el visitante que estamos recorriendo, no existe en el array de los visitantes que ya han jugado.
						$visitantesFinales[] = $linea[1];
						$flag2 = true;
					}		
				}
				$linea = fgetcsv($f,999,"\t"); 	
				}	
			flock($f,LOCK_UN);	// Bloqueamos.
			fclose($f);
		}else{
			
			echo 'Se ha producido un error a la hora de abrir el archivo';
		}
	
	if($flag2 == true){
	
		return $visitantesFinales;
	}else{
		return $flag2;
	}
}

function guardarResultado($direccion,$liga,$local,$visitante,$golesLocal,$golesVisitante){
	
	$f = fopen($direccion,'a');
	
	if($f){
		flock($f,LOCK_SH);	// Bloqueamos.
		fwrite($f,"$liga\t$local\t$golesLocal\t$visitante\t$golesVisitante\n");
		flock($f,LOCK_UN);	// Bloqueamos.
		fclose($f);
	}else{
		
		echo 'Se ha producido un error a la hora de abrir el archivo';
	}
	
	
}

function equiposPuntuacion($direccion,$liga){
	
	$f = fopen($direccion,'r');	// ficheros/equipos.
	
	if($f){
		
		flock($f,LOCK_SH);	// Bloqueamos.
		$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		while(!feof($f)){
			if($liga == $linea[0]){
				$equipos[$linea[1]] = equipoPuntos('ficheros/resultados.txt',$liga,$linea[1]);
			}
			$linea = fgetcsv($f,999,"\t"); 
		}
		flock($f,LOCK_UN);	// Bloqueamos.
		fclose($f);	
		
	}else{
		
		echo 'Se ha producido un error a la hora de abrir el archivo.';
		
	}
	arsort($equipos);	// Ordenamos el vector.
	return $equipos;
	
}

function equipoPuntos($direccion,$liga,$equipo){
	$puntos = 0;
	$f = fopen($direccion,'r');
	
	if($f){
		flock($f,LOCK_SH);	// Bloqueamos.
		$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		while(!feof($f)){
			if($liga == $linea[0]){
				if($equipo == $linea[1]){	// Si es local.
					
					if($linea[2] > $linea[4]){	// Gana el local.
						$puntos += 3;
					}elseif($linea[2] == $linea[4]){	// Empatan
						$puntos += 1;
					}
					
				}elseif($equipo == $linea[3]){	// Si es visitante.
					
						if($linea[2] < $linea[4]){	// Gana el visitante.
							$puntos += 3;
						}elseif($linea[2] == $linea[4]){	// Empatan
							$puntos += 1;
						}
					}
			} 
			$linea = fgetcsv($f,999,"\t"); 		
		}
		
		flock($f,LOCK_UN);	// Bloqueamos.
		fclose($f);
	}else{
		
		echo 'No se puede abrir el archivo';
	}
	return $puntos;
	
}
?>