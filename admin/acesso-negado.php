<?php
session_start();
require_once "../vendor/autoload.php";
require_once "../includes/cabecalho-admin.php";
?>

<div class="container my-5">
    <article class="p-5 my-5 rounded-3 bg-dark shadow">
        <div class="container-fluid py-1">
            <h2 class="display-4 bg-danger rounded text-center text-white">Acesso Negado!</h2>
            <hr class="my-4">
            <p class="fs-5 text-center text-white"><span style="font-size: 27px;"><b><?= $_SESSION["nome"] ?></b></span>
                você não tem permissão para acessar este recurso.</p>
            <hr class="my-5">
            <p>
                <a href="../index.php" class="btn btn-primary">Voltar para a página inicial</a>
            </p>

        </div>
    </article>
</div>

<?php
require_once "../includes/rodape-admin.php";
?>