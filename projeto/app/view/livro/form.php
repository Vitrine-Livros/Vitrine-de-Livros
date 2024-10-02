<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
?>

<h3 class="text-center">
    Cadastro de livro
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmLivro" method="POST" 
                action="<?= BASEURL ?>/controller/LivroController.php?action=save" >
                <div class="form-group">
                    <label for="txtNome">Nome:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome" 
                        maxlength="100" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["livro"]) ? $dados["livro"]->getNome() : ''); ?>" />
                </div>
                
                <div class="form-group">
                    <label for="txtAutores">Autor(es):</label>
                    <input class="form-control" type="text" id="txtAutores" name="autores" 
                        maxlength="200" placeholder="Informe o Autor(es)"
                        value="<?php echo (isset($dados["livro"]) ? $dados["livro"]->getAutores() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtAnoLancamento">Ano do lancamento:</label>
                    <input class="form-control" type="number" id="txtAnoLancamento" name="anoLancamento" 
                        placeholder="Informe o Ano de lancamento"
                        value="<?php echo (isset($dados["livro"]) ? $dados["livro"]->getAnoLancamento() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtEditora">Editora:</label>
                    <input class="form-control" type="text" id="txtEditora" name="editora" 
                        maxlength="45" placeholder="Informe a editora"
                        value="<?php echo (isset($dados["livro"]) ? $dados["livro"]->getEditora() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtIdGenero">Gênero:</label>
                    <select class="form-control" id="txtIdGenero" name="idGenero">
                        <option value="">----Selecione o gênero-----</option>
                        <?php foreach($dados["generos"] as $genero): ?>
                            <option value="<?php echo $genero->getId(); ?>" 
                                <?php if(isset($dados["livro"]) && $dados["livro"]->getGenero() && $dados["livro"]->getGenero()->getId() == $genero->getId())
                                    echo "selected";
                                ?>
                            >
                            <?php echo $genero->getNome(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="txtFoto">Foto:</label>
                    <input class="form-control" type="text" id="txtFoto" name="foto" 
                        maxlength="15" placeholder="Informe a Foto"
                        value="<?php echo (isset($dados["livro"]) ? $dados["livro"]->getFoto() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtLinkCompra">Link para a compra:</label>
                    <input class="form-control" type="text" id="txtLinkCompra" name="linkCompra" 
                        maxlength="200" placeholder="Informe o Link da compra"
                        value="<?php echo (isset($dados["livro"]) ? $dados["livro"]->getLinkCompra() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtResumo">Resumo:</label>
                    <textarea class="form-control" id="txtResumo" name="resumo" 
                        placeholder="Informe o Resumo"><?php echo (isset($dados["livro"]) ? $dados["livro"]->getResumo() : ''); ?></textarea>
                </div>

                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />

                <button type="submit" class="btn btn-success">Gravar</button>
                <button type="reset" class="btn btn-danger">Limpar</button>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
        <a class="btn btn-secondary" 
                href="<?= BASEURL ?>/controller/LivroController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>