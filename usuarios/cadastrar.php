<?php

use CineLivro\Models\Usuario;
use CineLivro\Services\UsuarioServico;
use CineLivro\Helpers\Utils;

require_once "../vendor/autoload.php";

$mensagemDeErro = "";

try {
    $usuarioServico = new UsuarioServico();
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    $mensagemDeErro = "Houve um erro ao carregar os dados. Fale com o Suporte.";
}

if (isset($_POST['cadastrar'])) {
    $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $senhaCodificada = Utils::codificarSenha($senha);
    $data_nascimento = filter_input(INPUT_POST, "data_nascimento", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
        $usuario = new Usuario($nome, $email, $senhaCodificada, $data_nascimento);
        $usuarioServico->cadastrar($usuario);
        header("location:visualizar.php");
        exit;
    } catch (Throwable $erro) {
        Utils::registrarLog($erro);
        $mensagemDeErro = "Houve um erro ao cadastrar Usuario. Fale com o Suporte.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-2 shadow-lg rounded pb-1">
        <h1><a class="btn btn-outline-dark" href="visualizar.php">&lt; Voltar</a> Usuarios | Cadastro</h1>
        <hr>

        <form action="" method="post" class="w-25">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input class="form-control" required type="text" name="nome" id="nome">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input class="form-control" required type="text" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input class="form-control" required type="password" name="senha" id="senha">
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de nascimento:</label>
                <input class="form-control" required type="date" name="data_nascimento" id="data_nascimento">
            </div>
            <button class="btn btn-success" type="submit" name="cadastrar">Cadastrar usuario</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>