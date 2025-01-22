<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");
require_once(__DIR__ . "/../dao/LivroCurtidoDAO.php");
require_once(__DIR__ . "/../dao/LivroLidoDAO.php");
require_once(__DIR__ . "/../dao/GeneroDAO.php");
require_once(__DIR__ . "/../service/LivroService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");
require_once(__DIR__ . "/../model/Livro.php");
require_once(__DIR__ . "/../model/Genero.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class LivroController extends Controller {

    private LivroDAO $livroDao;
    private LivroCurtidoDAO $livroCurtidoDao;
    private LivroLidoDAO $livroLidoDao;
    private GeneroDAO $generoDao;
    private LivroService $livroService;
    private ArquivoService $arqService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        $this->livroDao = new LivroDAO();
        $this->livroCurtidoDao = new LivroCurtidoDAO();
        $this->livroLidoDao = new LivroLidoDAO();
        $this->generoDao = new GeneroDAO();
        $this->livroService = new LivroService();
        $this->arqService = new ArquivoService();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $livro = $this->livroDao->list();
        //print_r($livro);
        $dados["lista"] = $livro;

        $this->loadView("livro/list.php", $dados, $msgErro, $msgSucesso);
    }

    protected function save() {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $autores = trim($_POST['autores']) ? trim($_POST['autores']) : NULL;
        $anoLancamento = trim($_POST['anoLancamento']) ? trim($_POST['anoLancamento']) : NULL;
        $editora = trim($_POST['editora']) ? trim($_POST['editora']) : NULL;
        $idGenero = trim($_POST['idGenero']) ? trim($_POST['idGenero']) : NULL;
        $linkCompra = trim($_POST['linkCompra']) ? trim($_POST['linkCompra']) : NULL;
        $resumo = trim($_POST['resumo']) ? trim($_POST['resumo']) : NULL;
        
        $arquivoCapa = $_FILES["foto"];
        $arquivoCapaAtual = trim($_POST['capaAtual']) ? trim($_POST['capaAtual']) : NULL;
        
        //Cria objeto Livro
        $livro = new Livro();
        $livro->setNome($nome);
        $livro->setAutores($autores);
        $livro->setAnoLancamento($anoLancamento);
        $livro->setEditora($editora);
        
        $genero = new Genero();
        $genero->setId($idGenero);
        $livro->setGenero($genero);
        
        $livro->setLinkCompra($linkCompra);
        $livro->setResumo($resumo);
        if($arquivoCapaAtual)
            $livro->setFoto($arquivoCapaAtual);

        //Validar os dados
        $erros = $this->livroService->validarDados($livro, $arquivoCapa);
        if(empty($erros)) {
            //Salvar a imagem da capa
            if($arquivoCapa['size'] > 0) {
                $nomeArquivo = $this->arqService->salvarArquivo($arquivoCapa);
                if($nomeArquivo)
                    $livro->setFoto($nomeArquivo);
                else
                    $erros = ["Erro ao salvar o arquivo da capa do livro."]; 
            }  
            
            if(empty($erros)) {
                //Persiste o objeto
                try {
                    
                    if($dados["id"] == 0)  //Inserindo
                        $this->livroDao->insert($livro);
                    else { //Alterando
                        $livro->setId($dados["id"]);
                        $this->livroDao->update($livro);
                    }

                    $this->list("", "Livro cadastrado com sucesso!");
                    exit;
                } catch (PDOException $e) {
                    $erros = ["Erro ao salvar o livro no base de dados."];   
                    //print_r($e);             
                }
            
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário
        $dados["livro"] = $livro;
        $dados["generos"] = $this->generoDao->list();

        $msgsErro = implode("<br>", $erros);
        $this->loadView("livro/form.php", $dados, $msgsErro);
    }

    //Método create
    protected function create() {
        //echo "Chamou o método create!";

        $dados["id"] = 0;
        $dados["generos"] = $this->generoDao->list();
        $this->loadView("livro/form.php", $dados);
    }

    //Método edit
    protected function edit() {
        $livro = $this->findLivroById();
        
        if($livro) {
            //Setar os dados
            $dados["id"] = $livro->getId();
            $dados["livro"] = $livro;
            $dados["generos"] = $this->generoDao->list();

            $this->loadView("livro/form.php", $dados);
        } else 
            $this->list("Livro não encontrado");
    }

    //Método para excluir
    protected function delete() {
        $livro = $this->findLivroById();
        if($livro) {
            //Excluir
            $this->livroDao->deleteById($livro->getId());
            $this->list("", "Livro excluído com sucesso!");
        } else {
            //Mensagem q não encontrou o livro
            $this->list("Livro não encontrado!");

        }               
    }

    protected function detalhesLivro()  {
        $livro = $this->findLivroById();
        if(! $livro) {
            echo "Livro inválido!";
            exit;
        }

        $dados["livro"] = $livro;

        $livroCurtido = $this->livroCurtidoDao->findByLivroUsuario($livro->getId(), $this->getUsuarioLogadoId());
        $dados["jaCurtido"] = $livroCurtido ? true : false;

        $livroLido = $this->livroLidoDao->findByLivroUsuario($livro->getId(), $this->getUsuarioLogadoId());
        $dados["jaLido"] = $livroLido ? true : false;

        $dados["comentarios"] = $this->livroLidoDao->listByLivro($livro->getId());
        
        $msgCurtido = 0;
        if(isset($_GET['msg_curtido']))
            $msgCurtido = $_GET['msg_curtido'];

        $msgLido = 0;
        if(isset($_GET['msg_lido']))
            $msgLido = $_GET['msg_lido'];

        $msgSucesso = "";
        $msgErro = "";

        if($msgCurtido == 1) //Sucesso curtida
            $msgSucesso = "Livro curtido com sucesso.";
        else if($msgCurtido == 2) //Sucesso descurtida
            $msgSucesso = "Livro descurtido com sucesso.";
        else if($msgCurtido == 3) //Erro 
            $msgErro = "Erro ao curtir/descurtir o livro.";

        else if($msgLido == 1) //Sucesso lido
            $msgSucesso = "Livro lido com sucesso.";
        else if($msgLido == 2) //Sucesso lido
            $msgSucesso = "Livro não lido com sucesso.";
        else if($msgLido == 3) //Erro 
            $msgErro = "Erro ao ler/não ler o livro.";
        
        $this->loadView("livro/livro.php", $dados, $msgErro, $msgSucesso);      
    }

    //Método para buscar o livro com base no ID recebido por parâmetro GET
    private function findLivroById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $livro = $this->livroDao->findById($id);
        return $livro;
    }



}


#Criar objeto da classe para assim executar o construtor
new LivroController();
