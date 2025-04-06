<?php
    class banco{
        private static $host= '127.0.0.1';
        private static $port= 3306;

        private static $user= 'root';

        private static $pass= '';

        private static $db= 'locadora_jogos';

        private static $conexao= null;

        private static $pwd= '';


        private static function conectar(){
            error_reporting(E_ERROR | E_PARSE);
            if(banco::$conexao==null){
                banco::$conexao=new mysqli(banco::$host, banco::$user, banco::$pwd, banco::$db, banco::$port);
                if(banco::$conexao->connect_error){

                    $objResposta = new stdClass();
                    $objResposta-> cod = 1;
                    $objResposta->msg = "Erro ao conectar no banco";
                    $objResposta->erro = banco::$conexao->connect_error;

                    die(json_encode($objResposta));
            }

        }
    }

    public static function get_conexao(){
        if(banco::$conexao==null){
            banco::conectar();
        }
        return banco::$conexao;
    }
}