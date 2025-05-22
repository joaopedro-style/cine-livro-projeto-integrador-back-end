<?php
namespace CineLivro\Auth;

final class ControleDeAcesso
{
    private function __construct() {}

    private static function iniciarsessao(): void
    {
        if(!isset($_SESSION)) session_start();
    }

    public static function exigirLogin(): void
    {
        self::iniciarsessao();

        if(!isset($_SESSION['id'])){
            session_destroy();
            header("location:../login.php?acesso_negado");
        }
    }

    public static function login(int $id, string $nome, string $tipo): void
    {
        self::iniciarsessao();

        $_SESSION['id'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['tipo'] = $tipo;
    }
}