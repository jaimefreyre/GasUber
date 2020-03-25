<?php
header('Access-Control-Allow-Origin: * ');
//header('Access-Control-Allow-Origin: "http://localhost:8100" ');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

$data = file_get_contents("puntos.json");
echo $data;

?>