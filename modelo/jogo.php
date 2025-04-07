<?php

require_once("modelo/banco.php");
class Jogo implements JsonSerializable
{

    private $id_jogo;
    private $preco_jogo;
    private $nome_jogo;
    private $distribuidora_jogo;
    private $id_categoria_jogo;

    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj->id_jogo = $this->getId_jogo();
        $obj->preco_jogo = $this->getPreco_jogo();
        $obj->nome_jogo = $this->getNome_jogo();
        $obj->distribuidora_jogo = $this->getDistribuidora_jogo();
        $obj->id_categoria_jogo = $this->getId_categoria_jogo();
 
        return $obj;
    }
    public function create(){
        $conexao = banco::get_conexao();
        $sql = 'INSERT INTO jogos (preco_jogo, nome_jogo, distribuidora_jogo, id_categoria_jogo)VALUES(?,?,?,?)';
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("dssi",
            $this->preco_jogo, 
            $this->nome_jogo, 
            $this->distribuidora_jogo, 
            $this->id_categoria_jogo,
        );

        $executou = $prepareSQL->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setId_jogo($idCadastrado);

        return $executou;
    }

    public function delete() {
        $conexao = Banco::get_conexao();
        $sql = "delete from jogos where id_jogo=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_jogo);
        return $prepareSQL->execute();
    }

    public function update(){
        $conexao = Banco::get_conexao();
        $sql = "update jogos SET preco_jogo=?, nome_jogo=?, distribuidora_jogo=?, id_categoria_jogo=? where id_jogo=?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("dssii", 
            $this->preco_jogo, 
            $this->nome_jogo, 
            $this->distribuidora_jogo, 
            $this->id_categoria_jogo,
            $this->id_jogo
        );
        $executou = $prepareSQL->execute();
        return $executou;
    }

    public function readAll(){
        $conexao = Banco::get_conexao();
        $sql = "select * from jogos order by id_jogo";
        $prepareSQL = $conexao->prepare($sql);
        $executou = $prepareSQL->execute();
        $matrizTuplas = $prepareSQL->get_result();
        $resultado = [];

        while ($tupla = $matrizTuplas->fetch_object()) {
            $resultado[] = [
                "id_jogo" => $tupla->id_jogo,
                "preco_jogo" => $tupla->preco_jogo,
                "nome_jogo" => $tupla->nome_jogo,
                "distribuidora_jogo" => $tupla->distribuidora_jogo,
                "id_categoria_jogo" => $tupla->id_categoria_jogo
            ];
        }
        
        echo json_encode($resultado, JSON_PRETTY_PRINT);
    }

    public function readById() {
        $conexao = Banco::get_conexao();
        $sql = "SELECT * FROM jogos WHERE id_jogo = ?";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("i", $this->id_jogo);
        $prepareSQL->execute();
    
        $matrizTuplas = $prepareSQL->get_result();
    
        if ($matrizTuplas === false) {
            return null;
        }
    
        if ($tupla = $matrizTuplas->fetch_object()) {
            return [
                "id_jogo" => $tupla->id_jogo,
                "preco_jogo" => $tupla->preco_jogo,
                "nome_jogo" => $tupla->nome_jogo,
                "distribuidora_jogo" => $tupla->distribuidora_jogo,
                "id_categoria_jogo" => $tupla->id_categoria_jogo
            ];
        }
    
        return null;
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
     * Get the value of preco_jogo
     */ 
    public function getPreco_jogo()
    {
        return $this->preco_jogo;
    }

    /**
     * Set the value of preco_jogo
     *
     * @return  self
     */ 
    public function setPreco_jogo($preco_jogo)
    {
        $this->preco_jogo = $preco_jogo;

        return $this;
    }

    /**
     * Get the value of nome_jogo
     */ 
    public function getNome_jogo()
    {
        return $this->nome_jogo;
    }

    /**
     * Set the value of nome_jogo
     *
     * @return  self
     */ 
    public function setNome_jogo($nome_jogo)
    {
        $this->nome_jogo = $nome_jogo;

        return $this;
    }

    /**
     * Get the value of distribuidora_jogo
     */ 
    public function getDistribuidora_jogo()
    {
        return $this->distribuidora_jogo;
    }

    /**
     * Set the value of distribuidora_jogo
     *
     * @return  self
     */ 
    public function setDistribuidora_jogo($distribuidora_jogo)
    {
        $this->distribuidora_jogo = $distribuidora_jogo;

        return $this;
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
}

?>