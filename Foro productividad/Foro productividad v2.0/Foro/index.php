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
	<h1 class ="titulo">Somos Productivos. El foro de la productividad.</h1>	
	
<?php
@include('funciones.php');
if(isset($_POST['comentar'])){
	$entrada = $_POST['entrada'];
	echo'<p class ="errorestitulo">Estos son los subtemas disponibles. Si no hay ninguno, puede crearlos en el formulario. </p>';


}else{
	
	$entrada = -1;
}
	$array = leerElementos('localhost',$entrada);
	if($array != false) mostrarTema($array);

if($entrada == -1){
	echo '<h2 class ="formulario">Desea iniciar un nuevo tema?</h2>';
}else{
	echo '<h2 class ="formulario">Desea responder?</h2>';
}
?>
<fieldset "formulario2">
		<form method="post" action="procesa.php">
			Email: <input type="text" name="email"><br /><br />
			<textarea name="descripcion" cols=60 rows = 10></textarea><br />
			<input type="hidden" name="entrada" value="<?php echo"$entrada"; ?>" />
			<input type="submit" name="envio" /><br />
			<input type="reset" name="reset" />
		</form>
		</fieldset>
		<?php
		if($entrada != -1){
			echo '<p class = "link"><a href = "index.php">Volver al listado general de temas</a></p>';
		}
		?>
</body>
</html>
