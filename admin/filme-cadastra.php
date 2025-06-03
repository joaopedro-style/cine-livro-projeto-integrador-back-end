<?php
require_once "../vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Filme;
use CineLivro\Services\FilmeServico;
use CineLivro\Services\GeneroServico;
use CineLivro\Services\PlataformaServico;

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$filmeServico = new FilmeServico();
$generoServico = new GeneroServico();
$plataformaServico = new PlataformaServico();

$listaDeGeneros = $generoServico->listarTodos();
$listaDePlataformas = $plataformaServico->listarTodos();

if (isset($_POST["cadastrar"])) {
    try {
        $titulo = Utils::sanitizar($_POST["titulo"]);
        $diretor = Utils::sanitizar($_POST["diretor"]);
        $data_lancamento = $_POST["data_lancamento"];
        $duracao = (int) Utils::sanitizar($_POST["duracao"], "inteiro");
        $classificacao = Utils::sanitizar($_POST["classificacao"]);
        $descricao = Utils::sanitizar($_POST["descricao"]);
        $poster_url = Utils::sanitizar($_POST["poster_url"]);
        $genero_id = (int) Utils::sanitizar($_POST["genero_id"], "inteiro");
        $usuario_id = $_SESSION["id"];
        $plataformaId = isset($_POST["plataforma"]) ? (int) $_POST["plataforma"] : null;

        $filme = new Filme(
            $titulo,
            $diretor,
            $data_lancamento,
            $duracao,
            $classificacao,
            $descricao,
            $poster_url,
            $usuario_id,
            $genero_id,
            $plataformaId
        );

        $filmeId = $filmeServico->cadastrarRetornandoId($filme, TipoUsuario::ADMIN);

        if ($plataformaId !== null) {
            $filmeServico->adicionarFilmePlataforma($filmeId, $plataformaId);
        }

        header("location:filme.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao cadastrar filme.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";
?>

<div class="container my-5">
    <article class="col-12 bg-black rounded shadow py-4">

        <h2 class="text-center text-white">
            Cadastrar novo filme
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-cadastrar" name="form-cadastrar">

            <div class="mb-3 text-white">
                <label class="form-label" for="titulo">Título:</label>
                <input class="form-control" type="text" id="titulo" name="titulo" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="diretor">Diretor:</label>
                <input class="form-control" type="text" id="diretor" name="diretor" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="data_lancamento">Data de Lançamento:</label>
                <input class="form-control" type="date" id="data_lancamento" name="data_lancamento" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="duracao">Duração (em minutos):</label>
                <input class="form-control" type="number" id="duracao" name="duracao" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="classificacao">Classificação:</label>
                <input class="form-control" type="text" id="classificacao" name="classificacao">
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="genero_id">Gênero:</label>
                <select class="form-select" name="genero_id" id="genero_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($listaDeGeneros as $genero) : ?>
                        <option value="<?= $genero['id'] ?>"><?= $genero['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label">Plataformas:</label>
                <div class="d-flex flex-wrap">
                    <?php foreach ($listaDePlataformas as $index => $plataforma) : ?>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="plataforma" value="<?= $plataforma['id'] ?>" id="plataforma<?= $plataforma['id'] ?>" <?= $index === 0 ? 'required' : '' ?>>
                            <label class="form-check-label" for="plataforma<?= $plataforma['id'] ?>">
                                <?= $plataforma['nome'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="poster_url">Poster URL:</label>
                <input class="form-control" type="url" id="poster_url" name="poster_url">
            </div>

            <button class="btn btn-success" name="cadastrar">
                <i class="bi bi-plus-circle"></i> Cadastrar
            </button>
            <a href="filme.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>