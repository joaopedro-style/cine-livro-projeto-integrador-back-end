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
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Usuário</a></li>
                    </ul>
                </nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-link text-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_nome']); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="usuario.php">Meu Perfil</a></li>
                            <li><a class="dropdown-item" href="favoritos.php">Favoritos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Sair</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="login-button">
                        <i class="fas fa-user"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <main class="container mb-5">
        <section class="welcome-section">
            <h2 class="mb-2 text-white"><?php echo isLoggedIn() ? 'Bem-vindo(a) de volta, ' . htmlspecialchars($_SESSION['user_nome']) . '!' : 'Bem-vindo(a) ao CineLivro!'; ?></h2>
        </section>
        <section class="recent-section">
            <h3 class="mb-4 text-white">FILMES EM DESTAQUE</h3>
            <div id="carouselFilmes" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row g-1 justify-content-start">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8uVKfOJUhmybNsVh089EqLHUYEG.jpg" class="card-img-top" alt="Duna: Parte Dois">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Duna: Parte Dois</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/fWSGD2yrzz6hscocnMD8AEXIThk.jpg" class="card-img-top" alt="Godzilla e Kong: O Novo Império">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Godzilla e Kong: O Novo Império</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://br.web.img2.acsta.net/c_600_900/img/fb/8a/fb8a2dd78cc344d9b2fdf5e0a4bb4026.jpeg" class="card-img-top" alt="Moana 2">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Moana 2</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xGvz7nlGQeePcVOpAzOcHsC7kRt.jpg" class="card-img-top" alt="Divertida Mente 2">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Divertida Mente 2</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row g-1 justify-content-start">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/xq4v7JE8niZ75OYYPDGNn6Gzpyt.jpg" class="card-img-top" alt="Deadpool & Wolverine">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Deadpool & Wolverine</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://www.themoviedb.org/t/p/w600_and_h900_bestv2/iMVuv6Gz5fj7vZ51IjRF3AiW87y.jpg" class="card-img-top" alt="Mufasa: O Rei Leão">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Mufasa: O Rei Leão</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="carousel-item active">
                        <div class="row g-1 justify-content-start">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/71qp8YwAt3L._SL1500_.jpg" class="card-img-top" alt="Nem Te Conto">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Nem Te Conto</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/811qQCoJQiL._SL1500_.jpg" class="card-img-top" alt="A Primeira Mentira">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">A Primeira Mentira</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/81LcML07DAL._SL1500_.jpg" class="card-img-top" alt="Até o fim do verão">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Até o Fim do Verão</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/71z5QR-Ov4L._SL1500_.jpg" class="card-img-top" alt="Como Arruinar um Casamento">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Como Arruinar um Casamento</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row g-1 justify-content-start">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/81Lyq240udL._SL1500_.jpg" class="card-img-top" alt="A Professora">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">A Professora</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/91cdzhQQwEL._SL1500_.jpg" class="card-img-top" alt="Casa de Chama e Sombra">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Casa de Chama e Sombra</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card card-cinelivro h-100 shadow-sm card-item">
                                    <img src="https://m.media-amazon.com/images/I/91crvEm6SwL._SL1500_.jpg" class="card-img-top" alt="Filhos de Aflição e Anarquia">
                                    <div class="card-body text-center">
                                        <h4 class="card-title mb-1">Filhos de Aflição e Anarquia</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <li class="nav-item"><a href="index.php" class="nav-link text-light">Index</a></li>
                    <li class="nav-item"><a href="filmes.php" class="nav-link text-light">Filmes</a></li>
                    <li class="nav-item"><a href="livros.php" class="nav-link text-light">Livros</a></li>
                    <li class="nav-item"><a href="usuario.php" class="nav-link text-light">Usuário</a></li>
                </ul>
            </nav>
            <p class="mb-0">&copy; 2025 CineLivro. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html> 