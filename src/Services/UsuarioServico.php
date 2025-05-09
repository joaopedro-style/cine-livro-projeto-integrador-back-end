<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;

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
            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            throw new Exception("Erro ao carregar usuarios: " . $erro->getMessage());
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
            throw new Exception("Erro ao inserir usuarios: " . $erro->getMessage());
        }
    }
}
