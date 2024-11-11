<?php 
#Nome do arquivo: LivroCurtido.php
#Objetivo: classe Model para LivroCurtido

class LivroCurtido {

    private ?int $id;
    private ?int $idLivro;
    private ?int $idUsuario;
    private $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIdLivro(): ?int
    {
        return $this->idLivro;
    }

    public function setIdLivro(?int $idLivro): self
    {
        $this->idLivro = $idLivro;

        return $this;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?int $idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }
}