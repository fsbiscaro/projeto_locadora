<?php

use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/banco.php");
require_once ("modelo/categoria-jogo.php");
require_once ("modelo/MeuTokenJWT.php");

$objResposta = new stdClass();
$objCategoriaJogo = new CategoriaJogo();

$headers = getallheaders(); //recuperando os headers
$authorization = $headers['Authorization']; //recuperando o token nos headers
$meuToken = new MeuTokenJWT(); //atribuindo o meu token à classe de token

//validando o meu token
if($meuToken->validarToken($authorization)==true){
    $payloadRecuperado = $meuToken->getPayload(); //recuperando payload (dados) do token
    $objCategoriaJogo->setId_categoria_jogo($id_categoria_jogo);
    $vetor = $objCategoriaJogo->readById();

    if($vetor==null){
        http_response_code(404);
        $objResposta->status == false;
        echo json_encode(["erro" => "Categoria nao encontrada"]);
        return null;
    } else {
        $objResposta->cod = 1;
        $objResposta->status = true;
        $objResposta->msg = "Categoria desejada";
        $objResposta->categoria = $vetor;
        $objResposta->token = $meuToken->gerarToken($payloadRecuperado); //gerando um novo token para que o usuário continue navegando pela aplicação
    }
    
    header("Content-Type: application/json");
    
    if($objResposta->status == true){
        header("HTTP:1.1 201");
    }else{
        header("HTTP:1.1 200");
    }
    
    echo json_encode($vetor);
}else{
    //retornando mensagem de token inválido caso o token não seja válido
    header("Content-Type: application/json");
    header("HTTP:1.1 401");
    $objResposta->code = 2;
    $objResposta->msg ="Token inválido!";
    $objResposta->status = false;
    echo json_encode($objResposta);
}

?>