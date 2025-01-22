<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");
require_once(__DIR__ . "/../service/LivroService.php");

class BibliotecaController extends Controller {

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

    protected function list() {
        //Carregar a lista de livros
        //1- Buscar os livros do banco de dados (LivroDAO)
        $dados['livrosLidos'] = $this->livroDao->listLivrosLidosByUsuario($this->getUsuarioLogadoId());
        foreach($dados['livrosLidos'] as $livro) {
            $this->livrosService->carregarEstrelas($livro);
        }

        
        //echo "<pre>" . print_r($dados, true) . "</pre>";
        $this->loadView("biblioteca/list.php", $dados);
    }

}

//Criar o objeto da classe BibliotecaController
new BibliotecaController();