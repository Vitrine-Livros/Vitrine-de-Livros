<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");
require_once(__DIR__ . "/../dao/GeneroDAO.php");
require_once(__DIR__ . "/../service/LivroService.php");
require_once(__DIR__ . "/../model/Livro.php");
require_once(__DIR__ . "/../model/Genero.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class LivroController extends Controller {

    private LivroDAO $livroDao;
    private GeneroDAO $generoDao;
    private LivroService $livroService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        //if(! $this->usuarioLogado())
        //    exit;

        $this->livroDao = new LivroDAO();
        $this->generoDao = new GeneroDAO();
        $this->livroService = new LivroService();

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
        $foto = trim($_POST['foto']) ? trim($_POST['foto']) : NULL;
        $linkCompra = trim($_POST['linkCompra']) ? trim($_POST['linkCompra']) : NULL;
        $resumo = trim($_POST['resumo']) ? trim($_POST['resumo']) : NULL;
       
        //Cria objeto Livro
        $livro = new Livro();
        $livro->setNome($nome);
        $livro->setAutores($autores);
        $livro->setAnoLancamento($anoLancamento);
        $livro->setEditora($editora);
        
        $genero = new Genero();
        $genero->setId($idGenero);
        $livro->setGenero($genero);
        
        $livro->setFoto($foto);
        $livro->setLinkCompra($linkCompra);
        $livro->setResumo($resumo);

        //Validar os dados
        $erros = $this->livroService->validarDados($livro);
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

    protected function listJson() {
        $listaLivro = $this->livroDao->list();
        $json = json_encode($listaLivro);
        echo $json;
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
