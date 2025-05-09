<?php
namespace CineLivro\Helpers;

abstract class Utils {
    public static function codificarSenha(string $senha):string {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}