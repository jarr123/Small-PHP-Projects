<html>
		<head>
			<style type="text/css">
				@import "sample.css";
			</style>
		</head>
	<body>
	</body></html>
	<?php
	@include ('funciones.php');
if(isset($_POST['puntuar'])){
	$entrada = $_POST['entrada'];
		puntuar($entrada);
		echo'<p class ="errorestitulo">Muchas gracias! Su puntuaci&oacute;n se ha introducido en el sistema. </p>';
		echo '<p class = "link"><a href="index.php" >Volver al listado general</a></p>';
	}












?>