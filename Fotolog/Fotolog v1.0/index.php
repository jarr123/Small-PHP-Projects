<?php
require("ej5_funciones.php");	// Importamos las funciones.
?>


<html>
	<head>
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
			

			$filtros = Array ('email'=> FILTER_VALIDATE_EMAIL,'comentario'=> array('filtro1' => FILTER_SANITIZE_MAGIC_QUOTES,'filtro2'=>FILTER_SANITIZE_STRING));			
			$result = filter_input_array(INPUT_POST, $filtros);
			if(array_search(false,$result,true) || array_search(NULL,$result,true) )
				$errores[]= 'Error en los datos del formulario.';
		
			// --------------------------------------------- ¿EXISTEN ERRORES? -------------------------------------------------------------
					
			if(isset($errores)){	// Si existen errores, recorremos el vector de errores.
				
				foreach ($errores as $key => $value) {

					echo"<p  style=\" border:red solid 1px; padding: 2em; color:red;\">$value</p>";
				}
							
			}else{	// Si no hay errores. No recorremos el vector, pero si añadimos al usuario que acabamos de introducir.
				$nick = $result['email'];
				echo "<p style=\" border:red solid 1px; padding: 2em; color:red;\">Introducido un comentario del usuario: " . "$nick" . ' y cuya foto se denomina: ' . $_FILES['fotografia']['name']. '</p><br />';
					
					$f = fopen('registro.txt','a');		// Abrimos el archivo y añadimos.
					
					if($f){	// Si no se han producido errores.
						
						flock($f,LOCK_EX);	// Bloqueamos.
						$nombre = "fotografias/" . $_FILES['fotografia']['name'];	// Dirección en la que se va guardar la foto.
						$comentario = $result['comentario']; 	// Calcular hora actual.
						fwrite($f,"$nick"."\t$nombre\t $comentario\n");	// Escribimos en el archivo.
						flock($f,LOCK_UN); 	// Desbloqueamos.
						fclose($f); 	// Cerramos el fichero.
						move_uploaded_file($_FILES['fotografia']['tmp_name'],$nombre); 	// Movemos el archivo hacia la dirección propuesta anteriormente.
						
					}else{	// Si se han producido errores...
						
						echo 'ERROR: No puedo escribir en el archivo';
					}

		}		// Se cierra isset($errores).

		
		}
		// --------------------------------------------- COMPROBAMOS SI EXISTE EL FICHERO -------------------------------
		
		
			if(file_exists("registro.txt") == False){	// Si NO existe...

				echo "<p style=\" border:red solid 1px; padding: 2em; color:red;\">El fichero no existe por el momento, por lo tanto no existe ning&uacute;n comentario registrado.</p>";
				
			}else{	// Si existe....
				
				echo '<h1> Comentarios registrados hasta el momento: </h1>';		
					// Visualizamos ahora los perfiles introducidos. Leemos el archivo.
					$cont = 0;	// Contador que va a llevar el recuento de los usuarios. Lo utilizaremos para el borrado.
					$f = fopen("registro.txt",'r');	// Leemos el archivo.
					if($f){
						flock($f,LOCK_SH);	// Bloqueamos.
						$perfiles = fgetcsv($f,999,"\t"); 	// Leemos el archivo y lo guardamos en un array.
						while(!feof($f)){
							$cont += 1;	
							 echo "<table class=\"tableStyle\"><tr><th>Email:</th><td> $perfiles[0]</td><td rowspan=\"2\"><img src=$perfiles[1] height=\"100\" /></td></tr><tr><th>Comentario:</th><td> $perfiles[2]</td></tr></table>";
							
							$perfiles = fgetcsv($f,999,"\t");

				}
				flock($f,LOCK_UN); 	// Desbloqueamos.
				fclose($f);	// Cerramos el archivo.
				
			}else{	// Si no se ha abierto correctamente...

					echo "No hay acceso al archivo";
				}
			}
		
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