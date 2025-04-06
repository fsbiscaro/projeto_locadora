<?php

require_once ("modelo/banco.php");
require_once ("modelo/usuario.php");
$objResposta = new stdClass();
$objUsuario = new Usuario();
$objUsuario->readAll();

header("Content-Type: application/json");

if($objResposta->status == true){
    header("HTTP:1.1 201");
}else{
    header("HTTP:1.1 200");
}

echo json_encode($objResposta);


?>