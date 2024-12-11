<?php
#Nome do arquivo: livro/livro.php
#Objetivo: interface para detalhar os dados de um livro

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="<?= BASEURL ?>/controller/HomeController.php?action=home" >Voltar</a>

            <h1><?= $dados["livro"]->getNome() ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4"> <!-- Imagem -->
            <img class="card-img-top" src="<?= URL_ARQUIVOS . "/" . $dados["livro"]->getFoto(); ?>" width="100%">
        </div>

        <div class="col-8"> <!-- Dados do livro -->
            <div style="font-size: 24px;" class="text-muted mb-2">Atores: <?= $dados["livro"]->getAutores() ?></div>
            
            <div style="font-size: 24px;" class="text-muted mb-2">Ano de lançamento: <?= $dados["livro"]->getAnoLancamento() ?></div>
            
            <div style="font-size: 24px;" class="text-muted mb-2">Editora: <?= $dados["livro"]->getEditora() ?></div>

            <div style="font-size: 24px;" class="text-muted mb-2"> <?= $dados["livro"]->getGenero()->getNome() ?></div>

            <div style="font-size: 18px;" class="text-muted mb-2"><?= $dados["livro"]->getResumo() ?></div>

            <div>
                <?php if(! $dados["jaCurtido"]): ?>
                    <a href="<?= BASEURL ?>/controller/LivroCurtidoController.php?action=insert&id_livro=<?= $dados["livro"]->getId() ?>" 
                        class="btn btn-primary">Curtir</a>
                <?php else: ?>
                    <a href="<?= BASEURL ?>/controller/LivroCurtidoController.php?action=delete&id_livro=<?= $dados["livro"]->getId() ?>" 
                        class="btn btn-secondary">Descurtir</a>
                <?php endif; ?>

                <?php if(! $dados["jaLido"]): ?>
                    <a href="<?= BASEURL ?>/controller/LivroLidoController.php?action=insert&id_livro=<?= $dados["livro"]->getId() ?>" class="btn btn-danger">Ler</a>
                <?php else: ?>
                    <a href="<?= BASEURL ?>/controller/LivroLidoController.php?action=delete&id_livro=<?= $dados["livro"]->getId() ?>" class="btn btn-secondary">Não Ler</a>
                <?php endif; ?>

                <?php if($dados["jaLido"]): ?>
                    <a href="<?= BASEURL ?>/controller/LivroLidoController.php?action=comentarAvaliar&id_livro=<?= $dados["livro"]->getId() ?>" class="btn btn-info">Comentar/Avaliar</a>
                <?php endif; ?>

                <a href="<?= $dados["livro"]->getLinkCompra() ?>" target="_blank" class="btn btn-success">Comprar</a>
            </div>

            <div class="mt-5">
                <?php require_once(__DIR__ . "/../include/msg.php"); ?>
            </div>
        </div>
       
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Listar comentários -->
            Comentários aqui!
        </div>
    </div>

   
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
