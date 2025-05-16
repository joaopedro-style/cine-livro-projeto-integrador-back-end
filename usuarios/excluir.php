<?php

use CineLivro\Helpers\Utils;
use CineLivro\Services\UsuarioServico;

require_once "../vendor/autoload.php";

$mensagemDeErro = "";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

try {
    $usuarioServico = new UsuarioServico();
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    $mensagemDeErro = "Houve um erro ao carregar os dados. Fale com o Suporte.";
}

if (isset($_GET['confirmar-exclusao'])) {
    try {
        $usuarioServico->excluir($id);
        header("location:visualizar.php");
        exit;
    } catch (Throwable $erro) {
        Utils::registrarLog($erro);
        $mensagemDeErro = "Houve um erro ao excluir Usuarios. Fale com o Suporte.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Exclusão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-2 shadow-lg rounded pb-1">
        <h1>Usuarios | DELETE</h1>
        <hr>

        <div class="alert alert-danger w-50">
            <p> Deseja realmente excluir este usuario?</p>

            <a href="visualizar.php" class="btn btn-secondary">Não</a>
            <a href="?id=<?= $id ?>&confirmar-exclusao" class="btn btn-danger">Sim</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>