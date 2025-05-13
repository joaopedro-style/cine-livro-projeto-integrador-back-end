<?php
namespace CineLivro\Helpers;



final class Utils {
private function __construct() {
    
}

    public static function codificarSenha(string $senha):string {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}