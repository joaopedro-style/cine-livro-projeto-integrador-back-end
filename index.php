<?php
require_once "vendor/autoload.php";
use CineLivro\Auth\ControleDeAcesso;
use CineLivro\Services\FilmeServico;
use CineLivro\Services\LivroServico;
use CineLivro\Enums\TipoUsuario;
use CineLivro\Helpers\Utils;

ControleDeAcesso::iniciarsessao();

if(isset($_GET['sair'])) {
    ControleDeAcesso::logout();
}

// Buscar filmes e livros para os carrosséis
$filmeServico = new FilmeServico();
$livroServico = new LivroServico();
$filmesDestaque = [];
$livrosDestaque = [];
$erroAoCarregarDestaques = null;

try {
    // Usar buscar('') para listar todos (ou modificar o método buscar se necessário)
    $todosFilmes = $filmeServico->buscar('');
    $todosLivros = $livroServico->buscar('');

    // Filtrar "wicked" dos destaques
    $filmesDestaque = array_filter($todosFilmes, function($filme) {
        return strtolower($filme['titulo']) !== 'wicked';
    });
    $livrosDestaque = array_filter($todosLivros, function($livro) {
        return strtolower($livro['titulo']) !== 'wicked';
    });

} catch (Exception $e) {
    $erroAoCarregarDestaques = "Erro ao carregar destaques: " . $e->getMessage();
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
                        <?php if (isset($_SESSION['id'])) : ?>
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php
                if (!isset($_SESSION['id'])) {
                ?>
                    <a href="login.php" class="login-button">
                        <i class="fas fa-user"></i> Login
                    </a>
                <?php } else { ?>
                    <a href="?sair" class="login-button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php } ?>
            </div>
        </div>
    </header>

    <main class="container mb-5">
        <section class="welcome-section">
            <h2 class="mb-2 text-white"></h2>
        </section>
        <section class="recent-section">
            <h3 class="mb-4 text-white">FILMES EM DESTAQUE</h3>
            <div id="carouselFilmes" class="carousel slide">
                <div class="carousel-inner">
                    <?php
                    // Dividir filmes em grupos de 4 para o carrossel
                    $gruposFilmes = array_chunk($filmesDestaque, 4);
                    foreach ($gruposFilmes as $index => $grupoFilmes):
                    ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row g-1 justify-content-start">
                                <?php foreach ($grupoFilmes as $filme):
                                ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <a href="filmes.php?id=<?= $filme['id'] ?>" class="card card-cinelivro h-100 shadow-sm card-item text-decoration-none">
                                            <img src="<?= htmlspecialchars($filme['poster_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($filme['titulo']) ?>">
                                            <div class="card-body text-center">
                                                <h4 class="card-title mb-1"><?= htmlspecialchars($filme['titulo']) ?></h4>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselFilmes" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselFilmes" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>

            <h3 class="mb-4 mt-5 text-white">LIVROS EM DESTAQUE</h3>
            <div id="carouselLivros" class="carousel slide">
                <div class="carousel-inner">
                    <?php
                    // Dividir livros em grupos de 4 para o carrossel
                    $gruposLivros = array_chunk($livrosDestaque, 4);
                    foreach ($gruposLivros as $index => $grupoLivros):
                    ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row g-1 justify-content-start">
                                <?php foreach ($grupoLivros as $livro):
                                ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <a href="livros.php?id=<?= $livro['id'] ?>" class="card card-cinelivro h-100 shadow-sm card-item text-decoration-none">
                                            <img src="<?= htmlspecialchars($livro['imagem_capa_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($livro['titulo']) ?>">
                                            <div class="card-body text-center">
                                                <h4 class="card-title mb-1"><?= htmlspecialchars($livro['titulo']) ?></h4>
                                            </div>
                                        </a>
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
        </section>
    </main>
    <footer class="footer-cinelivro text-center py-3 mt-5">
        <div class="container d-flex justify-content-center align-items-center gap-4">
            <img src="imagens/cinelivro_logo_transparente.png" alt="Logo CineLivro" class="logo-img">
            <nav>
                <ul class="nav navbar-cinelivro">
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Home</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <?php if (isset($_SESSION['id'])) : ?>
                    <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Perfil</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="login-admin.php" class="nav-link text-light">Admin</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2025 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="js/busca.js"></script>
</body>

</html>