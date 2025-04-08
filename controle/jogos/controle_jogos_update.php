<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/banco.php");
require_once ("modelo/jogo.php");
require_once ("modelo/MeuTokenJWT.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg": "formato incorreto"}');

$objResposta = new stdClass();
$objJogo = new Jogo();

$headers = getallheaders(); //recuperando os headers
$authorization = $headers['Authorization']; //recuperando o token nos headers
$meuToken = new MeuTokenJWT(); //atribuindo o meu token à classe de token

//validando o meu token
if($meuToken->validarToken($authorization)==true){
    $payloadRecuperado = $meuToken->getPayload(); //recuperando payload (dados) do token
    $objResposta->token = $meuToken->gerarToken($payloadRecuperado); //gerando um novo token para que o usuário continue navegando pela aplicação

    //atualizando informações do usuário
    $objJogo->setId_jogo($id_jogo);
    $objJogo->setPreco_jogo($objJson->preco_jogo);
    $objJogo->setNome_jogo($objJson->nome_jogo);
    $objJogo->setDistribuidora_jogo( $objJson->distribuidora_jogo);
    $objJogo->setId_categoria_jogo( $objJson->id_categoria_jogo);

    //TODO: verificações vídeo PT 3 min 50
    //verificações padrões de atualização de usuário
    if($objJogo->getNome_jogo()==""){
        $objResposta->cod = 1;
        $objResposta->msg = "Nome do jogo não pode ser vazio";
        $objResposta->status = false;
    }else{
        if($objJogo->update()==true){
            $objResposta->cod = 1;
            $objResposta->msg = "Dados atualizados com sucesso";
            $objResposta->status = true;
            $objResposta->jogo = $objJogo;
        }else{
            $objResposta->cod = 2;
            $objResposta->msg = "Erro ao atualizar";
            $objResposta->status = false;
        }
    }

    header("Content-Type: application/json");

    if($objResposta->status == true){
        header("HTTP:1.1 201");
    }else{
        header("HTTP:1.1 200");
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