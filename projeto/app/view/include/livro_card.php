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

            <div>
                <?php if($livro->getNumeroCurtidas() > 0): ?>
                    <span class="badge badge-info">
                        <img src="<?= BASEURL ?>/view/img/joinha.png" height="20px">
                        <?= $livro->getNumeroCurtidas() ?>
                    </span>
                    
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between">
                <div class="ratings mx-auto">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <?php if($livro->getNumeroEstrelas() >= $i): ?>
                            <i class="fa fa-star fa-xs rating-color"></i>
                        <?php else: ?>  
                            <i class="fa fa-star fa-xs"></i> 
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>                
            </div>

        </div>
    </div>

<?php endif; ?>