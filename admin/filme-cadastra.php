<?php
require_once "../vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Filme;
use CineLivro\Services\FilmeServico;
use CineLivro\Services\GeneroServico;

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$filmeServico = new FilmeServico();
$generoServico = new GeneroServico();

$listaDeGeneros = $generoServico->listarTodos();

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

        $filme = new Filme(
            $titulo,
            $diretor,
            $data_lancamento,
            $duracao,
            $classificacao,
            $descricao,
            $poster_url,
            $usuario_id,
            $genero_id
        );

        $filmeServico->cadastrar($filme, TipoUsuario::ADMIN);

        header("location:filme.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao cadastrar filme.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Cadastro de novo filme
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-cadastrar" name="form-cadastrar">

            <div class="mb-3">
                <label class="form-label" for="titulo">Título:</label>
                <input class="form-control" type="text" id="titulo" name="titulo" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="diretor">Diretor:</label>
                <input class="form-control" type="text" id="diretor" name="diretor" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="data_lancamento">Data de Lançamento:</label>
                <input class="form-control" type="date" id="data_lancamento" name="data_lancamento" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="duracao">Duração (em minutos):</label>
                <input class="form-control" type="number" id="duracao" name="duracao" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="classificacao">Classificação:</label>
                <input class="form-control" type="text" id="classificacao" name="classificacao">
            </div>

            <div class="mb-3">
                <label class="form-label" for="genero_id">Gênero:</label>
                <select class="form-select" name="genero_id" id="genero_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($listaDeGeneros as $genero) : ?>
                        <option value="<?= $genero['id'] ?>"><?= $genero['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>

            <div class="mb-3">
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