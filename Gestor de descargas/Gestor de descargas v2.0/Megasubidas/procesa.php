<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style type="text/css">
			@import "sample.css";
		</style>
	</head>
<body>

<?php
@include ("funciones.php");

	if(isset($_POST['envio'])){	// Si se ha pulsado el botón de envio.
		
			// 1.- Validacion.

			// Campo nombre.
			
			if($_POST['nombre'] == ""){
				
				$errores[]= 'No ha introducido nada en el campo "nombre"';
				
			}
			
			// Campo fichero.
			
			if ($_FILES['archivo']['error'] > 0) {	// Errores de la imagen.
				$errores[]= 'Error: ' . $_FILES['archivo']['error'] . '<br />';
			}

			// Campo descripción.
			
			if($_POST['descripcion'] == ""){
				
				$errores[]= 'No ha introducido nada en el campo "descripcí&oacute;n"';
				
			}

			// 2.- Saneamiento. 
		
		$args = array(  
		    'nombre'    => array(	'filter'    => FILTER_SANITIZE_MAGIC_QUOTES,  
		                            'flags'     => FILTER_FLAG_ENCODE_AMP | FILTER_FLAG_NO_ENCODE_QUOTES),
			'descripcion'    => array(	'filter'    => FILTER_SANITIZE_MAGIC_QUOTES,  
								    'flags'     => FILTER_FLAG_ENCODE_AMP | FILTER_FLAG_NO_ENCODE_QUOTES),
		                           );

		$myinputs = filter_input_array(INPUT_POST, $args);
		if($myinputs !== null && $myinputs !== false){  
			// 3.- Subida del fichero.
			
			if(!isset($errores)){	// Si no se han producido fallos...
			
				$res = subeArchivo('localhost',$myinputs['nombre'],$myinputs['descripcion'],$_FILES);	// Subimos el fichero al servidor.
			
				echo '<p class ="errorestitulo">Enhorabuena! Ya ha subido su archivo!</p>';
				if($res != false){
					$lista = leerArchivos('localhost');	// Leemos los ficheros.				
					if($lista != false) mostrarArchivos($lista);	// Mostramos los archivos.
				}				
			}else{	// Si se han producido fallos...
				echo'<p class ="errorestitulo">Se han producido los siguientes errores: </p>';
				foreach ($errores as $key => $value) {
					echo'<p class ="errores">'."$value".'</p>';
				}
			}
				echo '<p class = "link"><a href="index.php" >Volver al index!</a></p>';
			
}
}

?>


</body>
</html>