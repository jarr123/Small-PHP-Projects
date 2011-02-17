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
		$res = false;

		$con = mysql_connect("$direccion","root","");
		
		if(!$con){		
				echo "No se puede conectar al servidor";		

		}else{
			$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				echo "No se encuentra la base de datos";
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				$result = mysql_query("INSERT INTO ligas(nombre) values('$nombreLiga')",$con);
				if (!$result) {
					echo "No se pueden introducir los resultados";
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

function almacenaEquipos($direccion,$nombreLiga,$equipos){
	
		$res = false;

		$con = mysql_connect("$direccion","root","");
		
		if(!$con){				
				echo "No se puede conectar al servidor";
		}else{
					$res = true;
				}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				foreach ($equipos as $key => $value) {
					$result = mysql_query("INSERT INTO equipos(nombreLiga,nombre) values('$nombreLiga','$value')",$con);
			}
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

function ligas($direccion){
		$res = false;

		$con = mysql_connect("$direccion","root","");
		
		if($con){					
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			
			if($res != false){

			$result = mysql_query("SELECT nombre FROM ligas",$con);
			if (!$result) {
				$res = false;
						}
			}
			mysql_close($con);
			
			while($ligas = mysql_fetch_array($result)) {
				$vector[] = $ligas['nombre'];
			}

	}
	if($res != false){
		return $vector;
	}else{
		return $res;
	}
}
function equipos($direccion,$liga){
		$res = false;

		$con = mysql_connect("$direccion","root","");
		
		if($con){					

			$res = true;
		}

		if($res != false){
			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			
			if($res != false){

			$result = mysql_query("SELECT nombre FROM equipos WHERE nombreLiga = '$liga'",$con);
			if (!$result) {
				$res = false;
						}
			}
			mysql_close($con);
			if($res != false){
				while($equipos = mysql_fetch_array($result)) {
					$vector[] = $equipos['nombre'];
				}
			}
			
	}
	if($res != false){
		return $vector;
	}else{
		return $res;
	}
	
	
}

function buscarVisitantes($direccion,$liga,$local){
		$res = false;
		$flag = false;
		$con = mysql_connect("$direccion","root","");
		
		if($con){					

			$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			
			if($res != false){

			$result = mysql_query("SELECT nombre FROM equipos WHERE nombreLiga = '$liga' and nombre != '$local' and nombre NOT IN (SELECT visitante FROM resultados WHERE local = '$local');",$con);
			if (!$result) {
				$res = false;
						}						
			}
			mysql_close($con);
			if($res){
				while($equipos = mysql_fetch_array($result)) {
					$flag = true;
					$valor = $equipos['nombre'];
					$vector[] = $valor;	
				}
			}
				
	}
	if($res != false){
		return $vector;
	}else{
		return $res;
	}
	
}


function guardarResultado($direccion,$liga,$local,$visitante,$golesLocal,$golesVisitante){
		$res = false;
		$con = mysql_connect("localhost","root","");
		
		if($con){				
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){

				$result = mysql_query("INSERT INTO resultados(liga,local,visitante,golesLocal,golesVisitante) 				values('$liga','$local','$visitante','$golesLocal','$golesVisitante')",$con);
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

function equiposPuntuacion($direccion,$liga){
		$res = false;

		$con = mysql_connect("$direccion","root","");
		
		if($con){					
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			
			if($res != false){

			$result = mysql_query("SELECT nombre FROM equipos WHERE nombreLiga = '$liga'",$con);
			if (!$result) {
				$res = false;
						}
			}
			mysql_close($con);
			if($res){
					while($equipos = mysql_fetch_array($result)) {
						$flag = true;
						$valor = $equipos['nombre'];
						$vector[] = $valor;	
					}
					
					foreach ($vector as $key => $value) {
						
						$equipos[$value] = equipoPuntos('localhost',$value);
					}
				
			}

	}

	arsort($equipos);	// Ordenamos el vector.
	if($res != false){
		return $equipos;
	}else{
		return $res;
	}
	
}

function equipoPuntos($direccion,$equipo){
	$res = false;
	$puntosLocal = 0;
	$con = mysql_connect("$direccion","root","");
		if($con){					
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("comunio", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			
			if($res != false){
		// COMO LOCAL.
			$result1 = mysql_query("SELECT * FROM resultados WHERE local ='$equipo' and golesLocal > golesVisitante",$con);
			$puntosLocal = mysql_affected_rows()*3;
			$result2 = mysql_query("SELECT * FROM resultados WHERE local ='$equipo' and golesLocal = golesVisitante",$con);
			$puntosLocal += mysql_affected_rows();
			
		// COMO VISITANTE.
			$result3 = mysql_query("SELECT * FROM resultados WHERE visitante ='$equipo' and golesVisitante > golesLocal",$con);
			$puntosVisitante = mysql_affected_rows()*3;
			$result4 = mysql_query("SELECT * FROM resultados WHERE visitante ='$equipo' and golesVisitante = golesLocal",$con);
			$puntosVisitante += mysql_affected_rows();
			
			$puntosTotales = $puntosLocal + $puntosVisitante;
			
		}
}

if($res != false){
	return $puntosTotales;
}else{
	return $res;
}
	
}

?>