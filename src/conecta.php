<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "cine_livro";

try {

    $conexao = new PDO(
        "mysql:host=$servidor;dbname=$banco;charset=utf8",
        $usuario,
        $senha
    );

    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $erro) {
    die("Deu Ruim: " . $erro->getMessage());
}
