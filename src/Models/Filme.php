<?php

namespace CineLivro\Models;

final class Filme
{
    private ?int $id;
    private string $titulo;
    private string $diretor;
    private string $data_lancamento;
    private int $duracao;
    private string $classificacao;
    private string $descricao;
    private string $poster_url;
    private int $usuario_id;
    private int $genero_id;

    public function __construct(String $titulo, string $diretor, string $data_lancamento, int $duracao, string $classificacao, string $descricao, string $poster_url, int $usuario_id, int $genero_id, ?int $id = null)
    {
        $this->setId($id);
        $this->setTitulo($titulo);
        $this->setDiretor($diretor);
        $this->setData_lancamento($data_lancamento);
        $this->setDuracao($duracao);
        $this->setClassificacao($classificacao);
        $this->setDescricao($descricao);
        $this->setPoster_url($poster_url);
        $this->setUsuario_id($usuario_id);
        $this->setGenero_id($genero_id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getDiretor(): string
    {
        return $this->diretor;
    }

    public function getData_lancamento(): string
    {
        return $this->data_lancamento;
    }

    public function getDuracao(): int
    {
        return $this->duracao;
    }

    public function getClassificacao(): string
    {
        return $this->classificacao;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPoster_url(): string
    {
        return $this->poster_url;
    }

    public function getUsuario_id(): int
    {
        return $this->usuario_id;
    }

    public function getGenero_id(): int
    {
        return $this->genero_id;
    }

    private function setId(?int $id): void
    {
        $this->id = $id;
    }

    private function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    private function setDiretor(string $diretor): void
    {
        $this->diretor = $diretor;
    }

    private function setData_lancamento(string $data_lancamento): void
    {
        $this->data_lancamento = $data_lancamento;
    }

    private function setDuracao(int $duracao): void
    {
        $this->duracao = $duracao;
    }

    private function setClassificacao(string $classificacao): void
    {
        $this->classificacao = $classificacao;
    }

    private function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    private function setPoster_url(string $poster_url): void
    {
        $this->poster_url = $poster_url;
    }

    private function setUsuario_id(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    private function setGenero_id(int $genero_id): void
    {
        $this->genero_id = $genero_id;
    }
}