<?php
require_once "vendor/autoload.php";

use CineLivro\Services\FilmeServico;
use CineLivro\Services\LivroServico;
use CineLivro\Helpers\Utils;

header('Content-Type: application/json');

$termo = $_GET['termo'] ?? '';
$tipo = $_GET['tipo'] ?? 'todos';

if (empty($termo)) {
    echo json_encode(['erro' => 'Termo de busca não fornecido']);
    exit;
}

try {
    $resultados = [];
    
    if ($tipo === 'todos' || $tipo === 'filmes') {
        $filmeServico = new FilmeServico();
        $filmes = $filmeServico->buscar($termo);
        foreach ($filmes as $filme) {
            $resultados[] = [
                'id' => $filme['id'],
                'titulo' => $filme['titulo'],
                'tipo' => 'filme',
                'imagem' => $filme['poster_url'],
                'descricao' => $filme['descricao'],
                'genero' => $filme['genero'],
                'url' => 'filmes.php?id=' . $filme['id']
            ];
        }
    }
    
    if ($tipo === 'todos' || $tipo === 'livros') {
        $livroServico = new LivroServico();
        $livros = $livroServico->buscar($termo);
        foreach ($livros as $livro) {
            $resultados[] = [
                'id' => $livro['id'],
                'titulo' => $livro['titulo'],
                'tipo' => 'livro',
                'imagem' => $livro['imagem_capa_url'],
                'descricao' => $livro['descricao'],
                'genero' => $livro['genero'],
                'url' => 'livros.php?id=' . $livro['id']
            ];
        }
    }
    
    echo json_encode(['sucesso' => true, 'resultados' => $resultados]);
} catch (Throwable $erro) {
    Utils::registrarLog($erro);
    echo json_encode(['erro' => 'Erro ao realizar a busca']);
} 