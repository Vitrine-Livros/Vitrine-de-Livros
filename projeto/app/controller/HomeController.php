<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");
require_once(__DIR__ . "/../service/LivroService.php");


class HomeController extends Controller {

    private LivroDAO $livroDao;
    private LivroService $livrosService;

    public function __construct() {
        //Testar se o usuário está logado
        if(! $this->usuarioLogado()) {
            exit;
        }

        //Criar o objeto do UsuarioDAO
        $this->livroDao = new LivroDAO();

        $this->livrosService = new LivroService();

        $this->handleAction();       
    }

    protected function home() {
        //Carregar a lista de livros
        //1- Buscar os livros do banco de dados (LivroDAO)

        $dados['livrosMaisLidos'] = $this->livroDao->listMaisLidos();
        foreach($dados['livrosMaisLidos'] as $livro) {
            $this->livrosService->carregarEstrelas($livro);
        }

        $dados['livrosMaisCurtidos'] = $this->livroDao->listMaisCurtidos();
        foreach($dados['livrosMaisCurtidos'] as $livro) {
            $this->livrosService->carregarEstrelas($livro);
        }

        
        //echo "<pre>" . print_r($dados, true) . "</pre>";
        $this->loadView("home/home.php", $dados);
    }

}

//Criar o objeto da classe HomeController
new HomeController();