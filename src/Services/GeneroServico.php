<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Genero;
use Exception;
use PDO;
use Throwable;

final class GeneroServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM generos ORDER BY nome";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            return $consulta->fetchALL(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao carregar generos");
        }
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM generos WHERE id = :id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar generos");
        }
    }

    public function cadastrar(Genero $genero): void
    {
        $sql = "INSERT INTO generos (nome) VALUES(:nome)";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $genero->getNome(), PDO::PARAM_STR);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao inserir generos");
        }
    }

    public function atualizar(Genero $genero): void
    {
        $sql = "UPDATE generos SET
                    nome = :nome WHERE id = :id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $genero->getNome(), PDO::PARAM_STR);
            $consulta->bindValue(":id", $genero->getId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao atualizar generos");
        }            
    }

    public function excluir(int $id): void
    {
        $sql = "DELETE FROM generos WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao excluir generos");
        }
    }
}
