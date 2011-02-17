<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Clasificación</title>
	<head><style type="text/css">
		@import "sample.css";
	</style></head>
	<body></body>
</html>


<?php
@include('funciones.php');

if(isset($_POST['envio'])){	// Si hemos pulsado el botón de envio, una vez la liga esté seleccionada.
	$cont = 0;
	$liga = $_POST['liga'];
	if(isset($_POST['liga'])){
		$equipos = equiposPuntuacion('localhost',$liga);	// Calculamos las puntuaciones.
		echo '<h1>Clasificaci&oacute;n de '."$liga".': </h1>';
		echo '<table>';
		foreach ($equipos as $key => $value) {	// Mostramos la clasificación.
			$cont += 1;
			echo "<tr><td class=\"ranking\">$cont</td><th class=\"rankingletra1\">$key:</th><td class=\"rankingletra2\"> $value</td></tr>";
		}
		echo '</table>';
	}else{
		echo '<p class= "errores">No ha seleccionado ninguna liga.</p>';
	}
	
	
}else{

$ligas = ligas('localhost');	// Leemos las ligas.
echo '<h1>Clasificaciones: </h1>';
echo '<fieldset><form method="post" action="clasificacion.php">';
	foreach ($ligas as $key => $valor) {	// Las mostramos en pantalla.
		echo "$valor";
		echo "<input type=\"radio\" name=\"liga\" value=\"$valor\"/><br />";
	}
	echo '<br /><input type="submit" name="envio" value="Enviar"><br />';
	echo '<input type="reset" name="reset" value="Reestablecer"><br />';
echo '</form></fieldset>';





}





?>
	<h2>Desea volver al men&uacute; principal?. Pulse <a href="index.php">Aqu&iacute;</a></h2>