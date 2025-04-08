<?php

require_once("modelo/banco.php");
class Emprestimo implements JsonSerializable
{

    private $id_emprestimo_usuario;
    private $valor_emprestimo;
    private $data_emprestimo;
    private $id_jogo;
    private $id_usuario;

    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj->id_emprestimo_usuario = $this->getId_emprestimo_usuario();
        $obj->valor_emprestimo = $this->getValor_emprestimo();
        $obj->data_emprestimo = $this->getData_emprestimo();
        $obj->id_jogo = $this->getId_jogo();
        $obj->id_usuario = $this->getId_usuario();
 
        return $obj;
    }

    public function create(){
        //TODO: pegar horário atual para data
        $conexao = banco::get_conexao();
        $sql = 'INSERT INTO emprestimo_usuario (valor_emprestimo, data_emprestimo, id_jogo, id_usuario)VALUES(?,?,?,?)';
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("dsii",
            $this->valor_emprestimo, 
            $this->data_emprestimo, 
            $this->id_jogo,
            $this->id_usuario,
        );

        $executou = $prepareSQL->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setId_emprestimo_usuario($idCadastrado);

        return $executou;
    }

    public function delete() {
        $conexao = Banco::get_conexao();
        $sql = "delete from emprestimo_usuario where id_emprestimo_usuario=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_emprestimo_usuario);
        return $prepareSQL->execute();
    }

    public function update(){
        $conexao = Banco::get_conexao();
        $sql = "update emprestimo_usuario SET valor_emprestimo=?, data_emprestimo=?, id_jogo=?, id_usuario=? where id_emprestimo_usuario=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("dsiii", 
        $this->valor_emprestimo, 
        $this->data_emprestimo, 
        $this->id_jogo,
        $this->id_usuario,
        $this->id_emprestimo_usuario,
        );
        $executou = $prepareSQL->execute();
        return $executou;
    }

    public function readAll(){
        $conexao = Banco::get_conexao();
        $sql = "select * from emprestimo_usuario order by id_emprestimo_usuario";
        $prepareSQL = $conexao->prepare($sql);
        $executou = $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();
        $resultado = [];

        while ($tupla = $matrizTuplas->fetch_object()) {
            $resultado[] = [
                "id_emprestimo_usuario" => $tupla->id_emprestimo_usuario,
                "valor_emprestimo" => $tupla->preco_jogo,
                "data_emprestimo" => $tupla->data_emprestimo,
                "id_jogo" => $tupla->id_jogo,
                "id_usuario" => $tupla->id_usuario
            ];
        }
        
        echo json_encode($resultado, JSON_PRETTY_PRINT);
    }

    public function readById() {
        $conexao = Banco::get_conexao();
        $sql = "SELECT * FROM emprestimo_usuario WHERE id_emprestimo_usuario = ?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_emprestimo_usuario);
        $prepareSQL->execute();
    
        $matrizTuplas = $prepareSQL->get_result();
    
        if ($matrizTuplas === false) {
            return null;
        }
    
        if ($tupla = $matrizTuplas->fetch_object()) {
            return [
                "id_emprestimo_usuario" => $tupla->id_emprestimo_usuario,
                "valor_emprestimo" => $tupla->valor_emprestimo,
                "data_emprestimo" => $tupla->data_emprestimo,
                "id_jogo" => $tupla->id_jogo,
                "id_usuario" => $tupla->id_usuario
            ];
        }
    
        return null;
    }

    /**
     * Get the value of valor_emprestimo
     */ 
    public function getValor_emprestimo()
    {
        return $this->valor_emprestimo;
    }

    /**
     * Set the value of valor_emprestimo
     *
     * @return  self
     */ 
    public function setValor_emprestimo($valor_emprestimo)
    {
        $this->valor_emprestimo = $valor_emprestimo;

        return $this;
    }

    /**
     * Get the value of data_emprestimo
     */ 
    public function getData_emprestimo()
    {
        return $this->data_emprestimo;
    }

    /**
     * Set the value of data_emprestimo
     *
     * @return  self
     */ 
    public function setData_emprestimo($data_emprestimo)
    {
        $this->data_emprestimo = $data_emprestimo;

        return $this;
    }

    /**
     * Get the value of id_jogo
     */ 
    public function getId_jogo()
    {
        return $this->id_jogo;
    }

    /**
     * Set the value of id_jogo
     *
     * @return  self
     */ 
    public function setId_jogo($id_jogo)
    {
        $this->id_jogo = $id_jogo;

        return $this;
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
     * Get the value of id_emprestimo_usuario
     */ 
    public function getId_emprestimo_usuario()
    {
        return $this->id_emprestimo_usuario;
    }

    /**
     * Set the value of id_emprestimo_usuario
     *
     * @return  self
     */ 
    public function setId_emprestimo_usuario($id_emprestimo_usuario)
    {
        $this->id_emprestimo_usuario = $id_emprestimo_usuario;

        return $this;
    }
}

?>