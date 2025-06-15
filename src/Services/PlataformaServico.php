<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Plataforma;
use Exception;
use PDO;
use Throwable;

final class PlataformaServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM plataformas ORDER BY nome";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            return $consulta->fetchALL(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao carregar plataformas");
        }
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM plataformas WHERE id = :id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar plataformas");
        }
    }

    public function cadastrar(Plataforma $plataforma): void
    {
        $sql = "INSERT INTO plataformas (nome) VALUES(:nome)";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $plataforma->getNome(), PDO::PARAM_STR);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao inserir plataformas");
        }
    }

    public function atualizar(Plataforma $plataforma): void
    {
        $sql = "UPDATE plataformas SET
                    nome = :nome WHERE id = :id";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $plataforma->getNome(), PDO::PARAM_STR);
            $consulta->bindValue(":id", $plataforma->getId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao atualizar plataformas");
        }
    }

    public function excluir(int $id): void
    {
        $sql = "DELETE FROM plataformas WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao excluir plataformas");
        }
    }
}
