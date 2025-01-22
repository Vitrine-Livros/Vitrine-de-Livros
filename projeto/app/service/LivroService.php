<?php
    
require_once(__DIR__ . "/../model/Livro.php");
require_once(__DIR__ . "/../dao/LivroLidoDAO.php");

class LivroService {

    private LivroLidoDAO $livroLidoDao;

    public function __construct()
    {
        $this->livroLidoDao = new LivroLidoDAO();
    }

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

    public function carregarEstrelas(Livro $livro) {
        $leiturasAvaliacoes = $this->livroLidoDao->listByLivro($livro->getId());

        $totalEstrelas = 0;
        $numeroAvaliacoes = 0;
        foreach($leiturasAvaliacoes as $livroLido) {
            if($livroLido->getAvaliacao()) {
                $totalEstrelas += $livroLido->getAvaliacao();
                $numeroAvaliacoes++;
            }
        }

        if($numeroAvaliacoes > 0)
            $livro->setNumeroEstrelas($totalEstrelas/$numeroAvaliacoes);
    }

}
