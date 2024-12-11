<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");

class BibliotecaController extends Controller {

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

    protected function list() {
        //Carregar a lista de livros
        //1- Buscar os livros do banco de dados (LivroDAO)
        $dados['livrosLidos'] = $this->livroDao->listLivrosLidosByUsuario($this->getUsuarioLogadoId());

        
        //echo "<pre>" . print_r($dados, true) . "</pre>";
        $this->loadView("biblioteca/list.php", $dados);
    }

}

//Criar o objeto da classe BibliotecaController
new BibliotecaController();