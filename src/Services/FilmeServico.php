<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Filme;
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

    public function getConexao(): PDO
    {
        return $this->conexao;
    }

    public function listarTodos(TipoUsuario $tipoUsuario): array
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem listar todos os filmes.");
        }

        $sql = "SELECT filmes.id, filmes.titulo, filmes.diretor, filmes.data_lancamento,
                   filmes.duracao, filmes.classificacao, filmes.descricao,
                   filmes.poster_url, filmes.usuario_id, generos.nome AS genero,
                   usuarios.nome AS nome_usuario
            FROM filmes
            INNER JOIN generos ON filmes.genero_id = generos.id
            INNER JOIN usuarios ON filmes.usuario_id = usuarios.id
            ORDER BY filmes.data_lancamento DESC";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao listar filmes.");
        }
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT filmes.*, generos.nome AS genero,
                   GROUP_CONCAT(plataformas.nome SEPARATOR ', ') AS plataformas
            FROM filmes
            INNER JOIN generos ON filmes.genero_id = generos.id
            LEFT JOIN filmes_plataformas ON filmes.id = filmes_plataformas.filme_id
            LEFT JOIN plataformas ON filmes_plataformas.plataforma_id = plataformas.id
            WHERE filmes.id = :id
            GROUP BY filmes.id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar filme por ID.");
        }
    }

    public function cadastrar(Filme $filme, TipoUsuario $tipoUsuario): void
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem inserir filmes.");
        }

        $sql = "INSERT INTO filmes (
                titulo, diretor, data_lancamento, duracao, classificacao,
                descricao, poster_url, usuario_id, genero_id
            ) VALUES (
                :titulo, :diretor, :data_lancamento, :duracao, :classificacao,
                :descricao, :poster_url, :usuario_id, :genero_id
            )";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":titulo", $filme->getTitulo(), PDO::PARAM_STR);
            $consulta->bindValue(":diretor", $filme->getDiretor(), PDO::PARAM_STR);
            $consulta->bindValue(":data_lancamento", $filme->getData_lancamento(), PDO::PARAM_STR);
            $consulta->bindValue(":duracao", $filme->getDuracao(), PDO::PARAM_INT);
            $consulta->bindValue(":classificacao", $filme->getClassificacao(), PDO::PARAM_STR);
            $consulta->bindValue(":descricao", $filme->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":poster_url", $filme->getPoster_url(), PDO::PARAM_STR);
            $consulta->bindValue(":usuario_id", $filme->getUsuario_id(), PDO::PARAM_INT);
            $consulta->bindValue(":genero_id", $filme->getGenero_id(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao inserir filme.");
        }
    }

    public function atualizar(Filme $filme, TipoUsuario $tipoUsuario): void
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem atualizar filmes.");
        }

        $sql = "UPDATE filmes SET
                titulo = :titulo,
                diretor = :diretor,
                data_lancamento = :data_lancamento,
                duracao = :duracao,
                classificacao = :classificacao,
                descricao = :descricao,
                poster_url = :poster_url,
                usuario_id = :usuario_id,
                genero_id = :genero_id
            WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":titulo", $filme->getTitulo(), PDO::PARAM_STR);
            $consulta->bindValue(":diretor", $filme->getDiretor(), PDO::PARAM_STR);
            $consulta->bindValue(":data_lancamento", $filme->getData_lancamento(), PDO::PARAM_STR);
            $consulta->bindValue(":duracao", $filme->getDuracao(), PDO::PARAM_INT);
            $consulta->bindValue(":classificacao", $filme->getClassificacao(), PDO::PARAM_STR);
            $consulta->bindValue(":descricao", $filme->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":poster_url", $filme->getPoster_url(), PDO::PARAM_STR);
            $consulta->bindValue(":usuario_id", $filme->getUsuario_id(), PDO::PARAM_INT);
            $consulta->bindValue(":genero_id", $filme->getGenero_id(), PDO::PARAM_INT);
            $consulta->bindValue(":id", $filme->getId(), PDO::PARAM_INT);

            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao atualizar filme.");
        }
    }

    public function excluir(int $id, TipoUsuario $tipoUsuario): void
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem excluir filmes.");
        }

        $sql = "DELETE FROM filmes WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao excluir filme.");
        }
    }

    public function buscar(string $termo): array
    {
        try {
            $sql = "SELECT filmes.*, generos.nome AS genero,
                    GROUP_CONCAT(plataformas.nome SEPARATOR ', ') AS plataformas
                FROM filmes
                INNER JOIN generos ON filmes.genero_id = generos.id
                LEFT JOIN filmes_plataformas ON filmes.id = filmes_plataformas.filme_id
                LEFT JOIN plataformas ON filmes_plataformas.plataforma_id = plataformas.id
                WHERE filmes.titulo LIKE :termo 
                   OR filmes.diretor LIKE :termo 
                   OR filmes.classificacao LIKE :termo
                   OR filmes.data_lancamento LIKE :termo
                   OR generos.nome LIKE :termo
                GROUP BY filmes.id
                ORDER BY filmes.titulo ASC";

            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
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
            $sql = "SELECT COUNT(*) FROM filmes_favoritos WHERE usuario_id = :usuarioId AND filme_id = :filmeId";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id, PDO::PARAM_INT);
            $consulta->bindValue(':filmeId', $filme_id, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->fetchColumn() > 0) {
                return;
            }

            $sql = "INSERT INTO filmes_favoritos (usuario_id, filme_id) VALUES (:usuarioId, :filmeId)";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id, PDO::PARAM_INT);
            $consulta->bindValue(':filmeId', $filme_id, PDO::PARAM_INT);
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

    public function verificarFavorito(int $usuario_id, int $filme_id): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM filmes_favoritos WHERE usuario_id = :usuarioId AND filme_id = :filmeId";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id, PDO::PARAM_INT);
            $consulta->bindValue(':filmeId', $filme_id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetchColumn() > 0;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao verificar favorito. Fale com o Suporte.");
        }
    }

    public function retornandoId(Filme $filme): int
    {
        $sql = "INSERT INTO filmes (
            titulo, diretor, data_lancamento, duracao, classificacao,
            descricao, poster_url, usuario_id, genero_id
        ) VALUES (
            :titulo, :diretor, :data_lancamento, :duracao, :classificacao,
            :descricao, :poster_url, :usuario_id, :genero_id
        )";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":titulo", $filme->getTitulo(), PDO::PARAM_STR);
            $consulta->bindValue(":diretor", $filme->getDiretor(), PDO::PARAM_STR);
            $consulta->bindValue(":data_lancamento", $filme->getData_lancamento(), PDO::PARAM_STR);
            $consulta->bindValue(":duracao", $filme->getDuracao(), PDO::PARAM_INT);
            $consulta->bindValue(":classificacao", $filme->getClassificacao(), PDO::PARAM_STR);
            $consulta->bindValue(":descricao", $filme->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":poster_url", $filme->getPoster_url(), PDO::PARAM_STR);
            $consulta->bindValue(":usuario_id", $filme->getUsuario_id(), PDO::PARAM_INT);
            $consulta->bindValue(":genero_id", $filme->getGenero_id(), PDO::PARAM_INT);
            $consulta->execute();

            return (int) $this->conexao->lastInsertId();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao retornar id do filme.");
        }
    }

    public function adicionarFilmePlataforma(int $filmeId, int $plataformaId): void
    {
        $sql = "INSERT INTO filmes_plataformas (filme_id, plataforma_id) VALUES (:filmeId, :plataformaId)";
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':filmeId', $filmeId, PDO::PARAM_INT);
            $consulta->bindValue(':plataformaId', $plataformaId, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao associar filme à plataforma.");
        }
    }
}
