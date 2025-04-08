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

//verificações padrões para login
if($objUsuario->getEmail_usuario()==""){
    $objResposta->cod=1;
    $objResposta->status=false;
    $objResposta->msg="O e-mail não pode ser vazio.";
} else if($objUsuario->getSenha_usuario()==''){
    $objResposta->cod=2;
    $objResposta->status=false;
    $objResposta->msg="A senha não pode ser vazia.";
}else{
    //chamando o método de login e validando se ele retornou verdadeiro
    if($objUsuario->login()==true){
        $tokenJWT = new MeuTokenJWT(); //atribuindo o meu token à classe JWT
        $objClaimsToken = new stdClass(); //criando um objeto genérico para armazenar as informações do token

        //listando as informações desejadas no token
        $objClaimsToken->email_usuario = $objUsuario->getEmail_usuario();
        $objClaimsToken->id_usuario = $objUsuario->getId_usuario();
        $objClaimsToken->nome_usuario = $objUsuario->getNome_usuario();
        $objClaimsToken->cpf_usuario = $objUsuario->getCpf_usuario();
        $objClaimsToken->data_nascimento_usuario = $objUsuario->getData_nascimento_usuario();
        $objClaimsToken->telefone_usuario = $objUsuario->getTelefone_usuario();

        //gerando o novo token
        $novoToken = $tokenJWT->gerarToken($objClaimsToken);

        //retornando a resposta de sucesso após gerar o token
        $objResposta->cod = 3;
        $objResposta->msg = "Login efetuado com sucesso";
        $objResposta->status = true;
        $objResposta->usuario = $objUsuario;
        $objResposta->token = $novoToken;
    }else{
        //retornando a resposta de erro caso o login retorne erro
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