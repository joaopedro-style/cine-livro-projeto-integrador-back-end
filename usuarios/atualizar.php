<?php

use CineLivro\Helpers\Utils;
use CineLivro\Models\Usuario;
use CineLivro\Services\UsuarioServico;

require_once "../vendor/autoload.php";

$mensagemDeErro = "";

try {
    $usuarioServico = new UsuarioServico();
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $usuarioDados = $usuarioServico->buscarPorId($id);
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    $mensagemDeErro = "Houve um erro ao buscar o id do usuario. Fale com o Suporte";
}

if (isset($_POST['atualizar'])) {
    try {
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data_nascimento = filter_input(INPUT_POST, "data_nascimento", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($senha)) {
            $senhaCodificada = $usuarioDados['senha'];
        } else {
            $senhaCodificada = Utils::codificarSenha($senha);
        }

        $usuario = new Usuario($nome, $email, $senhaCodificada, $data_nascimento, $id);

        $usuarioServico->atualizar($usuario);

        header("location:visualizar.php");
        exit;
    } catch (Throwable $erro) {
        Utils::registrarLog($erro);
        $mensagemDeErro = "Houve um erro ao atualizar usuarios. Fale com o Suporte.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Atualização</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-2 shadow-lg rounded pb-1">
        <h1><a class="btn btn-outline-dark" href="visualizar.php">&lt; Voltar</a> Usuarios | SELECT/UPDATE</h1>
        <hr>

        <form action="" method="post" class="w-25">
            <input type="hidden" name="id" value="<?= $usuarioDados['id'] ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input value="<?= $usuarioDados['nome'] ?>" class="form-control" required type="text" name="nome" id="nome">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input value="<?= $usuarioDados['email'] ?>" class="form-control" required type="text" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input value="<?= $usuarioDados['senha'] ?>" class="form-control" required type="password" name="senha" id="senha">
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de nascimento:</label>
                <input value="<?= $usuarioDados['data_nascimento'] ?>" class="form-control" required type="date" name="data_nascimento" id="data_nascimento">
            </div>
            <button class="btn btn-warning" type="submit" name="atualizar">
                Atualizar usuario</button>
        </form>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>