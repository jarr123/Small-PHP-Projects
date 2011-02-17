<?php

function soloImagenes($fichero){ 	// Comprobamos si el formato de imagen es el adecuado.
	$tiposAceptados = Array('image/gif','image/jpeg'); 
	if(array_search($fichero['type'],$tiposAceptados)===false){
			return false;
		}else{
 			return true;
		}
	}

function limiteTamanyo($fichero,$limite){ 	// Comprobamos el tamaño del fichero.
	return $fichero['size']<=$limite;
}

function leerComentarios($direccion){
		$res = false;

		$con = mysql_connect("$direccion","root","");
		
		if($con){					

			$res = true;
		}

		if($res != false){
			$db_selected = mysql_select_db("fotolog", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			
			if($res != false){

			$result = mysql_query("SELECT email,comentario,fotografia FROM comentario",$con);
			if (!$result) {
				$res = false;
						}
			}
			mysql_close($con);
			
	}
	if($res != true){
		return $res;
	}else{
		return $result;
	}

}

function mostrarComentarios($array){

	while($row = mysql_fetch_array($array)) {
		$address = 'fotografias/'.$row['fotografia'];
						 echo "<table class=\"tableStyle\"><tr><th>Email:</th><td>". $row['email']."</td><td rowspan=\"2\"><img 				src=$address height=\"100\" /></td></tr><tr><th>Comentario:</th><td>". $row['comentario']."</td></tr></table>";
						}
}

function introducirComentario($direccion,$email,$comentario,$_FILES){
			$res = false;

			$con = mysql_connect("$direccion","root","");

			if($con){				
					$res = true;
			}

			if($res != false){

				$db_selected = mysql_select_db("fotolog", $con);

				if (!$db_selected) {
					mysql_close($con);
					$res = false;
				}
				if($res != false){
					$fotografia = $_FILES['fotografia']['name'];
					$result = mysql_query("INSERT INTO comentario(email,comentario,fotografia) 				values('$email','$comentario','$fotografia')",$con);
					if (!$result) {
						$res = false;
					}else{
						
						move_uploaded_file($_FILES['fotografia']['tmp_name'],"fotografias/".$_FILES['fotografia']['name']);
			
					}
				}
				mysql_close($con);

		}
		if($res != true){
			return $res;
		}else{
			return $result;
		}

	}





?>