<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		@import "sample.css";
	</style>
	<title>Liga Comunio</title>	
	<?php
	@include('funciones.php');
	if(isset($_POST['envio'])){	// Si se ha pulsado el botón de envio.
	
			if($_POST['equipos'] == ""){
				
				$errores[]= 'No ha introducido nada en el campo "equipos"';
				
			}
			if($_POST['liga'] == ""){
				
				$errores[]= 'No ha introducido nada en el campo "liga"';
				
			}
		
			$args = array(  
				'equipos'		=> FILTER_VALIDATE_INT,
				'liga'	=> FILTER_SANITIZE_MAGIC_QUOTES,	// Añadimos protección contra injecciones.
				);

			$myinputs = filter_input_array(INPUT_POST, $args);

			if(array_search(false,$myinputs,true) || array_search(NULL,$myinputs,true)){
				$errores[]= 'Error en los datos del formulario.';
			}
	
				if(!isset($errores)){
					$liga = filter_var($myinputs['liga'],FILTER_SANITIZE_STRING);	// Eliminamos las etiquetas html.
					mostrarformularioEquipos($myinputs['equipos'],$liga);

				}

	
	
	}elseif(isset($_POST['envioEquipos'])){
		
		$equipos = $_POST['equipos'];
		$liga = $_POST['liga'];
		
		for ($i=0; $i < $equipos ; $i++) { 
			$valor = $_POST[$i];
			if($valor == ""){
				
				$errores[]= 'No ha introducido nada en el campo "equipos" numero '.$i;
				
			}else{
				$valor = filter_var($valor,FILTER_SANITIZE_STRING);
				$valor = filter_var($valor, FILTER_SANITIZE_MAGIC_QUOTES);   
			}

				$vector[] = $valor;

					
			
		}
		
		if(!isset($errores)){
				$res1 = almacenaLiga('localhost',$liga);
				$res2 = almacenaEquipos('localhost',$liga,$vector);
				echo '<p class="errores">Enhorabuena! Ha introducido todos los equipos correctamente!';
				echo '<h2>Pulse <a href="index.php">aqu&iacute;</a> para volver a la p&aacute;gina principal</h2>';
		}

	
	}else{
	
	?>
	
</head>

<body>
	<h1>Bienvenido a la liga Comunio.</h1>
	<h2>Por favor, introduzca el numero de equipos que desea tener.</h2>
	<fieldset>
		<form method="post" action="formulario.php">
			Nombre de la liga:<input type="text" name="liga"><br />
			Numero de equipos: <input type="text" name="equipos"><br />
			<input type="hidden" name="oculto" value="nombreLiga"><br />
			<input type="submit" name="envio" /><br />
			<input type="reset" name="reset" /><br />
		</form>
	</fieldset>
	<h2>Desea volver al men&uacute; principal?. Pulse <a href="index.php">Aqu&iacute;</a></h2>
<?php

}
if(isset($errores)){	// Si ha habido errores en el documento.
	
echo'<p class ="errorestitulo">Se han producido los siguientes errores: </p>';
		foreach ($errores as $key => $value) {
			echo"<p  class=\"errores\">$value</p>";
		}
}
?>
</body>
</html>
