<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Genero;
use CineLivro\Services\GeneroServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$generoServico = new GeneroServico();

$listaDeGeneros = $generoServico->listarTodos();

if (isset($_POST["cadastrar"])) {
    try {
        $nome = Utils::sanitizar($_POST["nome"]);

        $genero = new Genero($nome);

        $generoServico->cadastrar($genero);

        header("location:genero.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao cadastrar genero.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>

<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Cadastrar novo Genero
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-cadastrar" name="form-cadastrar">

            <div class="mb-3">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" id="nome" name="nome" required>
            </div>

            <button class="btn btn-success" name="cadastrar">
                <i class="bi bi-plus-circle"></i> Cadastrar
            </button>
            <a href="genero.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>