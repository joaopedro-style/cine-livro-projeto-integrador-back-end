<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Plataforma;
use CineLivro\Services\PlataformaServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$plataformaServico = new PlataformaServico();

$listaDePlataformas = $plataformaServico->listarTodos();

if (isset($_POST["cadastrar"])) {
    try {
        $nome = Utils::sanitizar($_POST["nome"]);

        if (empty($nome)) {
            throw new Exception("O nome da plataforma não pode ser vazio.");
        }

        $plataforma = new Plataforma($nome);

        $plataformaServico->cadastrar($plataforma);

        header("location:plataforma.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao cadastrar plataforma.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>
<div class="container my-5">
    <article class="col-12 bg-dark rounded shadow py-4">

        <h2 class="text-center text-white">
            Cadastrar nova Plataforma
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-cadastrar" name="form-cadastrar">

            <div class="mb-3 text-white">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" id="nome" name="nome" required>
            </div>

            <button class="btn btn-success" name="cadastrar">
                <i class="bi bi-plus-circle"></i> Cadastrar
            </button>
            <a href="plataforma.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>