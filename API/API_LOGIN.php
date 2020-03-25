<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

//Creo el valor de fecha actual requerido en varias funciones
$fecha = date("Y-m-d");

//Ingreso la conexion
require("CX.php");
require("API_FUNCIONES.php");

//Testeo la conexion
if ($CX->connect_error){die('Problemas con la conexion a la base de datos');}
else{
	//Recupero la funcion enviada por Get
	$key = $_REQUEST['key'];
	//Organizo el selector de Funciones
	$post_data = file_get_contents("php://input");
 	$request = json_decode($post_data);
		switch ($key) {
		    //http://simsa.com.ec/API/API_LOGIN.php?key=crear_usuario&tipoUsario=(cliente o distribuidor)
		    case 'crear_usuario':
				$tipoUsuario = $_REQUEST['tipoUsuario'];
				$tipoUsuario = (string) $tipoUsuario;
				$request->PASSWORD = password_hash($request->PASSWORD, PASSWORD_DEFAULT);
				//print_r($request);
				$pista = inJson($tipoUsuario, false, $request, false);
				print_r($pista);
				$CX->query("SET NAMES 'utf8'"); 
				$CX->query($pista);
				$ultimoID = $CX->insert_id;
				$CX->close();
				echo $ultimoID;
		    break;
		    
		    //http://simsa.com.ec/API/API_LOGIN.php?key=leer_usuario
		    case 'leer_usuario':
		    	$tipoUsuario = $_REQUEST['tipoUsuario'];
				$tipoUsuario = (string) $tipoUsuario;
				if($request->ID){
					print_r( buscarUsuario($CX, $tipoUsuario, false, false, $request->ID) );
		    	}
		    	else{
				print_r( buscarUsuario($CX, $tipoUsuario, $request->EMAIL, $request->PASSWORD, false) );
				}
		    break;
		    
		    //http://simsa.com.ec/API/API_LOGIN.php?key=borrar_usuario
		    case 'borrar_usuario':
		    break;
		    
		    //http://simsa.com.ec/API/API_LOGIN.php?key=actualizar_usuario
		    case 'actualizar_usuario':
		    break;
		    
		    //http://simsa.com.ec/API/API_LOGIN.php?key=inicio_sesion
		    case 'inicio_sesion':
		    break;
		    
		    //http://simsa.com.ec/API/API_LOGIN.php?key=cierre_sesion
		    case 'cierre_sesion':
		    break;
		    
		    //http://simsa.com.ec/API/API_LOGIN.php
		    default:
		    	echo 'Hello Money';
		    break;
		};
	}
?>