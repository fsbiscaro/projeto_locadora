<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/jogo.php");
require_once ("modelo/MeuTokenJWT.php");

$objResposta = new stdClass();
$objJogo = new Jogo();

$headers = getallheaders(); //recuperando os headers
$authorization = $headers['Authorization']; //recuperando o token nos headers
$meuToken = new MeuTokenJWT(); //atribuindo o meu token à classe de token

//validando o meu token
if($meuToken->validarToken($authorization)==true){
    $payloadRecuperado = $meuToken->getPayload(); //recuperando payload (dados) do token
    $objResposta->token = $meuToken->gerarToken($payloadRecuperado); //gerando um novo token para que o usuário continue navegando pela aplicação
    
    $objJogo->setId_jogo($id_jogo);

    if($objJogo->delete()==true){
        header("HTTP/1.1 200");
        $objResposta->code = 1;
        $objResposta->msg ="Jogo deletado com sucesso!";
        $objResposta->status = true;
    }else{
        $objResposta->code = 2;
        $objResposta->msg ="Erro ao deletar jogo!";
        $objResposta->status = false;
        header("HTTP/1.1 200");
        header("Content-Type: application/json");
    }
    echo json_encode($objResposta);
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
