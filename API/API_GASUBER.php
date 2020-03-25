<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

//Creo el valor de fecha actual requerido en varias funciones
$fecha = date("Y-m-d");

//Ingreso la conexion
require("CX.php");
require("API_FUNCIONES.php");
require("API_CLASES.php");



//Testeo la conexion
if ($CX->connect_error){die('Problemas con la conexion a la base de datos');}
else{
	//Recupero la funcion enviada por Get
	$key = $_REQUEST['key'];
	//Organizo el selector de Funciones
	$post_data = file_get_contents("php://input");
 	$request = json_decode($post_data);
		switch ($key) {
	    //http://simsa.com.ec/API/API_GASUBER.PHP?key=crear_oferta
	    case 'crear_oferta':
	    	if( isset($request) ){

			$pista = inJsonTipado("direcciones", false, $request->DIRECCION, false);
			//print_r($pista);
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);
			$request->DIRECCION = $CX->insert_id; 
			
			$d = $request->PEDIDO;
			unset($request->PEDIDO);
			$request->FECHA = $fecha;
			$request->HORA = time();
			
			$pista = inJsonTipado("ofertas", false, $request, false);
			//print_r($pista);
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);
			$ultimoID = $CX->insert_id;
			
			print_r($CX->insert_id);

			$estado = new stdClass();
			$estado->IDOFERTA = $ultimoID;
			$estado->ESTADO = 1;
			$pista_estado = inJsonTipado("estados", false, $estado, false);
			//print_r($pista_estado);
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista_estado);

			
			$pedidos_w = new clasePedido($d[0], $d[1], $ultimoID);
			$pista = inJsonTipado("pedidos", false, $pedidos_w, false);
			
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);

			
			$CX->close();
		}else{
			echo 'Thankiu';
		}
		break;
	    
		//http://simsa.com.ec/API/API_GASUBER.php?key=cancelar_estado&IDS=
		case 'cancelar_estado':
			$IDS = $_REQUEST['IDS'];
			$pista = 'UPDATE estados SET ESTADO = 0 WHERE IDOFERTA = '.$IDS.';';
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);
			$CX->close();
		break;
	    
	    //Aceptar Oferta
		//http://simsa.com.ec/API/API_GASUBER.php?key=aceptar_oferta&IDS= &ID_MIO=
	    case 'aceptar_oferta':
			$IDS = $_REQUEST['IDS'];
			$ID_MIO = $_REQUEST['ID_MIO'];
			$pista = 'UPDATE estados SET ESTADO = 2 WHERE IDOFERTA = '.$IDS.';';
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);

			$pista = 'UPDATE ofertas SET DISTRIBUIDOR = '.$ID_MIO.' WHERE ID = '.$IDS.';';
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);

			$pista = 'INSERT gps (DISTRIBUIDORES) Values ('.$ID_MIO.');';
			$CX->query("SET NAMES 'utf8'"); 
			$CX->query($pista);



			
			$CX->close();
		break;

	    //http://simsa.com.ec/API/API_GASUBER.php?key=seguimiento_oferta
	    case 'seguimiento_oferta':
	    	$IDS = $_REQUEST['IDS'];
			$p = "SELECT ESTADO FROM estados WHERE IDOFERTA = ".$IDS." LIMIT 1;";
			
			$CX->query("SET NAMES 'utf8'");
			$resultado = $CX->query($p);
			$todos = array();
		
			while($r = $resultado->fetch_object()){array_push($todos, $r);};
			print_r($todos[0]->ESTADO);

			$CX->close();
		break;
	    
	    //http://simsa.com.ec/API/API_GASUBER.php?key=ofertas_disponibles
		case 'ofertas_disponibles':
		$p = "SELECT ofertas.ID, ofertas.PRECIO, ES.ESTADO, clientes.NOMBRE, clientes.TELEFONO, direcciones.LATITUD, direcciones.LONGITUD, direcciones.NOMBRE AS 'D_NOMBRE', COUNT(pedidos.P1) AS 'G1', COUNT(pedidos.P2) AS 'G2' FROM direcciones, ofertas, clientes, pedidos, estados AS ES WHERE (ES.IDOFERTA = ofertas.ID) AND (ES.ESTADO = 1) AND (clientes.ID = ofertas.CLIENTE) AND (direcciones.ID = ofertas.DIRECCION) AND (pedidos.OFERTA = ofertas.ID);";
	
			$CX->query("SET NAMES 'utf8'");
			$resultado = $CX->query($p);
			
			$todos = array();
			while($r = $resultado->fetch_object()){array_push($todos, $r);};
			$completa = json_encode($todos, 128);
			
			print_r($completa);
			$CX->close();
		break;



	    //http://simsa.com.ec/API/API_GASUBER.php?key=leer_GPS
	    case 'leer_Distribuidor':
	        $IDS = $_REQUEST['IDS'];
		    $p = "SELECT distribuidores.ID, distribuidores.NOMBRE, distribuidores.TELEFONO, distribuidores.DNI FROM ofertas, distribuidores WHERE (ofertas.DISTRIBUIDOR = distribuidores.ID) AND (ofertas.ID = ".$IDS.") LIMIT 1;";
			$CX->query("SET NAMES 'utf8'");
			$resultado = $CX->query($p);
			$todos = array();
			while($r = $resultado->fetch_object()){array_push($todos, $r);};
			$completa = json_encode($todos, 128);
			print_r($completa);
			$CX->close();
	    break;
	    //http://simsa.com.ec/API/API_GASUBER.php?key=leer_GPS
	    case 'leer_GPS':
		    $IDS = $_REQUEST['IDS'];
		    $p = "SELECT * FROM gps WHERE DISTRIBUIDORES = ".$IDS." LIMIT 1;";
			$CX->query("SET NAMES 'utf8'");
			$resultado = $CX->query($p);
				
			$todos = array();
			while($r = $resultado->fetch_object()){array_push($todos, $r);};
			$completa = json_encode($todos, 128);

			print_r($completa);
			$CX->close();
		break;

	    //http://simsa.com.ec/API/API_GASUBER.php?key=seguimiento_oferta
	    case 'seguimiento_GPS':
	    $pista = 'UPDATE gps SET LAT='.$request->LATITUD.', LNG='.$request->LONGITUD.' WHERE DISTRIBUIDORES = '.$request->DISTRIBUIDORES.' ;';
	    print_r($pista);
		$CX->query("SET NAMES 'utf8'");
		$resultado = $CX->query($pista);
		$CX->close();
		break;
	    
	    //http://simsa.com.ec/API/API_GASUBER.PHP
	    default:
		    echo 'Claves y Conexiones a base de dato correctas';
		    print_r($request);
		break;
	}
}
?>





