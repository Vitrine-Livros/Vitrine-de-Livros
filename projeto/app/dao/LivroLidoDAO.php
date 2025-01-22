<?php
#Nome do arquivo: LivroCurtidoDAO.php
#Objetivo: classe DAO para o model de LivroCurtido

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/LivroLido.php");
include_once(__DIR__ . "/../model/Usuario.php");

class LivroLidoDAO
{

    public function findByLivroUsuario(int $idLivro, int $idUsuario)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM livro_lido WHERE id_livro = :id_livro AND id_usuario = :id_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $idLivro);
        $stm->bindValue("id_usuario", $idUsuario);

        $stm->execute();

        $result = $stm->fetchAll();

        $lidas = $this->mapLivroLido($result);

        if(count($lidas) == 1)
            return $lidas[0];
        else
            return null;
    }

    public function listByLivro(int $idLivro)
    {
        $conn = Connection::getConn();

        $sql = "SELECT ll.*, u.nome
                FROM livro_lido ll
                    JOIN usuario u ON (u.id_usuario = ll.id_usuario) 
                WHERE ll.id_livro = :id_livro ORDER BY ll.data_atualizacao DESC";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $idLivro);

        $stm->execute();

        $result = $stm->fetchAll();

        return $this->mapLivroLido($result);
    }

    //Método para inserir um LivroCurtido
    public function insert(LivroLido $livroLido)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO livro_lido (id_livro, id_usuario, data_atualizacao)" .
            " VALUES (:id_livro, :id_usuario, CURRENT_DATE)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $livroLido->getIdLivro());
        $stm->bindValue("id_usuario", $livroLido->getIdUsuario());

        $stm->execute();
    }

    public function deleteByLivroUsuario(int $idLivro, int $idUsuario)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM livro_lido WHERE id_livro = :id_livro AND id_usuario = :id_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_livro", $idLivro);
        $stm->bindValue("id_usuario", $idUsuario);
        $stm->execute();
    }

    public function update(LivroLido $livroLido)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE livro_lido 
                SET comentarios = :comentarios, avaliacao = :avaliacao
                WHERE id_livro = :id_livro AND id_usuario = :id_usuario";

        $stm = $conn->prepare($sql);
        $stm->bindValue("comentarios", $livroLido->getComentario());
        $stm->bindValue("avaliacao", $livroLido->getAvaliacao());
        $stm->bindValue("id_livro", $livroLido->getIdLivro());
        $stm->bindValue("id_usuario", $livroLido->getIdUsuario());

        $stm->execute();
    }


    private function mapLivroLido($result)
    {
        $lidos = array();
        foreach ($result as $reg) {
            $livroLido = new LivroLido();
            $livroLido->setId($reg['id_livro_lido']);
            $livroLido->setIdLivro($reg['id_livro']);
            $livroLido->setIdUsuario($reg['id_usuario']);
            $livroLido->setAvaliacao($reg['avaliacao']);
            $livroLido->setComentario($reg['comentarios']);
            $livroLido->setData($reg['data_atualizacao']);

            if(isset($reg['nome'])) {
                $usuario = new Usuario();
                $usuario->setNome($reg['nome']);
                $livroLido->setUsuario($usuario);
            }
            
            array_push($lidos, $livroLido);
        }

        return $lidos;
    }

}