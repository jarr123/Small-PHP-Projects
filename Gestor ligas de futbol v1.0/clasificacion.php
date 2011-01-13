<html>
	<head><style type="text/css">
		@import "sample.css";
	</style></head>
	<body></body>
</html>


<?php
@include('funciones.php');

if(isset($_POST['envio'])){
	$cont = 0;
	$liga = $_POST['liga'];
	$equipos = equiposPuntuacion('ficheros/equipos.csv',$liga);
	echo '<h1>Clasificaci&oacute;n de '."$liga".': </h1>';
	echo '<table>';
	foreach ($equipos as $key => $value) {
		$cont += 1;
		echo "<tr><td class=\"ranking\">$cont</td><th class=\"rankingletra1\">$key:</th><td class=\"rankingletra2\"> $value</td></tr>";
	}
	echo '</table>';
	
	
}else{

$ligas = ligas('ficheros/ligas.csv');
echo '<h1>Clasificaciones: </h1>';
echo '<fieldset><form method="post" action="clasificacion.php">';
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