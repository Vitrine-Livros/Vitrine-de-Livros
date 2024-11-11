<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroCurtidoDAO.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");

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
        //1- Chamar o método findLivroById e pegar o livro

        //2- Criar o objeto LivroCurtido

        //3- Chamar o método insert do LivroCurtidoDAO
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
