<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

$distribuidorUser = $_GET["tipo"];
$usuario = $_GET["usuario"];
//echo $usuario;


if (isset($_FILES["file"]))
{
    $file = $_FILES["file"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    $carpeta = "IMG_MEDIA/";
    $length = 10;
    
    if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif')
    {
      echo "Error, el archivo no es una imagen"; 
    }
    else
    {
        $extension = '.jpg';            
        if($tipo == 'image/jpeg'){
            $extension = '.jpeg';            
        }
        if($tipo == 'image/png'){
            $extension = '.png';            
        }
        if($tipo == 'image/gif'){
            $extension = '.gif';            
        }

        $src = $carpeta.$distribuidorUser.$usuario.$extension;
        move_uploaded_file($ruta_provisional, $src);
        echo 'http://apptablets0km.com/Backs/MAPS_API/API/' . $src;
    }
}


?>
