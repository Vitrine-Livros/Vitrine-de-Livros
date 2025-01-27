<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");

?>

<style>
.conteudo {
    min-height: calc( 100vh - 75px);
}

.tela-login {
    background-image: url("https://getwallpapers.com/wallpaper/full/e/0/5/166002.jpg");
}

footer {
    margin-top: 0px!important;
}
</style>

<div class="tela-login">
    <div class="container conteudo">
        <div class="row pt-5">
            <div class="col-md-6 offset-md-3 mt-5">
                <div class="alert alert-info">
                    <h4>Informe os dados para logar:</h4>
                    <br>

                    <!-- Formulário de login -->
                    <form id="frmLogin" action="./LoginController.php?action=logon" method="POST" >
                        <div class="form-group">
                            <label for="txtLogin">Email:</label>
                            <input type="text" class="form-control" name="email" id="txtEmail"
                                maxlength="100" placeholder="Informe o email"
                                value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
                        </div>

                        <div class="form-group">
                            <label for="txtSenha">Senha:</label>
                            <input type="password" class="form-control" name="senha" id="txtSenha"
                                maxlength="15" placeholder="Informe a senha"
                                value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />        
                        </div>

                        <div>
                        <button type="submit" class="btn btn-success">Logar</button>
                        </div>

                    </form>
                </div>

                <div>
                    <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=autoCadastro">Não possui cadastro? Clique aqui</a>
                </div>

                <div class="col-12">
                    <?php include_once(__DIR__ . "/../include/msg.php") ?>
                </div>

            </div>


        </div>
    </div>
</div>



<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
