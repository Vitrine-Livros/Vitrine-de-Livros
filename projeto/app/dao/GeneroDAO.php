<?php

require_once(__DIR__ . "/../model/Genero.php");

class GeneroDAO {

    //Método para listar os livros a partir da base de dados
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM genero g ORDER BY g.nome";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapGeneros($result);
    }


    private function mapGeneros($result) {
        $generos = array();

        foreach($result as $r) {
            $genero = new Genero();
            $genero->setId($r["id_genero"]);
            $genero->setNome($r["nome"]);

            array_push($generos, $genero);
        }

        return $generos;
    }

}