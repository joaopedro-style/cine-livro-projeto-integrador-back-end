<?php

namespace CineLivro\Helpers;

use Throwable;

final class Utils
{
    private function __construct() {}

    public static function sanitizar(mixed $entrada, string $tipo = 'texto'): mixed
    {
        switch ($tipo) {
            case 'email':
                return trim(filter_var($entrada, FILTER_SANITIZE_EMAIL));
            case 'inteiro':
                return (int) filter_var($entrada, FILTER_SANITIZE_NUMBER_INT);
            case 'arquivo':
                if (is_array($entrada) && isset($entrada['tmp_name']) && is_uploaded_file($entrada['tmp_name'])) {
                    return $entrada;
                } else {
                    return null;
                }
            default:
                return trim(filter_var($entrada, FILTER_SANITIZE_SPECIAL_CHARS));
        }
    }

    public static function verificarId(mixed $valor): void
    {
        if (!isset($valor) || !is_numeric($valor) || $valor <= 0) {
            header("Location: index.php");
            exit;
        }
    }

    public static function dump(mixed $dados): void
    {
        echo "<pre>";
        var_dump($dados);
        echo "</pre>";
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

    public static function formataData(string $data): string
    {
        return date("d/m/Y", strtotime($data));
    }

    public static function codificarSenha(string $senha): string
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    public static function verificarSenha(
        string $senhaFormulario,
        string $senhaBanco
    ): string {

        if (password_verify($senhaFormulario, $senhaBanco)) {
            return $senhaBanco;
        } else {
            return self::codificarSenha($senhaFormulario);
        }
    }

    public static function alertaErro(string $mensagem): void
    {
        $mensagemSanitizada = filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
        die("<script>alert('$mensagemSanitizada'); history.back(); </script>");
    }
}
