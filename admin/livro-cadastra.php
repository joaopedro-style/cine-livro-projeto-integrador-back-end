<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Livro;
use CineLivro\Services\GeneroServico;
use CineLivro\Services\LivroServico;
use CineLivro\Services\PlataformaServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$livroServico = new LivroServico();
$generoServico = new GeneroServico();
$plataformaServico = new PlataformaServico();

$listaDeGeneros = $generoServico->listarTodos();
$listaDePlataformas = $plataformaServico->listarTodos();

if (isset($_POST["cadastrar"])) {
    try {
        $titulo = Utils::sanitizar($_POST["titulo"]);
        $autor = Utils::sanitizar($_POST["autor"]);
        $data_lancamento = $_POST["data_lancamento"];
        $faixa_etaria = Utils::sanitizar($_POST["faixa_etaria"]);
        $descricao = Utils::sanitizar($_POST["descricao"]);
        $imagem_capa_url = Utils::sanitizar($_POST["imagem_capa_url"]);
        $genero_id = (int) Utils::sanitizar($_POST["genero_id"], "inteiro");
        $usuario_id = $_SESSION["id"];
        $plataformaId = isset($_POST["plataforma"]) ? (int) $_POST["plataforma"] : null;

        if (empty($titulo) || empty($autor) || empty($data_lancamento) || empty($genero_id)) {
            throw new Exception("Preencha todos os campos.");
        }

        $livro = new Livro($titulo, $autor, $data_lancamento, $faixa_etaria, $descricao, $imagem_capa_url, $usuario_id, $genero_id, $plataformaId);

        $livroId = $livroServico->retornandoId($livro);

        if ($plataformaId !== null) {
            $livroServico->adicionarLivroPlataforma($livroId, $plataformaId);
        }

        header("location:livro.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao cadastrar livro.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="container my-5">
    <article class="col-12 bg-dark rounded shadow py-4">

        <h2 class="text-center text-white">
            Cadastrar novo livro
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
                <label class="form-label" for="autor">Autor:</label>
                <input class="form-control" type="text" id="autor" name="autor" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="data_lancamento">Data de Lançamento:</label>
                <input class="form-control" type="date" id="data_lancamento" name="data_lancamento" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="faixa_etaria">Faixa etaria:</label>
                <input class="form-control" type="text" id="faixa_etaria" name="faixa_etaria" required>
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
                <label class="form-label">Plataforma:</label>
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
                <label class="form-label" for="imagem_capa_url">Imagem capa URL:</label>
                <input class="form-control" type="url" id="imagem_capa_url" name="imagem_capa_url">
            </div>

            <button class="btn btn-success" name="cadastrar">
                <i class="bi bi-plus-circle"></i> Cadastrar
            </button>
            <a href="livro.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>