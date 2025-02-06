<?php
#View para a home do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/livro_card.css">

<div class="container-fluid principal">

    <h2 class="titulo-secao">Livros encontrados</h2>

    <h5 class="titulo-secao">Título ou gênero pesquisado: <?= $dados['filtro'] ?></h5>
    
    <div class="row mt-3">
        <?php foreach ($dados['livrosEncontrados'] as $livro): ?>
            <div class="col-sm-6 col-md-4 col-xl-2 text-center mt-3">
               <?php include(__DIR__ . "/../include/livro_card.php"); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php require_once(__DIR__ . "/../include/msg.php"); ?>
</div>

<!-- <script src="<?= BASEURL ?>/view/home/home.js"></script> -->

<?php
require_once(__DIR__ . "/../include/footer.php");
?>