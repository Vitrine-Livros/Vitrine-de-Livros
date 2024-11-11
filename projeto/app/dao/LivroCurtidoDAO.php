<?php
#Nome do arquivo: LivroCurtidoDAO.php
#Objetivo: classe DAO para o model de LivroCurtido

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/LivroCurtido.php");

class LivroCurtidoDAO
{

    //Método para inserir um LivroCurtido
    public function insert(LivroCurtido $livroCurtido)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO livro_curtido (id_livro, id_usuario, data)" .
            " VALUES (:id_livro, :id_usuario, CURRENT_DATE)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $livroCurtido->getIdLivro());
        $stm->bindValue("id_usuario", $livroCurtido->getIdUsuario());
    }

}