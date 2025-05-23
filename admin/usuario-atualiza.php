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

        header("location:usuario.php");
        exit;
    } catch (Throwable $erro) {
        Utils::registrarLog($erro);
        $mensagemDeErro = "Houve um erro ao atualizar usuarios. Fale com o Suporte.";
    }
}
?>