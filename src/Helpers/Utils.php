<?php
namespace CineLivro\Helpers;

use Throwable;

final class Utils {
private function __construct() {
    
}
    public static function codificarSenha(string $senha):string {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    public static function registrarLog(Throwable $e): void
    {
        date_default_timezone_set('America/Sao_Paulo');

        $mensagem = "[" . date("Y-m-d H:i:s") . "]\n" .
            "Arquivo: " . $e->getFile() . "\n" .
            "Linha: " . $e->getLine() . "\n" .
            "Mensagem: " . $e->getMessage() . "\n\n";


        file_put_contents(__DIR__ . '/../../logs/erros.log', $mensagem, FILE_APPEND);
    }
}