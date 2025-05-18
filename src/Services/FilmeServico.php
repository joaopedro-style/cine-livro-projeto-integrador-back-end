<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Helpers\Utils;
use Exception;
use PDO;
use Throwable;

final class FilmeServico
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = ConexaoBD::getConexao();
    }

    public function buscar(string $termo): array
    {
        try {
            $sql = " SELECT * FROM filmes
            WHERE titulo LIKE :termo 
               OR diretor LIKE :termo 
               OR classificacao LIKE :termo
               OR genero LIKE :termo 
               OR data_lancamento LIKE :termo
            ORDER BY titulo ASC ";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':termo', '%' . $termo . '%');
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar filmes. Fale com o Suporte.");
        }
    }

    public function adicionarAosFavoritos(int $usuario_id, int $filme_id): void
    {
        try {
            $sql = "INSERT INTO filmes_favoritos (usuario_id, filme_id) VALUES (:usuarioId, :filmeId)";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id);
            $consulta->bindValue(':filmeId', $filme_id);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao Adicionar aos Favoritos. Fale com o suporte.");
        }
    }

    public function removerDosFavoritos(int $usuario_id, int $filme_id): void
    {
        try {
            $sql = "DELETE FROM filmes_favoritos WHERE usuario_id = :usuarioId AND filme_id = :filmeId";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id);
            $consulta->bindValue(':filmeId', $filme_id);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao Remover dos Favoritos. Fale com o Suporte.");
        }
    }
}
