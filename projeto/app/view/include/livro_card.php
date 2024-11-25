<?php
//Card de livros - previsa os dados do livro na variável $livro

if ($livro):
?>

    <div class="card" style="width: 100%;">
        <a href="<?= BASEURL ?>/controller/LivroController.php?action=detalhesLivro&id=<?= $livro->getId() ?>">
            <img class="card-img-top" src="<?= URL_ARQUIVOS . "/" . $livro->getFoto(); ?>" height="300px">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?php echo $livro->getNome() ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo $livro->getAutores() ?></h6>
            <h7 class="card-subtitle mb-2 text-muted"><?php echo $livro->getAnoLancamento() ?></h7>
        </div>
    </div>

<?php endif; ?>