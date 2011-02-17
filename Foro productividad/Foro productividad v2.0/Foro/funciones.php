<?php

// Foro sobre productividad.

function creaElemento($direccion,$entradaPrevia,$email,$descripcion){	// Creamos o un tema principal o una respuesta.
		$res = false;
		$con = mysql_connect($direccion,"root","");
		
		if($con){				
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("foro", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				$result = mysql_query("INSERT INTO tema(entradaPrevia,email,descripcion) 				values('$entradaPrevia','$email','$descripcion')",$con);
				if (!$result) {
					$res = false;
				}else{
					$result2 = mysql_query("SELECT indice FROM tema WHERE descripcion = '$descripcion'",$con);
						while($row = mysql_fetch_array($result2)){
							$indice = $row['indice'];
						}
				}
			}
			mysql_close($con);

	}	
	if($res != true){
		return $res;
	}else{
		return $indice;
	}
}


function leerElementos($direccion,$entrada = -1){	// Eliminamos al usuario.
			$res = false;
			$con = mysql_connect($direccion,"root","");

			if($con){				
					$res = true;
			}

			if($res != false){

				$db_selected = mysql_select_db("foro", $con);

				if (!$db_selected) {
					mysql_close($con);
					$res = false;
				}
				if($res != false){
					$result = mysql_query("SELECT * FROM tema WHERE entradaPrevia = '$entrada'",$con);
					if (!$result) {
						$res = false;
					}
				}
				mysql_close($con);

		}	
		if($res != true){
			return $res;
		}else{
			return $result;
		}
	}
	
function mostrarTema($array){
				while($row = mysql_fetch_array($array)){
					$subtemas = numeroSubtemas('localhost',$row['indice']);
					$puntuacion = verPuntuacion('localhost',$row['indice']);
											 echo "<table class=\"tableStyle\"><tr><th>ID:</th><td>". $row['indice']."</td><th>Fecha: </th><td>".$row['time']."</td></tr><tr><th>Email:</th><td>".$row['email']."</td><th>Descripci&oacute;n:</th><td>".$row['descripcion']."</td><td><form method=\"post\" action = \"index.php\"><input type=\"submit\" name=\"comentar\" value=\"Ver tema\" /><input type=\"hidden\" name=\"entrada\" value=\"$row[indice]\" /></form></td></tr><tr><th>Respuestas:</th><td>$subtemas</td><th>Votos Positivos:</th><td>$puntuacion</td><td><form method=\"post\" action = \"procesa.php\"><input type=\"submit\" name=\"puntuar\" value=\"Puntuar\" /><input type=\"hidden\" name=\"previo\" value=\"$row[indice]\" /><input type=\"hidden\" name=\"puntuacion\" value=\"$puntuacion\" /></form></td></tr></table>";
		
	}	
}

function contarSubtemas($array){
			$cont = 0;
				while($row = mysql_fetch_array($array)){
					$cont++;
				}	
	return $cont;
}


function numeroSubtemas($direccion,$id){
			$res = false;
			$con = mysql_connect($direccion,"root","");

			if($con){				
					$res = true;
			}

			if($res != false){

				$db_selected = mysql_select_db("foro", $con);

				if (!$db_selected) {
					mysql_close($con);
					$res = false;
				}
				if($res != false){
					$result = mysql_query("SELECT * FROM tema WHERE	entradaPrevia = '$id'",$con);
					if (!$result) {
						$res = false;
					}else{
						$num = contarSubtemas($result);
					}
				}
				mysql_close($con);

		}	
		if($res != true){
			return $res;
		}else{
			return $num;
		}
}

function crearPuntuacion($direccion,$indice){
			$res = false;
			$con = mysql_connect($direccion,"root","");

			if($con){				
					$res = true;
			}

			if($res != false){

				$db_selected = mysql_select_db("foro", $con);

				if (!$db_selected) {
					mysql_close($con);
					$res = false;
				}
				if($res != false){
					$result = mysql_query("INSERT INTO puntuacion(indice,puntuacion) values('$indice',0)",$con);
					if (!$result) {
						$res = false;
					}
				}
				mysql_close($con);

		}
		if($res != true){	
			return $res;
		}else{
			return $result;
		}
}

function puntuar($direccion,$indice){
		$res = false;
		$con = mysql_connect($direccion,"root","");

		if($con){				
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("foro", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){

				$result = mysql_query("SELECT * FROM puntuacion WHERE indice = '$indice'",$con);
				if (!$result) {
					$res = false;
				}else{

						while($row = mysql_fetch_array($result)){

							$nuevaPuntuacion = $row['puntuacion'] + 1;
							$result2 = mysql_query("UPDATE puntuacion SET puntuacion = '$nuevaPuntuacion' WHERE indice = '$indice'",$con);
				}
			}
			}
			mysql_close($con);

	}
	if($res != true){	
		return $res;
	}else{
		return $result;
	}

}


function verPuntuacion($direccion,$indice){
		$res = false;
		$con = mysql_connect($direccion,"root","");

		if($con){				
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("foro", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				$result = mysql_query("SELECT puntuacion FROM puntuacion WHERE indice = '$indice'",$con);
				if (!$result) {
					$res = false;
				}else{
					while($row = mysql_fetch_array($result)){
						$puntuacion = $row['puntuacion'];
					}
				}
			}
			mysql_close($con);

	}
	if($res != true){	
		return $res;
	}else{
		return $puntuacion;
	}
	}




?>