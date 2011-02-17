<?php
require("ej5_funciones.php");	// Importamos las funciones.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Inicio</title>
		<style type="text/css">
			@import "sample.css";
		</style>
	</head>
	<body>
		<h1 class="titulo">Ejercicio 3: Fotolog interactivo.</h1>
		<span class="left">
		<?php

		if(isset($_POST['envio'])){	// Si se ha pulsado el botón de envio.
			
			// --------------------------------------------- ERRORES DE IMAGEN -------------------------------------------------------------
			
			if ($_FILES['fotografia']['error'] > 0) {	// Errores de la imagen.
				$errores[]= 'Error: ' . $_FILES['fotografia']['error'] . '<br />';
				}else if(!soloImagenes($_FILES['fotografia'])) {
						$errores[]= 'Error: Tipo de fichero no aceptado <br />';
				}else if(!limiteTamanyo($_FILES['fotografia'],1024*512)){
						$errores[]='Error: El tama&ntilde;o del fichero supera los 512KB <br />';
					}


			// ------------------------------------ FILTRADO ---------------------------------------------
			

			$filtros = array('email'=> FILTER_VALIDATE_EMAIL,'comentario'=> array('filtro1' => FILTER_SANITIZE_MAGIC_QUOTES,'filtro2'=>FILTER_SANITIZE_STRING));			
			$result = filter_input_array(INPUT_POST, $filtros);
			if(array_search(false,$result,true) || array_search(NULL,$result,true) )
				$errores[]= 'Error en los datos del formulario.';
		
			// --------------------------------------------- ¿EXISTEN ERRORES? -------------------------------------------------------------
					
			if(isset($errores)){	// Si existen errores, recorremos el vector de errores.
				
				foreach ($errores as $key => $value) {

					echo"<p  class=\"error\">$value</p>";
				}
							
			}else{	// Si no hay errores. No recorremos el vector, pero si añadimos al usuario que acabamos de introducir.
				$nick = $result['email'];
				echo "<p class=\" error\">Introducido un comentario del usuario: " . "$nick" . ' y cuya foto se denomina: ' . $_FILES['fotografia']['name']. '</p><br />';

					$res = introducirComentario("localhost",$nick,$result['comentario'],$_FILES);	// Introducimos el comentario en la BD.
					if($res != true){
						echo 'Se ha producido un error introduciendo el comentario.';
					}

		}		// Se cierra isset($errores).
	
		// --------------------------------------------- COMPROBAMOS SI EXISTE EL FICHERO -------------------------------
		
	}
				echo '<h1> Comentarios registrados hasta el momento: </h1>';		

				$array = leerComentarios("localhost");	// Leemos los comentarios de la BD.
				if($array != false) mostrarComentarios($array);	// Los mostramos en pantalla.
				
			// --------------------------------------------- FORMULARIO ------------------------------------------------------------------------
		?>
		</span>
		<span class="columright">
		<fieldset>
			<legend>Introduce un nuevo comentario</legend>
		<form method="post" enctype="multipart/form-data">
		   Email: <input name="email" type="text"/>
		Fotograf&iacute;a: <input type="file" name="fotografia"  /> <br />
		<textarea name="comentario" rows=20 cols=50 >Escriba aqu&iacute; su comentario...</textarea><br />
		<input type="submit" name="envio" value="Enviar" />
		<input type="reset" name="rest" value="Restaurar" />
		</form>	
		</fieldset>
		</span>
	</body>
</html>