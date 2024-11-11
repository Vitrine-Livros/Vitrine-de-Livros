<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">

<div class="container-fluid">


    <div class="row mt-3 justify-content-center">
        <?php foreach ($dados['livros'] as $livro): ?>
            <div class="col-2 text-center mt-3">

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
            </div>

        <?php endforeach; ?>

    </div>

</div>

<script src="<?= BASEURL ?>/view/home/home.js"></script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>