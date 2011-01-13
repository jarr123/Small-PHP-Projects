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
		$local = $_POST['local'];
		$visitante = $_POST['visitante'];
		$liga = $_POST['liga'];
		
		$args = array(  
		    'golesLocal'   => array('filter' => FILTER_VALIDATE_INT, 'options' => array('min_range' => 1, 'max_range' => 100)),  
		    'golesVisitante'    => array('filter'    => FILTER_VALIDATE_INT,  'options'   => array('min_range' => 1, 'max_range' => 100)));

		$result = filter_input_array(INPUT_POST, $args);
		
		if(array_search(false,$result,true) ||	array_search(NULL,$result,true)){
			
				echo '<p class ="errores">Se ha producido un error en la validaci&oacute;n de los goles</p>';
				
			}else{
		
		$golesLocal = $_POST['golesLocal'];
		$golesVisitante = $_POST['golesVisitante'];
		guardarResultado('ficheros/resultados.txt',$liga,$local,$visitante,$golesLocal,$golesVisitante);

		echo '<div class ="errores">Se han introducido los datos correctamente.</div>';
		echo'<h2><form method="post" method="resultados.php">Desea introducir m&aacute; resultados?. Pulse <input type="submit" name="envio" value="Aqu&iacute;" /><input type="hidden" name="liga" value="'."$liga".'"/></form></h2>';

}
	
	
	}elseif(isset($_POST['envio2'])){
			echo '<h1>Seleccione al equipo visitante</h1>';
		$local = $_POST['equipo'];
		$liga = $_POST['liga'];
		$visitantes = buscarVisitantes('ficheros/resultados.txt',$liga,$local);
		if($visitantes != false){
		echo '<fieldset><form method="post" action="resultados.php">';
			foreach ($visitantes as $key => $value) {
				echo "<input type=\"radio\" name=\"visitante\" value=\"$value\">$value<br />";
			}
			echo "<input type=\"hidden\" name=\"liga\" value=\"$liga\">";
			echo "<br /><b>Goles:</b> <input type=\"hidden\" name=\"local\" value=\"$local\"><br />";
			echo 'Local: <input type="text" name="golesLocal" /><br />';
			echo 'Visitante: <input type="text" name="golesVisitante" /><br />';
			echo '<br /><input type="submit" name="envio3" value="Enviar"><br />';
			echo '<input type="reset" name="reset" value="Reestablecer"><br />';
		echo '</form></fieldset>';
	}else{
		
		echo '<p class= "errores">Ese equipo ha jugado ya todos los partidos como local</p>';
	}
	
	
	
	}elseif(isset($_POST['envio'])){
		$liga = $_POST['liga'];
		echo '<h1>Seleccione el equipo que juega en casa:</h1>';
		
		$equipos = equipos('ficheros/equipos.csv',$liga);
		if($equipos != -1){
		echo '<fieldset><form method="post" action="resultados.php">';
			foreach ($equipos as $key => $value) {
				echo "<input type=\"radio\" name=\"equipo\" value=\"$value\">$value<br />";
			}
			echo "<input type=\"hidden\" name=\"liga\" value=\"$liga\">";
			echo '<br /><input type="submit" name="envio2" value="Enviar"><br />';
			echo '<input type="reset" name="reset" value="Reestablecer"><br />';
		echo '</form></fieldset>';

	}else{
		
		echo '<h2 class="errores">No se ha encontrado ning&uacute;n equipo en la liga.</h2>';
	}
		
		
	}else{

	$ligas = ligas('ficheros/ligas.csv');
	echo '<h1>Resultados:</h1>';
	echo '<fieldset><form method="post" action="resultados.php">';
		foreach ($ligas as $key => $valor) {
			echo "$valor";
			echo "<input type=\"radio\" name=\"liga\" value=\"$valor\"/><br />";
		}
		echo '<br /><input type="submit" name="envio" value="Enviar"><br />';
		echo '<input type="reset" name="reset" value="Reestablecer"><br />';
	echo '</form></fieldset>';
}
	?>
	<h2>Desea volver al men&uacute; principal?. Pulse <a href="index.php">Aqu&iacute;</a></h2>
</body>
</html>
