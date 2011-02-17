<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Resultados</title>
	<style type="text/css">
		@import "sample.css";
	</style>
</head>

<body>
	<?php
	@include('funciones.php');
	
	if(isset($_POST['envio3'])){
		if(isset($_POST['visitante'])){	// Si hemos seleccionado un equipo visitante...
			$local = $_POST['local'];
			$visitante = $_POST['visitante'];
			$liga = $_POST['liga'];
		
		// Realizamos la validación y el saneamiento.
		
		// Si el rango de goles es el válido.
			$args = array(  
		    	'golesLocal'   => array('filter' => FILTER_VALIDATE_INT, 'options' => array('min_range' => 1, 'max_range' => 100)),  
		    	'golesVisitante'    => array('filter'    => FILTER_VALIDATE_INT,  'options'   => array('min_range' => 1, 'max_range' => 100)));

			$result = filter_input_array(INPUT_POST, $args);
		
			if(array_search(false,$result,true) ||	array_search(NULL,$result,true)){
			
					echo '<p class ="errores">Se ha producido un error en la validaci&oacute;n de los goles</p>';
				
				}else{
		
					$golesLocal = $_POST['golesLocal'];
					$golesVisitante = $_POST['golesVisitante'];
					$res = guardarResultado('localhost',$liga,$local,$visitante,$golesLocal,$golesVisitante);	// Guardamos el resultado en la BD
					if($res != true){
						echo 'Se ha producido un error a la hora de guardar el resultado';
					}

					echo '<div class ="errores">Se han introducido los datos correctamente.</div>';
					echo'<h2><form method="post" method="resultados.php">Desea introducir m&aacute;s resultados?. Pulse <input type="submit" name="envio" value="Aqu&iacute;" /><input type="hidden" name="liga" value="'."$liga".'"/></form></h2>';
				

				}
				}else{echo '<p class= "errores">Seleccione un equipo visitante por favor.</p>';}

	
	
	}elseif(isset($_POST['envio2'])){	// Ahora toca seleccionar el equipo visitante y el resultado.
		if(isset($_POST['equipo'])){	// Si hemos seleccionado un equipo local...
			echo '<h1>Seleccione al equipo visitante</h1>';
			$local = $_POST['equipo'];
			$liga = $_POST['liga'];
			$visitantes = buscarVisitantes('localhost',$liga,$local);	// Buscamos los equipos que aún puedan ser visitantes.
			if(count($visitantes)){	// Si hay al menos un visitante.
				echo '<fieldset><form method="post" action="resultados.php">';
				foreach ($visitantes as $key => $value) {	// Los mostramos por pantalla.
					echo "<input type=\"radio\" name=\"visitante\" value=\"$value\">$value<br />";
				}
				echo "<input type=\"hidden\" name=\"liga\" value=\"$liga\">";
				echo "<br /><b>Goles:</b> <input type=\"hidden\" name=\"local\" value=\"$local\"><br />";
				echo 'Local: <input type="text" name="golesLocal" /><br />';
				echo 'Visitante: <input type="text" name="golesVisitante" /><br />';
				echo '<br /><input type="submit" name="envio3" value="Enviar"><br />';	// Enviamos el equipo visitante y el resultado.
				echo '<input type="reset" name="reset" value="Reestablecer"><br />';
				echo '</form></fieldset>';

	}else{
		
		echo '<p class= "errores">Ese equipo ha jugado ya todos los partidos como local</p>';
	}
				}else{echo '<p class= "errores">Seleccione por favor un equipo como local</p>';}
	
	
	}elseif(isset($_POST['envio'])){	// Ahora toca seleccionar el equipo local.
		if(isset($_POST['liga'])){	// Si hemos seleccionado una liga.
			$liga = $_POST['liga'];
			echo '<h1>Seleccione el equipo que juega en casa:</h1>';
		
			$equipos = equipos('localhost',$liga);	// Buscamos los equipos.
			if(count($equipos)){	// Si hay al menos uno...
				echo '<fieldset><form method="post" action="resultados.php">';
				foreach ($equipos as $key => $value) {	// Los motramos por pantalla.
					echo "<input type=\"radio\" name=\"equipo\" value=\"$value\">$value<br />";
				}
				echo "<input type=\"hidden\" name=\"liga\" value=\"$liga\">";
				echo '<br /><input type="submit" name="envio2" value="Enviar"><br />';	// Seleccionamos un equipo como local.
				echo '<input type="reset" name="reset" value="Reestablecer"><br />';
				echo '</form></fieldset>';

	}else{
		
		echo '<h2 class="errores">No se ha encontrado ning&uacute;n equipo en la liga.</h2>';
	}
				}else{echo'<p class= "errores">Seleccione alguna liga por favor</p>';}	
		
	}else{

	$ligas = ligas('localhost');	// Leemos las ligas.
	echo '<h1>Resultados:</h1>';
	echo '<fieldset><form method="post" action="resultados.php">';
	if(count($ligas)){	// Si existe al menos una liga...
		foreach ($ligas as $key => $valor) {	// Las mostramos por pantalla.
			echo "$valor";
			echo "<input type=\"radio\" name=\"liga\" value=\"$valor\"/><br />";
		}
		echo '<br /><input type="submit" name="envio" value="Enviar"><br />';	// Seleccionamos una liga.
		echo '<input type="reset" name="reset" value="Reestablecer"><br />';
	echo '</form></fieldset>';
}else{
	
			echo '<h2 class="errores">No se ha encontrado ninguna liga.</h2>';
	
}
}
	?>
	<h2>Desea volver al men&uacute; principal?. Pulse <a href="index.php">Aqu&iacute;</a></h2>
</body>
</html>
