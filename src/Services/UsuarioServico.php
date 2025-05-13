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
            // $usuarios = [];
            // while ($dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC)) {
            //     $usuario = new Usuario(
            //         $dadosUsuario['nome'],
            //         $dadosUsuario['email'],
            //         $dadosUsuario['senha'],
            //         $dadosUsuario['data_nascimento'],
            //         $dadosUsuario['id']
            //     );

            //     $usuarios[] = $usuario;
            // }

            // return $usuarios;
            return $consulta->fetchALL(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            throw new Exception("Erro ao carregar usuarios: " . $erro->getMessage());
        }
    }

    public function buscarPorId(int $id): ?Usuario
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return new Usuario(
                    $dadosUsuario['nome'],
                    $dadosUsuario['email'],
                    $dadosUsuario['senha'],
                    $dadosUsuario['data_nascimento'],
                    $dadosUsuario['id']
                );
            }

            return null;
        } catch (Throwable $erro) {
            throw new Exception("Erro ao buscar usuário: " . $erro->getMessage());
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
            $consulta->bindValue(":data_nascimento", $usuario->getData_nascimento(), PDO::PARAM_STR);
            $consulta->bindValue(":id", $usuario->getId(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            throw new Exception("Erro ao atualizar usuário: " . $erro->getMessage());
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
            throw new Exception("Erro ao excluir usuário: " . $erro->getMessage());
        }
    }
}
