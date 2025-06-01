<?php

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Helpers\Utils;
use CineLivro\Models\Plataforma;
use CineLivro\Services\PlataformaServico;

require_once "../vendor/autoload.php";

ControleDeAcesso::exigirAdmin();

$mensagemDeErro = "";
$plataformaServico = new PlataformaServico();

$id = Utils::sanitizar($_GET["id"], 'inteiro');
$dadosPlataforma = $plataformaServico->buscarPorId($id);

if(empty($dadosPlataforma)) {
    Utils::alertaErro("Plataforma não encontrada.");
    header("location:plataforma.php");
    exit;
}

$listaDePlataformas = $plataformaServico->listarTodos();

if(isset($_POST["atualizar"])) {
    try {
        $id = Utils::sanitizar($_POST["id"], 'inteiro');
        $nome = Utils::sanitizar($_POST["nome"]);

        $plataforma = new Plataforma($nome, $id);

        $plataformaServico->atualizar($plataforma);

        header("location:plataforma.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemDeErro = "Erro ao atualizar plataforma.";
        Utils::registrarLog($erro);
    }
}

require_once "../includes/cabecalho-admin.php";

?>
<div class="row">
    <article class="col-12 bg-white rounded shadow my-1 py-4">

        <h2 class="text-center">
            Atualizar nome da Plataforma
        </h2>

        <?php if (!empty($mensagemDeErro)) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $mensagemDeErro ?>
            </div>
        <?php endif; ?>

        <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
            <input type="hidden" name="id" value="<?= $dadosPlataforma["id"] ?>">

            <div class="mb-3">
                <label class="form-label" for="nome">Nome:</label>
                <input class="form-control" type="text" id="nome" name="nome" value="<?= $dadosPlataforma['nome'] ?>" required>
            </div>

            <button class="btn btn-primary" name="atualizar">
                <i class="bi bi-arrow-clockwise"></i> Atualizar
            </button>
            <a href="plataforma.php" class="btn btn-secondary">Cancelar</a>
        </form>

    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>