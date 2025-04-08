<?php

require_once("modelo/banco.php");
class CategoriaJogo implements JsonSerializable
{

    private $id_categoria_jogo;
    private $nome_categoria_jogo;

    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj->id_jogo = $this->getId_categoria_jogo();
        $obj->nome_categoria_jogo = $this->getNome_categoria_jogo();
 
        return $obj;
    }
    public function create(){
        $conexao = banco::get_conexao();
        $sql = 'INSERT INTO categoria_jogo (nome_categoria_jogo)VALUES(?)';
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("s",
            $this->nome_categoria_jogo,
        );

        $executou = $prepareSQL->execute();
        $idCadastrado = $conexao->insert_id;
        $this->getId_categoria_jogo($idCadastrado);

        return $executou;
    }

    public function delete() {
        $conexao = Banco::get_conexao();
        $sql = "delete from categoria_jogo where id_categoria_jogo=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_categoria_jogo);
        return $prepareSQL->execute();
    }

    public function update(){
        $conexao = Banco::get_conexao();
        $sql = "update categoria_jogo SET nome_categoria_jogo=? where id_categoria_jogo=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("si",
            $this->nome_categoria_jogo, 
            $this->id_categoria_jogo
        );
        $executou = $prepareSQL->execute();
        return $executou;
    }

    public function readAll(){
        $conexao = Banco::get_conexao();
        $sql = "select * from categoria_jogo order by id_categoria_jogo";
        $prepareSQL = $conexao->prepare($sql);
        $executou = $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();
        $resultado = [];

        while ($tupla = $matrizTuplas->fetch_object()) {
            $resultado[] = [
                "id_categoria_jogo" => $tupla->id_categoria_jogo,
                "nome_categoria_jogo" => $tupla->nome_categoria_jogo,
            ];
        }
        
        echo json_encode($resultado, JSON_PRETTY_PRINT);
    }

    public function readById() {
        $conexao = Banco::get_conexao();
        $sql = "SELECT * FROM categoria_jogo WHERE id_categoria_jogo = ?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_categoria_jogo);
        $prepareSQL->execute();
    
        $matrizTuplas = $prepareSQL->get_result();
    
        if ($matrizTuplas === false) {
            return null;
        }
    
        if ($tupla = $matrizTuplas->fetch_object()) {
            return [
                "id_categoria_jogo" => $tupla->id_categoria_jogo,
                "nome_categoria_jogo" => $tupla->nome_categoria_jogo,
            ];
        }
    
        return null;
    }

    /**
     * Get the value of id_categoria_jogo
     */ 
    public function getId_categoria_jogo()
    {
        return $this->id_categoria_jogo;
    }

    /**
     * Set the value of id_categoria_jogo
     *
     * @return  self
     */ 
    public function setId_categoria_jogo($id_categoria_jogo)
    {
        $this->id_categoria_jogo = $id_categoria_jogo;

        return $this;
    }


    /**
     * Get the value of nome_categoria_jogo
     */ 
    public function getNome_categoria_jogo()
    {
        return $this->nome_categoria_jogo;
    }

    /**
     * Set the value of nome_categoria_jogo
     *
     * @return  self
     */ 
    public function setNome_categoria_jogo($nome_categoria_jogo)
    {
        $this->nome_categoria_jogo = $nome_categoria_jogo;

        return $this;
    }
}

?>