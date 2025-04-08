<?php
use Firebase\JWT\MeuTokenJWT;

require_once ("modelo/banco.php");
require_once ("modelo/emprestimo.php");
require_once ("modelo/MeuTokenJWT.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg": "formato incorreto"}');

$objResposta = new stdClass();
$objEmprestimo = new Emprestimo();

$headers = getallheaders(); //recuperando os headers
$authorization = $headers['Authorization']; //recuperando o token nos headers
$meuToken = new MeuTokenJWT(); //atribuindo o meu token à classe de token

//validando o meu token
if($meuToken->validarToken($authorization)==true){
    $payloadRecuperado = $meuToken->getPayload(); //recuperando payload (dados) do token
    $objResposta->token = $meuToken->gerarToken($payloadRecuperado); //gerando um novo token para que o usuário continue navegando pela aplicação

    //atualizando informações do usuário
    $objEmprestimo->setId_emprestimo_usuario($id_emprestimo_usuario);
    $objEmprestimo->setValor_emprestimo($objJson->valor_emprestimo);
    $objEmprestimo->setData_emprestimo($objJson->data_emprestimo);
    $objEmprestimo->setId_jogo($objJson->id_jogo);
    $objEmprestimo->setId_usuario( $objJson->id_usuario);

    //TODO: verificações vídeo PT 3 min 50
    //verificações padrões de atualização de usuário
    if($objEmprestimo->getValor_emprestimo()===null){
        $objResposta->cod = 1;
        $objResposta->msg = "Valor do empréstimo não pode ser vazio";
        $objResposta->status = false;
    }else{
        if($objEmprestimo->update()==true){
            $objResposta->cod = 1;
            $objResposta->msg = "Dados atualizados com sucesso";
            $objResposta->status = true;
            $objResposta->jogo = $objEmprestimo;
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