<?php

use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/banco.php");
require_once ("modelo/categoria-jogo.php");
require_once ("modelo/MeuTokenJWT.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg": "formato incorreto"}');
$objResposta = new stdClass();
$objCategoriaJogo = new CategoriaJogo();

$headers = getallheaders(); //recuperando os headers
$authorization = $headers['Authorization']; //recuperando o token nos headers
$meuToken = new MeuTokenJWT(); //atribuindo o meu token à classe de token

if($meuToken->validarToken($authorization)==true){
    $payloadRecuperado = $meuToken->getPayload(); //recuperando payload (dados) do token
    $objResposta->token = $meuToken->gerarToken($payloadRecuperado); //gerando um novo token para que o usuário continue navegando pela aplicação

    $objCategoriaJogo->setNome_categoria_jogo( $objJson->nome_categoria_jogo);

    if($objCategoriaJogo->getNome_categoria_jogo()==""){
        $objResposta->cod = 1;
        $objResposta->msg = "Nome não pode ser vazio";
        $objResposta->status = false;
    }else{
        if($objCategoriaJogo->create()==true){
            $objResposta->cod = 1;
            $objResposta->msg = "Categoria cadastrada com sucesso";
            $objResposta->status = true;
            $objResposta->categoria = $objCategoriaJogo;
        }else{
            $objResposta->cod = 2;
            $objResposta->msg = "Erro ao cadastrar categoria";
            $objResposta->status = false;
        }
    }

    header("Content-Type: application/json");

    if($objResposta->status == true){
        header("HTTP:1.1 201");
    }else{
        header("HTTP:1.1 200");
    }

    //TODO: verificações vídeo PT 3 min 50

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