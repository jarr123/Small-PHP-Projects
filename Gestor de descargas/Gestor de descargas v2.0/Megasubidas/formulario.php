<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Formulario</title>
	<style type="text/css">
		@import "sample.css";
	</style>
</head>

<body>
	<p class="link">Formulario de subida</p>
	<fieldset>
		<form method="post" action="procesa.php" enctype="multipart/form-data">
			Nombre del fichero: <input type="text" name="nombre" /><br />
			Buscar: <input type="file" name="archivo"  /> <br />
			<textarea name="descripcion" rows = 20 cols = 50>Escriba una descripci&oacute;n del archivo...</textarea><br />
			<input type="submit" name="envio" /><br />
			<input type="reset" name="reset" />
		</form>
	</fieldset>
	<p class = "link"><a href="index.php" >Volver al index!</a></p>
</body>
</html>
