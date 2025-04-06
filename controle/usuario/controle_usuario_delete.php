<?php

require_once ("modelo/usuario.php");

$objResposta = new stdClass();
$objUsuario = new Usuario();

$objUsuario->setId_usuario($id_usuario);

if($objUsuario->delete()==true){
    header("HTTP/1.1 204");
}else{
    header("HTTP/1.1 200");
    header("Content-Type: application/json");
}
?>