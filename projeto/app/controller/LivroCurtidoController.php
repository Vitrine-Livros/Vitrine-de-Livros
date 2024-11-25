<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroCurtidoDAO.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");
require_once(__DIR__ . "/../model/LivroCurtido.php");

class LivroCurtidoController extends Controller {

    private LivroCurtidoDAO $livroCurtidoDao;
    private LivroDAO $livroDao;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        $this->livroCurtidoDao = new LivroCurtidoDAO();
        $this->livroDao = new LivroDAO();

        $this->handleAction();
    }

    protected function insert() {
        //1- Chamar o método findLivroById e pegar o livro do banco de dados
        $livro = $this->findLivroById();
        if(! $livro) {
            echo "Livro inválido!";
            exit;
        }

        //2- Criar o objeto LivroCurtido
        $livroCurt = new LivroCurtido();
        $livroCurt->setIdLivro($livro->getId());
        $livroCurt->setIdUsuario($this->getUsuarioLogadoId());

        //3- Chamar o método insert do LivroCurtidoDAO
        try {
            $this->livroCurtidoDao->insert($livroCurt);

            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&tipo_msg=1&id=" . $livro->getId());
            exit;

        } catch (PDOException $e) {
            //print_r($e);
            //exit;  
            
            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&tipo_msg=3&id=" . $livro->getId());
        }
    }

    protected function delete() {
        //1- Chamar o método findLivroById e pegar o livro do banco de dados
        $livro = $this->findLivroById();
        if(! $livro) {
            echo "Livro inválido!";
            exit;
        }

        //2- Chamar o método delete do LivroCurtidoDAO
        try {
            $this->livroCurtidoDao->deleteByLivroUsuario($livro->getId(), $this->getUsuarioLogadoId());

            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&tipo_msg=2&id=" . $livro->getId());
            exit;

        } catch (PDOException $e) {
            //print_r($e);
            //exit;  
            
            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&tipo_msg=3&id=" . $livro->getId());
        }
    }

    //Método para buscar o livro com base no ID recebido por parâmetro GET
    private function findLivroById() {
        $id = 0;
        if(isset($_GET['id_livro']))
            $id = $_GET['id_livro'];

        $livro = $this->livroDao->findById($id);
        return $livro;
    }

}


#Criar objeto da classe para assim executar o construtor
new LivroCurtidoController();
