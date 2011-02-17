<?php

// Foro sobre productividad.

function creaElemento($nombreFichero,$indice,$entradaPrevia,$email,$descripcion){	// Creamos o un tema principal o una respuesta.
	
	$f = fopen($nombreFichero,'a');		// Abrimos el archivo y añadimos.
	
	if($f){	// Si no se han producido errores.
		
		flock($f,LOCK_EX);	// Bloqueamos.
		$time = date("F j, Y, g:i a");	// Marca de tiempo.
		fwrite($f,"$indice\t$entradaPrevia\t$time\t$email\t$descripcion\n");	// Escribimos en el archivo.
		flock($f,LOCK_UN); 	// Desbloqueamos.
		fclose($f); 	// Cerramos el fichero.
		crearPuntuaciones('puntuaciones.txt',$indice);
	}else{	// Si se han producido errores...
		
		echo 'ERROR: No puedo escribir en el archivo';
	}
	

}

function modificaIndice($direccion){
	if(file_exists($direccion) != false){	
		$f = fopen($direccion,'r');
		if($f){
			flock($f,LOCK_EX);	// Bloqueamos.
				$array = fgetcsv($f,999); 
				flock($f,LOCK_UN); 	// Desbloqueamos.
				fclose($f);
				unlink($direccion);
			}else{
				echo 'ERROR: No puedo leer el archivo';
			}
			$indice = $array[0];
			
		}else{
			$indice = 0;
		}
	
	$f = fopen($direccion,'w');
	
	if($f){
		$indice += 1;
		flock($f,LOCK_EX);	// Bloqueamos.
		fwrite($f,$indice);
		flock($f,LOCK_UN); 	// Desbloqueamos.
		fclose($f);
	}else{
		echo 'ERROR: No puedo escribir en el archivo';
	}

	return $indice;
}

function leerElementos($nombreArchivo,$entrada = -1){	// Eliminamos al usuario.
	$entra = false;
	$flag = false;
		if(file_exists($nombreArchivo) == False){	// Si NO existe...

			echo "<p class=\" errorestitulo\">El fichero no existe por el momento, por lo tanto no existe ning&uacute;n tema creado.</p>";
			
		}else{	// Si existe....
					
				// Visualizamos ahora los perfiles introducidos. Leemos el archivo.
				$f = fopen($nombreArchivo,'r');	// Leemos el archivo.
				if($f){
					flock($f,LOCK_SH);	// Bloqueamos.
					$cont = 1;
					$archivo = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
					while(!feof($f)){
						$descripcion = buscarDescripcion($entrada);
						if($archivo[1] == $entrada){
							if($flag == false && $entrada == -1){
								echo'<p class="titulo2">Temas principales creados hasta el momento:</p>';
								$flag = true;
							}elseif($flag == false && $entrada != -1){
								echo'<p class="titulo2">Respuestas para el tema llamado "<i>'."$descripcion".'</i>":</p>';
								$flag = true;
							}
							$subtemas = numeroSubtemas($archivo[0]);
							$votos = numeroVotos($archivo[0]);
						 echo "<table class=\"tableStyle\"><tr><th>ID:</th><td> $archivo[0]</td><th>Fecha: </th><td>$archivo[2]</td></tr><tr><th>Email:</th><td> $archivo[3]</td><th>Descripci&oacute;n:</th><td> $archivo[4]</td><td><form method=\"post\" action = \"index.php\"><input type=\"submit\" name=\"comentar\" value=\"Ver tema\" /><input type=\"hidden\" name=\"entrada\" value=\"$cont\" /></form></td></tr><tr><th>Respuestas:</th><td>$subtemas</td><th>Votos Positivos:</th><td>$votos</td><td><form method=\"post\" action = \"procesa.php\"><input type=\"submit\" name=\"puntuar\" value=\"Puntuar\" /><input type=\"hidden\" name=\"previo\" value=\"$archivo[1]\" /><input type=\"hidden\" name=\"puntuacion\" value=\"$archivo[0]\" /></form></td></tr></table>";
						$entra = true;
						}
						$cont += 1;
						$archivo = fgetcsv($f,999,"\t");

			}
			flock($f,LOCK_UN); 	// Desbloqueamos.
			fclose($f);	// Cerramos el archivo.
			
			if($entra == false){
				echo'<p class="errores">Desafortunadamente, no hemos encontrado ninguna respuesta a este tema. Puede ser el primero!</p>';
			}
		}else{	// Si no se ha abierto correctamente...

				echo "No hay acceso al archivo";
			}
		}
}

function numeroSubtemas($id){
	$cont = 0;
	$f = fopen('temas.txt','r');
	
	if($f){
		flock($f,LOCK_SH); 	// Desbloqueamos.
		$archivo = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
			while(!feof($f)){ 
				if($id == $archivo[1]){
					$cont += 1;
				}
					$archivo = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
			}
		flock($f,LOCK_UN); 	// Desbloqueamos.
		fclose($f);
	}else{
		
		echo "Se ha producido un error a la hora de abrir el archivo";
	}
	return $cont;
}

function buscarDescripcion($id){
	$cont = false;
	$f = fopen('temas.txt','r');
	
	if($f){
		flock($f,LOCK_SH); 	// Desbloqueamos.
		$archivo = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
			while(!feof($f) && $cont != true){ 
				if($id == $archivo[0]){
					$cont = true;
					$descripcion = $archivo[4]; 
				}
				$archivo = fgetcsv($f,999,"\t"); 		// Leemos el archivo y lo guardamos en un array.
			}
		flock($f,LOCK_UN); 	// Desbloqueamos.
		fclose($f);
	}else{
		
		echo "Se ha producido un error a la hora de abrir el archivo";
	}
	return $descripcion;
	
}

function crearPuntuaciones($direccion,$indice){
	$puntuacion = 0;
	$f = fopen($direccion,'a');		// Abrimos el archivo y añadimos.
	
	if($f){	// Si no se han producido errores.
		
		flock($f,LOCK_EX);	// Bloqueamos.

		fwrite($f,"$indice\t$puntuacion\n");	// Escribimos en el archivo.
		flock($f,LOCK_UN); 	// Desbloqueamos.
		fclose($f); 	// Cerramos el fichero.
		
	}else{	// Si se han producido errores...
		
		echo 'ERROR: No puedo escribir en el archivo';
	}
	
}

function puntuar($indice){

		$f = fopen('puntuaciones.txt','r');
		$f2 = fopen('puntuacionesM.txt','w');	// Fichero auxiliar.
		rewind($f);	// Nos vamos al inicio del fichero.
		flock($f,LOCK_SH);	// Bloqueamos lectura.
		flock($f2,LOCK_EX);	// Bloqueamos escritura.
		$linea = fgetcsv($f,999,"\t"); 	// Guardamos el contenido en el array $linea.
		while(!feof($f)){
			if($linea[0] == $indice){	// Si es un elemento que no hay que borrar lo escribimos en el archivo auxiliar.
					$valor = $linea[1] + 1;
					fwrite($f2,"$linea[0]\t$valor\n");
				}else{
					fwrite($f2,"$linea[0]\t$linea[1]\n");
				}
				$linea = fgetcsv($f,999,"\t"); 
		}
		flock($f,LOCK_UN);	// Desbloqueamos lectura.
		flock($f2,LOCK_UN);	// Desbloqueamos escritura.
		fclose($f);	// Cerramos el fichero f.
		fclose($f2);	// Cerramos el fichero f2.

		sustituyeArchivo('puntuaciones.txt','puntuacionesM.txt');	// Sustituimos los archivos anteriores.


	}



	function sustituyeArchivo($direccion1,$direccion2){		// Esta función nos va a borrar el fichero antiguo y lo va a sustituir por el nuevo fichero modificado.

		unlink($direccion1);	// Borramos el fichero antiguo para liberar su nombre.

		$f = fopen($direccion1,'w');	// NUEVO fichero registro.txt
		$f2 = fopen($direccion2,'r');	// fichero registroM.txt
		flock($f,LOCK_EX);
		flock($f2,LOCK_SH);

		$linea = fgetcsv($f2,999,"\t"); 	// Metemos los datos de registroM.txt en registro.txt
		while(!feof($f2)){
			fwrite($f,"$linea[0]\t$linea[1]\t$linea[2]\n");
			$linea = fgetcsv($f2,999,"\t"); 

		}
		flock($f,LOCK_UN);
		flock($f2,LOCK_UN);
		fclose($f);
		fclose($f2);

		unlink($direccion2);	// Borramos el fichero auxiliar porque ya no nos es necesario.
	}

	function numeroVotos($id){
		$flag = false;
		$f = fopen('puntuaciones.txt','r');

		if($f){
			flock($f,LOCK_SH); 	// Desbloqueamos.
			$archivo = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
				while(!feof($f) && $flag != true){ 
					if($id == $archivo[0]){
						$cont = $archivo[1];
						$flag = true;
					}
						$archivo = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
				}
			flock($f,LOCK_UN); 	// Desbloqueamos.
			fclose($f);
		}else{

			echo "Se ha producido un error a la hora de abrir el archivo";
		}
		return $cont;
	}




?>