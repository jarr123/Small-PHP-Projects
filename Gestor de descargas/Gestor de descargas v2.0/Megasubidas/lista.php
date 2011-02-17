<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Listado</title>
			<style type="text/css">
				@import "sample.css";
			</style>
		</head>
	<body>
	</body></html>
<?php
@include("funciones.php");
	echo '<p class = "indice">Listado de archivos:</p>';
	$lista = leerArchivos('localhost');
	if($lista != false) mostrarArchivos($lista);
	echo '<p class = "link"><a href="index.php" >Volver al index!</a></p>';
?>	
