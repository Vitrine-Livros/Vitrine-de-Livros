<?php 
#Nome do arquivo: Livro.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioTipo.php");

class Livro {

    private ?int $id;
    private ?string $nome;
    private ?string $autores;
    private ?string $anoLancamento;
    private ?string $editora;
    private ?Genero $genero;
    private ?string $foto;
    private ?string $linkCompra;
    private ?string $resumo;

    private ?int $numeroCurtidas;
    private ?int $numeroLidas;
    private ?int $numeroEstrelas;

    public function __construct() {
        $this->genero = null; 
        $this->foto = null; 
        $this->numeroCurtidas = 0;  
        $this->numeroLidas = 0;     
        $this->numeroEstrelas = 0;  
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getAutores(): ?string
    {
        return $this->autores;
    }

    public function setAutores(?string $autores): self
    {
        $this->autores = $autores;

        return $this;
    }

    public function getAnoLancamento(): ?string
    {
        return $this->anoLancamento;
    }

    public function setAnoLancamento(?string $anoLancamento): self
    {
        $this->anoLancamento = $anoLancamento;

        return $this;
    }

    public function getEditora(): ?string
    {
        return $this->editora;
    }

    public function setEditora(?string $editora): self
    {
        $this->editora = $editora;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getLinkCompra(): ?string
    {
        return $this->linkCompra;
    }

    public function setLinkCompra(?string $linkCompra): self
    {
        $this->linkCompra = $linkCompra;

        return $this;
    }

    public function getResumo(): ?string
    {
        return $this->resumo;
    }

    public function setResumo(?string $resumo): self
    {
        $this->resumo = $resumo;

        return $this;
    }

    public function getGenero(): ?Genero
    {
        return $this->genero;
    }

    public function setGenero(?Genero $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getNumeroCurtidas(): ?int
    {
        return $this->numeroCurtidas;
    }

    public function setNumeroCurtidas(?int $numeroCurtidas): self
    {
        $this->numeroCurtidas = $numeroCurtidas;

        return $this;
    }

    public function getNumeroEstrelas(): ?int
    {
        return $this->numeroEstrelas;
    }

    public function setNumeroEstrelas(?int $numeroEstrelas): self
    {
        $this->numeroEstrelas = $numeroEstrelas;

        return $this;
    }

    public function getNumeroLidas(): ?int
    {
        return $this->numeroLidas;
    }

    public function setNumeroLidas(?int $numeroLidas): self
    {
        $this->numeroLidas = $numeroLidas;

        return $this;
    }
}