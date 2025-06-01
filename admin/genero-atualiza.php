<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Genero;
use CineLivro\Services\GeneroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$generoServico = new GeneroServico();

$id = Utils::sanitizar($_GET["id"], 'inteiro');
$dadosGenero = $generoServico->buscarPorId($id);

if (empty($dadosGenero)) {
    Utils::alertaErro("Genero não encontrado.");
    header("location:genero.php");
    exit;
}

$listaDeGeneros = $generoServico->listarTodos();

if (isset($_POST["atualizar"])) {
    try {
        $id = Utils::sanitizar($_POST["id"], 'inteiro');
        $nome = Utils::sanitizar($_POST["nome"]);

        $genero = new Genero($nome, $id);

        $generoServico->atualizar($genero);

        header("location:genero.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao atualizar genero.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Atualizar nome do genero
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
            <input type="hidden" name="id" value="<?= $dadosGenero["id"] ?>">

            <div class="mb-3">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" id="nome" name="nome" value="<?= $dadosGenero['nome'] ?>" required>
            </div>

            <button class="btn btn-primary" name="atualizar">
                <i class="bi bi-arrow-clockwise"></i> Atualizar
            </button>
            <a href="genero.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>