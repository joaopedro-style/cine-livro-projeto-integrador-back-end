<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Helpers\Utils;
use Exception;
use CineLivro\Models\Usuario;
use PDO;
use Throwable;

final class UsuarioServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM usuarios ORDER BY nome";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            return $consulta->fetchALL(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao carregar usuarios");
        }
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar usuário");
        }
    }

    public function cadastrar(Usuario $usuario): void
    {
        $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento) VALUES(:nome, :email, :senha, :data_nascimento)";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
            $consulta->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
            $consulta->bindValue(":senha", $usuario->getSenha(), PDO::PARAM_STR);
            $consulta->bindValue(":data_nascimento", $usuario->getData_nascimento(), PDO::PARAM_STR);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao inserir usuarios");
        }
    }

    public function atualizar(Usuario $usuario): void
    {
        $sql = "UPDATE usuarios SET
                    nome = :nome, 
                    email = :email, 
                    senha = :senha, 
                    data_nascimento = :data_nascimento 
                WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
            $consulta->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
            $consulta->bindValue(":senha", $usuario->getSenha(), PDO::PARAM_STR);
            $consulta->bindValue(":data_nascimento",$usuario->getData_nascimento(), PDO::PARAM_STR);
            $consulta->bindValue(":id", $usuario->getId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao atualizar usuário");
        }
    }

    public function excluir(int $id): void
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao excluir usuário");
        }
    }

    public function buscaPorEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":email", $email, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar usuário por e-mail.");
        }
    }
}
