<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Livro;
use CineLivro\Services\GeneroServico;
use CineLivro\Services\LivroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$livroServico = new LivroServico();
$generoServico = new GeneroServico();

$id = Utils::sanitizar($_GET["id"], 'inteiro');
$dadosLivro = $livroServico->buscarPorId($id, TipoUsuario::ADMIN);

if (empty($dadosLivro)) {
    Utils::alertaErro("Livro não encontrado.");
    header("location:livro.php");
    exit;
}

$listaDeGeneros = $generoServico->listarTodos();

if (isset($_POST["atualizar"])) {
    try {
        $titulo = Utils::sanitizar($_POST["titulo"]);
        $autor = Utils::sanitizar($_POST["autor"]);
        $data_lancamento = $_POST["data_lancamento"];
        $faixa_etaria = Utils::sanitizar($_POST["faixa_etaria"]);
        $descricao = Utils::sanitizar($_POST["descricao"]);
        $imagem_capa_url = Utils::sanitizar($_POST["imagem_capa_url"]);
        $genero_id = (int) Utils::sanitizar($_POST["genero_id"], "inteiro");
        $usuario_id = $_SESSION["id"];

        $livro = new Livro($titulo, $autor, $data_lancamento, $faixa_etaria, $descricao, $imagem_capa_url, $usuario_id, $genero_id, $id);

        $livroServico->atualizar($livro, TipoUsuario::ADMIN);

        header("location:livro.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao atualizar livro.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="container my-5">
    <article class="col-12 bg-dark rounded shadow py-4">

        <h2 class="text-center text-white">
            Atualizar dados do livro
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
            <input type="hidden" name="id" value="<?= $dadosLivro["id"] ?>">

            <div class="mb-3 text-white">
                <label class="form-label" for="titulo">Título:</label>
                <input class="form-control" type="text" id="titulo" name="titulo" value="<?= $dadosLivro['titulo'] ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="autor">Autor:</label>
                <input class="form-control" type="text" id="autor" name="autor" value="<?= $dadosLivro['autor'] ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="data_lancamento">Data de Lançamento:</label>
                <input class="form-control" type="date" id="data_lancamento" name="data_lancamento" value="<?= $dadosLivro['data_lancamento'] ?>" required>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="faixa_etaria">Faixa etaria:</label>
                <input class="form-control" type="text" id="faixa_etaria" name="faixa_etaria" value="<?= $dadosLivro['faixa_etaria'] ?>">
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="genero_id">Gênero:</label>
                <select class="form-select" name="genero_id" id="genero_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($listaDeGeneros as $genero) : ?>
                        <option value="<?= $genero['id'] ?>" <?= ($genero['nome'] === $dadosLivro['genero']) ? 'selected' : '' ?>>
                            <?= $genero['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= $dadosLivro['descricao'] ?></textarea>
            </div>

            <div class="mb-3 text-white">
                <label class="form-label" for="imagem_capa_url">Imagem capa url:</label>
                <input class="form-control" type="url" id="imagem_capa_url" name="imagem_capa_url" value="<?= $dadosLivro['imagem_capa_url'] ?>">
            </div>

            <button class="btn btn-success" name="atualizar">
                <i class="bi bi-arrow-clockwise"></i> Atualizar
            </button>
            <a href="livro.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>