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

    public function listMaisCurtidosMes()
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


    //Método para buscar um usuário por seu email e senha
    public function findByEmailSenha(string $email, string $senha)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM livro l" .
            " WHERE BINARY u.email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();

        $livro = $this->mapLivro($result);

        if (count($livro) == 1) {
            //Tratamento para senha criptografada
            if (password_verify($senha, $livro[0]->getSenha()))
                return $livro[0];
            else
                return null;
        } elseif (count($livro) == 0)
            return null;

        die("LivroDAO.findByEmailSenha()" .
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
            array_push($livros, $livro);
        }

        return $livros;
    }
}
