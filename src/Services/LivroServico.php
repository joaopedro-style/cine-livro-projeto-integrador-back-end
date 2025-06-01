<?php

namespace CineLivro\Services;

use CineLivro\Database\ConexaoBD;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Livro;
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

    public function getConexao(): PDO
    {
        return $this->conexao;
    }

    public function listarTodos(TipoUsuario $tipoUsuario): array
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem listar todos os livros.");
        }

        $sql = "SELECT livros.id, livros.titulo, livros.autor, livros.data_lancamento,
                   livros.faixa_etaria, livros.descricao, livros.imagem_capa_url, livros.usuario_id,
                   generos.nome AS genero,
                   usuarios.nome AS nome_usuario
            FROM livros
            INNER JOIN generos ON livros.genero_id = generos.id
            INNER JOIN usuarios ON livros.usuario_id = usuarios.id
            ORDER BY livros.data_lancamento DESC";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao listar livros.");
        }
    }

    public function buscarPorId(int $id, TipoUsuario $tipoUsuario): ?array
    {
        $sql = "SELECT livros.*, generos.nome AS genero,
                   GROUP_CONCAT(plataformas.nome SEPARATOR ', ') AS plataformas
            FROM livros
            INNER JOIN generos ON livros.genero_id = generos.id
            LEFT JOIN livros_plataformas ON livros.id = livros_plataformas.livro_id
            LEFT JOIN plataformas ON livros_plataformas.plataforma_id = plataformas.id
            WHERE livros.id = :id
            GROUP BY livros.id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar livro por ID.");
        }
    }

    public function cadastrar(Livro $livro, TipoUsuario $tipoUsuario): void
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem inserir livros.");
        }

        $sql = "INSERT INTO livros (
                titulo, autor, data_lancamento, faixa_etaria, descricao,
                imagem_capa_url, usuario_id, genero_id
            ) VALUES (
                :titulo, :autor, :data_lancamento, :faixa_etaria, :descricao,
                :imagem_capa_url, :usuario_id, :genero_id
            )";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":titulo", $livro->getTitulo(), PDO::PARAM_STR);
            $consulta->bindValue(":autor", $livro->getAutor(), PDO::PARAM_STR);
            $consulta->bindValue(":data_lancamento", $livro->getData_lancamento(), PDO::PARAM_STR);
            $consulta->bindValue(":faixa_etaria", $livro->getFaixa_etaria(), PDO::PARAM_STR);
            $consulta->bindValue(":descricao", $livro->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":imagem_capa_url", $livro->getImagem_capa_url(), PDO::PARAM_STR);
            $consulta->bindValue(":usuario_id", $livro->getUsuario_id(), PDO::PARAM_INT);
            $consulta->bindValue(":genero_id", $livro->getGenero_id(), PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao inserir livro.");
        }
    }

    public function atualizar(Livro $livro, TipoUsuario $tipoUsuario): void
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem atualizar livros.");
        }

        $sql = "UPDATE livros SET
                titulo = :titulo,
                autor = :autor,
                data_lancamento = :data_lancamento,
                faixa_etaria = :faixa_etaria,
                descricao = :descricao,
                imagem_capa_url = :imagem_capa_url,
                usuario_id = :usuario_id,
                genero_id = :genero_id
            WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":titulo", $livro->getTitulo(), PDO::PARAM_STR);
            $consulta->bindValue(":autor", $livro->getAutor(), PDO::PARAM_STR);
            $consulta->bindValue(":data_lancamento", $livro->getData_lancamento(), PDO::PARAM_STR);
            $consulta->bindValue(":faixa_etaria", $livro->getFaixa_etaria(), PDO::PARAM_STR);
            $consulta->bindValue(":descricao", $livro->getDescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":imagem_capa_url", $livro->getImagem_capa_url(), PDO::PARAM_STR);
            $consulta->bindValue(":usuario_id", $livro->getUsuario_id(), PDO::PARAM_INT);
            $consulta->bindValue(":genero_id", $livro->getGenero_id(), PDO::PARAM_INT);
            $consulta->bindValue(":id", $livro->getId(), PDO::PARAM_INT);

            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao atualizar livro.");
        }
    }

    public function excluir(int $id, TipoUsuario $tipoUsuario): void
    {
        if ($tipoUsuario !== TipoUsuario::ADMIN) {
            throw new Exception("Acesso negado. Somente administradores podem excluir livros.");
        }

        $sql = "DELETE FROM livros WHERE id = :id";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao excluir livro.");
        }
    }

    public function buscar(string $termo): array
    {
        try {
            $sql = "SELECT livros.*, generos.nome AS genero,
                    GROUP_CONCAT(plataformas.nome SEPARATOR ', ') AS plataformas
                FROM livros
                INNER JOIN generos ON livros.genero_id = generos.id
                LEFT JOIN livros_plataformas ON livros.id = livros_plataformas.livro_id
                LEFT JOIN plataformas ON livros_plataformas.plataforma_id = plataformas.id
                WHERE livros.titulo LIKE :termo 
                   OR livros.autor LIKE :termo 
                   OR livros.faixa_etaria LIKE :termo
                   OR livros.data_lancamento LIKE :termo
                   OR generos.nome LIKE :termo
                GROUP BY livros.id
                ORDER BY livros.titulo ASC";

            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao buscar livros. Fale com o Suporte.");
        }
    }

    public function adicionarAosFavoritos(int $usuario_id, int $livro_id): void
    {
        try {
            $sql = "SELECT COUNT(*) FROM livros_favoritos WHERE usuario_id = :usuarioId AND livro_id = :livroId";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id, PDO::PARAM_INT);
            $consulta->bindValue(':livroId', $livro_id, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->fetchColumn() > 0) {
                return;
            }

            $sql = "INSERT INTO livros_favoritos (usuario_id, livro_id) VALUES (:usuarioId, :livroId)";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id, PDO::PARAM_INT);
            $consulta->bindValue(':livroId', $livro_id, PDO::PARAM_INT);
            $consulta->execute();
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao adicionar aos favoritos. Fale com o suporte.");
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

    public function verificarFavorito(int $usuario_id, int $livro_id): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM livros_favoritos WHERE usuario_id = :usuarioId AND livro_id = :livroId";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(':usuarioId', $usuario_id, PDO::PARAM_INT);
            $consulta->bindValue(':livroId', $livro_id, PDO::PARAM_INT);
            $consulta->execute();
            
            return $consulta->fetchColumn() > 0;
        } catch (Throwable $erro) {
            Utils::registrarLog($erro);
            throw new Exception("Erro ao verificar favorito. Fale com o Suporte.");
        }
    }
}
