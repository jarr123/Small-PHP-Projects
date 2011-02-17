<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Descarga</title>
			<style type="text/css">
				@import "sample.css";
			</style>
		</head>
	<body>
	</body></html>
<?php
@include ('funciones.php');
	$direccionArchivo = $_POST['direccion'];
	echo'<p class="link">Descarga el archivo desde nuestros servidores!:</p>';	
	echo "<p class = \"indice\">Pulse <a href=\"archivos/$direccionArchivo\">aqu&iacute;</a> para descargar!</p>";
	$res = anyadirDescarga('localhost',$direccionArchivo);
	if($res != true){
		echo 'FALLO en la descarga del archivo.';
	}
	echo '<p class = "link"><a href="index.php" >Volver al index!</a></p>';


?>
