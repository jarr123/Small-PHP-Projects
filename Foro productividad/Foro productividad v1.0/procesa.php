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
	</body></html>
<?php
@include('funciones.php');
if(isset($_POST['envio'])){	// Si se ha pulsado el botón de envio.
		// 1.- Validacion.

		// Campo nombre.
		
		if($_POST['email'] == ""){
			
			$errores[]= 'No ha introducido nada en el campo "email"';
			
		}

		// Campo descripción.
		
		if($_POST['descripcion'] == ""){
			
			$errores[]= 'No ha introducido nada en el campo "descripcí&oacute;n"';
			
		}

		// 2.- Saneamiento. 
	
	$args = array(  
		'email'		=> FILTER_VALIDATE_EMAIL,
		'descripcion'    => array(	'filter'    => FILTER_SANITIZE_MAGIC_QUOTES,  
							    'flags'     => FILTER_FLAG_ENCODE_AMP | FILTER_FLAG_NO_ENCODE_QUOTES),
	                           );

	$myinputs = filter_input_array(INPUT_POST, $args);
	
	if(array_search(false,$myinputs,true) || array_search(NULL,$myinputs,true)){
		$errores[]= 'Error en los datos del formulario.';
	}
		if(!isset($errores)){
		$email = $myinputs['email'];
		$descripcion = $myinputs['descripcion'];
		$entrada = $_POST['entrada'];
		
		$indice = modificaIndice('indice.txt');
		creaElemento('temas.txt',$indice,$entrada,$email,$descripcion);	
		echo'<p class ="errorestitulo">Muchas gracias! Se han introducido los datos en el sistema. </p>';
		leerElementos('temas.txt',$entrada);
		
		}else{
			echo'<p class ="errorestitulo">Se han producido los siguientes errores: </p>';
			foreach ($errores as $key => $value) {
				echo"<p  class=\"errores\">$value</p>";
			}
		}


echo '<p class = "link"><a href="index.php" >Volver al listado general</a></p>';

}elseif(isset($_POST['puntuar'])){
	
		$previo = $_POST['previo'];
		$puntuacion = $_POST['puntuacion'];
			puntuar($puntuacion);
			echo'<p class ="errorestitulo">Muchas gracias! Su puntuaci&oacute;n se ha introducido en el sistema. </p>';
			leerElementos('temas.txt',$previo);
			echo '<p class = "link"><a href="index.php" >Volver al listado general</a></p>';
		

	
}


?>