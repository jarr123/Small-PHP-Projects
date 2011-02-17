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

?>