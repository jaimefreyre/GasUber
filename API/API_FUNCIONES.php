<?php
//BACKUP DE FUNCIONES
//FUNCION RECUPERO DE LOS VALORES PASADOS POR POST 
//Recupero los datos enviados por POST
//$datosEntrega = file_get_contents("php://input");
//$request = json_decode($datosEntrega);
//print_r($request);
//require('mailer/PHPMailerAutoload.php');

function backDatos(){
	$datosEntrega = file_get_contents("php://input");
	$request = json_decode($datosEntrega);
	return $request;
};
function busqe($coneccion, $tabla, $filawhere, $parametrodebusqueda){
	$devolver = "SELECT * FROM ".$tabla." WHERE ".$filawhere." = '". $parametrodebusqueda ."';";
	$coneccion->query("SET NAMES 'utf8'");
	$es = $coneccion->query($devolver);
	return $es;
}
function procesarRespuesta($tipo, $respuestaMysql){
	$eturno = array();
	while($r = $respuestaMysql->fetch_object()){
		array_push($eturno, $r);
	}
	if ($tipo == 'json'){$completa2 = json_encode($eturno, 128);}
	else{$completa2 = $eturno;}
	return $completa2;
}
function inJson($tabla, $preguntaporextender, $obj1, $obj2){
	/*Aplican las claves*/
	$insertar = "INSERT INTO ". $tabla ."  ( ";
	foreach ($obj1 as $key => $value) {$insertar .= $key .', ';}
	if ($preguntaporextender == 'extender'){
		foreach ($obj2 as $key => $value) {
			$insertar .= $key .', ';
		}
		$insertar = rtrim($insertar, ", ");
	}
	else{$insertar = rtrim($insertar, ", ");}
	/*Aplican los valores*/
	$insertar .= ") VALUES ( ";
	foreach ($obj1 as $key => $value){$insertar .= '"' .$value .'", ';}
	if ($preguntaporextender == 'extender'){
		foreach ($obj2 as $key => $value) {
			$insertar .= '"' .$value .'", ';
		}
		$insertar = rtrim($insertar, ", ");	
	}
	else{$insertar = rtrim($insertar, ", ");}
	/*cierra la clausula*/
	$insertar .= ');';
	return $insertar;
}
function inJsonTipado($tabla, $preguntaporextender, $obj1, $obj2){
	/*Aplican las claves*/
	$insertar = "INSERT INTO ". $tabla ."  ( ";
	foreach ($obj1 as $key => $value) {$insertar .= $key .', ';}
	if ($preguntaporextender == 'extender'){
		foreach ($obj2 as $key => $value) {
			$insertar .= $key .', ';
		}
		$insertar = rtrim($insertar, ", ");
	}
	else{$insertar = rtrim($insertar, ", ");}
	/*Aplican los valores*/
	$insertar .= ") VALUES ( ";
	foreach ($obj1 as $key => $value){
		switch ($value){
			case is_int($value):
			$insertar .= ' ' .$value .', ';
			break;
			case is_float($value):
			$insertar .= '' .$value .', ';
			break;
			case is_numeric($value):
			$insertar .= '' .$value .', ';
			break;
			default:
			$insertar .= '"' .$value .'", ';
			break;
		};
	}
	if ($preguntaporextender == 'extender'){
		foreach ($obj2 as $key => $value) {
			$insertar .= '"' .$value .'", ';
		}
		$insertar = rtrim($insertar, ", ");	
	}
	else{$insertar = rtrim($insertar, ", ");}
	/*cierra la clausula*/
	$insertar .= ');';
	return $insertar;
}
function insertarOne($CX, $tabla, $request, $fecha){
	//Rastreamos los nombres de la columna a la que agregamos registros
	$CX->query("SET NAMES 'utf8'"); 
	$R1 = $CX->query('SHOW COLUMNS FROM ' . $tabla);
	$R2 = array();
	if ($R1){while ($r = $R1->fetch_object()) {
			array_push($R2, $r);
		}
	}
	else{
		echo 'No se recuPeraron los nombres de los campo de la Tabla ' . $tabla;
	}
	//Seteo correctamente el valor de como conocio
	//print_r($request[0][8]);
	//$request[0][8] =  implode(', ', $request[0][8]);
	//print_r($request[0][8]);
	//Crea la consulta para insertar info pasada por post
	$pista = 'INSERT INTO ' . $tabla .' ('; 
	foreach ($R2 as $key => $value) {
		$pista .= '';$pista .= $value->Field;$pista .=',';
	};
	//__INTEGRA LA FUNCION FECHA DE RGISTRO
	$pista = substr($pista, 0, -1);
	$pista.= ') VALUES ( null,';
	//echo $pista;
	//ITERA EL REQUEST Y LO AGREGA A LA SENTENCIA SQL DE INTERACCION CON LA TABLA
	foreach ($request as $key => $value) {
		$pista .= '"';
		$pista .= $value;
		$pista .= '"';
		$pista .=',';
	}
	// ___INTEGRA LA FUNCION FECHA DE RGISTRO
	$vg = end($R2);
	if( $vg->Field == 'FECHA'){
		$fcha = date('Y-m-d');
		//BORRA substr($pista, 0, -1) 
		$pista .=  '"';
		$pista .= ' '.$fcha.' " );';
	}
	else{
		$pista = substr($pista, 0, -1);
		$pista .=  ');';
	}
	echo $pista;
	$CX->query("SET NAMES 'utf8'"); 
	$CX->query($pista);
	$ultimoID = $CX->insert_id;
	$CX->close();
	return $ultimoID;
}
function buscarUsuario($CX, $tabla, $EMAIL, $PASSWORD, $ID){
	//Sentencia a crear en la consulta  que devuelva los valores coincidentes
	if($ID){
		$pista = "SELECT * FROM ".$tabla." WHERE (ID = '".$ID."');";
		$CX->query("SET NAMES 'utf8'"); 
		$resultado = $CX->query($pista);
		$todos = array();
		while($r = $resultado->fetch_object()){array_push($todos, $r);};
		$completa = json_encode($todos, 128);
		$CX->close();
		return $completa;
	}
	else{
		$pista = "SELECT * FROM ".$tabla." WHERE (EMAIL = '".$EMAIL."');";
		$CX->query("SET NAMES 'utf8'"); 
		$resultado = $CX->query($pista);
		$todos = array();
	    while($r = $resultado->fetch_object()){array_push($todos, $r);};
	    if( password_verify($PASSWORD, $todos[0]->PASSWORD) ) {
			$todos->PASSWORD = "CHUPALAAAAA";
		    $completa = json_encode($todos, 128);
		    $CX->close();
		    return $completa;
	    }else{
	    	echo 'La contraseña y/o el usuario no son validos.';
	    }

	}

}
function actualizarTipado($tabla, $objActualiza, $objReferencia){
	$pista = "UPDATE ".$tabla." SET ";
	$cc = 0;
	foreach ($objActualiza as $key => $value) {
		if($cc > 0){
			$pista.= ", ";
		}
		switch ($value){
			case is_string($value):
				$pista.= $key." = ' ".$value. "' ";  
			break;
			case is_numeric($value):
				$pista.= $key." = ".$value;  
			break;
			default:
				$pista.= $key." = ' ".$value. "' ";  
			break;
		}
		$cc++;
	};

	//. WHERE idregistro = '$idregistro' AND dia = '$dia'"
	$pista = rtrim($pista, ", ");
	$pista .= " WHERE ";
	$cc = 0;
	foreach ($objReferencia as $key => $value) {
		if($cc > 0){
			$pista.= "AND ";
		}
		switch ($value){
			case is_string($value):
				$pista.= $key." = ' ".$value. "' ";  
			break;
			case is_numeric($value):
				$pista.= $key." = ".$value . " ";  
			break;
			default:
				$pista.= $key." = ' ".$value. "' ";  
			break;
		};
		$cc++;
	};
	$pista = rtrim($pista, "AND ");
	print_r($pista);
	print_r('<br>');

}
?>