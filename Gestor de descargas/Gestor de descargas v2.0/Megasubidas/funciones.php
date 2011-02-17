<?php


function subeArchivo($direccion,$nombreArchivo,$descripcion,$_FILES){
		$res = false;
		$con = mysql_connect($direccion,"root","");
		
		if($con){				
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("megasubidas", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				$time = time();
				$direccion = $time.$_FILES['archivo']['name'];
				$result = mysql_query("INSERT INTO archivos(nombreArchivo,descripcion,direccion) 				values('$nombreArchivo','$descripcion','$direccion')",$con);
				if (!$result) {
					$res = false;
				}else{
					move_uploaded_file($_FILES['archivo']['tmp_name'],'archivos/'.$direccion); 
					
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

function leerArchivos($direccion){	

			$res = false;
			$con = mysql_connect($direccion,"root","");

			if($con){				
					$res = true;
			}

			if($res != false){

				$db_selected = mysql_select_db("megasubidas", $con);

				if (!$db_selected) {
					mysql_close($con);
					$res = false;
				}
				if($res != false){
					$result = mysql_query("SELECT * FROM archivos"); 				
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

function mostrarArchivos($array){
				
				while($row = mysql_fetch_array($array)){
									  echo "<table class=\"tableStyle\"><tr><th class=\"rankingletra1\">Nombre:</th><td class=\"rankingletra2\">".$row['nombreArchivo']."</td><th class=\"rankingletra1\">Descargas: </th><td class=\"rankingletra2\">".$row['descargas']."</td></tr><tr><th class=\"rankingletra1\">Descripcion:</th><td class=\"rankingletra2\">".$row['descripcion']."</td><td><form method=\"post\" action =\"descarga.php\"><input type=\"submit\" name=\"descarga\" value=\"Descargar\" /><input type=\"hidden\" name=\"direccion\" value=\"".$row['direccion']."\"/></form></td></tr></table>";
									}
	
	
}

function mostrarArchivosRanking($array){
				$cont = 1;
				while($row = mysql_fetch_array($array)){
									  echo "<table class=\"tableStyle\"><tr><th class=\"ranking\" rowspan = \"2\">TOP $cont</th><th class=\"rankingletra1\">Nombre:</th><td class=\"rankingletra2\">".$row['nombreArchivo']."</td><th class=\"rankingletra1\">Descargas: </th><td class=\"rankingletra2\">".$row['descargas']."</td></tr><tr><th class=\"rankingletra1\">Descripcion:</th><td class=\"rankingletra2\" >".$row['descripcion']."</td><td><form method=\"post\" action =\"descarga.php\"><input type=\"submit\" name=\"descarga\" value=\"Descargar\" /><input type=\"hidden\" name=\"direccion\" value=\"".$row['direccion']."\"/></form></td></tr></table>";
				$cont++;
									}
	
	
}

function anyadirDescarga($direccion,$direccionArchivo){
		$res = false;
		$con = mysql_connect($direccion,"root","");
		
		if($con){				
				$res = true;
		}
		if($res != false){

			$db_selected = mysql_select_db("megasubidas", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				$result = mysql_query("SELECT descargas from archivos WHERE direccion = '$direccionArchivo'",$con);
				if (!$result) {
					$res = false;
				}else{					
					while($row = mysql_fetch_array($result)){
						$descargas = $row['descargas']+1;
						$result2 = mysql_query("UPDATE archivos SET descargas = '$descargas' WHERE direccion = '$direccionArchivo'",$con);
						
					}

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

function obtenerRanking($direccion){

		$res = false;
		$con = mysql_connect($direccion,"root","");

		if($con){				
				$res = true;
		}

		if($res != false){

			$db_selected = mysql_select_db("megasubidas", $con);

			if (!$db_selected) {
				mysql_close($con);
				$res = false;
			}
			if($res != false){
				$result = mysql_query("SELECT * FROM archivos ORDER BY descargas DESC",$con); 				
				if (!$result) {
					$res = false;
					echo 'FALLO';
				}
			}
			mysql_close($con);

	}
	if($res != false){
		return $result;
	}else{
		return $res;
	}
}

?>
