<?php

namespace CineLivro\Helpers;

use CineLivro\Enums\TipoUsuario;
use DateTime;
use InvalidArgumentException;

final class Validacoes
{
    private function __construct()
    {
    }

    public static function validarNome(string $nome): void
    {
        if (empty($nome)) {
            throw new InvalidArgumentException("O Nome é obrigatório.");
        }
    }

    public static function validarEmail(string $email): void
    {
        if (empty($email)) {
            throw new InvalidArgumentException("O Email é obrigatório.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido.");
        }
    }

    public static function validarSenha(string $senha): void
    {
        if (empty($senha)) {
            throw new InvalidArgumentException("A Senha é obrigatória.");
        }
    }

    public static function validarTipo(string $tipo): void
    {
        if (empty($tipo)) {
            throw new InvalidArgumentException("Selecione um tipo de usuário.");
        }

        if (!TipoUsuario::tryFrom($tipo)) {
            throw new InvalidArgumentException("Tipo de usuário inválido.");
        }
    }

    public static function validarTitulo(string $titulo): void
    {
        if (empty($titulo)) {
            throw new InvalidArgumentException("Título não pode ser vazio.");
        }
    }

    public static function validarDescricao(string $descricao): void
    {
        if (empty($descricao)) {
            throw new InvalidArgumentException("Descrição não pode ser vazio.");
        }
    }

    public static function validarDataLancamento(string $data): void
    {
        if (empty($data)) {
            throw new InvalidArgumentException("A data de lançamento é obrigatória.");
        }

        $dataFormatada = DateTime::createFromFormat('Y-m-d', $data);

        if (!$dataFormatada || $dataFormatada->format('Y-m-d') !== $data) {
            throw new InvalidArgumentException("Formato de data inválido.");
        }

        if ($dataFormatada > new DateTime()) {
            throw new InvalidArgumentException("A data de lançamento não pode estar vazia.");
        }
    }

    public static function validarDuracao(int $duracao): void
    {
        if ($duracao <= 0) {
            throw new InvalidArgumentException("A duração deve ser um número positivo.");
        }

        if ($duracao > 240) {
            throw new InvalidArgumentException("A duração máxima permitida é 600 minutos.");
        }
    }

    public static function validarClassificacao(string $classificacao): void
    {
        $valoresValidos = ['Livre', '10 anos', '12 anos', '14 anos', '16 anos', '18 anos'];

        if (empty($classificacao)) {
            throw new InvalidArgumentException("A classificação é obrigatória.");
        }

        if (!in_array($classificacao, $valoresValidos, true)) {
            throw new InvalidArgumentException("Classificação inválida.");
        }
    }

    public static function validarDataNascimento(string $dataNascimento): void
    {
        if (empty($dataNascimento)) {
            throw new InvalidArgumentException("A data de nascimento é obrigatória.");
        }
        
        $data = DateTime::createFromFormat('Y-m-d', $dataNascimento);
        $erros = DateTime::getLastErrors();
        
        if ($data === false || ($erros !== false && ($erros['warning_count'] > 0 || $erros['error_count'] > 0))) {
            throw new InvalidArgumentException("Data de nascimento inválida.");
        }
    }


    public static function validarFaixaEtaria(string $faixa): void
    {
        $faixasValidas = ['Infantil', 'Infantojuvenil', 'juvenil', 'Adulto'];

        if (empty($faixa)) {
            throw new InvalidArgumentException("A faixa etária é obrigatória.");
        }

        if (!in_array($faixa, $faixasValidas, true)) {
            throw new InvalidArgumentException("Faixa etária inválida.");
        }
    }
}
