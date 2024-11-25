<?php
#Nome do arquivo: LivroCurtidoDAO.php
#Objetivo: classe DAO para o model de LivroCurtido

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/LivroCurtido.php");

class LivroCurtidoDAO
{

    public function findByLivroUsuario(int $idLivro, int $idUsuario)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM livro_curtido WHERE id_livro = :id_livro AND id_usuario = :id_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $idLivro);
        $stm->bindValue("id_usuario", $idUsuario);

        $stm->execute();

        $result = $stm->fetchAll();

        $curtidas = $this->mapLivroCurtido($result);

        if(count($curtidas) == 1)
            return $curtidas[0];
        else
            return null;
    }

    //Método para inserir um LivroCurtido
    public function insert(LivroCurtido $livroCurtido)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO livro_curtido (id_livro, id_usuario, data)" .
            " VALUES (:id_livro, :id_usuario, CURRENT_DATE)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $livroCurtido->getIdLivro());
        $stm->bindValue("id_usuario", $livroCurtido->getIdUsuario());

        $stm->execute();
    }

    public function deleteByLivroUsuario(int $idLivro, int $idUsuario)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM livro_curtido WHERE id_livro = :id_livro AND id_usuario = :id_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $idLivro);
        $stm->bindValue("id_usuario", $idUsuario);
        $stm->execute();
    }

    private function mapLivroCurtido($result)
    {
        $curtidas = array();
        foreach ($result as $reg) {
            $livroCurtido = new LivroCurtido();
            $livroCurtido->setId($reg['id_livro_curtido']);
            $livroCurtido->setIdLivro($reg['id_livro']);
            $livroCurtido->setIdUsuario($reg['id_usuario']);
            $livroCurtido->setData($reg['data']);

            array_push($curtidas, $livroCurtido);
        }

        return $curtidas;
    }

}