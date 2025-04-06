<?php

require_once ("modelo/banco.php");
require_once ("modelo/usuario.php");

$objResposta = new stdClass();
$objUsuario = new Usuario();
$objUsuario->setId_usuario($id_usuario);

$vetor = $objUsuario->readById();


if($vetor==null){
    http_response_code(404);
    $objResposta->status == false;
    echo json_encode(["erro" => "Usuário não encontrado"]);
    return null;
} else {
    $objResposta->cod = 1;
    $objResposta->status = true;
    $objResposta->msg = "Usuário desejado";
    $objResposta->usuario = $vetor;
}

header("Content-Type: application/json");

if($objResposta->status == true){
    header("HTTP:1.1 201");
}else{
    header("HTTP:1.1 200");
}

echo json_encode($objResposta);


?>