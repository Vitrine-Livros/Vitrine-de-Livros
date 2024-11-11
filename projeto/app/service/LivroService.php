<?php
    
require_once(__DIR__ . "/../model/Livro.php");

class LivroService {

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Livro $livro, array $arquivoCapa) {
        $erros = array();

        //Validar campos vazios
        if(! $livro->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");

        if(! $livro->getAutores())
            array_push($erros, "O campo [Autores] é obrigatório.");

        if(! $livro->getAnoLancamento())
            array_push($erros, "O campo [AnoLancamento] é obrigatório.");

        if(! $livro->getEditora())
            array_push($erros, "O campo [Editora] é obrigatório.");

        if(! $livro->getGenero()->getId())
            array_push($erros, "O campo [Gênero] é obrigatório.");

        if((! $livro->getFoto()) && $arquivoCapa['size'] <= 0)
            array_push($erros, "O campo [Capa] é obrigatório.");

        if(! $livro->getLinkCompra())
            array_push($erros, "O campo [LinkCompra] é obrigatório.");

        if(! $livro->getResumo())
            array_push($erros, "O campo [Resumo] é obrigatório.");

        return $erros;
    }

}
