<?php

require_once ("modelo/banco.php");
require_once ("modelo/usuario.php");
$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg": "formato incorreto"}');

$objResposta = new stdClass();
$objUsuario = new Usuario();

$objUsuario->setNome_usuario($objJson->nome_usuario);
$objUsuario->setCpf_usuario($objJson->cpf_usuario);
$objUsuario->setData_nascimento_usuario( $objJson->data_nascimento_usuario);
$objUsuario->setEmail_usuario( $objJson->email_usuario);
$objUsuario->setTelefone_usuario( $objJson->telefone_usuario);
$objUsuario->setSenha_usuario( $objJson->senha_usuario);

if($objUsuario->getNome_usuario()==""){
    $objResposta->cod = 1;
    $objResposta->msg = "Nome não pode ser vazio";
    $objResposta->status = false;
}else{
    if($objUsuario->create()==true){
        $objResposta->cod = 1;
        $objResposta->msg = "Cadastrado com sucesso";
        $objResposta->status = true;
        $objResposta->usuario = $objUsuario;
    }else{
        $objResposta->cod = 2;
        $objResposta->msg = "Erro ao cadastrar";
        $objResposta->status = false;
    }
}

header("Content-Type: application/json");

if($objResposta->status == true){
    header("HTTP:1.1 201");
}else{
    header("HTTP:1.1 200");
}

##TODO: verificações vídeo PT 3 min 50

echo json_encode($objResposta);

?>