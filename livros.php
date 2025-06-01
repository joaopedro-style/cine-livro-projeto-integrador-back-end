<?php
require_once "vendor/autoload.php";

use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\LivroServico;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;

ControleDeAcesso::iniciarsessao();

if(isset($_GET['sair'])) {
    ControleDeAcesso::logout();
}

$livro = null;
$livros = [];
$erroAoCarregar = null;

// Verificar se um ID de livro foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $livroId = (int)$_GET['id'];
    try {
        $livroServico = new LivroServico();
        // Obter o tipo de usuário da sessão e criar o enum
        $tipoUsuario = isset($_SESSION['tipo']) ? TipoUsuario::from($_SESSION['tipo']) : TipoUsuario::PADRÃO; // Assumindo PADRÃO para não logados ou tipo indefinido
        $livro = $livroServico->buscarPorId($livroId, $tipoUsuario);
        
        if (!$livro) {
            $erroAoCarregar = "Livro não encontrado.";
        }
    } catch (Throwable $erro) {
        $erroAoCarregar = "Erro ao carregar detalhes do livro: " . $erro->getMessage();
        error_log("Erro ao buscar livro por ID " . $livroId . ": " . $erro->getMessage());
    }
} else {
    // Buscar livros do banco de dados (para a lista na página principal de livros)
    try {
        $livroServico = new LivroServico();
        $livros = $livroServico->buscar(''); // Mantido como buscar('') para listar todos
        if (empty($livros)) {
            error_log("Nenhum livro encontrado no banco de dados para a lista.");
        }
    } catch (Throwable $erro) {
        $erroAoCarregar = "Erro ao listar livros.";
        error_log("Erro ao buscar livros para lista: " . $erro->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineLivro</title>
    <link rel="icon" type="image/png" href="imagens/cinelivro_logo_transparente.png">
    <link rel="apple-touch-icon" href="imagens/cinelivro_logo_transparente.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header class="bg-cinelivro border-bottom border-dark py-3 mb-4">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="index.php">
                    <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
                </a>
            </div>
            <div class="d-flex align-items-center">

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Buscar filmes, livros...">
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <nav>
                    <ul class="nav navbar-cinelivro">
                        <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                        <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                        <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                    </ul>
                </nav>
                <?php
                if (!isset($_SESSION['id'])) {
                ?>
                    <a href="login.php" class="login-button">
                        <i class="fas fa-user"></i> Login
                    </a>
                <?php } else {
                ?>
                    <a href="?sair" class="login-button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php } ?>
            </div>
        </div>
    </header>

    <main class="container mb-5">
        <?php if ($erroAoCarregar):
        ?>
            <div class="alert alert-danger">
                <?= $erroAoCarregar ?>
            </div>
        <?php elseif ($livro):
        /* Exibir detalhes de um único livro */
        ?>
            <section class="book-details-section">
                <h2 class="mb-4 text-white text-center"><?= htmlspecialchars($livro['titulo']) ?></h2>
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="<?= htmlspecialchars($livro['imagem_capa_url']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: contain; background-color: white; padding: 1rem;">
                    </div>
                    <div class="col-md-8">
                        <div class="detalhes-info">
                            <p class="detalhes-descricao"><?= nl2br(htmlspecialchars($livro['descricao'] ?? 'Sinopse não disponível.')) ?></p>
                            <div class="detalhes-metadata mt-4">
                                <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor'] ?? 'Não informado') ?></p>
                                <p><strong>Data de Lançamento:</strong> <?= htmlspecialchars($livro['data_lancamento'] ? (new DateTime($livro['data_lancamento']))->format('d/m/Y') : 'Não informada') ?></p>
                                <p><strong>Faixa Etária:</strong> <?= htmlspecialchars($livro['faixa_etaria'] ?? 'Não informada') ?></p>
                                <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero'] ?? 'Não informado') ?></p>
                                <p><strong>Plataformas:</strong> <?= htmlspecialchars($livro['plataformas'] ?? 'Não informadas') ?></p>
                            </div>
                            <?php if (isset($_SESSION['id'])):
                            // Mostrar botão de favorito apenas para usuários logados
                            ?>
                                <?php
                                // Verificar se o livro é favorito para o usuário logado
                                $isFavorito = false;
                                try {
                                    // Passar o TipoUsuario obtido da sessão
                                    $isFavorito = $livroServico->verificarFavorito($_SESSION['id'], $livro['id']);
                                } catch (Throwable $e) {
                                    error_log("Erro ao verificar favorito: " . $e->getMessage());
                                }
                                ?>
                                <div class="card-actions mt-4">
                                    <button class="favorite-button <?= $isFavorito ? 'added' : '' ?>" data-id="<?= $livro['id'] ?>" data-tipo="livro" onclick="toggleFavorito(<?= $livro['id'] ?>, 'livro', this); event.stopPropagation();">
                                        <i class="fas fa-heart"></i> <span class="text-button"><?= $isFavorito ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' ?></span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php else:
        /* Exibir a lista de livros se nenhum ID for passado */
        ?>
            <section class="welcome-section">
                <h2 class="mb-2 text-white">Livros</h2>
                <p>Confira os livros mais populares e as últimas novidades do mundo literário.</p>
            </section>
            <section class="recent-section">
                <?php if (empty($livros)):
                ?>
                    <div class="alert alert-info">
                        Nenhum livro encontrado. Por favor, cadastre alguns livros primeiro.
                    </div>
                <?php else:
                ?>
                    <div id="carouselLivros" class="carousel slide">
                        <div class="carousel-inner">
                            <?php
                            // Dividir livros em grupos de 4 para o carrossel
                            $gruposLivros = array_chunk($livros, 4);
                            foreach ($gruposLivros as $index => $grupo):
                            ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="row g-1 justify-content-start">
                                        <?php foreach ($grupo as $livro):
                                        ?>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <!-- Atualizado onclick para redirecionar para a página de detalhes -->
                                                <div class="card card-cinelivro h-100 shadow-sm card-item" data-id="<?= $livro['id'] ?>" data-tipo="livro" onclick="window.location.href = 'livros.php?id=<?= $livro['id'] ?>';">
                                                    <img src="<?= htmlspecialchars($livro['imagem_capa_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($livro['titulo']) ?>">
                                                    <div class="card-body text-center">
                                                        <h4 class="card-title mb-1"><?= htmlspecialchars($livro['titulo']) ?></h4>
                                                        <div class="card-actions">
                                                            <?php if (isset($_SESSION['id'])):
                                                            // Mostrar botão de favorito apenas para usuários logados
                                                            ?>
                                                                <?php
                                                                $isFavorito = false;
                                                                try {
                                                                    // Passar o TipoUsuario obtido da sessão
                                                                    $isFavorito = $livroServico->verificarFavorito($_SESSION['id'], $livro['id']);
                                                                } catch (Throwable $e) {
                                                                    error_log("Erro ao verificar favorito na lista: " . $e->getMessage());
                                                                }
                                                                ?>
                                                                <button class="favorite-button <?= $isFavorito ? 'added' : '' ?>" data-id="<?= $livro['id'] ?>" data-tipo="livro" onclick="toggleFavorito(<?= $livro['id'] ?>, 'livro', this); event.stopPropagation();">
                                                                    <i class="fas fa-heart"></i> <span class="text-button"><?= $isFavorito ? 'Remover' : 'Favoritar' ?></span>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselLivros" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselLivros" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
    <footer class="footer-cinelivro text-center py-3 mt-5">
        <div class="container d-flex justify-content-center align-items-center gap-4">
            <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
            <nav>
                <ul class="nav navbar-cinelivro">
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2025 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/favoritos.js"></script>
    <script src="js/busca.js"></script>
</body>

</html>