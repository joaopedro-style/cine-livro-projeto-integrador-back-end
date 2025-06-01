<?php
require_once "vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\FilmeServico;
use CineLivro\Services\LivroServico;
use CineLivro\Helpers\Utils;

header('Content-Type: application/json');

ControleDeAcesso::iniciarsessao();
ControleDeAcesso::exigirLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

$tipo = $_POST['tipo'] ?? '';
$id = (int)($_POST['id'] ?? 0);

if (!$id || !in_array($tipo, ['filme', 'livro'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Parâmetros inválidos']);
    exit;
}

try {
    if ($tipo === 'filme') {
        $servico = new FilmeServico();
    } else {
        $servico = new LivroServico();
    }

    $favorito = $servico->verificarFavorito($_SESSION['id'], $id);
    echo json_encode(['favorito' => $favorito]);
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao verificar favorito']);
} 