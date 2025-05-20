<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Helpers\Utils;
use Exception;
use PDO;
use Throwable;

final class LivroServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function buscar(string $termo): array
    {
        try {
            $sql = " SELECT * FROM livros
            WHERE titulo LIKE :termo 
               OR autor LIKE :termo 
               OR faixa_etaria LIKE :termo
               OR genero_id LIKE :termo 
               OR data_lancamento LIKE :termo
            ORDER BY titulo ASC ";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':termo', '%' . $termo . '%');
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("erro ao buscar livros. Fale com o Suporte.");
        }
    }

    public function adicionarAosFavoritos(int $usuario_id, int $livro_id): void
    {
        try {
            $sql = "INSERT INTO livros_favoritos (usuario_id, livro_id) VALUES (:usuarioId, :livroId)";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id);
            $consulta->bindValue(':livroId', $livro_id);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao Adicionar aos Favoritos. Fale com o suporte.");
        }
    }

    public function removerDosFavoritos(int $usuario_id, int $livro_id): void
    {
        try {
            $sql = "DELETE FROM livros_favoritos WHERE usuario_id = :usuarioId AND livro_id = :livroId";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id);
            $consulta->bindValue(':livroId', $livro_id);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao Remover dos Favoritos. Fale com o Suporte.");
        }
    }
}