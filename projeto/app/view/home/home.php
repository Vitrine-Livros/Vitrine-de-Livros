<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/livro_card.css">
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/estrelas.css">

<div class="container-fluid principal" id="???">

    <h2 class="titulo-secao">Livros mais curtidos</h2>
    <div class="row mt-3">
        <?php foreach ($dados['livrosMaisCurtidos'] as $livro): ?>
            <div class="col-sm-6 col-md-4 col-xl-2 text-center mt-3">
               <?php include(__DIR__ . "/../include/livro_card.php"); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="titulo-secao">Livros mais lidos</h2>
    <div class="row mt-3 justify-content-center">
        <?php foreach ($dados['livrosMaisLidos'] as $livro): ?>
            <div class="col-sm-6 col-md-4 col-xl-2 text-center mt-3">
               <?php include(__DIR__ . "/../include/livro_card.php"); ?>
            </div>
        <?php endforeach; ?>

    </div>

</div>

<!-- <script src="<?= BASEURL ?>/view/home/home.js"></script> -->

<?php
require_once(__DIR__ . "/../include/footer.php");
?>