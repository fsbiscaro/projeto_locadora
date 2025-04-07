<?php
require_once ("modelo/banco.php");
require_once ("modelo/usuario.php");
require_once ("modelo/MeuTokenJWT.php");

use Firebase\JWT\MeuTokenJWT;

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg": "formato incorreto"}');
$objResposta = new stdClass();
$objUsuario = new Usuario();

$objUsuario->setEmail_usuario( $objJson->usuario->email_usuario);
$objUsuario->setSenha_usuario( $objJson->usuario->senha_usuario);

if($objUsuario->getEmail_usuario()==""){
    $objResposta->cod=1;
    $objResposta->status=false;
    $objResposta->msg="O e-mail não pode ser vazio.";
} else if($objUsuario->getSenha_usuario()==''){
    $objResposta->cod=2;
    $objResposta->status=false;
    $objResposta->msg="A senha não pode ser vazia.";
}else{
    if($objUsuario->login()==true){
        $tokenJWT = new MeuTokenJWT();
        $objClaimsToken = new stdClass();
        $objClaimsToken->email_usuario = $objUsuario->getEmail_usuario();
        $objClaimsToken->id_usuario = $objUsuario->getId_usuario();
        $objClaimsToken->nome_usuario = $objUsuario->getNome_usuario();
        $objClaimsToken->cpf_usuario = $objUsuario->getCpf_usuario();
        $objClaimsToken->data_nascimento_usuario = $objUsuario->getData_nascimento_usuario();
        $objClaimsToken->telefone_usuario = $objUsuario->getTelefone_usuario();
        $novoToken = $tokenJWT->gerarToken($objClaimsToken);
        $objResposta->cod = 3;
        $objResposta->msg = "Login efetuado com sucesso";
        $objResposta->status = true;
        $objResposta->usuario = $objUsuario;
        $objResposta->token = $novoToken;
    }else{
        $objResposta->cod = 4;
        $objResposta->msg = "Erro ao efetuar o login.";
        $objResposta->status = false;
    }
}

#TODO: adicionar validações de login :D

header("Content-Type: application/json");

if($objResposta->status == true){
    header("HTTP:1.1 200");
}else{
    header("HTTP:1.1 401");
}

echo json_encode($objResposta);

?>