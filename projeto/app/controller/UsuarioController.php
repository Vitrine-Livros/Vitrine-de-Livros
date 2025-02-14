<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class UsuarioController extends Controller {

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        if(! $this->usuarioLogado())
            exit;

        //Tratar para apenas ADMIN listar os usuário
        if(! $this->usuarioLogadoIsAdministrador()) {
            echo "Acessso negado!";
            exit;
        }

        $usuarios = $this->usuarioDao->list();
        //print_r($usuarios);
        $dados["lista"] = $usuarios;

        $this->loadView("usuario/list.php", $dados, $msgErro, $msgSucesso);
    }

    protected function save() {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;
        $tipo = UsuarioTipo::LEITOR;

        //Cria objeto Usuario
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setTipo($tipo);

        //Validar os dados
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);
        if(empty($erros)) {
            //Persiste o objeto
            try {
                
                if($dados["id"] == 0)  //Inserindo
                    $this->usuarioDao->insert($usuario);
                else { //Alterando
                    $usuario->setId($dados["id"]);
                    $this->usuarioDao->update($usuario);
                }

                if($this->usuarioLogadoStatus())
                    $this->list("", "Usuário cadastrado com sucesso.");
                else
                    header("Location: " . LOGIN_PAGE);
                exit;
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar o usuário na base de dados."];   
                //print_r($e);             
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário
        $dados["usuario"] = $usuario;
        $dados["confSenha"] = $confSenha;
        $dados["tipo"] = UsuarioTipo::getAllAsArray();

        $msgsErro = implode("<br>", $erros);

        if($this->usuarioLogadoStatus())
            $this->loadView("usuario/form.php", $dados, $msgsErro);
        else 
            $this->loadView("usuario/form_auto_cadastro.php", $dados, $msgsErro);
    }

    //Método create
    protected function autoCadastro() {
        //Chamada para autoCadastro

        $dados["id"] = 0;
        $dados["tipo"] = UsuarioTipo::getAllAsArray(); 
        $this->loadView("usuario/form_auto_cadastro.php", $dados);
    }

    //Método create
    protected function create() {
        if(! $this->usuarioLogado())
            exit;

        if(! $this->usuarioLogadoIsAdministrador()) {
            echo "Acessso negado!";
            exit;
        }

        $dados["id"] = 0;
        $dados["tipo"] = UsuarioTipo::getAllAsArray(); 
        $this->loadView("usuario/form.php", $dados);
    }

    //Método edit
    protected function edit() {
        if(! $this->usuarioLogado())
            exit;

        if(! $this->usuarioLogadoIsAdministrador()) {
            echo "Acessso negado!";
            exit;
        }

        $usuario = $this->findUsuarioById();
        
        if($usuario) {
            $usuario->setSenha("");
            
            //Setar os dados
            $dados["id"] = $usuario->getId();
            $dados["usuario"] = $usuario;
            $dados["tipo"] = UsuarioTipo::getAllAsArray(); 

            $this->loadView("usuario/form.php", $dados);
        } else 
            $this->list("Usuário não encontrado");
    }

    //Método para excluir
    protected function delete() {
        if(! $this->usuarioLogado())
            exit;

        if(! $this->usuarioLogadoIsAdministrador()) {
            echo "Acessso negado!";
            exit;
        }

        $usuario = $this->findUsuarioById();
        if($usuario) {
            //Excluir
            $this->usuarioDao->deleteById($usuario->getId());
            $this->list("", "Usuário excluído com sucesso!");
        } else {
            //Mensagem q não encontrou o usuário
            $this->list("Usuário não encontrado!");

        }               
    }

    protected function listJson() {
        $listaUsuarios = $this->usuarioDao->list();
        $json = json_encode($listaUsuarios);
        echo $json;
    }

    //Método para buscar o usuário com base no ID recebido por parâmetro GET
    private function findUsuarioById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $usuario = $this->usuarioDao->findById($id);
        return $usuario;
    }

}


#Criar objeto da classe para assim executar o construtor
new UsuarioController();
