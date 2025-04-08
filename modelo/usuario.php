<?php

require_once("modelo/banco.php");
class Usuario implements JsonSerializable
{

    private $id_usuario;
    private $nome_usuario;
    private $cpf_usuario;
    private $data_nascimento_usuario;
    private $email_usuario;
    private $telefone_usuario;
    private $senha_usuario;

    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj->id_usuario = $this->getId_usuario();
        $obj->nome_usuario = $this->getNome_usuario();
        $obj->cpf_usuario = $this->getCpf_usuario();
        $obj->data_nascimento_usuario = $this->getData_nascimento_usuario();
        $obj->email_usuario = $this->getEmail_usuario();
        $obj->telefone_usuario = $this->getTelefone_usuario();
        $obj->senha_usuario = $this->getSenha_usuario();
 
        return $obj;
    }
    public function create(){
        $conexao = banco::get_conexao();
        $sql = 'INSERT INTO usuario (nome_usuario, cpf_usuario, data_nascimento_usuario, email_usuario, telefone_usuario, senha_usuario)VALUES(?,?,?,?,?,MD5(?))';
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("ssssis", 
            $this->nome_usuario, 
            $this->cpf_usuario, 
            $this->data_nascimento_usuario, 
            $this->email_usuario, 
            $this->telefone_usuario, 
            $this->senha_usuario
        );

        $executou = $prepareSQL->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setId_usuario($idCadastrado);

        return $executou;
    }

    public function verifyEmail($email):bool{
        $conexao = banco::get_conexao();
        $sql = 'SELECT email_usuario FROM usuario WHERE email_usuario = ?';
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("s", $email);
        $prepareSQL->execute();
    
        $prepareSQL->bind_result($resultadoEmail);
    
        if ($prepareSQL->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $conexao = Banco::get_conexao();
        $sql = "delete from usuario where id_usuario=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_usuario);
        return $prepareSQL->execute();
    }

    public function update(){
        $conexao = Banco::get_conexao();
        $sql = "update usuario SET nome_usuario=?, cpf_usuario=?, data_nascimento_usuario=?, email_usuario=?, telefone_usuario=?, senha_usuario=? where id_usuario=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("ssssisi", 
            $this->nome_usuario, 
            $this->cpf_usuario, 
            $this->data_nascimento_usuario, 
            $this->email_usuario, 
            $this->telefone_usuario, 
            $this->senha_usuario,
            $this->id_usuario
        );
        return $prepareSQL->execute();
    }

    public function readAll(){
        $conexao = Banco::get_conexao();
        $sql = "select * from usuario order by id_usuario";
        $prepareSQL = $conexao->prepare($sql);
        $executou = $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();
        $resultado = [];

        while ($tupla = $matrizTuplas->fetch_object()) {
            $resultado[] = [
                "id_usuario" => $tupla->id_usuario,
                "nome_usuario" => $tupla->nome_usuario,
                "cpf_usuario" => $tupla->cpf_usuario,
                "data_nascimento_usuario" => $tupla->data_nascimento_usuario,
                "email_usuario" => $tupla->email_usuario,
                "telefone_usuario" => $tupla->telefone_usuario,
                "senha_usuario" => $tupla->senha_usuario
            ];
        }
        
        echo json_encode($resultado, JSON_PRETTY_PRINT);
    }

    public function readById(){
        $conexao = Banco::get_conexao();
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_usuario);
        $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();
    
        if ($tupla = $matrizTuplas->fetch_object()) {
            $resultado = [
                "id_usuario" => $tupla->id_usuario,
                "nome_usuario" => $tupla->nome_usuario,
                "cpf_usuario" => $tupla->cpf_usuario,
                "data_nascimento_usuario" => $tupla->data_nascimento_usuario,
                "email_usuario" => $tupla->email_usuario,
                "telefone_usuario" => $tupla->telefone_usuario,
                "senha_usuario" => $tupla->senha_usuario
            ];
            return $resultado;
        }
    }

    public function login(){
        $conexao = Banco::get_conexao();
        $sql = "select COUNT(*) AS qtd, id_usuario, nome_usuario, cpf_usuario, data_nascimento_usuario, email_usuario, telefone_usuario FROM usuario WHERE email_usuario=? AND senha_usuario=MD5(?)";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("ss",
        $this->email_usuario, 
        $this->senha_usuario,
        );
        $executou = $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();


        while($tupla = $matrizTuplas->fetch_object()) {
            if($tupla->qtd==1){
                $this->setId_usuario($tupla->id_usuario);
                $this->setNome_usuario($tupla->nome_usuario);
                $this->setCpf_usuario($tupla->cpf_usuario);
                $this->setData_nascimento_usuario($tupla->data_nascimento_usuario);
                $this->setEmail_usuario($tupla->email_usuario);
                $this->setTelefone_usuario($tupla->telefone_usuario);
                return true;
            }
        }
        return false;
    }

    /**
     * Get the value of id_usuario
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of nome_usuario
     */
    public function getNome_usuario()
    {
        return $this->nome_usuario;
    }

    /**
     * Set the value of nome_usuario
     *
     * @return  self
     */
    public function setNome_usuario($nome_usuario)
    {
        $this->nome_usuario = $nome_usuario;

        return $this;
    }

    /**
     * Get the value of cpf_usuario
     */
    public function getCpf_usuario()
    {
        return $this->cpf_usuario;
    }

    /**
     * Set the value of cpf_usuario
     *
     * @return  self
     */
    public function setCpf_usuario($cpf_usuario)
    {
        $this->cpf_usuario = $cpf_usuario;

        return $this;
    }

    /**
     * Get the value of data_nascimento_usuario
     */
    public function getData_nascimento_usuario()
    {
        return $this->data_nascimento_usuario;
    }

    /**
     * Set the value of data_nascimento_usuario
     *
     * @return  self
     */
    public function setData_nascimento_usuario($data_nascimento_usuario)
    {
        $this->data_nascimento_usuario = $data_nascimento_usuario;

        return $this;
    }

    /**
     * Get the value of email_usuario
     */
    public function getEmail_usuario()
    {
        return $this->email_usuario;
    }

    /**
     * Set the value of email_usuario
     *
     * @return  self
     */
    public function setEmail_usuario($email_usuario)
    {
        $this->email_usuario = $email_usuario;

        return $this;
    }

    /**
     * Get the value of telefone_usuario
     */
    public function getTelefone_usuario()
    {
        return $this->telefone_usuario;
    }

    /**
     * Set the value of telefone_usuario
     *
     * @return  self
     */
    public function setTelefone_usuario($telefone_usuario)
    {
        $this->telefone_usuario = $telefone_usuario;

        return $this;
    }

    /**
     * Get the value of senha_usuario
     */
    public function getSenha_usuario()
    {
        return $this->senha_usuario;
    }

    /**
     * Set the value of senha_usuario
     *
     * @return  self
     */
    public function setSenha_usuario($senha_usuario)
    {
        $this->senha_usuario = $senha_usuario;

        return $this;
    }
}



?>