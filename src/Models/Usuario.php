<?php

namespace CineLivro\Models;

use InvalidArgumentException;

final class Usuario
{
    private ?int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private string $data_nascimento;

    public function __construct(string $nome, string $email, string $senha, string $data_nascimento, ?int $id = null)
    {
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setData_nascimento($data_nascimento);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getData_nascimento(): string
    {
        return $this->data_nascimento;
    }

    private function setId(?int $id): void
    {
        $this->id = $id;
    }

    private function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    private function setSenha(string $senha): void
    {
        if (!password_get_info($senha)['algo']) {
            $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            $this->senha = $senha;
        }
    }

    private function setData_nascimento(string $data_nascimento): void
    {
        $this->data_nascimento = $data_nascimento;
    }
}
