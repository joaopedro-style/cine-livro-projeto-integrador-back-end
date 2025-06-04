<?php

namespace CineLivro\Models;

final class Livro
{
    private ?int $id;
    private string $titulo;
    private string $autor;
    private string $data_lancamento;
    private string $faixa_etaria;
    private string $descricao;
    private string $imagem_capa_url;
    private int $usuario_id;
    private int $genero_id;

    public function __construct(string $titulo, string $autor, string $data_lancamento, string $faixa_etaria, string $descricao, string $imagem_capa_url, int $usuario_id, int $genero_id, ?int $id = null)
    {
        $this->setId($id);
        $this->setTitulo($titulo);
        $this->setAutor($autor);
        $this->setData_lancamento($data_lancamento);
        $this->setFaixa_etaria($faixa_etaria);
        $this->setDescricao($descricao);
        $this->setImagem_capa_url($imagem_capa_url);
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

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getData_lancamento(): string
    {
        return $this->data_lancamento;
    }

    public function getFaixa_etaria(): string
    {
        return $this->faixa_etaria;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getImagem_capa_url(): string
    {
        return $this->imagem_capa_url;
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

    private function setAutor(string $autor): void
    {
        $this->autor = $autor;
    }

    private function setData_lancamento(string $data_lancamento): void
    {
        $this->data_lancamento = $data_lancamento;
    }

    private function setFaixa_etaria(string $faixa_etaria): void
    {
        $this->faixa_etaria = $faixa_etaria;
    }

    private function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    private function setImagem_capa_url(string $imagem_capa_url): void
    {
        $this->imagem_capa_url = $imagem_capa_url;
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