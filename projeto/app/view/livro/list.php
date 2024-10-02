<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Livro</h3>

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
        <div class="col-12">
            <table id="tabLivro" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Autores</th>
                        <th>AnoLancamento</th>
                        <th>Editora</th>
                        <th>Gênero</th>
                        <th>IdFoto</th>
                        <th>IdLinkCompra</th>
                        <th>IdResumo</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados['lista'] as $livro): ?>
                        <tr>
                            <td><?php echo $livro->getId(); ?></td>
                            <td><?= $livro->getNome(); ?></td>
                            <td><?= $livro->getAutores(); ?></td>
                            <td><?= $livro->getAnoLancamento(); ?></td>
                            <td><?= $livro->getEditora(); ?></td>
                            <td><?= $livro->getGenero()->getNome(); ?></td>
                            <td><?= $livro->getFoto(); ?></td>
                            <td><?= $livro->getLinkCompra(); ?></td>
                            <td><?= $livro->getResumo(); ?></td>
                            <td><a class="btn btn-primary" 
                                href="<?= BASEURL ?>/controller/LivroController.php?action=edit&id=<?= $livro->getId() ?>">
                                Alterar</a> 
                            </td>
                            <td><a class="btn btn-danger" 
                                onclick="return confirm('Confirma a exclusão do usuário?');"
                                href="<?= BASEURL ?>/controller/UsuarioController.php?action=delete&id=<?= $livro->getId() ?>">
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
