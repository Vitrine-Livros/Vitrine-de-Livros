<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");

class HomeController extends Controller {

    private LivroDAO $livroDao;

    public function __construct() {
        //Testar se o usuário está logado
        if(! $this->usuarioLogado()) {
            exit;
        }

        //Criar o objeto do UsuarioDAO
        $this->livroDao = new LivroDAO();

        $this->handleAction();       
    }

    protected function home() {
        //Carregar a lista de livros
        //1- Buscar os livros do banco de dados (LivroDAO)

        $dados['livros'] = array();
        $dados['livros'] = $this->livroDao->list();

        
        //echo "<pre>" . print_r($dados, true) . "</pre>";
        $this->loadView("home/home.php", $dados);
    }

}

//Criar o objeto da classe HomeController
new HomeController();