<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/LivroLidoDAO.php");
require_once(__DIR__ . "/../dao/LivroDAO.php");
require_once(__DIR__ . "/../model/LivroLido.php");

class LivroLidoController extends Controller {

    private LivroLidoDAO $livroLidoDao;
    private LivroDAO $livroDao;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        $this->livroLidoDao = new LivroLidoDAO();
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

        //2- Criar o objeto LivroLido
        $livroLido = new LivroLido();
        $livroLido->setIdLivro($livro->getId());
        $livroLido->setIdUsuario($this->getUsuarioLogadoId());

        //3- Chamar o método insert do LivroLidoDAO
        try {
            $this->livroLidoDao->insert($livroLido);

            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&msg_lido=1&id=" . $livro->getId());
            exit;

        } catch (PDOException $e) {
            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&msg_lido=3&id=" . $livro->getId());
        }
    }

    protected function delete() {
        //1- Chamar o método findLivroById e pegar o livro do banco de dados
        $livro = $this->findLivroById();
        if(! $livro) {
            echo "Livro inválido!";
            exit;
        }

        //2- Chamar o método delete do LivroLidoDAO
        try {
            $this->livroLidoDao->deleteByLivroUsuario($livro->getId(), $this->getUsuarioLogadoId());

            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&msg_lido=2&id=" . $livro->getId());
            exit;

        } catch (PDOException $e) {
            //print_r($e);
            //exit;  
            
            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&msg_lido=3&id=" . $livro->getId());
        }
    }

    protected function comentarAvaliar() {
        //1- Chamar o método findLivroById e pegar o livro do banco de dados
        $livro = $this->findLivroById();
        if(! $livro) {
            echo "Livro inválido!";
            exit;
        }

        $livroLido = $this->livroLidoDao->findByLivroUsuario($livro->getId(), $this->getUsuarioLogadoId());
        if(! $livroLido) {
            echo "Livro ainda não foi lido pelo usuário!";
            exit;
        }

        $dados["livro"] = $livro;
        $dados["livroLido"] = $livroLido;

        $this->loadView("livro_lido/comentar_avaliar.php", $dados);  
    }

    protected function salvarComentarioAvaliacao() {
        //Pegar os campos do formulário
        $idLivro = $_POST["idLivro"];
        $comentario = trim($_POST['comentario']) ? trim($_POST['comentario']) : NULL;
        $avaliaco = is_numeric($_POST['avaliacao']) ? $_POST['avaliacao'] : NULL;

        //Criar o objeto LivroLido
        $livroLido = new LivroLido();
        $livroLido->setIdLivro($idLivro);
        $livroLido->setIdUsuario($this->getUsuarioLogadoId());
        $livroLido->setComentario($comentario);
        $livroLido->setAvaliacao($avaliaco);

        //TODO - Validar os dados chamando o service (apenas comentário e avaliaçao)
        


        //Chamar o LivroLidoDAO para atualizar o comentário e a avaliaçáo
        try {
            $this->livroLidoDao->update($livroLido);

            header("location: " . BASEURL . "/controller/LivroController.php?action=detalhesLivro&id=" . $idLivro);
            exit;
        } catch (PDOException $e) {
            $erros = ["Erro ao salvar a avaliação na base de dados."];   
            print_r($e);             
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
new LivroLidoController();
