<?php
#Nome do arquivo: livro/livro.php
#Objetivo: interface para detalhar os dados de um livro

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="<?= BASEURL ?>/controller/LivroController.php?action=detalhesLivro&id=<?= $dados["livro"]->getId() ?>">Voltar</a>

            <h1>Comentar e avaliar</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4"> <!-- Imagem -->
            <img class="card-img-top" src="<?= URL_ARQUIVOS . "/" . $dados["livro"]->getFoto(); ?>" width="100%">
        </div>

        <div class="col-8"> <!-- Dados do livro -->
            <div style="font-size: 28px;" class="text-muted mb-2">Título: <?= $dados["livro"]->getNome() ?></div>

            <div style="font-size: 24px;" class="text-muted mb-2">Atores: <?= $dados["livro"]->getAutores() ?></div>
            
            <div style="font-size: 24px;" class="text-muted mb-2">Ano de lançamento: <?= $dados["livro"]->getAnoLancamento() ?></div>
            
            <div style="font-size: 24px;" class="text-muted mb-2">Editora: <?= $dados["livro"]->getEditora() ?></div>

            <div style="font-size: 24px;" class="text-muted mb-2">Gênero: <?= $dados["livro"]->getGenero()->getNome() ?></div>

            <div style="font-size: 18px;" class="text-muted mb-2"><?= $dados["livro"]->getResumo() ?></div>
       </div>
    </div>

    <div class="row mt-4">
        <div class="col-8">
            <!-- Formulário comentários -->
            <form method="POST" action="<?= BASEURL ?>/controller/LivroLidoController.php?action=salvarComentarioAvaliacao">
                <div class="form-group">
                    <label for="txtComentario">Comentário</label>
                    <textarea type="text" class="form-control" name="comentario" id="txtComentario"
                        rows="5"><?= $dados['livroLido']->getComentario() ? $dados['livroLido']->getComentario() : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="selAvaliacao">Avalição</label>
                    <select class="form-control" name="avaliacao" id="selAvaliacao">
                        <option value="">---Informe as estrelas---</option>
                        <option value="1" <?= $dados['livroLido']->getAvaliacao() == 1 ? 'selected' : '' ?>>1 estrela (muito ruim)</option>
                        <option value="2" <?= $dados['livroLido']->getAvaliacao() == 2 ? 'selected' : '' ?>>2 estrelas (ruim)</option>
                        <option value="3" <?= $dados['livroLido']->getAvaliacao() == 3 ? 'selected' : '' ?>>3 estrelas (bom)</option>
                        <option value="4" <?= $dados['livroLido']->getAvaliacao() == 4 ? 'selected' : '' ?>>4 estrelas (ótimo)</option>
                        <option value="5" <?= $dados['livroLido']->getAvaliacao() == 5 ? 'selected' : '' ?>>5 estrelas (excelente)</option>
                    </select>
                </div>

                <div>
                    <button class="btn btn-success">Gravar</button>
                </div>

                <input type="hidden" name="idLivro" value="<?= $dados["livro"]->getId() ?>">
            </form>
        </div>

        <div class="col-4">
            <!-- Mensagens -->
        </div>
    </div>
   
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
