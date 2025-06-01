<?php
session_start();
require_once "../vendor/autoload.php";
require_once "../includes/cabecalho-admin.php";
?>

<article class="p-5 my-4 rounded-3 bg-white shadow">
    <div class="container-fluid py-1">
        <h2 class="display-4 bg-danger rounded text-center">Acesso Negado!</h2>
        <hr class="my-4">
        <p class="fs-5 text-center"><b> <?= $_SESSION["nome"] ?></b> você <span class="badge bg-warning">não tem permissão </span> para acessar este recurso.</p>
        <hr class="my-4">

        <p>
            <a href="../index.php" class="btn btn-primary">Voltar para a página inicial</a>
        </p>

    </div>
</article>

<?php
require_once "../includes/rodape-admin.php";
?>