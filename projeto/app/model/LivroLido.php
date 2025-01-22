<?php

class LivroLido {

    private ?int $id;
    private ?int $idLivro;
    private ?int $idUsuario;
    private ?string $comentario;
    private ?int $avaliacao;
    private $data;

    private ?Usuario $usuario;

    public function __construct()
    {
        $this->usuario = null;
    }

    public function getDadosComentario() {
        $dataFormatada = date_format(date_create($this->data), "d/m/Y");

        if($this->usuario)
            return $this->usuario->getNome() . " em " . $dataFormatada;

        return $dataFormatada;
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

    public function getComentarioHTML(): ?string
    {
        if($this->comentario)
            return str_ireplace("\n", "<br>", $this->comentario);;

        return "";
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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

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