<?php
#Nome do arquivo: LivroDAO.php
#Objetivo: classe DAO para o model de Livro

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Livro.php");
include_once(__DIR__ . "/../model/Genero.php");

class LivroDAO
{

    //Método para listar os livros a partir da base de dados
    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT l.*, g.nome AS nome_genero 
                FROM livro l 
                JOIN genero g ON (g.id_genero = l.id_genero)
                ORDER BY l.nome";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapLivro($result);
    }

    public function listByLivro(string $filtro) {
        if(! $filtro)
            return array();

        $conn = Connection::getConn();

        $sql = "SELECT l.*, g.nome AS nome_genero 
                FROM livro l 
                JOIN genero g ON (g.id_genero = l.id_genero)
                WHERE l.nome LIKE ? COLLATE utf8_general_ci
                    OR g.nome = ? COLLATE utf8_unicode_ci
                ORDER BY l.nome";
        $stm = $conn->prepare($sql);
        $stm->execute(['%'.$filtro.'%', $filtro]);
        $result = $stm->fetchAll();

        return $this->mapLivro($result);
    }

    public function listMaisCurtidos()
    {
        $conn = Connection::getConn();

        $sql = "SELECT l.*, g.nome AS nome_genero, COUNT(lc.id_livro_curtido) AS num_curtidas
                FROM livro_curtido lc 
                    JOIN livro l ON (l.id_livro = lc.id_livro)
                    JOIN genero g ON (g.id_genero = l.id_genero)
                GROUP BY l.id_livro 
                ORDER BY COUNT(lc.id_livro_curtido) DESC, lc.data DESC 
                LIMIT 6";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapLivro($result);
    }

    public function listMaisLidos()
    {
        $conn = Connection::getConn();

        $sql = "SELECT l.*, g.nome AS nome_genero, COUNT(ll.id_livro_lido) AS num_lidas
                FROM livro_lido ll 
                    JOIN livro l ON (l.id_livro = ll.id_livro)
                    JOIN genero g ON (g.id_genero = l.id_genero)
                GROUP BY l.id_livro 
                ORDER BY COUNT(ll.id_livro_lido) DESC, ll.data_atualizacao DESC 
                LIMIT 6";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapLivro($result);
    }

    public function listLivrosLidosByUsuario(int $idUsuario) {
        $conn = Connection::getConn();

        $sql = "SELECT l.*, g.nome AS nome_genero 
                FROM livro_lido ll
                    JOIN livro l ON (l.id_livro = ll.id_livro)
                    JOIN genero g ON (g.id_genero = l.id_genero)
                WHERE ll.id_usuario = ?
                ORDER BY ll.data_atualizacao DESC";
        $stm = $conn->prepare($sql);
        $stm->execute([$idUsuario]);
        $result = $stm->fetchAll();

        return $this->mapLivro($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT l.*, g.nome AS nome_genero 
                FROM livro l 
                JOIN genero g ON (g.id_genero = l.id_genero)
                WHERE l.id_livro = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $livro = $this->mapLivro($result);

        if (count($livro) == 1)
            return $livro[0];
        elseif (count($livro) == 0)
            return null;

        die("LivroDAO.findById()" .
            " - Erro: mais de um livro encontrado.");
    }

    //Método para inserir um Livro
    public function insert(Livro $livro)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO livro (nome, autores, ano_lancamento, editora, id_genero, foto, link_compra, resumo)" .
            " VALUES (:nome, :autores, :ano_lancamento, :editora, :id_genero, :foto, :link_compra, :resumo)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $livro->getNome());
        $stm->bindValue("autores", $livro->getAutores());
        $stm->bindValue("ano_lancamento", $livro->getAnoLancamento());
        $stm->bindValue("editora", $livro->getEditora());
        $stm->bindValue("id_genero", $livro->getGenero()->getId());
        $stm->bindValue("foto", $livro->getFoto());
        $stm->bindValue("link_compra", $livro->getLinkCompra());
        $stm->bindValue("resumo", $livro->getResumo());
        $stm->execute();
    }

    //Método para atualizar um Livro
    public function update(Livro $livro)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE livro SET nome = :nome, autores = :autores, ano_lancamento = :ano_lancamento, editora = :editora,
         id_genero = :id_genero, foto = :foto, link_compra = :link_compra, resumo = :resumo" .
            " WHERE id_livro = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $livro->getNome());
        $stm->bindValue("autores", $livro->getAutores());
        $stm->bindValue("ano_lancamento", $livro->getAnoLancamento());
        $stm->bindValue("editora", $livro->getEditora());
        $stm->bindValue("id_genero", $livro->getGenero()->getId());
        $stm->bindValue("foto", $livro->getFoto());
        $stm->bindValue("link_compra", $livro->getLinkCompra());
        $stm->bindValue("resumo", $livro->getResumo());
        $stm->bindValue("id", $livro->getId());
        $stm->execute();
    }

    //Método para excluir um Livro pelo seu ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM livro WHERE id_livro = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function count()
    {
        $conn = Connection::getConn();

        $sql = "SELECT COUNT(*) total FROM livro";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $result[0]["total"];
    }

    //Método para converter um registro da base de dados em um objeto Livro
    private function mapLivro($result)
    {
        $livros = array();
        foreach ($result as $reg) {
            $livro = new Livro();
            $livro->setId($reg['id_livro']);
            $livro->setNome($reg['nome']);
            $livro->setAutores($reg['autores']);
            $livro->setAnoLancamento($reg['ano_lancamento']);
            $livro->setEditora($reg['editora']);

            $genero = new Genero();
            $genero->setId($reg['id_genero']);
            $genero->setNome($reg['nome_genero']);
            $livro->setGenero($genero);

            $livro->setFoto($reg['foto']);
            $livro->setLinkCompra($reg['link_compra']);
            $livro->setResumo($reg['resumo']);

            if(isset($reg['num_curtidas'])) 
                $livro->setNumeroCurtidas($reg['num_curtidas']);

            if(isset($reg['num_lidas'])) 
                $livro->setNumeroLidas($reg['num_lidas']);

            array_push($livros, $livro);
        }
        
        return $livros;
    }
}
