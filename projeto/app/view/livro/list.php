<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/usuario.css">

<h3 class="text-center titulo-secao">Livro</h3>

<div class="container">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success" 
                href="<?= BASEURL ?>/controller/LivroController.php?action=create">
                Inserir</a>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="titulo-secao col-12">
            <table id="tabLivro" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Autores</th>
                        <th>AnoLancamento</th>
                        <th>Editora</th>
                        <th>Gênero</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados['lista'] as $livro): ?>
                        <tr>
                            <td><img src="<?= URL_ARQUIVOS . "/" . $livro->getFoto(); ?>" height="50px"></td>
                            <td><?= $livro->getNome(); ?></td>
                            <td><?= $livro->getAutores(); ?></td>
                            <td><?= $livro->getAnoLancamento(); ?></td>
                            <td><?= $livro->getEditora(); ?></td>
                            <td><?= $livro->getGenero()->getNome(); ?></td>
                            <td><a class="btn btn-primary" 
                                href="<?= BASEURL ?>/controller/LivroController.php?action=edit&id=<?= $livro->getId() ?>">
                                Alterar</a> 
                            </td>
                            <td><a class="btn btn-danger" 
                                onclick="return confirm('Confirma a exclusão do livro?');"
                                href="<?= BASEURL ?>/controller/LivroController.php?action=delete&id=<?= $livro->getId() ?>">
                                Excluir</a> 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
