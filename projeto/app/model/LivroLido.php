<?php

class LivroLido {

    private ?int $id;
    private ?int $idLivro;
    private ?int $idUsuario;
    private ?string $comentario;
    private ?int $avaliacao;


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

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getAvaliacao(): ?int
    {
        return $this->avaliacao;
    }

    public function setAvaliacao(?int $avaliacao): self
    {
        $this->avaliacao = $avaliacao;

        return $this;
    }
}